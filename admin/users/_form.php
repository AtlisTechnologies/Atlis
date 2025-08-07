<?php
// Shared form for creating and editing users.
// Expects: $token, $id, $username, $email, $first_name, $last_name,
//          $type, $status, $btnClass, $assigned (array of role ids)
// Uses: $pdo for database access.

$roles = $roles ?? $pdo->query('SELECT id, name FROM admin_roles ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);

$typeStmt = $pdo->prepare("SELECT li.value, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'USER_TYPE' ORDER BY li.sort_order, li.label");
$typeStmt->execute();
$typeOptions = $typeStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$statusStmt = $pdo->prepare("SELECT li.value, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'USER_STATUS' ORDER BY li.sort_order, li.label");
$statusStmt->execute();
$statusOptions = $statusStmt->fetchAll(PDO::FETCH_KEY_PAIR);

if (!$id) {
    $type = array_key_first($typeOptions) ?? $type;
    $status = (int)(array_key_first($statusOptions) ?? $status);
}
?>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($username); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password <?= $id ? '(leave blank to keep current)' : ''; ?></label>
    <input type="password" class="form-control" name="password" <?= $id ? '' : 'required'; ?>>
  </div>
  <div class="mb-3">
    <label class="form-label">First Name</label>
    <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($first_name); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Last Name</label>
    <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($last_name); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Type</label>
    <select class="form-select" name="type">
      <?php foreach($typeOptions as $value => $label): ?>
        <option value="<?= htmlspecialchars($value); ?>" <?= $type === $value ? 'selected' : ''; ?>><?= htmlspecialchars($label); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select class="form-select" name="status">
      <?php foreach($statusOptions as $value => $label): ?>
        <option value="<?= htmlspecialchars($value); ?>" <?= (string)$status === $value ? 'selected' : ''; ?>><?= htmlspecialchars($label); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Roles</label>
    <?php foreach($roles as $r): ?>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $r['id']; ?>" id="role<?= $r['id']; ?>" <?= in_array($r['id'], $assigned) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="role<?= $r['id']; ?>"><?= htmlspecialchars($r['name']); ?></label>
      </div>
    <?php endforeach; ?>
  </div>
  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Back</a>
</form>
