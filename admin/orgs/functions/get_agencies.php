<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');

$token = $_GET['csrf_token'] ?? '';
if ($token !== ($_SESSION['csrf_token'] ?? '')) {
  echo json_encode(['error' => 'Invalid CSRF token']);
  exit;
}

require_permission('agency','read');

$parentId = (int)($_GET['parent_id'] ?? 0);

$agencyStatuses = array_column(get_lookup_items($pdo, 'AGENCY_STATUS'), null, 'id');

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

$stmt = $pdo->prepare('SELECT id,name,status,file_path,file_name,file_type FROM module_agency WHERE organization_id = :id ORDER BY name');
$stmt->execute([':id' => $parentId]);
$agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = '';
foreach ($agencies as $agency) {
  $attachment = render_file_attachment($agency['file_path'], $agency['file_name'], $agency['file_type'], "/module/agency/download.php?type=agency&id={$agency['id']}", 'agency');
  $pstmt = $pdo->prepare('SELECT CONCAT(p.first_name, " ", p.last_name) AS name FROM module_agency_persons ap JOIN person p ON ap.person_id = p.id WHERE ap.agency_id = :id ORDER BY name');
  $pstmt->execute([':id' => $agency['id']]);
  $persons = $pstmt->fetchAll(PDO::FETCH_COLUMN);
  $personsHtml = $persons ? '<div class="small text-muted">' . e(implode(', ', $persons)) . '</div>' : '';
  $statusBadge = render_status_badge($agencyStatuses, $agency['status']);
  $html .= "<div class='accordion-item'><h2 class='accordion-header'><button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#agency{$agency['id']}'>" . e($agency['name']) . "</button></h2><div id='agency{$agency['id']}' class='accordion-collapse collapse' data-type='divisions' data-parent-id='{$agency['id']}'><div class='accordion-body'><div class=\"d-flex justify-content-between align-items-start\"><div>{$attachment}{$personsHtml}</div><div>{$statusBadge}</div></div></div></div></div>";
}

echo json_encode(['html' => $html]);

