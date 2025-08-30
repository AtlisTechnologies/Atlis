<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');

$token = $_GET['csrf_token'] ?? '';
if ($token !== ($_SESSION['csrf_token'] ?? '')) {
  echo json_encode(['error' => 'Invalid CSRF token']);
  exit;
}

require_permission('division','read');

$parentId = (int)($_GET['parent_id'] ?? 0);

$divisionStatuses = array_column(get_lookup_items($pdo, 'DIVISION_STATUS'), null, 'id');

function render_file_attachment($file_path, $file_name, $file_type, $downloadUrl, $subdir) {
  if (empty($file_name)) {
    return '';
  }
  $path = $file_path;
  if (strpos($path, '/') !== 0) {
    $path = "/module/agency/uploads/{$subdir}/{$path}";
  }
  $src = getURLDir() . ltrim($path, '/');
  $downloadUrl = e($downloadUrl, ENT_QUOTES);
  $escName = e($file_name);
  $srcEsc = e($src, ENT_QUOTES);
  $download = "<a href=\"{$downloadUrl}\" class=\"ms-2\" download><span class=\"fas fa-download\"></span></a>";
  if (strpos($file_type, 'image/') === 0 || $file_type === 'application/pdf') {
    $preview = strpos($file_type, 'image/') === 0 ? "<img src=\"{$srcEsc}\" class=\"img-thumbnail\" style=\"max-width:100px;\" alt=\"{$escName}\">" : "<span class=\"fas fa-file-pdf me-1\"></span>{$escName}";
    return "<div class=\"mt-2\"><a href=\"{$srcEsc}\" data-fslightbox>{$preview}</a>{$download}</div>";
  }
  return "<div class=\"mt-2\"><a href=\"{$downloadUrl}\" class=\"d-inline-flex align-items-center\" download><span class=\"fas fa-paperclip me-1\"></span>{$escName}</a>{$download}</div>";
}

$stmt = $pdo->prepare('SELECT id,name,status,file_path,file_name,file_type FROM module_division WHERE agency_id = :id ORDER BY name');
$stmt->execute([':id' => $parentId]);
$divisions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = '<ul class="list-group">';
foreach ($divisions as $div) {
  $attachment = render_file_attachment($div['file_path'], $div['file_name'], $div['file_type'], "/module/agency/download.php?type=division&id={$div['id']}", 'division');
  $pstmt = $pdo->prepare('SELECT CONCAT(p.first_name, " ", p.last_name) AS name FROM module_division_persons dp JOIN person p ON dp.person_id = p.id WHERE dp.division_id = :id ORDER BY name');
  $pstmt->execute([':id' => $div['id']]);
  $persons = $pstmt->fetchAll(PDO::FETCH_COLUMN);
  $personsHtml = $persons ? '<div class="small text-muted">' . e(implode(', ', $persons)) . '</div>' : '';
  $statusBadge = render_status_badge($divisionStatuses, $div['status']);
  $html .= "<li class='list-group-item'><div class='d-flex justify-content-between align-items-start'><div><span class='fw-semibold'>" . e($div['name']) . "</span>{$attachment}{$personsHtml}</div><div>{$statusBadge}</div></div></li>";
}
$html .= '</ul>';

echo json_encode(['html' => $html]);

