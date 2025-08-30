<div class="modal fade" id="addKpiModal" tabindex="-1" aria-labelledby="addKpiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addKpiForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addKpiLabel">Add KPI</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="kpiTitle" class="form-label">Title</label>
          <input type="text" class="form-control" id="kpiTitle" name="title" required>
        </div>
        <input type="hidden" name="strategy_id" class="strategy-id-input">
        <?= csrf_field(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
