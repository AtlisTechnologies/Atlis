<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addNoteForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNoteLabel">Add Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="noteText" class="form-label">Note</label>
          <textarea class="form-control" id="noteText" name="note" required></textarea>
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
