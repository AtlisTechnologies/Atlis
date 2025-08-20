<?php
function fetch_boards(PDO $pdo): array {
    return $pdo->query('SELECT id, name FROM module_kanban_boards ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
}

function fetch_board(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare('SELECT id, name FROM module_kanban_boards WHERE id=?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function save_board(PDO $pdo, ?int $id, string $name, int $user_id): int {
    if ($id) {
        $stmt = $pdo->prepare('UPDATE module_kanban_boards SET user_updated=?, name=? WHERE id=?');
        $stmt->execute([$user_id, $name, $id]);
        return $id;
    }
    $stmt = $pdo->prepare('INSERT INTO module_kanban_boards (user_id, name) VALUES (?,?)');
    $stmt->execute([$user_id, $name]);
    return (int)$pdo->lastInsertId();
}

function delete_board(PDO $pdo, int $id): void {
    $pdo->prepare('DELETE FROM module_kanban_boards WHERE id=?')->execute([$id]);
}

function fetch_statuses(PDO $pdo, int $board_id): array {
    $stmt = $pdo->prepare('SELECT id, name, sort_order FROM module_kanban_statuses WHERE board_id=? ORDER BY sort_order');
    $stmt->execute([$board_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetch_tasks_for_status(PDO $pdo, string $status): array {
    $stmt = $pdo->prepare('SELECT id, name FROM module_tasks WHERE status=? ORDER BY id');
    $stmt->execute([$status]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
