<?php
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/helpers.php';
header('Content-Type: application/json');
$action = $_REQUEST['action'] ?? '';

try {
  switch ($action) {
    case 'list':
      require_permission('products_services','read');
      $stmt = $pdo->query('SELECT id, name, description FROM module_products_services ORDER BY name');
      $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode(['success'=>true,'items'=>$items]);
      break;
    case 'create':
      verifyToken();
      require_permission('products_services','create');
      $name = trim($_POST['name'] ?? '');
      $description = trim($_POST['description'] ?? '');
      if($name===''){ echo json_encode(['success'=>false,'error'=>'Name required']); break; }
      $stmt = $pdo->prepare('INSERT INTO module_products_services (user_id,user_updated,name,description) VALUES (:uid,:uid,:name,:descr)');
      $stmt->execute([':uid'=>$this_user_id,':name'=>$name,':descr'=>$description]);
      $id = $pdo->lastInsertId();
      audit_log($pdo,$this_user_id,'module_products_services',$id,'CREATE','Created product/service');
      echo json_encode(['success'=>true,'id'=>$id]);
      break;
    case 'update':
      verifyToken();
      require_permission('products_services','update');
      $id = (int)($_POST['id'] ?? 0);
      $name = trim($_POST['name'] ?? '');
      $description = trim($_POST['description'] ?? '');
      if($id<=0 || $name===''){ echo json_encode(['success'=>false,'error'=>'Invalid data']); break; }
      $stmt = $pdo->prepare('UPDATE module_products_services SET name=:name, description=:descr, user_updated=:uid WHERE id=:id');
      $stmt->execute([':name'=>$name,':descr'=>$description,':uid'=>$this_user_id,':id'=>$id]);
      audit_log($pdo,$this_user_id,'module_products_services',$id,'UPDATE','Updated product/service');
      echo json_encode(['success'=>true]);
      break;
    case 'delete':
      verifyToken();
      require_permission('products_services','delete');
      $id = (int)($_POST['id'] ?? 0);
      if($id<=0){ echo json_encode(['success'=>false,'error'=>'Invalid ID']); break; }
      $pdo->prepare('DELETE FROM module_products_services WHERE id=:id')->execute([':id'=>$id]);
      audit_log($pdo,$this_user_id,'module_products_services',$id,'DELETE','Deleted product/service');
      echo json_encode(['success'=>true]);
      break;
    default:
      echo json_encode(['success'=>false,'error'=>'Invalid action']);
  }
} catch (Exception $e) {
  error_log($e->getMessage());
  echo json_encode(['success'=>false,'error'=>'Server error']);
}

function verifyToken(){
  if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
    echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
    exit;
  }
}
