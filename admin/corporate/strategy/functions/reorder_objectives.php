<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'update');
header('Content-Type: application/json');

$data = json_decode($_POST['hierarchy'] ?? '[]', true);
if(!is_array($data)){
  echo json_encode(['success'=>false,'error'=>'Invalid data']);
  exit;
}

try {
  $update = $pdo->prepare('UPDATE module_strategy_objectives SET parent_id = :pid, sort_order = :sort, user_updated = :uid WHERE id = :id');
  $fn = function(array $items, $parent) use (&$fn, $update, $this_user_id){
    $sort = 0;
    foreach($items as $item){
      $pid = $parent ?: null;
      $update->execute([':pid'=>$pid, ':sort'=>$sort, ':uid'=>$this_user_id, ':id'=>$item['id']]);
      if(!empty($item['children'])){
        $fn($item['children'], (int)$item['id']);
      }
      $sort++;
    }
  };
  $fn($data, 0);
  echo json_encode(['success'=>true]);
} catch (PDOException $e){
  echo json_encode(['success'=>false,'error'=>'Database error']);
}
