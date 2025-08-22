<?php
$phRow = $phRow ?? [];
$index = $index ?? 0;
$selType = $phRow['type_id'] ?? $defaultPhoneTypeId;
$selStatus = $phRow['status_id'] ?? $defaultPhoneStatusId;
$phoneTypeMap = array_column($phoneTypeItems, null, 'id');
$phoneStatusMap = array_column($phoneStatusItems, null, 'id');
?>
<div class="phone-item border p-2 mb-2">
  <input type="hidden" name="phones[<?= $index; ?>][id]" value="<?= h($phRow['id'] ?? ''); ?>">
  <div class="row g-2 align-items-end">
    <div class="col-md-2">
      <label class="form-label mb-0">Type</label>
      <select name="phones[<?= $index; ?>][type_id]" class="form-select form-select-sm phone-type">
        <?php foreach($phoneTypeItems as $pt): $selected = ($selType == $pt['id']) ? 'selected' : ''; ?>
          <option value="<?= h($pt['id']); ?>" data-color="<?= h($pt['color_class']); ?>" <?= $selected; ?>><?= h($pt['label']); ?></option>
        <?php endforeach; ?>
      </select>
      <?= render_status_badge($phoneTypeMap, $selType, 'fs-10 ms-1 lookup-badge') ?>
    </div>
    <div class="col-md-2">
      <label class="form-label mb-0">Status</label>
      <select name="phones[<?= $index; ?>][status_id]" class="form-select form-select-sm phone-status">
        <?php foreach($phoneStatusItems as $ps): $selected = ($selStatus == $ps['id']) ? 'selected' : ''; ?>
          <option value="<?= h($ps['id']); ?>" data-color="<?= h($ps['color_class']); ?>" <?= $selected; ?>><?= h($ps['label']); ?></option>
        <?php endforeach; ?>
      </select>
      <?= render_status_badge($phoneStatusMap, $selStatus, 'fs-10 ms-1 lookup-badge') ?>
    </div>
    <div class="col-md-3">
      <label class="form-label mb-0">Number</label>
      <input type="text" name="phones[<?= $index; ?>][phone_number]" class="form-control form-control-sm" value="<?= h($phRow['phone_number'] ?? ''); ?>">
    </div>
    <div class="col-md-2">
      <label class="form-label mb-0">Start</label>
      <input type="date" name="phones[<?= $index; ?>][start_date]" class="form-control form-control-sm" value="<?= h($phRow['start_date'] ?? ''); ?>">
    </div>
    <div class="col-md-2">
      <label class="form-label mb-0">End</label>
      <input type="date" name="phones[<?= $index; ?>][end_date]" class="form-control form-control-sm" value="<?= h($phRow['end_date'] ?? ''); ?>">
    </div>
    <div class="col-md-1 d-flex justify-content-end">
      <button type="button" class="btn btn-danger btn-sm remove-phone">X</button>
    </div>
  </div>
</div>

