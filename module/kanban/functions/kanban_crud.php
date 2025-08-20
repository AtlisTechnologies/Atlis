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
    $board_id = (int)$pdo->lastInsertId();

    // Seed board statuses with all TASK_STATUS values
    $statusStmt = $pdo->prepare('SELECT li.id, li.sort_order FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = ? ORDER BY li.sort_order');
    $statusStmt->execute(['TASK_STATUS']);
    $insertStatus = $pdo->prepare('INSERT INTO module_kanban_board_statuses (user_id, board_id, status_id, sort_order) VALUES (?,?,?,?)');
    foreach ($statusStmt as $row) {
        $insertStatus->execute([$user_id, $board_id, $row['id'], $row['sort_order']]);
    }

    return $board_id;
}

function delete_board(PDO $pdo, int $id): void {
    $pdo->prepare('DELETE FROM module_kanban_boards WHERE id=?')->execute([$id]);
}

function fetch_statuses(PDO $pdo, int $board_id): array {
    $sql = 'SELECT bs.status_id, li.label, bs.sort_order
            FROM module_kanban_board_statuses bs
            JOIN lookup_list_items li ON bs.status_id = li.id
            WHERE bs.board_id=?
            ORDER BY bs.sort_order';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$board_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetch_board_projects(PDO $pdo, int $board_id): array {
    $stmt = $pdo->prepare('SELECT project_id FROM module_kanban_board_projects WHERE board_id=?');
    $stmt->execute([$board_id]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function save_board_projects(PDO $pdo, int $board_id, array $projects, int $user_id): void {
    $pdo->prepare('DELETE FROM module_kanban_board_projects WHERE board_id=?')->execute([$board_id]);
    if (!$projects) {
        return;
    }
    $stmt = $pdo->prepare('INSERT INTO module_kanban_board_projects (user_id, board_id, project_id) VALUES (?,?,?)');
    foreach ($projects as $pid) {
        $stmt->execute([$user_id, $board_id, $pid]);
    }
}

function fetch_tasks_for_status(PDO $pdo, int $board_id, int $status_id): array {
    $projectIds = fetch_board_projects($pdo, $board_id);
    if (!$projectIds) {
        return [];
    }
    $placeholders = implode(',', array_fill(0, count($projectIds), '?'));
    $sql = "SELECT id, name FROM module_tasks WHERE status=? AND project_id IN ($placeholders) ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge([$status_id], $projectIds));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
