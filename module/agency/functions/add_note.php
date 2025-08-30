<?php
require '../../../includes/php_header.php';
require_permission('agency','create|update');

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$note = trim($_POST['note'] ?? '');
if ($id && $note !== '') {
    $stmt = $pdo->prepare('INSERT INTO module_agency_notes (user_id,user_updated,agency_id,note_text) VALUES (:uid,:uid,:aid,:note)');
    $stmt->execute([
        ':uid' => $this_user_id,
        ':aid' => $id,
        ':note' => $note
    ]);
    $noteId = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'module_agency_notes', $noteId, 'NOTE', '', $note);

    $html = '<li class="list-group-item d-flex justify-content-between align-items-start">'
          . '<div>' . nl2br(e($note)) . '</div>'
          . '<small class="text-muted ms-2">' . date('Y-m-d H:i:s') . '</small>'
          . '</li>';

    header('Content-Type: application/json');
    echo json_encode(['html' => $html, 'id' => $noteId]);
    exit;
}

http_response_code(400);
header('Content-Type: application/json');
echo json_encode(['error' => 'Invalid input']);
exit;

