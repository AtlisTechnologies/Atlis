<?php
require '../../../includes/php_header.php';
require_permission('conference','delete');

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    // remove images from disk
    $imgStmt = $pdo->prepare('SELECT file_path FROM module_conference_images WHERE conference_id=?');
    $imgStmt->execute([$id]);
    foreach ($imgStmt->fetchAll(PDO::FETCH_COLUMN) as $path) {
        $file = __DIR__ . '/../uploads/' . basename($path);
        if (is_file($file)) { @unlink($file); }
    }
    // delete child records
    $pdo->prepare('DELETE FROM module_conference_tags WHERE conference_id=?')->execute([$id]);
    $pdo->prepare('DELETE FROM module_conference_ticket_options WHERE conference_id=?')->execute([$id]);
    $pdo->prepare('DELETE FROM module_conference_images WHERE conference_id=?')->execute([$id]);
    // delete conference
    $pdo->prepare('DELETE FROM module_conferences WHERE id=?')->execute([$id]);
}
header('Location: ../index.php');
exit;
?>
