<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('assets','update');

if($_SERVER['REQUEST_METHOD'] === 'GET'){
  $cid = (int)($_GET['contractor_id'] ?? 0);
  $pol = $pdo->query("SELECT id,version,content FROM module_asset_policies WHERE active=1 AND effective_date<=CURDATE() ORDER BY effective_date DESC LIMIT 1");
  $policy = $pol->fetch(PDO::FETCH_ASSOC);
  $needs = true;
  if($policy && $cid){
    $chk = $pdo->prepare('SELECT COUNT(*) FROM module_asset_assignments WHERE contractor_id=:cid AND policy_id=:pid AND agreement_file IS NOT NULL');
    $chk->execute([':cid'=>$cid,':pid'=>$policy['id']]);
    $needs = $chk->fetchColumn() == 0;
  }
  header('Content-Type: application/json');
  echo json_encode(['policy'=>$policy,'needs'=>$needs]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) { http_response_code(403); exit; }
$asset_id = (int)($_POST['asset_id'] ?? 0);
$contractor_id = (int)($_POST['contractor_id'] ?? 0);
$due_date = $_POST['due_date'] ?: null;
$condition_out_id = $_POST['condition_out_id'] !== '' ? (int)$_POST['condition_out_id'] : null;
$notes = $_POST['notes'] ?? null;
$policy_id = $_POST['policy_id'] !== '' ? (int)$_POST['policy_id'] : null;
$signature_data = $_POST['signature_data'] ?? null;
$agreement_file = null;

if($policy_id && $signature_data){
  $dir = __DIR__ . '/../uploads/' . $asset_id . '/agreements/';
  if(!is_dir($dir)) mkdir($dir,0777,true);
  $fileName = 'agreement_'.time().'.pdf';
  $filePath = $dir . $fileName;
  // TODO: replace with real PDF generation
  file_put_contents($filePath, $signature_data);
  $agreement_file = '/admin/corporate/assets/uploads/'.$asset_id.'/agreements/'.$fileName;
}

$open = $pdo->prepare('SELECT id FROM module_asset_assignments WHERE asset_id=:id AND returned_date IS NULL');
$open->execute([':id'=>$asset_id]);
if ($open->fetch()) { http_response_code(400); echo 'Asset already assigned'; exit; }

$pdo->prepare('INSERT INTO module_asset_assignments (asset_id,contractor_id,assigned_date,due_date,condition_out_id,notes,policy_id,agreement_file,user_id,user_updated) VALUES (:aid,:cid,NOW(),:due_date,:condition_out,:notes,:policy_id,:agreement,:uid,:uid)')
     ->execute([
        ':aid'=>$asset_id,
        ':cid'=>$contractor_id,
        ':due_date'=>$due_date,
        ':condition_out'=>$condition_out_id,
        ':notes'=>$notes,
        ':policy_id'=>$policy_id,
        ':agreement'=>$agreement_file,
        ':uid'=>$this_user_id
     ]);
$assign_id = (int)$pdo->lastInsertId();
$pdo->prepare('UPDATE module_assets SET assignee_id=:cid,user_updated=:uid WHERE id=:id')->execute([':cid'=>$contractor_id,':uid'=>$this_user_id,':id'=>$asset_id]);
$pdo->prepare('INSERT INTO module_asset_events (asset_id,event_type,memo,user_id,user_updated) VALUES (:aid,"assign",:memo,:uid,:uid)')
    ->execute([':aid'=>$asset_id,':memo'=>$notes,':uid'=>$this_user_id]);
admin_audit_log($pdo,$this_user_id,'module_asset_assignments',$assign_id,'asset.assign',null,json_encode([
  'asset_id'=>$asset_id,
  'contractor_id'=>$contractor_id,
  'due_date'=>$due_date,
  'condition_out_id'=>$condition_out_id,
  'notes'=>$notes,
  'policy_id'=>$policy_id,
  'agreement_file'=>$agreement_file
]),'Assigned asset');

echo 'ok';
?>
