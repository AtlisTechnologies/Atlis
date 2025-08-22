<?php
require '../admin_header.php';
require_permission('organization','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  if (isset($_POST['delete_organization_id'])) {
    require_permission('organization','delete');
    $id = (int)$_POST['delete_organization_id'];
    $stmt = $pdo->prepare('DELETE FROM module_organization WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_organization', $id, 'DELETE', 'Deleted organization');
    $message = 'Organization deleted.';
  } elseif (isset($_POST['delete_agency_id'])) {
    require_permission('agency','delete');
    $id = (int)$_POST['delete_agency_id'];
    $stmt = $pdo->prepare('DELETE FROM module_agency WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_agency', $id, 'DELETE', 'Deleted agency');
    $message = 'Agency deleted.';
  } elseif (isset($_POST['delete_division_id'])) {
    require_permission('division','delete');
    $id = (int)$_POST['delete_division_id'];
    $stmt = $pdo->prepare('DELETE FROM module_division WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_division', $id, 'DELETE', 'Deleted division');
    $message = 'Division deleted.';
  }
}

$orgStatuses      = array_column(get_lookup_items($pdo, 'ORGANIZATION_STATUS'), null, 'id');
$agencyStatuses   = array_column(get_lookup_items($pdo, 'AGENCY_STATUS'), null, 'id');
$divisionStatuses = array_column(get_lookup_items($pdo, 'DIVISION_STATUS'), null, 'id');

// Load organizations, agencies and divisions in a single query
$sql = 'SELECT o.id AS org_id, o.name AS org_name, o.status AS org_status,
               a.id AS agency_id, a.name AS agency_name, a.status AS agency_status,
               a.file_path, a.file_name, a.file_type,
               d.id AS division_id, d.name AS division_name, d.status AS division_status
        FROM module_organization o
        LEFT JOIN module_agency a ON a.organization_id = o.id
        LEFT JOIN module_division d ON d.agency_id = a.id
        ORDER BY o.name, a.name, d.name';

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group the results by organization and agencies
$organizations = [];
foreach ($rows as $row) {
  $orgId = $row['org_id'];
  if (!isset($organizations[$orgId])) {
    $organizations[$orgId] = [
      'id'       => $orgId,
      'name'     => $row['org_name'],
      'status'   => $row['org_status'],
      'agencies' => []
    ];
  }

  if (!empty($row['agency_id'])) {
    $agencyId = $row['agency_id'];
    if (!isset($organizations[$orgId]['agencies'][$agencyId])) {
      $organizations[$orgId]['agencies'][$agencyId] = [
        'id'        => $agencyId,
        'name'      => $row['agency_name'],
        'status'    => $row['agency_status'],
        'file_path' => $row['file_path'],
        'file_name' => $row['file_name'],
        'file_type' => $row['file_type'],
        'divisions' => []
      ];
    }

    if (!empty($row['division_id'])) {
      $organizations[$orgId]['agencies'][$agencyId]['divisions'][$row['division_id']] = [
        'id'     => $row['division_id'],
        'name'   => $row['division_name'],
        'status' => $row['division_status']
      ];
    }
  }
}

// Attach assigned persons
$orgPeople = $pdo->query('SELECT op.organization_id, CONCAT(p.first_name," ",p.last_name) AS name, op.is_lead, li.label AS role_label FROM module_organization_persons op JOIN person p ON op.person_id = p.id LEFT JOIN lookup_list_items li ON op.role_id = li.id')->fetchAll(PDO::FETCH_ASSOC);
foreach ($orgPeople as $p) {
  $organizations[$p['organization_id']]['persons'][] = $p;
}

$agencyPeople = $pdo->query('SELECT ap.agency_id, CONCAT(p.first_name," ",p.last_name) AS name, ap.is_lead, li.label AS role_label FROM module_agency_persons ap JOIN person p ON ap.person_id = p.id LEFT JOIN lookup_list_items li ON ap.role_id = li.id')->fetchAll(PDO::FETCH_ASSOC);
foreach ($agencyPeople as $p) {
  foreach ($organizations as &$org) {
    if (isset($org['agencies'][$p['agency_id']])) {
      $org['agencies'][$p['agency_id']]['persons'][] = $p;
      break;
    }
  }
  unset($org);
}

$divisionPeople = $pdo->query('SELECT dp.division_id, CONCAT(p.first_name," ",p.last_name) AS name, dp.is_lead, li.label AS role_label FROM module_division_persons dp JOIN person p ON dp.person_id = p.id LEFT JOIN lookup_list_items li ON dp.role_id = li.id')->fetchAll(PDO::FETCH_ASSOC);
foreach ($divisionPeople as $p) {
  foreach ($organizations as &$org) {
    foreach ($org['agencies'] as &$agency) {
      if (isset($agency['divisions'][$p['division_id']])) {
        $agency['divisions'][$p['division_id']]['persons'][] = $p;
        break 2;
      }
    }
    unset($agency);
  }
  unset($org);
}

// Re-index children arrays for easy iteration in the view
foreach ($organizations as &$org) {
  $org['agencies'] = array_values($org['agencies']);
  foreach ($org['agencies'] as &$agency) {
    $agency['divisions'] = array_values($agency['divisions']);
  }
  unset($agency);
}
unset($org);

// Convert to a simple indexed array
$organizations = array_values($organizations);
?>
<h2 class="mb-4">Organizations</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<?php if (user_has_permission('organization','create')): ?>
  <a href="organization_edit.php" class="btn btn-sm btn-success mb-3">Add Organization</a>
<?php endif; ?>
<div class="table-responsive">
  <table class="table fs-9 mb-0 border-top border-translucent">
    <thead>
      <tr>
        <th>Name</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($organizations as $org): ?>
        <tr>
          <td class="ps-2">
            <?= htmlspecialchars($org['name']); ?>
            <?php if (!empty($org['persons'])): ?>
              <br><small>
                <?php
                  $parts = [];
                  foreach ($org['persons'] as $p) {
                    $label = $p['name'];
                    if ($p['role_label']) $label .= ' ('.$p['role_label'].')';
                    if ($p['is_lead']) $label .= ' [Lead]';
                    $parts[] = htmlspecialchars($label);
                  }
                  echo implode(', ', $parts);
                ?>
              </small>
            <?php endif; ?>
          </td>
          <td>
            <?= render_status_badge($orgStatuses, $org['status']) ?>
          </td>
          <td>
            <a class="btn btn-sm btn-warning" href="organization_edit.php?id=<?= $org['id']; ?>">Edit</a>
            <?php if (user_has_permission('organization','delete')): ?>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_organization_id" value="<?= $org['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this organization?');">Delete</button>
              </form>
            <?php endif; ?>
            <?php if (user_has_permission('agency','create')): ?>
              <a class="btn btn-sm btn-success" href="agency_edit.php?organization_id=<?= $org['id']; ?>">Add Agency</a>
            <?php endif; ?>
          </td>
        </tr>
        <?php foreach ($org['agencies'] as $agency): ?>
          <tr class="bg-body-tertiary">
            <td class="ps-8"><b>Agency:</b> <?= htmlspecialchars($agency['name']); ?>
              <?php if (!empty($agency['file_path'])): ?>
                <br><a href="/module/agency/download.php?id=<?= $agency['id']; ?>" target="_blank">View File</a>
              <?php endif; ?>
              <?php if (!empty($agency['persons'])): ?>
                <br><small>
                  <?php
                    $parts = [];
                    foreach ($agency['persons'] as $p) {
                      $label = $p['name'];
                      if ($p['role_label']) $label .= ' ('.$p['role_label'].')';
                      if ($p['is_lead']) $label .= ' [Lead]';
                      $parts[] = htmlspecialchars($label);
                    }
                    echo implode(', ', $parts);
                  ?>
                </small>
              <?php endif; ?>
            </td>
            <td>
              <?= render_status_badge($agencyStatuses, $agency['status']) ?>
            </td>
            <td>
              <a class="btn btn-sm btn-warning" href="agency_edit.php?id=<?= $agency['id']; ?>">Edit</a>
              <?php if (user_has_permission('agency','delete')): ?>
                <form method="post" class="d-inline">
                  <input type="hidden" name="delete_agency_id" value="<?= $agency['id']; ?>">
                  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this agency?');">Delete</button>
                </form>
              <?php endif; ?>
              <?php if (user_has_permission('division','create')): ?>
                <a class="btn btn-sm btn-success" href="division_edit.php?agency_id=<?= $agency['id']; ?>">Add Division</a>
              <?php endif; ?>
            </td>
          </tr>
          <?php foreach ($agency['divisions'] as $division): ?>
            <tr class="bg-body-secondary">
              <td class="ps-12"><b>Division:</b> <?= htmlspecialchars($division['name']); ?>
                <?php if (!empty($division['persons'])): ?>
                  <br><small>
                    <?php
                      $parts = [];
                      foreach ($division['persons'] as $p) {
                        $label = $p['name'];
                        if ($p['role_label']) $label .= ' ('.$p['role_label'].')';
                        if ($p['is_lead']) $label .= ' [Lead]';
                        $parts[] = htmlspecialchars($label);
                      }
                      echo implode(', ', $parts);
                    ?>
                  </small>
                <?php endif; ?>
              </td>
              <td>
                <?= render_status_badge($divisionStatuses, $division['status']) ?>
              </td>
              <td>
                <a class="btn btn-sm btn-warning" href="division_edit.php?id=<?= $division['id']; ?>">Edit</a>
                <?php if (user_has_permission('division','delete')): ?>
                  <form method="post" class="d-inline">
                    <input type="hidden" name="delete_division_id" value="<?= $division['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this division?');">Delete</button>
                  </form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require '../admin_footer.php'; ?>
