-- Migration: Migrate Atlisware v2 finance data

-- Load legacy data into temporary tables
-- These source files include CREATE TABLE and INSERT statements
SOURCE _SQL/atlisware_v2/module_projects_invoices.sql;
SOURCE _SQL/atlisware_v2/module_projects_timetracking.sql;

START TRANSACTION;

-- Copy legacy tables into temporary tables and remove original imports
CREATE TEMPORARY TABLE tmp_module_projects_invoices AS
  SELECT * FROM module_projects_invoices;
CREATE TEMPORARY TABLE tmp_module_projects_timetracking AS
  SELECT * FROM module_projects_timetracking;
DROP TABLE module_projects_invoices;
DROP TABLE module_projects_timetracking;

-- Temporary mapping of old invoice ids to new ids
CREATE TEMPORARY TABLE tmp_invoice_map (
  old_id INT PRIMARY KEY,
  new_id INT
);

-- Insert invoices mapping project_id -> corporate_id and converting status text
INSERT INTO admin_finances_invoices (corporate_id, invoice_number, total_amount, status_id)
SELECT
  mpi.project_id AS corporate_id,
  mpi.name AS invoice_number,
  CAST(mpi.amount AS DECIMAL(10,2)) AS total_amount,
  (
    SELECT lli.id FROM lookup_list_items lli
    JOIN lookup_lists ll ON ll.id = lli.list_id
    WHERE ll.name = 'CORPORATE_FINANCE_INVOICE_STATUS'
      AND UPPER(lli.label) = UPPER(mpi.status)
    LIMIT 1
  ) AS status_id
FROM tmp_module_projects_invoices mpi;

-- Map old invoice ids to new ids
INSERT INTO tmp_invoice_map (old_id, new_id)
SELECT
  mpi.id,
  afi.id
FROM tmp_module_projects_invoices mpi
JOIN admin_finances_invoices afi
  ON afi.invoice_number = mpi.name
 AND afi.corporate_id = mpi.project_id;

-- Create a single invoice item for each legacy invoice row
INSERT INTO admin_finances_invoice_items (invoice_id, description, quantity, rate, amount)
SELECT
  map.new_id AS invoice_id,
  LEFT(mpi.notes,255) AS description,
  CAST(mpi.hours AS DECIMAL(10,2)) AS quantity,
  CAST(mpi.rate AS DECIMAL(10,2)) AS rate,
  CAST(mpi.amount AS DECIMAL(10,2)) AS amount
FROM tmp_module_projects_invoices mpi
JOIN tmp_invoice_map map ON mpi.id = map.old_id;

-- Migrate time tracking entries and link to new invoice ids
INSERT INTO admin_time_tracking_entries (corporate_id, person_id, work_date, hours, rate, invoice_id, memo)
SELECT
  mpt.project_id AS corporate_id,
  mpt.created_by AS person_id,
  DATE(mpt.date_work_start) AS work_date,
  CAST(mpt.hours AS DECIMAL(10,2)) AS hours,
  CAST(mpt.rate AS DECIMAL(10,2)) AS rate,
  map.new_id AS invoice_id,
  mpt.notes AS memo
FROM tmp_module_projects_timetracking mpt
LEFT JOIN tmp_invoice_map map ON mpt.invoice_id = map.old_id;

-- Log orphaned project_ids
SELECT DISTINCT mpi.project_id AS orphan_project_id
FROM tmp_module_projects_invoices mpi
LEFT JOIN admin_corporate c ON mpi.project_id = c.id
WHERE c.id IS NULL;

-- Log status values that failed to map
SELECT DISTINCT mpi.status AS unmapped_status
FROM tmp_module_projects_invoices mpi
LEFT JOIN lookup_list_items lli
       ON lli.list_id = (SELECT id FROM lookup_lists WHERE name='CORPORATE_FINANCE_INVOICE_STATUS')
      AND UPPER(lli.label) = UPPER(mpi.status)
WHERE lli.id IS NULL;

-- Clean up temporary tables
DROP TEMPORARY TABLE IF EXISTS tmp_invoice_map;
DROP TEMPORARY TABLE IF EXISTS tmp_module_projects_invoices;
DROP TEMPORARY TABLE IF EXISTS tmp_module_projects_timetracking;

COMMIT;
