<div class="modal fade" id="addCollaboratorModal" tabindex="-1" aria-labelledby="addCollaboratorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addCollaboratorForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCollaboratorLabel">Add Collaborator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="collaboratorPerson" class="form-label">Person</label>
          <select class="form-select" id="collaboratorPerson" name="person_id" data-choices="data-choices" required></select>
        </div>
        <div class="mb-3">
          <label for="collaboratorRole" class="form-label">Role</label>
          <select class="form-select" id="collaboratorRole" name="role_id" data-choices="data-choices"></select>
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
