<?php

function getURLDir(){
  return '/_atlis/';
}

function h(?string $v): string {
  return htmlspecialchars($v ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
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

// Checks if current user has a permission using permission-group relationships
function user_has_permission($module, $action){
  global $pdo, $this_user_id, $this_user_type, $restricted_admin_ids;
  static $cache = [];

  // unrestricted admins bypass permission checks
  if($this_user_type === 'ADMIN' && !in_array($this_user_id, $restricted_admin_ids)){
    return true;
  }

  // simple in-memory cache to avoid repeated queries per request
  $key = $this_user_id.'|'.$module.'|'.$action;
  if(isset($cache[$key])){
    return $cache[$key];
  }

  $sql = "SELECT 1 FROM admin_user_roles ur "
       . "JOIN admin_role_permission_groups rpg ON ur.role_id = rpg.role_id "
       . "JOIN admin_permission_group_permissions pgp ON rpg.permission_group_id = pgp.permission_group_id "
       . "JOIN admin_permissions p ON pgp.permission_id = p.id "
       . "WHERE ur.user_account_id = :uid AND p.module = :module AND p.action = :action";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':uid' => $this_user_id, ':module' => $module, ':action' => $action]);
  $cache[$key] = (bool)$stmt->fetchColumn();
  return $cache[$key];
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

// Caching for system properties
function load_system_properties(PDO $pdo, bool $useCache=true): array {
  global $__system_properties_cache;
  if($useCache && $__system_properties_cache !== null){
    return $__system_properties_cache;
  }
  $stmt = $pdo->query('SELECT id,name,value,category_id,type_id,memo FROM system_properties');
  $__system_properties_cache = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $__system_properties_cache;
}

function get_system_property(PDO $pdo, string $name, bool $useCache=true){
  $props = load_system_properties($pdo,$useCache);
  foreach($props as $p){
    if($p['name'] === $name){
      return $p['value'];
    }
  }
  return null;
}

function clear_system_properties_cache(): void {
  global $__system_properties_cache;
  $__system_properties_cache = null;
}

function export_system_properties(PDO $pdo, string $format='json'): string {
  $props = load_system_properties($pdo,false);
  if(strtolower($format) === 'csv'){
    $fh = fopen('php://temp','r+');
    fputcsv($fh,['name','value','category_id','type_id','memo']);
    foreach($props as $p){
      fputcsv($fh,[$p['name'],$p['value'],$p['category_id'],$p['type_id'],$p['memo']]);
    }
    rewind($fh);
    return stream_get_contents($fh);
  }
  return json_encode($props);
}

function import_system_properties(PDO $pdo, string $data, string $format='json'): bool {
  if(strtolower($format) === 'csv'){
    $rows = [];
    $fh = fopen('php://temp','r+');
    fwrite($fh,$data);
    rewind($fh);
    $header = fgetcsv($fh);
    while(($row = fgetcsv($fh)) !== false){
      $rows[] = array_combine($header,$row);
    }
  }else{
    $rows = json_decode($data,true);
    if(!is_array($rows)) return false;
  }
  foreach($rows as $p){
    $stmt=$pdo->prepare('SELECT id FROM system_properties WHERE name=:name');
    $stmt->execute([':name'=>$p['name']]);
    $id=$stmt->fetchColumn();
    if($id){
      $pdo->prepare('UPDATE system_properties SET value=:val,category_id=:cid,type_id=:tid,memo=:memo WHERE id=:id')->execute([
        ':val'=>$p['value'],':cid'=>$p['category_id'],':tid'=>$p['type_id'],':memo'=>$p['memo'],':id'=>$id
      ]);
    }else{
      $pdo->prepare('INSERT INTO system_properties (user_id,user_updated,name,value,category_id,type_id,memo) VALUES (0,0,:name,:val,:cid,:tid,:memo)')->execute([
        ':name'=>$p['name'],':val'=>$p['value'],':cid'=>$p['category_id'],':tid'=>$p['type_id'],':memo'=>$p['memo']
      ]);
    }
  }
  return true;
}

?>
