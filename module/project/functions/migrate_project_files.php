<?php
// CLI script to move project files into project-specific folders
require __DIR__ . '/../../../includes/config.php';

$baseDir = __DIR__ . '/../uploads/';

$stmt = $pdo->query('SELECT id, project_id, file_path FROM module_projects_files');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $fileName = basename($row['file_path']);
    $oldPath = $baseDir . $fileName;
    $projectDir = $baseDir . $row['project_id'] . '/';
    $newPath = $projectDir . $fileName;

    if (!is_dir($projectDir)) {
        mkdir($projectDir, 0777, true);
    }

    if (file_exists($oldPath) && !file_exists($newPath)) {
        rename($oldPath, $newPath);
    }

    $newRel = '/module/project/uploads/' . $row['project_id'] . '/' . $fileName;
    $update = $pdo->prepare('UPDATE module_projects_files SET file_path = :path WHERE id = :id');
    $update->execute([':path' => $newRel, ':id' => $row['id']]);
}

echo "Project file migration completed.\n";
