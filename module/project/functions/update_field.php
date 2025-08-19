<?php
require '../../../includes/php_header.php';
require_permission('project','update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectId = (int)($_POST['project_id'] ?? 0);
    $field = $_POST['field'] ?? '';
    $value = $_POST['value'] ?? '';
    $allowed = ['status','priority','start_date','complete_date'];
    if ($projectId > 0 && in_array($field, $allowed, true)) {
        if (in_array($field, ['status','priority'], true)) {
            $value = (int)$value;
        }
        $stmt = $pdo->prepare("UPDATE module_projects SET $field = :val, user_updated = :uid WHERE id = :id");
        $stmt->execute([
            ':val' => $value,
            ':uid' => $this_user_id,
            ':id' => $projectId
        ]);
        audit_log($pdo, $this_user_id, 'module_projects', $projectId, 'UPDATE', "Updated $field to $value");
        echo json_encode(['success' => true]);
        exit;
    }
}

echo json_encode(['success' => false]);
