<?php
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/helpers.php';
header('Content-Type: application/json');

try {
    require_permission('person','read');
    $person_id = isset($_GET['person_id']) ? (int)$_GET['person_id'] : 0;
    if($person_id <= 0){
        echo json_encode(['success'=>false,'error'=>'Invalid person_id']);
        exit;
    }
    $stmt = $pdo->prepare('SELECT ps.skill_id AS id, li.label FROM person_skills ps JOIN lookup_list_items li ON ps.skill_id = li.id WHERE ps.person_id = :pid ORDER BY li.label');
    $stmt->execute([':pid'=>$person_id]);
    $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success'=>true,'skills'=>$skills]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success'=>false,'error'=>'Server error']);
}

