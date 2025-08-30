<?php
require '../../includes/php_header.php';
require_permission('agency','read');

$id = (int)($_GET['id'] ?? 0);
if(!$id){
  echo 'Invalid agency ID';
  exit;
}

$sql = 'SELECT a.*, o.name AS organization_name FROM module_agency a LEFT JOIN module_organization o ON a.organization_id = o.id WHERE a.id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$agency = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$agency){
  echo 'Agency not found';
  exit;
}

$filesStmt = $pdo->prepare('SELECT id,file_name,file_path,file_size,file_type FROM module_agency_files WHERE agency_id = :id ORDER BY date_created DESC');
$filesStmt->execute([':id' => $id]);
$files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);

$notesStmt = $pdo->prepare('SELECT id,note_text,date_created FROM module_agency_notes WHERE agency_id = :id ORDER BY date_created DESC');
$notesStmt->execute([':id' => $id]);
$notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);

$peopleStmt = $pdo->prepare('SELECT aa.assigned_user_id AS user_id, COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) AS name, ap.is_lead, ap.role_id FROM module_agency_assignments aa JOIN users u ON aa.assigned_user_id = u.id LEFT JOIN person p ON u.id = p.user_id LEFT JOIN module_agency_persons ap ON ap.agency_id = aa.agency_id AND ap.person_id = p.id WHERE aa.agency_id = :id ORDER BY name');
$peopleStmt->execute([':id' => $id]);
$people = $peopleStmt->fetchAll(PDO::FETCH_ASSOC);

$divisionCount = (int)$pdo->query('SELECT COUNT(*) FROM module_division WHERE agency_id = '.(int)$id)->fetchColumn();

$statusList = array_column(get_lookup_items($pdo,'AGENCY_STATUS'), null, 'id');
$roleList = array_column(get_lookup_items($pdo,'AGENCY_PERSON_ROLES'), null, 'id');

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php // require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <div class="card">
      <div class="card-header">
        <h2 class="mb-0">Agency: <?= e($agency['name']); ?></h2>
      </div>
      <div class="card-body">
        <ul class="nav nav-tabs mb-3" id="agencyTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">Files</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">Notes</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="people-tab" data-bs-toggle="tab" data-bs-target="#people" type="button" role="tab">People</button>
          </li>
        </ul>
        <div class="tab-content" id="agencyTabsContent">
          <div class="tab-pane fade show active" id="overview" role="tabpanel">
            <p class="mb-2">
              <?php if (!empty($agency['organization_name'])): ?>
                <span class="badge badge-phoenix badge-phoenix-info fs-10"><?= e($agency['organization_name']); ?></span>
              <?php endif; ?>
              <?= render_status_badge($statusList, $agency['status'], 'fs-10'); ?>
            </p>
          </div>
          <div class="tab-pane fade" id="files" role="tabpanel">
            <?php if (user_has_permission('agency','create|update')): ?>
            <form id="fileUploadForm" class="mb-3" action="functions/upload_file.php" method="post" enctype="multipart/form-data">
              <?= csrf_field(); ?>
              <input type="hidden" name="id" value="<?= $id; ?>">
              <div class="mb-2">
                <input class="form-control" type="file" name="file" required>
              </div>
              <button class="btn btn-primary btn-sm" type="submit">Upload</button>
            </form>
            <?php endif; ?>
            <div class="row g-3" id="fileGrid">
              <?php foreach ($files as $f): ?>
              <div class="col-6 col-md-4 col-lg-3">
                <div class="border rounded p-2 text-center h-100 d-flex flex-column">
                  <a href="<?= e($f['file_path']); ?>" data-fslightbox="agency-files">
                    <?php if (strpos($f['file_type'],'image/') === 0): ?>
                      <img src="<?= e($f['file_path']); ?>" alt="<?= e($f['file_name']); ?>" class="img-fluid rounded">
                    <?php else: ?>
                      <div class="d-flex align-items-center justify-content-center bg-body-tertiary rounded" style="height:100px;">
                        <span class="fa-solid fa-file fs-3"></span>
                      </div>
                    <?php endif; ?>
                  </a>
                  <div class="mt-2 small flex-grow-1">
                    <?= e($f['file_name']); ?>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mt-1 small text-muted">
                    <span><?= round($f['file_size']/1024,1); ?> KB</span>
                    <a href="<?= e($f['file_path']); ?>" download class="text-secondary"><span class="fa-solid fa-download"></span></a>
                  </div>
                  <div class="small text-muted"><?= e($f['file_type']); ?></div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="tab-pane fade" id="notes" role="tabpanel">
            <?php if (user_has_permission('agency','create|update')): ?>
            <form id="noteForm" class="mb-3" action="functions/add_note.php" method="post">
              <?= csrf_field(); ?>
              <input type="hidden" name="id" value="<?= $id; ?>">
              <textarea class="form-control mb-2" name="note" rows="3" required></textarea>
              <button class="btn btn-primary btn-sm" type="submit">Add Note</button>
            </form>
            <?php endif; ?>
            <ul class="list-group" id="notesList">
              <?php foreach ($notes as $n): ?>
              <li class="list-group-item d-flex justify-content-between align-items-start">
                <div><?= nl2br(e($n['note_text'])); ?></div>
                <small class="text-muted ms-2"><?= e($n['date_created']); ?></small>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="tab-pane fade" id="people" role="tabpanel">
            <p><span class="badge bg-info-subtle text-info">Divisions: <?= $divisionCount; ?></span></p>
            <?php if ($people): ?>
            <ul class="list-group">
              <?php foreach ($people as $p): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <?= e($p['name']); ?>
                  <?php if (!empty($p['is_lead'])): ?>
                    <span class="fa-solid fa-star text-warning ms-1"></span>
                  <?php endif; ?>
                </div>
                <?php if (!empty($p['role_id'])): ?>
                  <?= render_status_badge($roleList, $p['role_id'], 'fs-10'); ?>
                <?php endif; ?>
              </li>
              <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p class="text-muted">No users assigned.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/fslightbox/index.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const fileForm = document.getElementById('fileUploadForm');
  if(fileForm){
    fileForm.addEventListener('submit', function(e){
      e.preventDefault();
      const formData = new FormData(fileForm);
      fetch('functions/upload_file.php', {method:'POST', body:formData})
        .then(r => r.json())
        .then(data => {
          if(data.file){
            const f = data.file;
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4 col-lg-3';
            col.innerHTML = `<div class="border rounded p-2 text-center h-100 d-flex flex-column">
              <a href="${f.path}" data-fslightbox="agency-files">
                ${f.type.startsWith('image/') ? `<img src="${f.path}" alt="${f.name}" class="img-fluid rounded">` :
                `<div class=\"d-flex align-items-center justify-content-center bg-body-tertiary rounded\" style=\"height:100px;\">
                  <span class=\"fa-solid fa-file fs-3\"></span>
                </div>`}
              </a>
              <div class="mt-2 small flex-grow-1">${f.name}</div>
              <div class="d-flex justify-content-between align-items-center mt-1 small text-muted">
                <span>${(f.size/1024).toFixed(1)} KB</span>
                <a href="${f.path}" download class="text-secondary"><span class="fa-solid fa-download"></span></a>
              </div>
              <div class="small text-muted">${f.type}</div>
            </div>`;
            document.getElementById('fileGrid').prepend(col);
            refreshFsLightbox();
            fileForm.reset();
          }
        });
    });
  }
  const noteForm = document.getElementById('noteForm');
  if(noteForm){
    noteForm.addEventListener('submit', function(e){
      e.preventDefault();
      const formData = new FormData(noteForm);
      fetch('functions/add_note.php', {method:'POST', body:formData})
        .then(r => r.json())
        .then(data => {
          if(data.html){
            document.getElementById('notesList').insertAdjacentHTML('afterbegin', data.html);
            noteForm.reset();
          }
        });
    });
  }
});
</script>

