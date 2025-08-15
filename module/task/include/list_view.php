<?php
// Div-based task list view using Phoenix todo-list structure
?>
<div class="mb-9">
  <h2 class="mb-4">Tasks<span class="text-body-tertiary fw-normal">(<?php echo count($tasks); ?>)</span></h2>
  <div class="row align-items-center g-3 mb-3">
    <div class="col-sm-auto">
      <div class="search-box">
        <form class="position-relative">
          <input class="form-control search-input search" type="search" placeholder="Search tasks" aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
    </div>
    <div class="col-sm-auto">
      <div class="d-flex">
        <a class="btn btn-link p-0 ms-sm-3 fs-9 text-body-tertiary fw-bold" href="#!"><span class="fas fa-filter me-1 fw-extra-bold fs-10"></span><?php echo count($tasks); ?> tasks</a>
        <a class="btn btn-link p-0 ms-3 fs-9 text-body-tertiary fw-bold" href="#!"><span class="fas fa-sort me-1 fw-extra-bold fs-10"></span>Sorting</a>
      </div>
    </div>
    <div class="col-sm-auto ms-auto">
      <a href="index.php?action=create" class="btn btn-primary btn-sm">New Task</a>
    </div>
  </div>
  <div class="mb-4 todo-list">
    <?php foreach ($tasks as $task): ?>
      <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 cursor-pointer border-top" data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-<?php echo (int)($task['id'] ?? 0); ?>">
        <div class="col-12 col-md-auto flex-1">
          <div>
            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
              <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2" type="checkbox" id="checkbox-todo-<?php echo (int)($task['id'] ?? 0); ?>" data-event-propagation-prevent="data-event-propagation-prevent" />
              <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1 flex-grow-1 flex-md-grow-0 cursor-pointer" for="checkbox-todo-<?php echo (int)($task['id'] ?? 0); ?>"><?php echo h($task['name'] ?? ''); ?></label>
              <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($task['priority_color'] ?? 'primary'); ?>"><?php echo h($task['priority_label'] ?? ''); ?></span>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-auto">
          <div class="d-flex ms-4 lh-1 align-items-center">
            <div class="d-none d-md-block end-0 position-absolute" style="top: 23%;">
              <div class="hover-actions end-0">
                <a class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0" href="index.php?action=edit&amp;id=<?php echo (int)($task['id'] ?? 0); ?>"><span class="fas fa-edit"></span></a>
                <a class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" href="index.php?action=delete&amp;id=<?php echo (int)($task['id'] ?? 0); ?>"><span class="fas fa-trash"></span></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="offcanvas offcanvas-end content-offcanvas offcanvas-backdrop-transparent border-start shadow-none bg-body-highlight" tabindex="-1" data-todo-content-offcanvas="data-todo-content-offcanvas" id="todoOffcanvas-<?php echo (int)($task['id'] ?? 0); ?>">
        <div class="offcanvas-body p-0">
          <div class="p-5 p-md-6">
            <div class="d-flex flex-between-center align-items-start gap-5 mb-4">
              <h2 class="fw-bold fs-6 mb-0 text-body-highlight"><?php echo h($task['name'] ?? ''); ?></h2>
              <button class="btn btn-phoenix-secondary btn-icon px-2" type="button" data-bs-dismiss="offcanvas" aria-label="Close"><span class="fa-solid fa-xmark"></span></button>
            </div>
            <p class="mb-0">No details available.</p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>
