<div class="modal fade" id="addObjectiveModal" tabindex="-1" aria-labelledby="addObjectiveLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addObjectiveForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addObjectiveLabel">Add Objective</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="objectiveParent" class="form-label">Parent Objective</label>
          <select class="form-select" id="objectiveParent" name="parent_id">
            <option value="">Top Level</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="objectiveTitle" class="form-label">Objective</label>
          <input type="text" class="form-control" id="objectiveTitle" name="objective" required>
        </div>
        <div class="mb-3">
          <label for="objectiveOwner" class="form-label">Owner</label>
          <select class="form-select" id="objectiveOwner" name="owner_id" data-choices="data-choices"></select>
        </div>
        <div class="mb-3">
          <label for="objectiveProgress" class="form-label">Progress</label>
          <input type="number" class="form-control" id="objectiveProgress" name="progress" min="0" max="100">
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
