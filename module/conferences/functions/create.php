<?php
require '../../../includes/php_header.php';
require_permission('conference','create');

$title = $_POST['title'] ?? '';
$type = $_POST['type'] ?? '';
$topic = $_POST['topic'] ?? '';
$mode = $_POST['mode'] ?? '';
$venue = $_POST['venue'] ?? '';
$schedule = !empty($_POST['schedule']) ? date('Y-m-d H:i:s', strtotime($_POST['schedule'])) : null;
$description = $_POST['description'] ?? '';
$organizers = $_POST['organizers'] ?? '';
$sponsors = $_POST['sponsors'] ?? '';
$tags = $_POST['tags'] ?? '';
$ticket_options = $_POST['ticket_options'] ?? '';
$custom_fields = $_POST['custom_fields'] ?? '';
$privacy = !empty($_POST['privacy']) ? 1 : 0;

$stmt = $pdo->prepare('INSERT INTO module_conferences (user_id,title,type,topic,mode,venue,schedule,description,organizers,sponsors,tags,ticket_options,custom_fields,privacy) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
$stmt->execute([$this_user_id,$title,$type,$topic,$mode,$venue,$schedule,$description,$organizers,$sponsors,$tags,$ticket_options,$custom_fields,$privacy]);
$id = $pdo->lastInsertId();

if (!empty($_FILES['images']['tmp_name'][0])) {
  $uploadDir = '../uploads/';
  if (!is_dir($uploadDir)) { mkdir($uploadDir,0777,true); }
  $paths = [];
  foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {
    if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
      $base = basename($_FILES['images']['name'][$i]);
      $safe = preg_replace('/[^A-Za-z0-9._-]/','_', $base);
      $target = 'conf_' . $id . '_' . time() . '_' . $safe;
      $targetPath = $uploadDir . $target;
      if (move_uploaded_file($tmp,$targetPath)) {
        $paths[] = '/module/conferences/uploads/' . $target;
      }
    }
  }
  if ($paths) {
    $pdo->prepare('UPDATE module_conferences SET images=? WHERE id=?')->execute([json_encode($paths),$id]);
  }
}

header('Location: ../index.php?action=details&id=' . $id);
exit;
