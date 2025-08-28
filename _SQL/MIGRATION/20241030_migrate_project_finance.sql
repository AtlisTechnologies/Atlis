START TRANSACTION;

-- Temporary table to map old invoice ids to new ids
CREATE TEMPORARY TABLE tmp_invoice_map (
  old_id INT PRIMARY KEY,
  new_id INT
);

-- Migrate invoices
INSERT INTO admin_finances_invoices (corporate_id, invoice_number, total_amount, status_id)
SELECT
  mpi.project_id AS corporate_id,
  mpi.name AS invoice_number,
  CAST(mpi.amount AS DECIMAL(10,2)) AS total_amount,
  (SELECT id FROM lookup_list_items WHERE label = mpi.status LIMIT 1) AS status_id
FROM module_projects_invoices mpi;

-- Map old invoice ids to new
INSERT INTO tmp_invoice_map (old_id, new_id)
SELECT
  mpi.id,
  afi.id
FROM module_projects_invoices mpi
JOIN admin_finances_invoices afi
  ON afi.invoice_number = mpi.name
 AND afi.corporate_id = mpi.project_id;

-- Create a single invoice item for each invoice
INSERT INTO admin_finances_invoice_items (invoice_id, description, quantity, rate, amount)
SELECT
  map.new_id AS invoice_id,
  LEFT(mpi.notes,255) AS description,
  CAST(mpi.hours AS DECIMAL(10,2)) AS quantity,
  CAST(mpi.rate AS DECIMAL(10,2)) AS rate,
  CAST(mpi.amount AS DECIMAL(10,2)) AS amount
FROM module_projects_invoices mpi
JOIN tmp_invoice_map map ON mpi.id = map.old_id;

-- Migrate time tracking entries
INSERT INTO admin_time_tracking_entries (corporate_id, person_id, work_date, hours, rate, invoice_id, memo)
SELECT
  mpt.project_id AS corporate_id,
  mpt.created_by AS person_id,
  DATE(mpt.date_work_start) AS work_date,
  CAST(mpt.hours AS DECIMAL(10,2)) AS hours,
  CAST(mpt.rate AS DECIMAL(10,2)) AS rate,
  map.new_id AS invoice_id,
  mpt.notes AS memo
FROM module_projects_timetracking mpt
LEFT JOIN tmp_invoice_map map ON mpt.invoice_id = map.old_id;

-- Referential integrity checks
SELECT COUNT(*) AS invalid_invoice_corporate
FROM admin_finances_invoices afi
LEFT JOIN admin_corporate c ON afi.corporate_id = c.id
WHERE c.id IS NULL;

SELECT COUNT(*) AS invalid_time_invoice
FROM admin_time_tracking_entries t
LEFT JOIN admin_finances_invoices afi ON t.invoice_id = afi.id
WHERE t.invoice_id IS NOT NULL AND afi.id IS NULL;

SELECT COUNT(*) AS invalid_time_corporate
FROM admin_time_tracking_entries t
LEFT JOIN admin_corporate c ON t.corporate_id = c.id
WHERE c.id IS NULL;

-- Drop the temporary mapping table
DROP TEMPORARY TABLE IF EXISTS tmp_invoice_map;

COMMIT;
