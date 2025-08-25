-- Adds Manager roles and Lake County hierarchy assignments

INSERT INTO lookup_list_items (user_id, user_updated, date_created, date_updated, memo, list_id, label, code, sort_order, active_from, active_to)
VALUES
  (1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 32, 'Manager', 'MANAGER', 2, '2025-08-27', NULL),
  (1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 33, 'Manager', 'MANAGER', 2, '2025-08-27', NULL),
  (1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 34, 'Manager', 'MANAGER', 2, '2025-08-27', NULL);

UPDATE module_organization SET main_person = 30 WHERE id = 2;

INSERT INTO module_organization_persons (user_id, user_updated, date_created, date_updated, memo, organization_id, person_id, role_id, is_lead)
VALUES
  (1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 2, 30, (SELECT id FROM lookup_list_items WHERE list_id = 32 AND code = 'MANAGER'), 1);

INSERT INTO module_agency_persons (user_id, user_updated, date_created, date_updated, memo, agency_id, person_id, role_id, is_lead)
VALUES
  (1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 3, 30, (SELECT id FROM lookup_list_items WHERE list_id = 33 AND code = 'MANAGER'), 1),
  (1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 4, 31, (SELECT id FROM lookup_list_items WHERE list_id = 33 AND code = 'MANAGER'), 1);

INSERT INTO module_division_persons (user_id, user_updated, date_created, date_updated, memo, division_id, person_id, role_id, is_lead)
VALUES
  (1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 5, 30, (SELECT id FROM lookup_list_items WHERE list_id = 34 AND code = 'MANAGER'), 1),
  (1, 1, '2025-08-27 00:00:00', '2025-08-27 00:00:00', NULL, 9, 31, (SELECT id FROM lookup_list_items WHERE list_id = 34 AND code = 'MANAGER'), 1);

ALTER TABLE module_agency
  ADD CONSTRAINT fk_module_agency_organization_id FOREIGN KEY (organization_id) REFERENCES module_organization (id);
