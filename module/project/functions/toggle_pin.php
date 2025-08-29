<?php
require '../../../includes/php_header.php';
require_permission('project','read');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

header('Content-Type: application/json');

$project_id = (int)($_POST['project_id'] ?? 0);
$pinned = false;

if ($project_id) {
    $check = $pdo->prepare('SELECT id FROM module_projects_pins WHERE user_id = :uid AND project_id = :pid');
    $check->execute([':uid' => $this_user_id, ':pid' => $project_id]);
    $pin_id = $check->fetchColumn();

    if ($pin_id) {
        $del = $pdo->prepare('DELETE FROM module_projects_pins WHERE id = :id');
        $del->execute([':id' => $pin_id]);
        $pinned = false;
    } else {
        $ins = $pdo->prepare('INSERT INTO module_projects_pins (user_id,user_updated,project_id) VALUES (:uid,:uid,:pid)');
        $ins->execute([':uid' => $this_user_id, ':pid' => $project_id]);
        $pinned = true;
    }
}

echo json_encode(['pinned' => $pinned]);
