<?php
require_once '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$first_name = $last_name = $email = $dob = '';
$gender_id = $organization_id = $agency_id = $division_id = null;
$existing = null;
$addresses = [];
$phones = [];
$btnClass = $id ? 'btn-warning' : 'btn-success';

if ($id) {
  require_permission('person','update');
  $stmt = $pdo->prepare('SELECT * FROM person WHERE id = :id');
  $stmt->execute([':id'=>$id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['user_id']) {
      header('Location: ../users/edit.php?id=' . $row['user_id']);
      exit;
    }
    $existing = $row;
    $first_name = $row['first_name'] ?? '';
    $last_name  = $row['last_name'] ?? '';
    $email      = $row['email'] ?? '';
    $gender_id  = $row['gender_id'] ?? null;
    $dob        = $row['dob'] ?? '';
    $organization_id = $row['organization_id'] ?? null;
    $agency_id       = $row['agency_id'] ?? null;
    $division_id     = $row['division_id'] ?? null;

    $stmt = $pdo->prepare('SELECT * FROM person_addresses WHERE person_id = :id');
    $stmt->execute([':id'=>$id]);
    $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT * FROM person_phones WHERE person_id = :id');
    $stmt->execute([':id'=>$id]);
    $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
} else {
  require_permission('person','create');
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$genderItems        = get_lookup_items($pdo, 'USER_GENDER');
$orgItems           = $pdo->query('SELECT id, name FROM module_organization ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$agencyItems        = $pdo->query('SELECT id, name FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$divisionItems      = $pdo->query('SELECT id, name FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$addressTypeItems   = get_lookup_items($pdo, 'PERSON_ADDRESS_TYPE');
$addressStatusItems = get_lookup_items($pdo, 'PERSON_ADDRESS_STATUS');
$phoneTypeItems     = get_lookup_items($pdo, 'PERSON_PHONE_TYPE');
$phoneStatusItems   = get_lookup_items($pdo, 'PERSON_PHONE_STATUS');

function get_default_id(array $items) {
  foreach ($items as $i) { if (!empty($i['is_default'])) return $i['id']; }
  return null;
}
$defaultAddressTypeId   = get_default_id($addressTypeItems);
$defaultAddressStatusId = get_default_id($addressStatusItems);
$defaultPhoneTypeId     = get_default_id($phoneTypeItems);
$defaultPhoneStatusId   = get_default_id($phoneStatusItems);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $first_name = trim($_POST['first_name'] ?? '');
  $last_name  = trim($_POST['last_name'] ?? '');
  $email      = trim($_POST['email'] ?? '');
  $gender_id  = $_POST['gender_id'] !== '' ? (int)$_POST['gender_id'] : null;
  $dob        = $_POST['dob'] !== '' ? $_POST['dob'] : null;
  $organization_id = $_POST['organization_id'] !== '' ? (int)$_POST['organization_id'] : null;
  $agency_id       = $_POST['agency_id'] !== '' ? (int)$_POST['agency_id'] : null;
  $division_id     = $_POST['division_id'] !== '' ? (int)$_POST['division_id'] : null;
  $addresses = $_POST['addresses'] ?? [];
  $phones    = $_POST['phones'] ?? [];

  $pdo->beginTransaction();
  try {
    if ($id) {
      $stmt = $pdo->prepare('UPDATE person SET first_name=:first_name,last_name=:last_name,email=:email,gender_id=:gender_id,organization_id=:organization_id,agency_id=:agency_id,division_id=:division_id,dob=:dob,user_updated=:uid WHERE id=:id');
      $stmt->execute([':first_name'=>$first_name,':last_name'=>$last_name,':email'=>$email,':gender_id'=>$gender_id,':organization_id'=>$organization_id,':agency_id'=>$agency_id,':division_id'=>$division_id,':dob'=>$dob,':uid'=>$this_user_id,':id'=>$id]);
      admin_audit_log($pdo,$this_user_id,'person',$id,'UPDATE',json_encode($existing),json_encode(['first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,'gender_id'=>$gender_id,'organization_id'=>$organization_id,'agency_id'=>$agency_id,'division_id'=>$division_id,'dob'=>$dob]),'Updated person');
    } else {
      $stmt = $pdo->prepare('INSERT INTO person (first_name,last_name,email,gender_id,organization_id,agency_id,division_id,dob,user_updated) VALUES (:first_name,:last_name,:email,:gender_id,:organization_id,:agency_id,:division_id,:dob,:uid)');
      $stmt->execute([':first_name'=>$first_name,':last_name'=>$last_name,':email'=>$email,':gender_id'=>$gender_id,':organization_id'=>$organization_id,':agency_id'=>$agency_id,':division_id'=>$division_id,':dob'=>$dob,':uid'=>$this_user_id]);
      $id = $pdo->lastInsertId();
      admin_audit_log($pdo,$this_user_id,'person',$id,'CREATE',null,json_encode(['first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,'gender_id'=>$gender_id,'organization_id'=>$organization_id,'agency_id'=>$agency_id,'division_id'=>$division_id,'dob'=>$dob]),'Created person');
    }

    $stmt = $pdo->prepare('SELECT id FROM person_addresses WHERE person_id = :id');
    $stmt->execute([':id'=>$id]);
    $existingAddrIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $submittedAddrIds = [];
    foreach ($addresses as $addr) {
      $addrId = !empty($addr['id']) ? (int)$addr['id'] : 0;
      $data = [
        ':pid'=>$id,
        ':type_id'=>$addr['type_id'] !== '' ? (int)$addr['type_id'] : null,
        ':status_id'=>$addr['status_id'] !== '' ? (int)$addr['status_id'] : null,
        ':start_date'=>$addr['start_date'] !== '' ? $addr['start_date'] : null,
        ':end_date'=>$addr['end_date'] !== '' ? $addr['end_date'] : null,
        ':line1'=>trim($addr['address_line1'] ?? ''),
        ':line2'=>trim($addr['address_line2'] ?? ''),
        ':city'=>trim($addr['city'] ?? ''),
        ':state'=>trim($addr['state'] ?? ''),
        ':postal'=>trim($addr['postal_code'] ?? ''),
        ':country'=>trim($addr['country'] ?? ''),
        ':uid'=>$this_user_id
      ];
      if ($addrId) {
        $data[':id']=$addrId;
        $stmt = $pdo->prepare('UPDATE person_addresses SET type_id=:type_id,status_id=:status_id,start_date=:start_date,end_date=:end_date,address_line1=:line1,address_line2=:line2,city=:city,state=:state,postal_code=:postal,country=:country,user_updated=:uid WHERE id=:id AND person_id=:pid');
        $stmt->execute($data);
        admin_audit_log($pdo,$this_user_id,'person_addresses',$addrId,'UPDATE',null,json_encode($data),'Updated address');
        $submittedAddrIds[] = $addrId;
      } else {
        $stmt = $pdo->prepare('INSERT INTO person_addresses (person_id,type_id,status_id,start_date,end_date,address_line1,address_line2,city,state,postal_code,country,user_updated) VALUES (:pid,:type_id,:status_id,:start_date,:end_date,:line1,:line2,:city,:state,:postal,:country,:uid)');
        $stmt->execute($data);
        $newId = $pdo->lastInsertId();
        admin_audit_log($pdo,$this_user_id,'person_addresses',$newId,'CREATE',null,json_encode($data),'Added address');
        $submittedAddrIds[] = $newId;
      }
    }
    foreach ($existingAddrIds as $eid) {
      if (!in_array($eid,$submittedAddrIds)) {
        $stmt = $pdo->prepare('DELETE FROM person_addresses WHERE id=:id');
        $stmt->execute([':id'=>$eid]);
        admin_audit_log($pdo,$this_user_id,'person_addresses',$eid,'DELETE',null,null,'Deleted address');
      }
    }

    $stmt = $pdo->prepare('SELECT id FROM person_phones WHERE person_id = :id');
    $stmt->execute([':id'=>$id]);
    $existingPhoneIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $submittedPhoneIds = [];
    foreach ($phones as $ph) {
      $phId = !empty($ph['id']) ? (int)$ph['id'] : 0;
      $data = [
        ':pid'=>$id,
        ':type_id'=>$ph['type_id'] !== '' ? (int)$ph['type_id'] : null,
        ':status_id'=>$ph['status_id'] !== '' ? (int)$ph['status_id'] : null,
        ':start_date'=>$ph['start_date'] !== '' ? $ph['start_date'] : null,
        ':end_date'=>$ph['end_date'] !== '' ? $ph['end_date'] : null,
        ':number'=>trim($ph['phone_number'] ?? ''),
        ':uid'=>$this_user_id
      ];
      if ($phId) {
        $data[':id']=$phId;
        $stmt = $pdo->prepare('UPDATE person_phones SET type_id=:type_id,status_id=:status_id,start_date=:start_date,end_date=:end_date,phone_number=:number,user_updated=:uid WHERE id=:id AND person_id=:pid');
        $stmt->execute($data);
        admin_audit_log($pdo,$this_user_id,'person_phones',$phId,'UPDATE',null,json_encode($data),'Updated phone');
        $submittedPhoneIds[] = $phId;
      } else {
        $stmt = $pdo->prepare('INSERT INTO person_phones (person_id,type_id,status_id,start_date,end_date,phone_number,user_updated) VALUES (:pid,:type_id,:status_id,:start_date,:end_date,:number,:uid)');
        $stmt->execute($data);
        $newId = $pdo->lastInsertId();
        admin_audit_log($pdo,$this_user_id,'person_phones',$newId,'CREATE',null,json_encode($data),'Added phone');
        $submittedPhoneIds[] = $newId;
      }
    }
    foreach ($existingPhoneIds as $eid) {
      if (!in_array($eid,$submittedPhoneIds)) {
        $stmt = $pdo->prepare('DELETE FROM person_phones WHERE id=:id');
        $stmt->execute([':id'=>$eid]);
        admin_audit_log($pdo,$this_user_id,'person_phones',$eid,'DELETE',null,null,'Deleted phone');
      }
    }

    $pdo->commit();
    header('Location: index.php');
    exit;
  } catch (Exception $e) {
    $pdo->rollBack();
    throw $e;
  }
}
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Person</h2>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">First Name</label>
    <input type="text" name="first_name" class="form-control" value="<?= h($first_name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Last Name</label>
    <input type="text" name="last_name" class="form-control" value="<?= h($last_name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?= h($email); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Organization</label>
    <select name="organization_id" class="form-select">
      <option value="">-- Select --</option>
      <?php foreach($orgItems as $o): ?>
        <option value="<?= h($o['id']); ?>" <?= (int)$organization_id === (int)$o['id'] ? 'selected' : ''; ?>><?= h($o['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Agency</label>
    <select name="agency_id" class="form-select">
      <option value="">-- Select --</option>
      <?php foreach($agencyItems as $o): ?>
        <option value="<?= h($o['id']); ?>" <?= (int)$agency_id === (int)$o['id'] ? 'selected' : ''; ?>><?= h($o['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Division</label>
    <select name="division_id" class="form-select">
      <option value="">-- Select --</option>
      <?php foreach($divisionItems as $o): ?>
        <option value="<?= h($o['id']); ?>" <?= (int)$division_id === (int)$o['id'] ? 'selected' : ''; ?>><?= h($o['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Gender</label>
    <select name="gender_id" class="form-select">
      <option value="">-- Select --</option>
      <?php foreach($genderItems as $g): ?>
        <option value="<?= h($g['id']); ?>" <?= (int)$gender_id === (int)$g['id'] ? 'selected' : ''; ?>><?= h($g['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Date of Birth</label>
    <input type="date" name="dob" class="form-control" value="<?= h($dob); ?>">
  </div>

  <h5 class="mt-4">Phone Numbers</h5>
  <div id="phones-container">
    <?php foreach($phones as $i=>$ph){ $index=$i; $phRow=$ph; include __DIR__.'/_phone_row.php'; } ?>
  </div>
  <button type="button" class="btn btn-sm btn-secondary mb-3" id="add-phone">Add Phone</button>

  <h5>Addresses</h5>
  <div id="addresses-container">
    <?php foreach($addresses as $i=>$addr){ $index=$i; $addrRow=$addr; include __DIR__.'/_address_row.php'; } ?>
  </div>
  <button type="button" class="btn btn-sm btn-secondary mb-3" id="add-address">Add Address</button>

  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<template id="phone-template">
<?php $index='__INDEX__'; $phRow=[]; include __DIR__.'/_phone_row.php'; ?>
</template>
<template id="address-template">
<?php $index='__INDEX__'; $addrRow=[]; include __DIR__.'/_address_row.php'; ?>
</template>

<script>
(function(){
  function updateBadges(container){
    container.querySelectorAll('select').forEach(function(sel){
      var badge = sel.parentElement.querySelector('.lookup-badge');
      if(badge){
        var color = sel.options[sel.selectedIndex].dataset.color || 'secondary';
        badge.className = 'badge badge-phoenix fs-10 ms-1 lookup-badge badge-phoenix-' + color;
      }
    });
  }
  document.querySelectorAll('.address-item,.phone-item').forEach(updateBadges);
  document.addEventListener('change', function(e){
    if(e.target.matches('.address-type, .address-status, .phone-type, .phone-status')){
      updateBadges(e.target.closest('.address-item, .phone-item'));
    }
  });
  document.getElementById('add-phone').addEventListener('click', function(){
    var tpl = document.getElementById('phone-template').innerHTML.replace(/__INDEX__/g, document.querySelectorAll('#phones-container .phone-item').length);
    var div = document.createElement('div'); div.innerHTML = tpl.trim();
    var item = div.firstElementChild; document.getElementById('phones-container').appendChild(item); updateBadges(item);
  });
  document.getElementById('phones-container').addEventListener('click', function(e){
    if(e.target.classList.contains('remove-phone')){ e.target.closest('.phone-item').remove(); }
  });
  document.getElementById('add-address').addEventListener('click', function(){
    var tpl = document.getElementById('address-template').innerHTML.replace(/__INDEX__/g, document.querySelectorAll('#addresses-container .address-item').length);
    var div = document.createElement('div'); div.innerHTML = tpl.trim();
    var item = div.firstElementChild; document.getElementById('addresses-container').appendChild(item); updateBadges(item);
  });
  document.getElementById('addresses-container').addEventListener('click', function(e){
    if(e.target.classList.contains('remove-address')){ e.target.closest('.address-item').remove(); }
  });
})();
</script>
<?php require '../admin_footer.php'; ?>
