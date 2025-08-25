<?php
require '../../admin_header.php';
require_permission('sow','read');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sow = null;
if ($id) {
  $stmt = $pdo->prepare('SELECT * FROM module_sows WHERE id = :id');
  $stmt->execute([':id'=>$id]);
  $sow = $stmt->fetch(PDO::FETCH_ASSOC);
}

$orgs = $pdo->query('SELECT id,name FROM module_organization ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$agencies = $pdo->query('SELECT id,name,organization_id FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$divisions = $pdo->query('SELECT id,name,agency_id FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$projects = $pdo->query('SELECT id,name FROM module_projects ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$statuses = get_lookup_items($pdo,'SOW_STATUS');
$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

// Load join-table items
$tasks = $users = $qa = $links = $notes = $logins = $lineItems = [];
if($id){
  $tasks = $pdo->prepare('SELECT task_id FROM module_sow_tasks WHERE sow_id = :id');
  $tasks->execute([':id'=>$id]);
  $tasks = $tasks->fetchAll(PDO::FETCH_COLUMN);

  $users = $pdo->prepare('SELECT person_id FROM module_sow_users WHERE sow_id = :id');
  $users->execute([':id'=>$id]);
  $users = $users->fetchAll(PDO::FETCH_COLUMN);

  $qa = $pdo->prepare('SELECT question,answer FROM module_sow_questions WHERE sow_id = :id');
  $qa->execute([':id'=>$id]);
  $qa = $qa->fetchAll(PDO::FETCH_ASSOC);

  $links = $pdo->prepare('SELECT url,description FROM module_sow_links WHERE sow_id = :id');
  $links->execute([':id'=>$id]);
  $links = $links->fetchAll(PDO::FETCH_ASSOC);

  $notes = $pdo->prepare('SELECT note_text FROM module_sow_notes WHERE sow_id = :id');
  $notes->execute([':id'=>$id]);
  $notes = $notes->fetchAll(PDO::FETCH_COLUMN);

  $logins = $pdo->prepare('SELECT login_url,login_username,login_password FROM module_sow_logins WHERE sow_id = :id');
  $logins->execute([':id'=>$id]);
  $logins = $logins->fetchAll(PDO::FETCH_ASSOC);

  $lineItems = $pdo->prepare('SELECT description,amount FROM module_sow_line_items WHERE sow_id = :id');
  $lineItems->execute([':id'=>$id]);
  $lineItems = $lineItems->fetchAll(PDO::FETCH_ASSOC);
}
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Create' ?> Statement of Work</h2>
<form method="post" action="functions/<?= $id ? 'update.php' : 'create.php' ?>">
  <input type="hidden" name="csrf_token" value="<?= h($token) ?>">
  <?php if($id): ?><input type="hidden" name="id" value="<?= h($id) ?>"><?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="<?= h($sow['title'] ?? '') ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Summary</label>
    <textarea name="summary" class="form-control" rows="4"><?= h($sow['summary'] ?? '') ?></textarea>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="form-label">Organization</label>
      <select name="organization_id" class="form-select">
        <option value="">--</option>
        <?php foreach($orgs as $o): ?>
          <option value="<?= h($o['id']) ?>" <?= ($sow['organization_id'] ?? '')==$o['id']?'selected':'' ?>><?= h($o['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Agency</label>
      <select name="agency_id" class="form-select">
        <option value="">--</option>
        <?php foreach($agencies as $a): ?>
          <option value="<?= h($a['id']) ?>" data-org="<?= h($a['organization_id']) ?>" <?= ($sow['agency_id'] ?? '')==$a['id']?'selected':'' ?>><?= h($a['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Division</label>
      <select name="division_id" class="form-select">
        <option value="">--</option>
        <?php foreach($divisions as $d): ?>
          <option value="<?= h($d['id']) ?>" data-agency="<?= h($d['agency_id']) ?>" <?= ($sow['division_id'] ?? '')==$d['id']?'selected':'' ?>><?= h($d['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <label class="form-label">Project</label>
      <select name="project_id" class="form-select">
        <option value="">--</option>
        <?php foreach($projects as $p): ?>
          <option value="<?= h($p['id']) ?>" <?= ($sow['project_id'] ?? '')==$p['id']?'selected':'' ?>><?= h($p['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status_id" class="form-select">
      <option value="">--</option>
      <?php foreach($statuses as $st): ?>
        <option value="<?= h($st['id']) ?>" <?= ($sow['status_id'] ?? '')==$st['id']?'selected':'' ?>><?= h($st['label']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Signatures</label>
    <textarea name="signatures" class="form-control" rows="2"><?= h($sow['signatures'] ?? '') ?></textarea>
  </div>

  <h4>Tasks</h4>
  <div id="sowTasks">
    <?php foreach($tasks as $t): ?>
      <input type="text" name="tasks[]" class="form-control mb-1" value="<?= h($t) ?>">
    <?php endforeach; ?>
    <input type="text" name="tasks[]" class="form-control mb-1" placeholder="Task ID">
  </div>

  <h4>Users</h4>
  <div id="sowUsers">
    <?php foreach($users as $u): ?>
      <input type="text" name="users[]" class="form-control mb-1" value="<?= h($u) ?>">
    <?php endforeach; ?>
    <input type="text" name="users[]" class="form-control mb-1" placeholder="Person ID">
  </div>

  <h4>Q &amp; A</h4>
  <div id="sowQA">
    <?php foreach($qa as $row): ?>
      <div class="mb-2">
        <input type="text" name="qa_question[]" class="form-control mb-1" value="<?= h($row['question']) ?>" placeholder="Question">
        <input type="text" name="qa_answer[]" class="form-control" value="<?= h($row['answer']) ?>" placeholder="Answer">
      </div>
    <?php endforeach; ?>
    <div class="mb-2">
      <input type="text" name="qa_question[]" class="form-control mb-1" placeholder="Question">
      <input type="text" name="qa_answer[]" class="form-control" placeholder="Answer">
    </div>
  </div>

  <h4>Links</h4>
  <div id="sowLinks">
    <?php foreach($links as $row): ?>
      <div class="mb-2">
        <input type="text" name="link_url[]" class="form-control mb-1" value="<?= h($row['url']) ?>" placeholder="URL">
        <input type="text" name="link_desc[]" class="form-control" value="<?= h($row['description']) ?>" placeholder="Description">
      </div>
    <?php endforeach; ?>
    <div class="mb-2">
      <input type="text" name="link_url[]" class="form-control mb-1" placeholder="URL">
      <input type="text" name="link_desc[]" class="form-control" placeholder="Description">
    </div>
  </div>

  <h4>Notes</h4>
  <div id="sowNotes">
    <?php foreach($notes as $n): ?>
      <textarea name="notes[]" class="form-control mb-1" rows="2"><?= h($n) ?></textarea>
    <?php endforeach; ?>
    <textarea name="notes[]" class="form-control mb-1" rows="2" placeholder="Note"></textarea>
  </div>

  <h4>Logins</h4>
  <div id="sowLogins">
    <?php foreach($logins as $l): ?>
      <div class="mb-2">
        <input type="text" name="login_url[]" class="form-control mb-1" value="<?= h($l['login_url']) ?>" placeholder="URL">
        <input type="text" name="login_username[]" class="form-control mb-1" value="<?= h($l['login_username']) ?>" placeholder="Username">
        <input type="text" name="login_password[]" class="form-control" value="<?= h($l['login_password']) ?>" placeholder="Password">
      </div>
    <?php endforeach; ?>
    <div class="mb-2">
      <input type="text" name="login_url[]" class="form-control mb-1" placeholder="URL">
      <input type="text" name="login_username[]" class="form-control mb-1" placeholder="Username">
      <input type="text" name="login_password[]" class="form-control" placeholder="Password">
    </div>
  </div>

  <h4>Line Items</h4>
  <div id="sowLineItems">
    <?php foreach($lineItems as $li): ?>
      <div class="mb-2">
        <input type="text" name="item_desc[]" class="form-control mb-1" value="<?= h($li['description']) ?>" placeholder="Description">
        <input type="number" step="0.01" name="item_amount[]" class="form-control" value="<?= h($li['amount']) ?>" placeholder="Amount">
      </div>
    <?php endforeach; ?>
    <div class="mb-2">
      <input type="text" name="item_desc[]" class="form-control mb-1" placeholder="Description">
      <input type="number" step="0.01" name="item_amount[]" class="form-control" placeholder="Amount">
    </div>
  </div>

  <button class="btn btn-primary mt-3" type="submit">Save</button>
</form>
<?php require '../../admin_footer.php'; ?>
