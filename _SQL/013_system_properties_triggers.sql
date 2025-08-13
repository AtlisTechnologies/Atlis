-- Triggers for module_system_properties versioning

DELIMITER $$
DROP TRIGGER IF EXISTS trg_module_system_properties_au $$
CREATE TRIGGER trg_module_system_properties_au
AFTER UPDATE ON module_system_properties
FOR EACH ROW
BEGIN
  -- prevent recursive trigger calls
  IF (@module_system_properties_au_disabled IS NULL) THEN
    SET @module_system_properties_au_disabled = TRUE;

    -- record previous value with audit metadata
    INSERT INTO module_system_properties_versions
      (property_id, version_number, value, user_id, date_created)
    VALUES
      (OLD.id, OLD.version_number, OLD.value, NEW.user_updated, NOW());

    -- increment version number on the updated record
    UPDATE module_system_properties
    SET version_number = OLD.version_number + 1
    WHERE id = NEW.id;

    SET @module_system_properties_au_disabled = NULL;
  END IF;
END $$
DELIMITER ;
