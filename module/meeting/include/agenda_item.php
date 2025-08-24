<li class="list-group-item d-flex align-items-center" data-agenda-item>
  <span class="drag-handle me-2 fas fa-grip-vertical"></span>
  <input type="hidden" name="agenda_order_index[]" class="order-index">
  <input type="text" name="agenda_title[]" class="form-control me-2" placeholder="Agenda Item" required>
  <input type="number" name="agenda_status_id[]" class="form-control me-2" placeholder="Status ID" min="0">
  <input type="number" name="agenda_linked_task_id[]" class="form-control me-2" placeholder="Task ID" min="0">
  <input type="number" name="agenda_linked_project_id[]" class="form-control me-2" placeholder="Project ID" min="0">
  <button type="button" class="btn btn-sm btn-danger remove-agenda-item"><span class="fas fa-times"></span></button>
</li>
