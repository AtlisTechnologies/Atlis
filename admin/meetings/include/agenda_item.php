<li class="list-group-item d-flex align-items-center" data-agenda-item>
  <span class="drag-handle me-2 fas fa-grip-vertical"></span>
  <input type="hidden" name="agenda_order_index[]" class="order-index">
  <input type="text" name="agenda_title[]" class="form-control me-2" placeholder="Agenda Item" required>
  <select name="agenda_status_id[]" class="form-select me-2 agenda-status"></select>
  <input type="text" class="form-control me-2 task-search" placeholder="Search Task">
  <input type="hidden" name="agenda_linked_task_id[]">
  <input type="text" class="form-control me-2 project-search" placeholder="Search Project">
  <input type="hidden" name="agenda_linked_project_id[]">
  <button type="button" class="btn btn-sm btn-danger remove-agenda-item"><span class="fas fa-times"></span></button>
</li>
