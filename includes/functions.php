<?php

function getURLDir(){
  return '/_atlis/';
}

/**
 * Writes an entry to the audit_log table using a stored procedure.
 *
 * @param PDO    $pdo      Active PDO connection.
 * @param int    $userId   ID of the acting user.
 * @param string $table    Name of the table acted upon.
 * @param int    $recordId Primary key of the affected record.
 * @param string $action   CRUD action (CREATE, READ, UPDATE, DELETE).
 * @param string $details  Optional description of the change.
 */

// Records CRUD actions into the audit_log table
function audit_log($pdo, $userId, $table, $recordId, $action, $details){
  $sql = "INSERT INTO audit_log (user_id, user_updated, table_name, record_id, action, details)
          VALUES (:user_id, :user_updated, :table_name, :record_id, :action, :details)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':user_id' => $userId,
    ':user_updated' => $userId,
    ':table_name' => $table,
    ':record_id' => $recordId,
    ':action' => $action,
    ':details' => $details,
  ]);
}

// Records admin-side CRUD actions into the admin_audit_log table
function admin_audit_log($pdo, $userId, $table, $recordId, $action, $oldValue, $newValue, $details=''){
  $sql = "INSERT INTO admin_audit_log (user_id, user_updated, table_name, record_id, action, details, old_value, new_value)"
       . " VALUES (:user_id, :user_updated, :table_name, :record_id, :action, :details, :old_value, :new_value)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':user_id' => $userId,
    ':user_updated' => $userId,
    ':table_name' => $table,
    ':record_id' => $recordId,
    ':action' => $action,
    ':details' => $details,
    ':old_value' => $oldValue,
    ':new_value' => $newValue,
  ]);
}

// Checks if current user has a permission
function user_has_permission($module, $action){
  global $pdo, $this_user_id, $this_user_type;
  if($this_user_type === 'ADMIN'){
    return true;
  }
  $sql = "SELECT 1 FROM admin_user_roles ur "
       . "JOIN admin_role_permissions rp ON ur.role_id = rp.role_id "
       . "JOIN admin_permissions p ON rp.permission_id = p.id "
       . "WHERE ur.user_account_id = :uid AND p.module = :module AND p.action = :action";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':uid' => $this_user_id, ':module' => $module, ':action' => $action]);
  return (bool)$stmt->fetchColumn();
}

// Enforces permission check
function require_permission($module, $action){
  if(!user_has_permission($module, $action)){
    header('HTTP/1.1 403 Forbidden');
    echo '403 Forbidden';
    exit;
  }
}

// Ensures the current session belongs to an admin user
function require_admin(){
  global $is_admin;
  if(!$is_admin){
    header('HTTP/1.1 403 Forbidden');
    echo '403 Forbidden';
    exit;
  }
}

?>
