<?php
require '../../../includes/php_header.php';
require_permission('conference','update');

$id = (int)($_POST['id'] ?? 0);
if (!$id) { header('Location: ../index.php'); exit; }

$name           = $_POST['name'] ?? '';
$event_type_id  = $_POST['event_type_id'] ?? null;
$topic_id       = $_POST['topic_id'] ?? null;
$mode           = $_POST['mode'] ?? null;
$venue          = $_POST['venue'] ?? '';
$start_datetime = !empty($_POST['start_datetime']) ? date('Y-m-d H:i:s', strtotime($_POST['start_datetime'])) : null;
$end_datetime   = !empty($_POST['end_datetime']) ? date('Y-m-d H:i:s', strtotime($_POST['end_datetime'])) : null;
$description    = $_POST['description'] ?? '';
$organizers     = $_POST['organizers'] ?? '';
$sponsors       = $_POST['sponsors'] ?? '';
$is_private     = !empty($_POST['is_private']) ? 1 : 0;

$stmt = $pdo->prepare('UPDATE module_conferences SET user_updated=?, name=?, event_type_id=?, topic_id=?, mode=?, venue=?, start_datetime=?, end_datetime=?, description=?, organizers=?, sponsors=?, is_private=? WHERE id=?');
$stmt->execute([$this_user_id, $name, $event_type_id, $topic_id, $mode, $venue, $start_datetime, $end_datetime, $description, $organizers, $sponsors, $is_private, $id]);

// Sync tags
$pdo->prepare('DELETE FROM module_conference_tags WHERE conference_id=?')->execute([$id]);
$tagsStr = $_POST['tags'] ?? '';
if ($tagsStr !== '') {
    $tags = array_filter(array_map('trim', explode(',', $tagsStr)));
    if ($tags) {
        $tagStmt = $pdo->prepare('INSERT INTO module_conference_tags (user_id, conference_id, tag) VALUES (?,?,?)');
        foreach ($tags as $tag) {
            $tagStmt->execute([$this_user_id, $id, $tag]);
        }
    }
}

// Sync ticket options
$pdo->prepare('DELETE FROM module_conference_ticket_options WHERE conference_id=?')->execute([$id]);
$ticketJson = $_POST['ticket_options'] ?? '';
if ($ticketJson !== '') {
    $tickets = json_decode($ticketJson, true);
    if (is_array($tickets)) {
        $ticketStmt = $pdo->prepare('INSERT INTO module_conference_ticket_options (user_id, conference_id, option_name, price) VALUES (?,?,?,?)');
        foreach ($tickets as $t) {
            $name  = $t['option_name'] ?? ($t['name'] ?? null);
            $price = $t['price'] ?? 0;
            if ($name !== null) {
                $ticketStmt->execute([$this_user_id, $id, $name, $price]);
            }
        }
    }
}

// Sync custom fields
$pdo->prepare('DELETE FROM module_conference_custom_fields WHERE conference_id=?')->execute([$id]);
$fieldsJson = $_POST['custom_fields'] ?? '';
if ($fieldsJson !== '') {
    $fields = json_decode($fieldsJson, true);
    if (is_array($fields)) {
        $fieldStmt = $pdo->prepare('INSERT INTO module_conference_custom_fields (user_id, conference_id, name, field_type, field_options) VALUES (?,?,?,?,?)');
        foreach ($fields as $f) {
            $fname = $f['name'] ?? null;
            $ftype = $f['field_type'] ?? null;
            $fopt  = $f['field_options'] ?? null;
            if ($fname && $ftype) {
                $fieldStmt->execute([$this_user_id, $id, $fname, $ftype, $fopt]);
            }
        }
    }
}

// New images
if (!empty($_FILES['images']['tmp_name'][0])) {
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) { mkdir($uploadDir,0777,true); }
    $imgStmt = $pdo->prepare('INSERT INTO module_conference_images (user_id, conference_id, file_name, file_path, file_size, file_type) VALUES (?,?,?,?,?,?)');
    foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {
        if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
            $base = basename($_FILES['images']['name'][$i]);
            $safe = preg_replace('/[^A-Za-z0-9._-]/','_', $base);
            $target = 'conf_' . $id . '_' . time() . '_' . $safe;
            $targetPath = $uploadDir . $target;
            if (move_uploaded_file($tmp, $targetPath)) {
                $path = '/module/conferences/uploads/' . $target;
                $imgStmt->execute([$this_user_id, $id, $base, $path, $_FILES['images']['size'][$i], $_FILES['images']['type'][$i]]);
            }
        }
    }
}

header('Location: ../index.php?action=details&id=' . $id);
exit;
?>
