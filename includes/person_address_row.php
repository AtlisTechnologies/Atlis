<?php
$addrRow = $addrRow ?? [];
$index = $index ?? 0;
$selType = $addrRow['type_id'] ?? $defaultAddressTypeId;
$selStatus = $addrRow['status_id'] ?? $defaultAddressStatusId;
$selState  = $addrRow['state_id'] ?? null;
$addressTypeMap = array_column($addressTypeItems, null, 'id');
$addressStatusMap = array_column($addressStatusItems, null, 'id');
?>
<div class="address-item border p-2 mb-2">
  <input type="hidden" name="addresses[<?= $index; ?>][id]" value="<?= h($addrRow['id'] ?? ''); ?>">
  <div class="row g-2">
    <div class="col-md-2">
      <label class="form-label mb-0">Type</label>
      <select name="addresses[<?= $index; ?>][type_id]" class="form-select form-select-sm address-type">
        <?php foreach($addressTypeItems as $pt): $selected = ($selType == $pt['id']) ? 'selected' : ''; ?>
          <option value="<?= h($pt['id']); ?>" data-color="<?= h($pt['color_class']); ?>" <?= $selected; ?>><?= h($pt['label']); ?></option>
        <?php endforeach; ?>
      </select>
      <?= render_status_badge($addressTypeMap, $selType, 'fs-10 ms-1 lookup-badge') ?>
    </div>
    <div class="col-md-2">
      <label class="form-label mb-0">Status</label>
      <select name="addresses[<?= $index; ?>][status_id]" class="form-select form-select-sm address-status">
        <?php foreach($addressStatusItems as $ps): $selected = ($selStatus == $ps['id']) ? 'selected' : ''; ?>
          <option value="<?= h($ps['id']); ?>" data-color="<?= h($ps['color_class']); ?>" <?= $selected; ?>><?= h($ps['label']); ?></option>
        <?php endforeach; ?>
      </select>
      <?= render_status_badge($addressStatusMap, $selStatus, 'fs-10 ms-1 lookup-badge') ?>
    </div>
    <div class="col-md-4">
      <label class="form-label mb-0">Line 1</label>
      <input type="text" name="addresses[<?= $index; ?>][address_line1]" class="form-control form-control-sm" value="<?= h($addrRow['address_line1'] ?? ''); ?>">
    </div>
    <div class="col-md-2">
      <label class="form-label mb-0">Postal</label>
      <input type="text" name="addresses[<?= $index; ?>][postal_code]" class="form-control form-control-sm postal-lookup" value="<?= h($addrRow['postal_code'] ?? ''); ?>">
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button type="button" class="btn btn-danger btn-sm remove-address">X</button>
    </div>
    <div class="col-md-4 mt-2">
      <label class="form-label mb-0">Line 2</label>
      <input type="text" name="addresses[<?= $index; ?>][address_line2]" class="form-control form-control-sm" value="<?= h($addrRow['address_line2'] ?? ''); ?>">
    </div>
    <div class="col-md-3 mt-2">
      <label class="form-label mb-0">City</label>
      <input type="text" name="addresses[<?= $index; ?>][city]" class="form-control form-control-sm city-input" value="<?= h($addrRow['city'] ?? ''); ?>">
    </div>
    <div class="col-md-2 mt-2">
      <label class="form-label mb-0">State</label>
      <select name="addresses[<?= $index; ?>][state_id]" class="form-select form-select-sm state-select">
        <option value=""></option>
        <?php foreach($stateItems as $st): $selected = ($selState == $st['id']) ? 'selected' : ''; ?>
          <option value="<?= h($st['id']); ?>" data-code="<?= h($st['code']); ?>" <?= $selected; ?>><?= h($st['code']); ?> - <?= h($st['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2 mt-2">
      <label class="form-label mb-0">Country</label>
      <input type="text" name="addresses[<?= $index; ?>][country]" class="form-control form-control-sm" value="<?= h($addrRow['country'] ?? ''); ?>">
    </div>
    <div class="col-md-2 mt-2">
      <label class="form-label mb-0">Start</label>
      <input type="date" name="addresses[<?= $index; ?>][start_date]" class="form-control form-control-sm" value="<?= h($addrRow['start_date'] ?? ''); ?>">
    </div>
    <div class="col-md-2 mt-2">
      <label class="form-label mb-0">End</label>
      <input type="date" name="addresses[<?= $index; ?>][end_date]" class="form-control form-control-sm" value="<?= h($addrRow['end_date'] ?? ''); ?>">
    </div>
  </div>
</div>

