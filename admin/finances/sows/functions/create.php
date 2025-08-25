<?php
require '../../../../includes/php_header.php';
require_permission('sow','read');
require_permission('sow','create');

if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../edit.php');
  exit;
}

$title = trim($_POST['title'] ?? '');
$summary = trim($_POST['summary'] ?? '');
$org = (int)($_POST['organization_id'] ?? 0);
$agency = (int)($_POST['agency_id'] ?? 0);
$division = (int)($_POST['division_id'] ?? 0);
$project = (int)($_POST['project_id'] ?? 0);
$status = (int)($_POST['status_id'] ?? 0);
$signatures = trim($_POST['signatures'] ?? '');

// parent-child validation
if($division){
  $stmt = $pdo->prepare('SELECT agency_id FROM module_division WHERE id = :id');
  $stmt->execute([':id'=>$division]);
  $divAgency = (int)$stmt->fetchColumn();
  if(!$divAgency || $divAgency != $agency){
    die('Invalid division parent');
  }
}
if($agency){
  $stmt = $pdo->prepare('SELECT organization_id FROM module_agency WHERE id = :id');
  $stmt->execute([':id'=>$agency]);
  $agOrg = (int)$stmt->fetchColumn();
  if(!$agOrg || $agOrg != $org){
    die('Invalid agency parent');
  }
}

$stmt = $pdo->prepare('INSERT INTO module_sows (user_id,user_updated,title,summary,organization_id,agency_id,division_id,project_id,status_id,signatures) VALUES (:uid,:uid,:title,:summary,:org,:agency,:division,:project,:status,:sigs)');
$stmt->execute([
  ':uid'=>$this_user_id,
  ':title'=>$title,
  ':summary'=>$summary !== '' ? $summary : null,
  ':org'=>$org ?: null,
  ':agency'=>$agency ?: null,
  ':division'=>$division ?: null,
  ':project'=>$project ?: null,
  ':status'=>$status ?: null,
  ':sigs'=>$signatures !== '' ? $signatures : null
]);
$id = $pdo->lastInsertId();

// tasks
$tasks = $_POST['tasks'] ?? [];
foreach($tasks as $t){
  $t = (int)$t;
  if($t){
    $pdo->prepare('INSERT INTO module_sow_tasks (user_id,user_updated,sow_id,task_id) VALUES (:uid,:uid,:sid,:tid)')->execute([
      ':uid'=>$this_user_id,
      ':sid'=>$id,
      ':tid'=>$t
    ]);
  }
}
// users
$users = $_POST['users'] ?? [];
foreach($users as $u){
  $u = (int)$u;
  if($u){
    $pdo->prepare('INSERT INTO module_sow_users (user_id,user_updated,sow_id,person_id) VALUES (:uid,:uid,:sid,:pid)')->execute([
      ':uid'=>$this_user_id,
      ':sid'=>$id,
      ':pid'=>$u
    ]);
  }
}
// QA
$questions = $_POST['qa_question'] ?? [];
$answers = $_POST['qa_answer'] ?? [];
for($i=0;$i<count($questions);$i++){
  $q = trim($questions[$i]);
  $a = trim($answers[$i] ?? '');
  if($q !== ''){
    $pdo->prepare('INSERT INTO module_sow_questions (user_id,user_updated,sow_id,question,answer) VALUES (:uid,:uid,:sid,:q,:a)')->execute([
      ':uid'=>$this_user_id,
      ':sid'=>$id,
      ':q'=>$q,
      ':a'=>$a !== '' ? $a : null
    ]);
  }
}
// Links
$linkUrls = $_POST['link_url'] ?? [];
$linkDesc = $_POST['link_desc'] ?? [];
for($i=0;$i<count($linkUrls);$i++){
  $url = trim($linkUrls[$i]);
  $desc = trim($linkDesc[$i] ?? '');
  if($url !== ''){
    $pdo->prepare('INSERT INTO module_sow_links (user_id,user_updated,sow_id,url,description) VALUES (:uid,:uid,:sid,:url,:desc)')->execute([
      ':uid'=>$this_user_id,
      ':sid'=>$id,
      ':url'=>$url,
      ':desc'=>$desc !== '' ? $desc : null
    ]);
  }
}
// Notes
$notes = $_POST['notes'] ?? [];
foreach($notes as $n){
  $n = trim($n);
  if($n !== ''){
    $pdo->prepare('INSERT INTO module_sow_notes (user_id,user_updated,sow_id,note_text) VALUES (:uid,:uid,:sid,:note)')->execute([
      ':uid'=>$this_user_id,
      ':sid'=>$id,
      ':note'=>$n
    ]);
  }
}
// Logins
$loginUrls = $_POST['login_url'] ?? [];
$loginUser = $_POST['login_username'] ?? [];
$loginPass = $_POST['login_password'] ?? [];
for($i=0;$i<count($loginUrls);$i++){
  $lu = trim($loginUrls[$i]);
  $un = trim($loginUser[$i] ?? '');
  $pw = trim($loginPass[$i] ?? '');
  if($lu !== '' || $un !== '' || $pw !== ''){
    $pdo->prepare('INSERT INTO module_sow_logins (user_id,user_updated,sow_id,login_url,login_username,login_password) VALUES (:uid,:uid,:sid,:url,:un,:pw)')->execute([
      ':uid'=>$this_user_id,
      ':sid'=>$id,
      ':url'=>$lu !== '' ? $lu : null,
      ':un'=>$un !== '' ? $un : null,
      ':pw'=>$pw !== '' ? $pw : null
    ]);
  }
}
// Line items
$itemDesc = $_POST['item_desc'] ?? [];
$itemAmount = $_POST['item_amount'] ?? [];
for($i=0;$i<count($itemDesc);$i++){
  $desc = trim($itemDesc[$i]);
  $amt = trim($itemAmount[$i] ?? '');
  if($desc !== '' || $amt !== ''){
    $pdo->prepare('INSERT INTO module_sow_line_items (user_id,user_updated,sow_id,description,amount) VALUES (:uid,:uid,:sid,:desc,:amt)')->execute([
      ':uid'=>$this_user_id,
      ':sid'=>$id,
      ':desc'=>$desc !== '' ? $desc : null,
      ':amt'=>$amt !== '' ? $amt : null
    ]);
  }
}

admin_audit_log($pdo,$this_user_id,'module_sows',$id,'CREATE',null,json_encode(['title'=>$title]));
header('Location: ../edit.php?id='.$id);
exit;
