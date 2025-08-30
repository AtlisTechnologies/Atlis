<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('minder_note','create');

$isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
    || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(405);
    echo json_encode(['success'=>false,'error'=>'Method not allowed']);
  } else {
    $_SESSION['error_message'] = 'Method not allowed';
    header('Location: ../index.php');
  }
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  } else {
    $_SESSION['error_message'] = 'Invalid CSRF token';
    header('Location: ../index.php');
  }
  exit;
}

$title = trim($_POST['title'] ?? '');
$body  = trim($_POST['body'] ?? '');
$category_id = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;

if ($title === '' || $body === '') {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Title and body required']);
  } else {
    $_SESSION['error_message'] = 'Title and body required';
    header('Location: ../note.php');
  }
  exit;
}

$noteId = 0;
try {
  $stmt = $pdo->prepare('INSERT INTO admin_minder_note (title, body, category_id, user_id, user_updated) VALUES (:title,:body,:category_id,:uid,:uid)');
  $stmt->execute([
    ':title' => $title,
    ':body' => $body,
    ':category_id' => $category_id,
    ':uid' => $this_user_id
  ]);
  $noteId = (int)$pdo->lastInsertId();
  if ($noteId === 0) {
    throw new PDOException('Insert failed');
  }

  if (!empty($_FILES['attachments']['name'][0])) {
    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }
    foreach ($_FILES['attachments']['name'] as $i => $name) {
      if ($_FILES['attachments']['error'][$i] === UPLOAD_ERR_OK) {
        $baseName = basename($name);
        $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $baseName);
        $targetName = 'note_' . $noteId . '_' . time() . '_' . $safeName;
        $targetPath = $uploadDir . $targetName;
        if (move_uploaded_file($_FILES['attachments']['tmp_name'][$i], $targetPath)) {
          $dbPath = '/admin/minder/notes/uploads/' . $targetName;
          $pdo->prepare('INSERT INTO admin_minder_note_file (note_id, file_name, file_path, file_size, file_type, user_id, user_updated) VALUES (:nid,:fname,:fpath,:fsize,:ftype,:uid,:uid)')
            ->execute([
              ':nid' => $noteId,
              ':fname' => $baseName,
              ':fpath' => $dbPath,
              ':fsize' => $_FILES['attachments']['size'][$i],
              ':ftype' => $_FILES['attachments']['type'][$i],
              ':uid' => $this_user_id
            ]);
        }
      }
    }
  }
} catch (PDOException $e) {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  } else {
    $_SESSION['error_message'] = 'Unable to save note';
    header('Location: ../note.php');
  }
  exit;
}

admin_audit_log($pdo, $this_user_id, 'minder_note', $noteId, 'CREATE', null, json_encode(['title'=>$title]), 'Created note');

if ($isAjax) {
  header('Content-Type: application/json');
  $fetch = $pdo->prepare('SELECT n.id, n.title, n.body, n.category_id, n.date_created, cat.label AS category_label FROM admin_minder_note n LEFT JOIN lookup_list_items cat ON n.category_id = cat.id WHERE n.id = :id');
  $fetch->execute([':id' => $noteId]);
  $note = $fetch->fetch(PDO::FETCH_ASSOC);
  $fileFetch = $pdo->prepare('SELECT id, file_name, file_path FROM admin_minder_note_file WHERE note_id = :id');
  $fileFetch->execute([':id' => $noteId]);
  $note['attachments'] = $fileFetch->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode(['success'=>true,'note'=>$note]);
} else {
  $_SESSION['message'] = 'Note saved';
  header('Location: ../note.php?id=' . $noteId);
}
exit;
