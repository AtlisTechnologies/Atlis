<?php
require '../../../includes/php_header.php';
require_permission('project','update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectId = (int)($_POST['project_id'] ?? 0);
    $field = $_POST['field'] ?? '';
    $value = (int)($_POST['value'] ?? 0);
    $allowed = ['status','priority'];
    if ($projectId > 0 && in_array($field, $allowed, true)) {
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
