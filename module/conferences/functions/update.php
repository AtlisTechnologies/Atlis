<?php
require '../../../includes/php_header.php';
require_permission('conference','update');

$id = (int)($_POST['id'] ?? 0);
if (!$id) { header('Location: ../index.php'); exit; }

$name           = $_POST['name'] ?? '';
$conference_type_id  = $_POST['conference_type_id'] ?? null;
$topic_id       = $_POST['topic_id'] ?? null;
$mode           = $_POST['mode'] ?? null;
$venue          = $_POST['venue'] ?? '';
$country_id     = $_POST['country_id'] ?? null;
$state_id       = $_POST['state_id'] ?? null;
$city           = $_POST['city'] ?? null;
$latitude       = $_POST['latitude'] ?? null;
$longitude      = $_POST['longitude'] ?? null;
$start_datetime = !empty($_POST['start_datetime']) ? date('Y-m-d H:i:s', strtotime($_POST['start_datetime'])) : null;
$end_datetime   = !empty($_POST['end_datetime']) ? date('Y-m-d H:i:s', strtotime($_POST['end_datetime'])) : null;
$timezone       = $_POST['timezone'] ?? null;
$registration_deadline = !empty($_POST['registration_deadline']) ? date('Y-m-d', strtotime($_POST['registration_deadline'])) : null;
$description    = $_POST['description'] ?? '';
$organizers     = $_POST['organizers'] ?? '';
$sponsors       = $_POST['sponsors'] ?? '';
$banner_image_id = $_POST['banner_image_id'] ?? null;
$is_private     = !empty($_POST['is_private']) ? 1 : 0;
$show_ticket_count = !empty($_POST['show_ticket_count']) ? 1 : 0;

$stmt = $pdo->prepare('UPDATE module_conferences SET user_updated=?, name=?, event_type_id=?, topic_id=?, mode=?, venue=?, country_id=?, state_id=?, city=?, latitude=?, longitude=?, start_datetime=?, end_datetime=?, timezone=?, registration_deadline=?, description=?, organizers=?, sponsors=?, banner_image_id=?, is_private=?, show_ticket_count=? WHERE id=?');
$stmt->execute([$this_user_id, $name, $event_type_id, $topic_id, $mode, $venue, $country_id, $state_id, $city, $latitude, $longitude, $start_datetime, $end_datetime, $timezone, $registration_deadline, $description, $organizers, $sponsors, $banner_image_id, $is_private, $show_ticket_count, $id]);

// Sync tags
$pdo->prepare('DELETE FROM module_conference_tags WHERE conference_id=?')->execute([$id]);
$tagsInput = $_POST['tags'] ?? [];
$tags = [];
if (is_string($tagsInput)) {
    $tags = array_filter(array_map('trim', explode(',', $tagsInput)));
} elseif (is_array($tagsInput)) {
    $tags = array_filter(array_map('trim', $tagsInput));
}
if ($tags) {
    $tagStmt = $pdo->prepare('INSERT INTO module_conference_tags (user_id, conference_id, tag) VALUES (?,?,?)');
    foreach ($tags as $tag) {
        $tagStmt->execute([$this_user_id, $id, $tag]);
    }
}

// Sync ticket options
$pdo->prepare('DELETE FROM module_conference_ticket_options WHERE conference_id=?')->execute([$id]);
$ticketOptions = $_POST['ticket_options'] ?? [];
if (is_string($ticketOptions)) {
    $decoded = json_decode($ticketOptions, true);
    $ticketOptions = is_array($decoded) ? $decoded : [];
}

if (is_array($ticketOptions)) {
    $ticketStmt = $pdo->prepare('INSERT INTO module_conference_ticket_options (user_id, conference_id, option_name, price) VALUES (?,?,?,?)');
    foreach ($ticketOptions as $t) {
        $name  = $t['option_name'] ?? ($t['name'] ?? null);
        $price = $t['price'] ?? 0;
        if ($name) {
            $ticketStmt->execute([$this_user_id, $id, $name, $price]);
        }
    }
}

// New images
$bannerIndex = $_POST['banner_image_index'] ?? null;
if (!empty($_FILES['images']['tmp_name'][0])) {
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) { mkdir($uploadDir,0777,true); }
    $imgStmt = $pdo->prepare('INSERT INTO module_conference_images (user_id, conference_id, file_name, file_path, file_size, file_type, is_banner) VALUES (?,?,?,?,?,?,?)');
    foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {
        if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
            $base = basename($_FILES['images']['name'][$i]);
            $safe = preg_replace('/[^A-Za-z0-9._-]/','_', $base);
            $target = 'conf_' . $id . '_' . time() . '_' . $safe;
            $targetPath = $uploadDir . $target;
            if (move_uploaded_file($tmp, $targetPath)) {
                $isBanner = ($bannerIndex !== null && (int)$bannerIndex === $i) ? 1 : 0;
                $path = '/module/conferences/uploads/' . $target;
                $imgStmt->execute([$this_user_id, $id, $base, $path, $_FILES['images']['size'][$i], $_FILES['images']['type'][$i], $isBanner]);
                if ($isBanner) {
                    $newImgId = $pdo->lastInsertId();
                    $pdo->prepare('UPDATE module_conferences SET banner_image_id=? WHERE id=?')->execute([$newImgId, $id]);
                }
            }
        }
    }
}

header('Location: ../index.php?action=details&id=' . $id);
exit;
?>
