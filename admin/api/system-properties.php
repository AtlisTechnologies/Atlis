<?php
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/functions.php';
header('Content-Type: application/json');
$action = $_REQUEST['action'] ?? '';

try{
  switch($action){
    case 'list':
      require_permission('system_properties','read');
      $stmt = $pdo->query('SELECT sp.id, sp.name, sp.value, c.label AS category, t.label AS type FROM system_properties sp JOIN lookup_list_items c ON sp.category_id=c.id JOIN lookup_list_items t ON sp.type_id=t.id ORDER BY sp.name');
      echo json_encode(['success'=>true,'properties'=>$stmt->fetchAll(PDO::FETCH_ASSOC)]);
      break;
    case 'create':
      require_permission('system_properties','create');
      verify_csrf();
      handleSave();
      break;
    case 'update':
      require_permission('system_properties','update');
      verify_csrf();
      handleSave(true);
      break;
    case 'delete':
      require_permission('system_properties','delete');
      verify_csrf();
      $id = (int)($_POST['id'] ?? 0);
      if($id<=0){ echo json_encode(['success'=>false,'error'=>'Invalid ID']); break; }
      $pdo->prepare('DELETE FROM system_properties WHERE id=:id')->execute([':id'=>$id]);
      audit_log($pdo,$this_user_id,'system_properties',$id,'DELETE','Deleted system property');
      echo json_encode(['success'=>true]);
      break;
    case 'versions':
      require_permission('system_properties','read');
      $pid=(int)($_GET['id']??0);
      $stmt=$pdo->prepare('SELECT id,value,user_id,date_created FROM system_property_versions WHERE property_id=:id ORDER BY date_created DESC');
      $stmt->execute([':id'=>$pid]);
      echo json_encode(['success'=>true,'versions'=>$stmt->fetchAll(PDO::FETCH_ASSOC)]);
      break;
    case 'restore':
      require_permission('system_properties','update');
      verify_csrf();
      $vid=(int)($_POST['version_id']??0);
      if($vid<=0){ echo json_encode(['success'=>false,'error'=>'Invalid version']); break; }
      $stmt=$pdo->prepare('SELECT property_id,value FROM system_property_versions WHERE id=:id');
      $stmt->execute([':id'=>$vid]);
      $ver=$stmt->fetch(PDO::FETCH_ASSOC);
      if(!$ver){ echo json_encode(['success'=>false,'error'=>'Version not found']); break; }
      $pdo->beginTransaction();
      $cur=$pdo->prepare('SELECT value FROM system_properties WHERE id=:id');
      $cur->execute([':id'=>$ver['property_id']]);
      $curVal=$cur->fetchColumn();
      $pdo->prepare('INSERT INTO system_property_versions (property_id,value,user_id) VALUES (:pid,:val,:uid)')->execute([':pid'=>$ver['property_id'],':val'=>$curVal,':uid'=>$this_user_id]);
      $pdo->prepare('UPDATE system_properties SET value=:val,user_updated=:uid WHERE id=:id')->execute([':val'=>$ver['value'],':uid'=>$this_user_id,':id'=>$ver['property_id']]);
      $pdo->commit();
      audit_log($pdo,$this_user_id,'system_properties',$ver['property_id'],'UPDATE','Restored system property version');
      echo json_encode(['success'=>true]);
      break;
    default:
      echo json_encode(['success'=>false,'error'=>'Invalid action']);
  }
}catch(Exception $e){
  echo json_encode(['success'=>false,'error'=>'Server error']);
}

function verify_csrf(){
  if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
    echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
    exit;
  }
}

function handleSave($isUpdate=false){
  global $pdo,$this_user_id;
  $id=(int)($_POST['id']??0);
  $category=(int)($_POST['category_id']??0);
  $type=(int)($_POST['type_id']??0);
  $name=trim($_POST['name']??'');
  $value=trim($_POST['value']??'');
  $memo=trim($_POST['memo']??'');
  if($category<=0||$type<=0||$name===''){ echo json_encode(['success'=>false,'error'=>'Invalid data']); return; }
  if(!lookupExists($category) || !lookupExists($type)){ echo json_encode(['success'=>false,'error'=>'Invalid lookup']); return; }
  if(!validateValue($type,$value)){ echo json_encode(['success'=>false,'error'=>'Invalid value for type']); return; }
  if($isUpdate){
    if($id<=0){ echo json_encode(['success'=>false,'error'=>'Invalid ID']); return; }
    $pdo->beginTransaction();
    $stmt=$pdo->prepare('SELECT value FROM system_properties WHERE id=:id');
    $stmt->execute([':id'=>$id]);
    $old=$stmt->fetchColumn();
    $pdo->prepare('INSERT INTO system_property_versions (property_id,value,user_id) VALUES (:pid,:val,:uid)')->execute([':pid'=>$id,':val'=>$old,':uid'=>$this_user_id]);
    $pdo->prepare('UPDATE system_properties SET category_id=:cid,type_id=:tid,name=:name,value=:val,memo=:memo,user_updated=:uid WHERE id=:id')->execute([':cid'=>$category,':tid'=>$type,':name'=>$name,':val'=>$value,':memo'=>$memo,':uid'=>$this_user_id,':id'=>$id]);
    $pdo->commit();
    audit_log($pdo,$this_user_id,'system_properties',$id,'UPDATE','Updated system property');
    echo json_encode(['success'=>true]);
  }else{
    $stmt=$pdo->prepare('INSERT INTO system_properties (user_id,user_updated,category_id,type_id,name,value,memo) VALUES (:uid,:uid,:cid,:tid,:name,:val,:memo)');
    $stmt->execute([':uid'=>$this_user_id,':cid'=>$category,':tid'=>$type,':name'=>$name,':val'=>$value,':memo'=>$memo]);
    $nid=$pdo->lastInsertId();
    $pdo->prepare('INSERT INTO system_property_versions (property_id,value,user_id) VALUES (:pid,:val,:uid)')->execute([':pid'=>$nid,':val'=>$value,':uid'=>$this_user_id]);
    audit_log($pdo,$this_user_id,'system_properties',$nid,'CREATE','Created system property');
    echo json_encode(['success'=>true,'id'=>$nid]);
  }
}

function lookupExists($id){
  global $pdo;
  $stmt=$pdo->prepare('SELECT 1 FROM lookup_list_items WHERE id=:id');
  $stmt->execute([':id'=>$id]);
  return (bool)$stmt->fetchColumn();
}

function validateValue($typeId,$value){
  global $pdo;
  $stmt=$pdo->prepare('SELECT label FROM lookup_list_items WHERE id=:id');
  $stmt->execute([':id'=>$typeId]);
  $label=$stmt->fetchColumn();
  if(!$label) return false;
  switch(strtolower($label)){
    case 'integer':
      return filter_var($value,FILTER_VALIDATE_INT)!==false;
    case 'boolean':
      return in_array(strtolower($value),['0','1','true','false'],true);
    case 'json':
      json_decode($value); return json_last_error()===JSON_ERROR_NONE;
    default:
      return true;
  }
}
