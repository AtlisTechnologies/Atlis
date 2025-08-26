-- Project File Cabinet Migration

-- 1. Table for project file folders
CREATE TABLE `module_projects_file_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `memo` text DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_module_projects_file_folders_user_id` (`user_id`),
  KEY `fk_module_projects_file_folders_user_updated` (`user_updated`),
  KEY `fk_module_projects_file_folders_project_id` (`project_id`),
  KEY `fk_module_projects_file_folders_parent_id` (`parent_id`),
  CONSTRAINT `fk_module_projects_file_folders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_projects_file_folders_user_updated` FOREIGN KEY (`user_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_module_projects_file_folders_project_id` FOREIGN KEY (`project_id`) REFERENCES `module_projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_module_projects_file_folders_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `module_projects_file_folders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Alter existing files table
ALTER TABLE `module_projects_files`
  ADD COLUMN `folder_id` int(11) DEFAULT NULL AFTER `project_id`,
  ADD KEY `fk_module_projects_files_folder_id` (`folder_id`);

ALTER TABLE `module_projects_files`
  ADD CONSTRAINT `fk_module_projects_files_folder_id` FOREIGN KEY (`folder_id`) REFERENCES `module_projects_file_folders` (`id`) ON DELETE SET NULL;

-- 3. Seed root folders and update existing file paths
INSERT INTO module_projects_file_folders (user_id, user_updated, project_id, parent_id, name, path, sort_order)
SELECT 1,1,mpf.project_id,NULL,'root', CONCAT('/module/project/uploads/', mpf.project_id, '/'),0
FROM module_projects_files mpf
LEFT JOIN module_projects_file_folders f ON f.project_id = mpf.project_id AND f.parent_id IS NULL
WHERE f.id IS NULL
GROUP BY mpf.project_id;

UPDATE module_projects_files f
JOIN module_projects_file_folders r ON r.project_id = f.project_id AND r.parent_id IS NULL
SET f.folder_id = r.id,
    f.file_path = CONCAT('/module/project/uploads/', f.project_id, '/', SUBSTRING_INDEX(f.file_path, '/', -1));

-- 4. System properties
INSERT INTO lookup_list_items (user_id,user_updated,list_id,label,code,sort_order)
SELECT 1,1,8,'PROJECT_SETTINGS','PROJECT_SETTINGS',3
WHERE NOT EXISTS (SELECT 1 FROM lookup_list_items WHERE list_id=8 AND code='PROJECT_SETTINGS');

INSERT INTO lookup_list_items (user_id,user_updated,list_id,label,code,sort_order)
SELECT 1,1,9,'INTEGER','INTEGER',3
WHERE NOT EXISTS (SELECT 1 FROM lookup_list_items WHERE list_id=9 AND code='INTEGER');

INSERT INTO system_properties (user_id,user_updated,category_id,name,value,type_id,description)
SELECT 1,1,
(SELECT id FROM lookup_list_items WHERE list_id=8 AND code='PROJECT_SETTINGS'),
'PROJECT_FILE_MAX_UPLOAD_MB','10',
(SELECT id FROM lookup_list_items WHERE list_id=9 AND code='INTEGER'),
'Max upload size (MB) for project files'
WHERE NOT EXISTS (SELECT 1 FROM system_properties WHERE name='PROJECT_FILE_MAX_UPLOAD_MB');

INSERT INTO system_properties_versions (user_id,user_updated,property_id,version_number,previous_value,metadata)
SELECT 1,1,p.id,1,p.value,'Initial version'
FROM system_properties p
WHERE p.name='PROJECT_FILE_MAX_UPLOAD_MB'
  AND NOT EXISTS (SELECT 1 FROM system_properties_versions v WHERE v.property_id=p.id AND v.version_number=1);

INSERT INTO system_properties (user_id,user_updated,category_id,name,value,type_id,description)
SELECT 1,1,
(SELECT id FROM lookup_list_items WHERE list_id=8 AND code='PROJECT_SETTINGS'),
'PROJECT_FILE_MAX_FOLDERS','10',
(SELECT id FROM lookup_list_items WHERE list_id=9 AND code='INTEGER'),
'Maximum folders per project'
WHERE NOT EXISTS (SELECT 1 FROM system_properties WHERE name='PROJECT_FILE_MAX_FOLDERS');

INSERT INTO system_properties_versions (user_id,user_updated,property_id,version_number,previous_value,metadata)
SELECT 1,1,p.id,1,p.value,'Initial version'
FROM system_properties p
WHERE p.name='PROJECT_FILE_MAX_FOLDERS'
  AND NOT EXISTS (SELECT 1 FROM system_properties_versions v WHERE v.property_id=p.id AND v.version_number=1);

INSERT INTO system_properties (user_id,user_updated,category_id,name,value,type_id,description)
SELECT 1,1,
(SELECT id FROM lookup_list_items WHERE list_id=8 AND code='PROJECT_SETTINGS'),
'PROJECT_FILE_MAX_FOLDER_DEPTH','3',
(SELECT id FROM lookup_list_items WHERE list_id=9 AND code='INTEGER'),
'Maximum folder depth per project'
WHERE NOT EXISTS (SELECT 1 FROM system_properties WHERE name='PROJECT_FILE_MAX_FOLDER_DEPTH');

INSERT INTO system_properties_versions (user_id,user_updated,property_id,version_number,previous_value,metadata)
SELECT 1,1,p.id,1,p.value,'Initial version'
FROM system_properties p
WHERE p.name='PROJECT_FILE_MAX_FOLDER_DEPTH'
  AND NOT EXISTS (SELECT 1 FROM system_properties_versions v WHERE v.property_id=p.id AND v.version_number=1);

-- 5. Run PHP script `module/project/functions/migrate_project_files.php` to move existing files on disk.
