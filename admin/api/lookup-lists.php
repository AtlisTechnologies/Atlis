<?php
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/helpers.php';
header('Content-Type: application/json');
$entity = $_REQUEST['entity'] ?? '';
$action = $_REQUEST['action'] ?? '';

try {
  switch ($entity) {
    case 'list':
      handleList($action);
      break;
    case 'item':
      handleItem($action);
      break;
    case 'attribute':
      handleAttr($action);
      break;
    default:
      echo json_encode(['success'=>false,'error'=>'Invalid entity']);
  }
} catch (Exception $e) {
  echo json_encode(['success'=>false,'error'=>'Server error']);
}

function verifyToken() {
  if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
    exit;
  }
}

function handleList($action){
  global $pdo, $this_user_id;
  if(in_array($action, ['create','update','delete'])){ verifyToken(); }
  if($action==='create'){
    $name=trim($_POST['name']??'');
    if($name===''){ echo json_encode(['success'=>false,'error'=>'Name is required']); return; }
    $description=trim($_POST['description']??'');
    $memo=trim($_POST['memo']??'');
    $stmt=$pdo->prepare('SELECT id FROM lookup_lists WHERE name=:name');
    $stmt->execute([':name'=>$name]);
    if($stmt->fetch()){
      echo json_encode(['success'=>false,'error'=>'Name already exists']);
      return;
    }
    try{
      $stmt=$pdo->prepare('INSERT INTO lookup_lists (user_id,user_updated,name,description,memo) VALUES (:uid,:uid,:name,:description,:memo)');
      $stmt->execute([':uid'=>$this_user_id,':name'=>$name,':description'=>$description,':memo'=>$memo]);
      $id=$pdo->lastInsertId();
      audit_log($pdo,$this_user_id,'lookup_lists',$id,'CREATE','Created lookup list');
      echo json_encode(['success'=>true,'message'=>'Lookup list created','list'=>['id'=>$id,'name'=>$name,'description'=>$description]]);
    }catch(PDOException $e){
      if($e->getCode()==='23000'){
        echo json_encode(['success'=>false,'error'=>'Name already exists']);
      }else{
        echo json_encode(['success'=>false,'error'=>'Database error']);
      }
    }
  }elseif($action==='update'){
    $id=(int)($_POST['id']??0);
    $name=trim($_POST['name']??'');
    if($id<=0||$name===''){ echo json_encode(['success'=>false,'error'=>'Invalid data']); return; }
    $description=trim($_POST['description']??'');
    $memo=trim($_POST['memo']??'');
    $stmt=$pdo->prepare('SELECT id FROM lookup_lists WHERE name=:name AND id<>:id');
    $stmt->execute([':name'=>$name,':id'=>$id]);
    if($stmt->fetch()){
      echo json_encode(['success'=>false,'error'=>'Name already exists']);
      return;
    }
    try{
      $stmt=$pdo->prepare('UPDATE lookup_lists SET name=:name,description=:description,memo=:memo,user_updated=:uid WHERE id=:id');
      $stmt->execute([':name'=>$name,':description'=>$description,':memo'=>$memo,':uid'=>$this_user_id,':id'=>$id]);
      audit_log($pdo,$this_user_id,'lookup_lists',$id,'UPDATE','Updated lookup list');
      echo json_encode(['success'=>true,'message'=>'Lookup list updated','list'=>['id'=>$id,'name'=>$name,'description'=>$description]]);
    }catch(PDOException $e){
      if($e->getCode()==='23000'){
        echo json_encode(['success'=>false,'error'=>'Name already exists']);
      }else{
        echo json_encode(['success'=>false,'error'=>'Database error']);
      }
    }
  }elseif($action==='delete'){
    $id=(int)($_POST['id']??0);
    if($id<=0){ echo json_encode(['success'=>false,'error'=>'Invalid ID']); return; }
    $stmt=$pdo->prepare('SELECT COUNT(*) FROM lookup_list_items WHERE list_id=:id');
    $stmt->execute([':id'=>$id]);
    if($stmt->fetchColumn()>0){
      echo json_encode(['success'=>false,'error'=>'Remove items before deleting this list']);
      return;
    }
    try{
      $pdo->prepare('DELETE FROM lookup_lists WHERE id=:id')->execute([':id'=>$id]);
      audit_log($pdo,$this_user_id,'lookup_lists',$id,'DELETE','Deleted lookup list');
      echo json_encode(['success'=>true,'message'=>'Lookup list deleted']);
    }catch(PDOException $e){
      if($e->getCode()==='23000'){
        echo json_encode(['success'=>false,'error'=>'List is in use']);
      }else{
        echo json_encode(['success'=>false,'error'=>'Database error']);
      }
    }
  }else{
    echo json_encode(['success'=>false,'error'=>'Invalid action']);
  }
}

function handleItem($action){
  global $pdo,$this_user_id;
  if(in_array($action,['create','update','delete'])){ verifyToken(); }
  if($action==='list'){
    $list_id=(int)($_GET['list_id']??0);
    $stmt=$pdo->prepare('SELECT id,label,code,active_from,active_to FROM lookup_list_items WHERE list_id=:list_id AND active_from <= CURDATE() AND (active_to IS NULL OR active_to >= CURDATE()) ORDER BY label');
    $stmt->execute([':list_id'=>$list_id]);
    $items=$stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success'=>true,'items'=>$items]);
  }elseif($action==='create'){
    $list_id=(int)($_POST['list_id']??0);
    $label=trim($_POST['label']??'');
    $code=trim($_POST['code']??'');
    $active_from=$_POST['active_from']??date('Y-m-d');
    $active_to=$_POST['active_to']??null;
    if($active_to==='' || $active_to==='0000-00-00'){
       $active_to=null;
     }
    if($list_id<=0||$label===''){ echo json_encode(['success'=>false,'error'=>'Invalid data']); return; }
    $stmt=$pdo->prepare('SELECT id FROM lookup_list_items WHERE list_id=:list_id AND label=:label');
    $stmt->execute([':list_id'=>$list_id,':label'=>$label]);
    if($stmt->fetch()){
      echo json_encode(['success'=>false,'error'=>'Label already exists']);
      return;
    }
    try{
      $stmt=$pdo->prepare('INSERT INTO lookup_list_items (user_id,user_updated,list_id,label,code,active_from,active_to) VALUES (:uid,:uid,:list_id,:label,:code,:active_from,:active_to)');
      $stmt->execute([':uid'=>$this_user_id,':list_id'=>$list_id,':label'=>$label,':code'=>$code,':active_from'=>$active_from,':active_to'=>$active_to]);
      $id=$pdo->lastInsertId();
      audit_log($pdo,$this_user_id,'lookup_list_items',$id,'CREATE','Created lookup list item');
      echo json_encode(['success'=>true,'message'=>'Item created','item'=>['id'=>$id,'label'=>$label,'code'=>$code,'active_from'=>$active_from,'active_to'=>$active_to]]);
    }catch(PDOException $e){
      if($e->getCode()==='23000'){
        echo json_encode(['success'=>false,'error'=>'Label already exists']);
      }else{
        echo json_encode(['success'=>false,'error'=>'Database error']);
      }
    }
  }elseif($action==='update'){
    $id=(int)($_POST['id']??0);
    $label=trim($_POST['label']??'');
    $code=trim($_POST['code']??'');
    $active_from=$_POST['active_from']??date('Y-m-d');
    $active_to=$_POST['active_to']??null;
    if($active_to===''){ $active_to=null; }
    if($id<=0||$label===''){ echo json_encode(['success'=>false,'error'=>'Invalid data']); return; }
    $stmt=$pdo->prepare('SELECT list_id FROM lookup_list_items WHERE id=:id');
    $stmt->execute([':id'=>$id]);
    $list_id=$stmt->fetchColumn();
    if(!$list_id){ echo json_encode(['success'=>false,'error'=>'Item not found']); return; }
    $stmt=$pdo->prepare('SELECT id FROM lookup_list_items WHERE list_id=:list_id AND label=:label AND id<>:id');
    $stmt->execute([':list_id'=>$list_id,':label'=>$label,':id'=>$id]);
    if($stmt->fetch()){
      echo json_encode(['success'=>false,'error'=>'Label already exists']);
      return;
    }
    try{
      $stmt=$pdo->prepare('UPDATE lookup_list_items SET label=:label,code=:code,active_from=:active_from,active_to=:active_to,user_updated=:uid WHERE id=:id');
      $stmt->execute([':label'=>$label,':code'=>$code,':active_from'=>$active_from,':active_to'=>$active_to,':uid'=>$this_user_id,':id'=>$id]);
      audit_log($pdo,$this_user_id,'lookup_list_items',$id,'UPDATE','Updated lookup list item');
      echo json_encode(['success'=>true,'message'=>'Item updated','item'=>['id'=>$id,'label'=>$label,'code'=>$code,'active_from'=>$active_from,'active_to'=>$active_to]]);
    }catch(PDOException $e){
      if($e->getCode()==='23000'){
        echo json_encode(['success'=>false,'error'=>'Label already exists']);
      }else{
        echo json_encode(['success'=>false,'error'=>'Database error']);
      }
    }
  }elseif($action==='delete'){
    $id=(int)($_POST['id']??0);
    if($id<=0){ echo json_encode(['success'=>false,'error'=>'Invalid ID']); return; }
    $tables=['module_agency','module_division','module_organization','users'];
    foreach($tables as $tbl){
      $stmt=$pdo->prepare("SELECT COUNT(*) FROM {$tbl} WHERE status=:id");
      $stmt->execute([':id'=>$id]);
      if($stmt->fetchColumn()>0){
        echo json_encode(['success'=>false,'error'=>'Item is referenced in '.$tbl]);
        return;
      }
    }
    try{
      $pdo->prepare('DELETE FROM lookup_list_items WHERE id=:id')->execute([':id'=>$id]);
      audit_log($pdo,$this_user_id,'lookup_list_items',$id,'DELETE','Deleted lookup list item');
      echo json_encode(['success'=>true,'message'=>'Item deleted']);
    }catch(PDOException $e){
      if($e->getCode()==='23000'){
        echo json_encode(['success'=>false,'error'=>'Item is in use']);
      }else{
        echo json_encode(['success'=>false,'error'=>'Database error']);
      }
    }
  }else{
    echo json_encode(['success'=>false,'error'=>'Invalid action']);
  }
}

function handleAttr($action){
  global $pdo,$this_user_id;
  if(in_array($action,['create','update','delete'])){ verifyToken(); }
  if($action==='list'){
    $item_id=(int)($_GET['item_id']??0);
      $stmt=$pdo->prepare('SELECT id,attr_code,attr_value FROM lookup_list_item_attributes WHERE item_id=:item_id');
    $stmt->execute([':item_id'=>$item_id]);
    $attrs=$stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success'=>true,'attrs'=>$attrs]);
  }elseif($action==='create'){
    $item_id=(int)($_POST['item_id']??0);
      $key=trim($_POST['attr_code']??'');
      $value=trim($_POST['attr_value']??'');
      if($item_id<=0||$key===''){ echo json_encode(['success'=>false,'error'=>'Invalid data']); return; }
      try{
        $stmt=$pdo->prepare('INSERT INTO lookup_list_item_attributes (user_id,user_updated,item_id,attr_code,attr_value) VALUES (:uid,:uid,:item_id,:k,:v)');
        $stmt->execute([':uid'=>$this_user_id,':item_id'=>$item_id,':k'=>$key,':v'=>$value]);
        $id=$pdo->lastInsertId();
        audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$id,'CREATE','Created item attribute');
        echo json_encode(['success'=>true,'message'=>'Attribute created','attr'=>['id'=>$id,'attr_code'=>$key,'attr_value'=>$value]]);
      }catch(PDOException $e){
        if($e->getCode()==='23000'){
          echo json_encode(['success'=>false,'error'=>'Attribute already exists for this item']);
        }else{
          echo json_encode(['success'=>false,'error'=>'Database error']);
        }
      }
  }elseif($action==='update'){
    $id=(int)($_POST['id']??0);
      $key=trim($_POST['attr_code']??'');
      $value=trim($_POST['attr_value']??'');
      if($id<=0||$key===''){ echo json_encode(['success'=>false,'error'=>'Invalid data']); return; }
      try{
        $stmt=$pdo->prepare('UPDATE lookup_list_item_attributes SET attr_code=:k, attr_value=:v, user_updated=:uid WHERE id=:id');
        $stmt->execute([':k'=>$key,':v'=>$value,':uid'=>$this_user_id,':id'=>$id]);
        audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$id,'UPDATE','Updated item attribute');
        echo json_encode(['success'=>true,'message'=>'Attribute updated','attr'=>['id'=>$id,'attr_code'=>$key,'attr_value'=>$value]]);
      }catch(PDOException $e){
        if($e->getCode()==='23000'){
          echo json_encode(['success'=>false,'error'=>'Attribute already exists for this item']);
        }else{
          echo json_encode(['success'=>false,'error'=>'Database error']);
        }
      }
  }elseif($action==='delete'){
    $id=(int)($_POST['id']??0);
    if($id<=0){ echo json_encode(['success'=>false,'error'=>'Invalid ID']); return; }
    $pdo->prepare('DELETE FROM lookup_list_item_attributes WHERE id=:id')->execute([':id'=>$id]);
    audit_log($pdo,$this_user_id,'lookup_list_item_attributes',$id,'DELETE','Deleted item attribute');
    echo json_encode(['success'=>true,'message'=>'Attribute deleted']);
  }else{
    echo json_encode(['success'=>false,'error'=>'Invalid action']);
  }
}
