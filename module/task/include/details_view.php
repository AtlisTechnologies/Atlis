<?php
// Details view of a single task using Phoenix layout
require_once __DIR__ . '/../../../includes/functions.php';
?>
<?php if (!empty($current_task)): ?>
  <?php
    // Build hierarchy string
    $hierarchyParts = array_filter([
      $current_task['project_name'] ?? null,
      $current_task['division_name'] ?? null,
      $current_task['agency_name'] ?? null,
      $current_task['organization_name'] ?? null
    ]);

  ?>
  <div class="mb-5">
    <div class="d-flex align-items-center gap-2 mb-2">
      <?php if (!empty($current_task['project_id'])): ?>
        <a class="btn btn-secondary btn-sm"
           href="<?php echo getURLDir(); ?>module/project/index.php?action=details&id=<?= (int)$current_task['project_id']; ?>">
          &larr; Back to Project
        </a>
      <?php endif; ?>
      <?php if (user_has_permission('task','update')): ?>
        <button class="btn btn-warning btn-sm" id="editTaskBtn">Edit</button>
      <?php endif; ?>
    </div>
    <h2 class="text-body-emphasis fw-bolder mb-2"><?php echo h($current_task['name'] ?? ''); ?></h2>
    <?php if ($hierarchyParts): ?>
      <p class="text-body-secondary mb-0"><?php echo implode(' / ', array_map('h', $hierarchyParts)); ?></p>
    <?php endif; ?>
    <p class="mb-3 mt-3">
      <div class="dropdown d-inline">
        <?= render_status_badge($statusMap, $current_task['status'], 'fs-8' . (user_has_permission('task','update') ? ' dropdown-toggle' : ''), array_merge(['id' => 'statusBadge'], user_has_permission('task','update') ? ['data-bs-toggle' => 'dropdown', 'role' => 'button'] : [])) ?>
        <?php if (user_has_permission('task','update')): ?>
        <ul class="dropdown-menu">
          <?php foreach ($statusMap as $sid => $s): ?>
            <li><a class="dropdown-item task-field-option" data-field="status" data-value="<?= (int)$sid; ?>" data-color="<?= h($s['color_class']); ?>"><?= h($s['label']); ?></a></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
      <div class="dropdown d-inline ms-2">
        <?= render_status_badge($priorityMap, $current_task['priority'], 'fs-8' . (user_has_permission('task','update') ? ' dropdown-toggle' : ''), array_merge(['id' => 'priorityBadge'], user_has_permission('task','update') ? ['data-bs-toggle' => 'dropdown', 'role' => 'button'] : [])) ?>
        <?php if (user_has_permission('task','update')): ?>
        <ul class="dropdown-menu">
          <?php foreach ($priorityMap as $pid => $p): ?>
            <li><a class="dropdown-item task-field-option" data-field="priority" data-value="<?= (int)$pid; ?>" data-color="<?= h($p['color_class']); ?>"><?= h($p['label']); ?></a></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
    </p>
    <?php if (!empty($current_task['completed_by_name'])): ?>
      <p class="text-body-secondary mb-3">Completed by <?php echo h($current_task['completed_by_name']); ?></p>
    <?php endif; ?>
    <?php if (!empty($current_task['description'])): ?>
      <p><?php echo nl2br(h($current_task['description'])); ?></p>
    <?php endif; ?>
  </div>

  <div class="row gx-0 gx-sm-7 mb-4">
    <div class="col-12 col-lg-4 mb-4 mb-lg-0">
      <?php if (user_has_permission('task','update')): ?>
      <form id="taskDatesForm" class="mb-3">
        <?= csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo (int)$current_task['id']; ?>">
        <table class="lh-sm w-100">
          <tbody>
            <tr>
              <td class="align-top py-1 text-body text-nowrap fw-bold">Start :</td>
              <td class="text-body-tertiary fw-semibold ps-3"><input type="date" class="form-control form-control-sm" name="start_date" value="<?php echo h($current_task['start_date'] ?? ''); ?>"></td>
            </tr>
            <tr>
              <td class="align-top py-1 text-body text-nowrap fw-bold">Due :</td>
              <td class="text-body-tertiary fw-semibold ps-3"><input type="date" class="form-control form-control-sm" name="due_date" value="<?php echo h($current_task['due_date'] ?? ''); ?>"></td>
            </tr>
          </tbody>
        </table>
        <button class="btn btn-atlis btn-sm" type="submit">Save</button>
      </form>
      <?php else: ?>
      <table class="lh-sm mb-3 w-100">
        <tbody>
          <tr>
            <td class="align-top py-1 text-body text-nowrap fw-bold">Start :</td>
            <td class="text-body-tertiary fw-semibold ps-3"><?php echo h($current_task['start_date'] ?? ''); ?></td>
          </tr>
          <tr>
            <td class="align-top py-1 text-body text-nowrap fw-bold">Due :</td>
            <td class="text-body-tertiary fw-semibold ps-3"><?php echo h($current_task['due_date'] ?? ''); ?></td>
          </tr>
        </tbody>
      </table>
      <?php endif; ?>
      <div class="mb-3">
        <div class="d-flex align-items-center mb-1">
          <span class="fw-bold text-body text-nowrap me-2">Progress :</span>
          <span class="text-body-tertiary fw-semibold" id="progressText"><?php echo (int)($current_task['progress_percent'] ?? 0); ?>%</span>
        </div>
        <div class="progress" style="height:5px;">
          <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo (int)($current_task['progress_percent'] ?? 0); ?>%" aria-valuenow="<?php echo (int)($current_task['progress_percent'] ?? 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-8">
      <div class="row gx-0 gx-sm-7">
        <div class="col-12 col-md-6 mb-4 mb-md-0">
          <h5 class="fw-bold mb-1">Requirements</h5>
          <?php if (!empty($current_task['requirements'])): ?>
            <?php if (strlen($current_task['requirements']) > 300): ?>
              <div class="collapse" id="requirementsCollapse">
                <p class="text-body-tertiary mb-0"><?php echo nl2br(h($current_task['requirements'])); ?></p>
              </div>
              <a class="fs-9" data-bs-toggle="collapse" href="#requirementsCollapse" role="button" aria-expanded="false" aria-controls="requirementsCollapse">Show more</a>
            <?php else: ?>
              <p class="text-body-tertiary mb-0"><?php echo nl2br(h($current_task['requirements'])); ?></p>
            <?php endif; ?>
          <?php else: ?>
            <p class="text-body-tertiary mb-0">None</p>
          <?php endif; ?>
        </div>
        <div class="col-12 col-md-6">
          <h5 class="fw-bold mb-1">Specifications</h5>
          <?php if (!empty($current_task['specifications'])): ?>
            <?php if (strlen($current_task['specifications']) > 300): ?>
              <div class="collapse" id="specificationsCollapse">
                <p class="text-body-tertiary mb-0"><?php echo nl2br(h($current_task['specifications'])); ?></p>
              </div>
              <a class="fs-9" data-bs-toggle="collapse" href="#specificationsCollapse" role="button" aria-expanded="false" aria-controls="specificationsCollapse">Show more</a>
            <?php else: ?>
              <p class="text-body-tertiary mb-0"><?php echo nl2br(h($current_task['specifications'])); ?></p>
            <?php endif; ?>
          <?php else: ?>
            <p class="text-body-tertiary mb-0">None</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-0">
    <div class="col-12 col-xxl-8 px-0">
      <div class="p-4 p-lg-6">
        <div class="d-flex align-items-center mb-4">
          <h4 class="text-body-emphasis mb-0 me-2">Assigned</h4>
          <?php if (user_has_permission('task','update')): ?>
            <button class="bg-transparent border-0 text-success fs-9 me-1" type="button" data-bs-toggle="modal" data-bs-target="#assignUserModal" aria-label="Assign user">
              <span class="fa-solid fa-plus"></span>
            </button>
          <?php endif; ?>
          <?php if (user_has_permission('task','update') && !$alreadyAssigned && (empty($current_task['project_id']) || !empty($current_task['project_assigned']))): ?>
            <form method="post" action="functions/assign_user.php" class="d-inline">
              <?= csrf_field(); ?>
              <input type="hidden" name="task_id" value="<?= (int)$current_task['id']; ?>">
              <input type="hidden" name="user_id" value="<?= (int)$this_user_id; ?>">
              <button class="btn btn-success btn-sm p-1" type="submit"><span class="fa-solid fa-user-plus"></span></button>
            </form>
          <?php endif; ?>
        </div>
        <?php if (!empty($assignedUsers)): ?>
          <ul class="list-unstyled mb-4">
            <?php foreach ($assignedUsers as $au): ?>
              <li class="d-flex align-items-center mb-2">
                <?php $pic = !empty($au['user_pic']) ? $au['user_pic'] : 'assets/img/team/avatar.webp'; ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal" data-file-src="<?php echo getURLDir() . h($pic); ?>" data-file-type="image/*">
                  <img class="rounded-circle avatar avatar-m me-2" src="<?php echo getURLDir() . h($pic); ?>" alt="<?php echo h($au['name']); ?>" />
                </a>
                <div class="d-flex align-items-center flex-grow-1">
                  <h6 class="mb-0"><?php echo h($au['name']); ?></h6>
                  <?php if (user_has_permission('task','update')): ?>
                    <form method="post" action="functions/remove_user.php" class="ms-2" onclick="return confirm('Remove this user?')">
                      <?= csrf_field(); ?>
                      <input type="hidden" name="task_id" value="<?php echo (int)$current_task['id']; ?>">
                      <input type="hidden" name="user_id" value="<?php echo (int)$au['user_id']; ?>">
                      <button class="bg-transparent border-0 text-danger fs-9" type="submit" aria-label="Unassign user">
                        <span class="fa-solid fa-xmark"></span>
                      </button>
                    </form>
                  <?php endif; ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p class="fs-9 text-body-secondary mb-4">No team members assigned.</p>
        <?php endif; ?>
        <?php if (user_has_permission('admin_strategy','update') && user_has_permission('task','read')): ?>
          <?php
            $krStmt = $pdo->prepare('SELECT id, name, progress_percent FROM module_strategy_key_results WHERE task_id = :tid');
            $krStmt->execute([':tid' => $current_task['id']]);
            $taskKeyResults = $krStmt->fetchAll(PDO::FETCH_ASSOC);
          ?>
          <h5 class="fw-bold mb-2">Key Results</h5>
          <?php if ($taskKeyResults): ?>
            <ul class="list-unstyled mb-4">
              <?php foreach ($taskKeyResults as $kr): ?>
                <li class="mb-3">
                  <div class="d-flex justify-content-between mb-1">
                    <span><?= h($kr['name']); ?></span>
                    <span class="fs-9"><?= (int)($kr['progress_percent'] ?? 0); ?>%</span>
                  </div>
                  <div class="progress" style="height:4px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= (int)($kr['progress_percent'] ?? 0); ?>%"></div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p class="fs-9 text-body-secondary mb-4">No key results linked.</p>
          <?php endif; ?>
        <?php endif; ?>
        <div class="modal fade" id="assignUserModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <form class="modal-content" method="post" action="functions/assign_user.php">
              <?= csrf_field(); ?>
              <div class="modal-header">
                <h5 class="modal-title">Assign User</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="task_id" value="<?php echo (int)$current_task['id']; ?>">
                <select class="form-select" name="user_id">
                  <?php foreach ($availableUsers as $au): ?>
                    <option value="<?php echo (int)$au['user_id']; ?>"><?php echo h($au['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="modal-footer">
                <button class="btn btn-success" type="submit">Assign</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-xxl-4 px-0 border-top-sm border-start-xxl">
      <div class="bg-light dark__bg-gray-1100 h-100">
        <div class="p-4 p-lg-6">
          <h3 class="text-body-highlight mb-4 fw-bold">Task Notes</h3>
          <div class="timeline-vertical timeline-with-details">
            <?php if (!empty($notes)): ?>
              <?php foreach ($notes as $n): ?>
              <div class="timeline-item position-relative">
                <div class="row g-md-3 mb-4">
                  <div class="col-12 col-md-auto d-flex">
                    <div class="timeline-item-date order-1 order-md-0 me-md-4">
                      <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">
                        <?= h(date('d M, Y', strtotime($n['date_created']))) ?><br class="d-none d-md-block" />
                        <?= h(date('h:i A', strtotime($n['date_created']))) ?>
                      </p>
                    </div>
                    <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                      <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle"><span class="fa-solid fa-note-sticky text-primary-dark fs-10"></span></div><span class="timeline-bar border-end border-dashed"></span>
                    </div>
                  </div>
                  <div class="col">
                    <div class="timeline-item-content ps-6 ps-md-3">
                      <div class="d-flex">
                        <p class="fs-9 lh-sm mb-1 flex-grow-1"><?= nl2br(h($n['note_text'])) ?></p>
                        <?php if ($is_admin || ($n['user_id'] ?? 0) == $this_user_id): ?>
                        <form action="functions/delete_note.php" method="post" class="ms-2" onsubmit="return confirm('Delete this note?');">
                          <?= csrf_field(); ?>
                          <input type="hidden" name="id" value="<?= (int)$n['id'] ?>">
                          <input type="hidden" name="task_id" value="<?= (int)$current_task['id'] ?>">
                          <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-trash"></span></button>
                        </form>
                        <?php endif; ?>
                      </div>
                      <?php if (!empty($noteFiles[$n['id']])): ?>
                        <ul class="list-unstyled mt-2">
                          <?php foreach ($noteFiles[$n['id']] as $f): ?>
                            <li class="mb-1">
                              <div class="d-flex mb-1"><span class="fa-solid <?= strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file' ?> me-2 text-body-tertiary fs-9"></span>
                                <p class="text-body-highlight mb-0 lh-1">
                                  <?php if (strpos($f['file_type'], 'image/') === 0): ?>
                                    <a class="text-body-highlight" href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                                  <?php else: ?>
                                    <a class="text-body-highlight" href="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                                  <?php endif; ?>
                                </p>
                                <?php if (user_has_permission('task','create|update|delete') && ($is_admin || ($f['user_id'] ?? 0) == $this_user_id)): ?>
                                <form action="functions/delete_file.php" method="post" class="ms-2" onsubmit="return confirm('Delete this file?');">
                                  <?= csrf_field(); ?>
                                  <input type="hidden" name="id" value="<?= (int)$f['id']; ?>">
                                  <input type="hidden" name="task_id" value="<?= (int)$current_task['id']; ?>">
                                  <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-trash"></span></button>
                                </form>
                                <?php endif; ?>
                              </div>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>
                      <?php $pic = $n['user_pic'] ?? ''; ?>
                      <p class="fs-9 mb-0">by <a class="d-flex align-items-center fw-semibold" href="#!">
                        <div class="avatar avatar-m"><img class="rounded-circle" src="<?=getURLDir().($pic?:'assets/img/team/avatar.webp')?>"></div>
                        <span class="ms-2"><?= h($n['user_name'] ?? '') ?></span></a></p>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="fs-9 text-body-secondary mb-0">No notes found.</p>
            <?php endif; ?>
          </div>
          <?php if (user_has_permission('task','create|update|delete')): ?>
          <div class="mt-4">
            <form action="functions/add_note.php" method="post" enctype="multipart/form-data">
              <?= csrf_field(); ?>
              <input type="hidden" name="id" value="<?= (int)$current_task['id'] ?>">
              <div class="mb-3">
                <textarea class="form-control" name="note" rows="3" placeholder="Add a new Note" required></textarea>
              </div>
              <div class="mb-3">
                <input class="form-control" type="file" name="files[]" multiple>
              </div>
          <center><button class="btn btn-success" type="submit">Add Note</button></center>
        </form>
      </div>
      <?php endif; ?>
      <?php if (user_has_permission('task','create|update|delete')): ?>
      <div class="mt-4">
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Questions</button>
      </div>
      <?php endif; ?>
      <div class="mt-4">
        <h3 class="text-body-highlight fw-bold">Questions</h3>
        <?php if (!empty($questions)): ?>
          <?php foreach ($questions as $q): ?>
            <div class="mb-3 border-top pt-3">

              <?php $qpic = !empty($q['user_pic']) ? $q['user_pic'] : 'assets/img/team/avatar.webp'; ?>
              <div class="d-flex align-items-center">
                <p class="mb-1 fw-semibold flex-grow-1"><?= h($q['question_text']); ?></p>
                <?php if (user_has_permission('task','create|update|delete') && ($is_admin || ($q['user_id'] ?? 0) == $this_user_id)): ?>
                <button class="btn btn-warning btn-sm ms-2" type="button" data-bs-toggle="modal" data-bs-target="#editQuestionModal<?= (int)$q['id']; ?>" aria-label="Edit question">
                  <span class="fa-solid fa-pen"></span>
                </button>
                <form action="functions/delete_question.php" method="post" class="ms-2" onsubmit="return confirm('Delete this question?');">
                  <?= csrf_field(); ?>
                  <input type="hidden" name="id" value="<?= (int)$q['id']; ?>">
                  <input type="hidden" name="task_id" value="<?= (int)$current_task['id']; ?>">
                  <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-trash"></span></button>
                </form>
                <?php endif; ?>

              </div>
              <?php if (user_has_permission('task','create|update|delete') && ($is_admin || ($q['user_id'] ?? 0) == $this_user_id)): ?>
              <div class="modal fade" id="editQuestionModal<?= (int)$q['id']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <form class="modal-content" method="post" action="functions/edit_question.php">
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Question</h5>
                      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="id" value="<?= (int)$q['id']; ?>">
                      <input type="hidden" name="task_id" value="<?= (int)$current_task['id']; ?>">
                      <textarea class="form-control" name="question_text" rows="3" required><?= h($q['question_text']); ?></textarea>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                  </form>
                </div>
              </div>
              <?php endif; ?>
              <div class="d-flex align-items-center fs-9 text-body-secondary mb-2">
                <div class="avatar avatar-m me-2"><img class="rounded-circle" src="<?php echo getURLDir() . h($qpic); ?>" alt="" /></div>
                <div>
                  <div class="fw-bold text-body"><?= h($q['user_name']); ?></div>
                  <div><?= h($q['date_created']); ?></div>
                </div>
              </div>
              <?php if (!empty($questionFiles[$q['id']])): ?>
                <ul class="list-unstyled mt-2 ms-3">
                  <?php foreach ($questionFiles[$q['id']] as $f): ?>
                    <li class="mb-1">
                      <div class="d-flex mb-1"><span class="fa-solid <?= strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file' ?> me-2 text-body-tertiary fs-9"></span>
                        <p class="text-body-highlight mb-0 lh-1">
                          <?php if (strpos($f['file_type'], 'image/') === 0): ?>
                            <a class="text-body-highlight" href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                          <?php else: ?>
                            <a class="text-body-highlight" href="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                          <?php endif; ?>
                        </p>
                        <?php if (user_has_permission('task','create|update|delete') && ($is_admin || ($f['user_id'] ?? 0) == $this_user_id)): ?>
                        <form action="functions/delete_file.php" method="post" class="ms-2" onsubmit="return confirm('Delete this file?');">
                          <?= csrf_field(); ?>
                          <input type="hidden" name="id" value="<?= (int)$f['id']; ?>">
                          <input type="hidden" name="task_id" value="<?= (int)$current_task['id']; ?>">
                          <input type="hidden" name="question_id" value="<?= (int)$q['id']; ?>">
                          <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-trash"></span></button>
                        </form>
                        <?php endif; ?>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>


              <?php if (!empty($questionAnswers[$q['id']])): ?>
                <ul class="list-unstyled ps-5">
                  <?php foreach ($questionAnswers[$q['id']] as $ans): ?>
                    <li class="mb-2">
                      <div class="d-flex">
                        <p class="mb-1 flex-grow-1"><?= h($ans['answer_text']); ?></p>
                        <?php if (user_has_permission('task','create|update|delete') && ($is_admin || ($ans['user_id'] ?? 0) == $this_user_id)): ?>
                        <button class="btn btn-warning btn-sm ms-2" type="button" data-bs-toggle="modal" data-bs-target="#editAnswerModal<?= (int)$ans['id']; ?>" aria-label="Edit answer">
                          <span class="fa-solid fa-pen"></span>
                        </button>
                        <form action="functions/delete_answer.php" method="post" class="ms-2" onsubmit="return confirm('Delete this answer?');">
                          <?= csrf_field(); ?>
                          <input type="hidden" name="id" value="<?= (int)$ans['id']; ?>">
                          <input type="hidden" name="task_id" value="<?= (int)$current_task['id']; ?>">
                          <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-trash"></span></button>
                        </form>
                        <?php endif; ?>
                      </div>
                      <?php if (user_has_permission('task','create|update|delete') && ($is_admin || ($ans['user_id'] ?? 0) == $this_user_id)): ?>
                      <div class="modal fade" id="editAnswerModal<?= (int)$ans['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                          <form class="modal-content" method="post" action="functions/edit_answer.php">
                            <?= csrf_field(); ?>
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Answer</h5>
                              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <input type="hidden" name="id" value="<?= (int)$ans['id']; ?>">
                              <input type="hidden" name="task_id" value="<?= (int)$current_task['id']; ?>">
                              <textarea class="form-control" name="answer_text" rows="3" required><?= h($ans['answer_text']); ?></textarea>
                            </div>
                            <div class="modal-footer">
                              <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                          </form>
                        </div>
                      </div>
                      <?php endif; ?>
                      <?php $apic = !empty($ans['user_pic']) ? $ans['user_pic'] : 'assets/img/team/avatar.webp'; ?>
                      <div class="d-flex align-items-center fs-9 text-body-secondary">
                        <div class="avatar avatar-m me-2"><img class="rounded-circle" src="<?php echo getURLDir() . h($apic); ?>" alt="" /></div>
                        <div>
                          <div class="fw-semibold text-body"><?= h($ans['user_name']); ?></div>
                          <div><?= h($ans['date_created']); ?></div>
                        </div>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              <?php if (user_has_permission('task','create|update|delete')): ?>
              <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addAnswerModal<?= (int)$q['id']; ?>">Add Answer</button>
              <div class="modal fade" id="addAnswerModal<?= (int)$q['id']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <form class="modal-content" method="post" action="functions/add_answer.php">
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                      <h5 class="modal-title">Add Answer</h5>
                      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="task_id" value="<?= (int)$current_task['id']; ?>">
                      <input type="hidden" name="question_id" value="<?= (int)$q['id']; ?>">
                      <textarea class="form-control" name="answer_text" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-success" type="submit">Add Answer</button>
                    </div>
                  </form>
                </div>
              </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="fs-9 text-body-secondary mb-0">No questions have been asked.</p>
        <?php endif; ?>
      </div>
    </div>
    <hr>
    <div class="px-4 px-lg-6">
      <h3 class="text-body-highlight fw-bold">Files</h3>
    </div>
        <?php if (user_has_permission('task','create|update|delete')): ?>
        <div class="px-4 px-lg-6 py-4">
          <form action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="mb-3">
            <?= csrf_field(); ?>
            <div class="input-group">
              <input type="hidden" name="id" value="<?= (int)$current_task['id'] ?>">
              <input class="form-control" type="file" name="file" id="taskFileUpload" aria-describedby="taskFileUpload" aria-label="Upload" required>
              <button class="btn btn-success" type="submit">Upload New</button>
            </div>
          </form>
        </div>
        <?php endif; ?>
        <?php if (!empty($taskFiles)): ?>
          <?php foreach ($taskFiles as $f): ?>
          <div class="border-top px-4 px-lg-6 py-4">
            <div class="me-n3">
              <div class="d-flex flex-between-center">
                <div class="d-flex mb-1"><span class="fa-solid <?= strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file' ?> me-2 text-body-tertiary fs-9"></span>
                  <p class="text-body-highlight mb-0 lh-1">
                    <?php if (strpos($f['file_type'], 'image/') === 0): ?>
                      <a class="text-body-highlight" href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                    <?php else: ?>
                      <a class="text-body-highlight" href="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                    <?php endif; ?>
                  </p>
                </div>
                <?php if ($is_admin || ($f['user_id'] ?? 0) == $this_user_id): ?>
                <form action="functions/delete_file.php" method="post" onsubmit="return confirm('Delete this file?');">
                  <?= csrf_field(); ?>
                  <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
                  <input type="hidden" name="task_id" value="<?= (int)$current_task['id'] ?>">
                  <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-trash"></span></button>
                </form>
                <?php endif; ?>
              </div>
              <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap"><span><?= h($f['file_size']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['file_type']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['date_created']) ?></span></div>
              <?php if (strpos($f['file_type'], 'image/') === 0): ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>">
                  <img class="rounded-2 mt-2" src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>" alt="" style="width:320px" />
                </a>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="border-top px-4 px-lg-6 py-4">
            <p class="fs-9 text-body-secondary mb-0">No files uploaded.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php if (user_has_permission('task','create|update|delete')): ?>
  <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" method="post" action="functions/add_question.php">
        <?= csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title">Add Question</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="task_id" value="<?= (int)$current_task['id']; ?>">
          <div class="mb-3">
            <textarea class="form-control" name="question_text" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <input class="form-control" type="file" name="files[]" multiple>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="submit">Add Question</button>
        </div>
      </form>
    </div>
  </div>
  <?php endif; ?>
  <?php if (user_has_permission('task','update')): ?>
  <div class="modal fade" id="taskEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content"></div>
    </div>
  </div>
  <?php endif; ?>
  <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Image preview</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <img id="modalImage" src="" class="img-fluid" alt="Preview">
        </div>
      </div>
    </div>
  </div>
  <script>
  const csrfToken = '<?= csrf_token(); ?>';
  document.addEventListener('DOMContentLoaded', function () {
    var imageModal = document.getElementById('imageModal');
    if (imageModal) {
      imageModal.addEventListener('show.bs.modal', function (event) {
        var trigger = event.relatedTarget;
        var img = document.getElementById('modalImage');
        if (trigger && img) {
          img.src = trigger.getAttribute('data-img-src');
        }
      });
    }

    var taskId = <?= (int)$current_task['id']; ?>;
    document.querySelectorAll('.task-field-option').forEach(function (opt) {
      opt.addEventListener('click', function (e) {
        e.preventDefault();
        var field = opt.getAttribute('data-field');
        var value = opt.getAttribute('data-value');
        fetch('functions/update_field.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ id: taskId, field: field, value: value, csrf_token: csrfToken })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (data.success && data.task) {
            if (field === 'status') {
              var statusBadge = document.getElementById('statusBadge');
              if (statusBadge) {
                statusBadge.className = 'badge badge-phoenix fs-8 badge-phoenix-' + (data.task.status_color || 'secondary') + ' dropdown-toggle';
                var sLabel = statusBadge.querySelector('.badge-label');
                if (sLabel) { sLabel.textContent = data.task.status_label || ''; }
              }
            } else if (field === 'priority') {
              var priorityBadge = document.getElementById('priorityBadge');
              if (priorityBadge) {
                priorityBadge.className = 'badge badge-phoenix fs-8 badge-phoenix-' + (data.task.priority_color || 'secondary') + ' dropdown-toggle';
                var pLabel = priorityBadge.querySelector('.badge-label');
                if (pLabel) { pLabel.textContent = data.task.priority_label || ''; }
              }
            }
          }
        });
      });
    });

    var datesForm = document.getElementById('taskDatesForm');
    if (datesForm) {
      datesForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var fd = new FormData(datesForm);
        fetch('functions/update.php', {
          method: 'POST',
          body: fd
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (data.success && data.task) {
            var startInput = datesForm.querySelector('[name="start_date"]');
            var dueInput = datesForm.querySelector('[name="due_date"]');
            if (startInput) { startInput.value = data.task.start_date || ''; }
            if (dueInput) { dueInput.value = data.task.due_date || ''; }
            var progText = document.getElementById('progressText');
            var progBar = datesForm.parentNode.querySelector('.progress-bar');
            if (progText && progBar && typeof data.task.progress_percent !== 'undefined') {
              progText.textContent = data.task.progress_percent + '%';
              progBar.style.width = data.task.progress_percent + '%';
              progBar.setAttribute('aria-valuenow', data.task.progress_percent);
            }
          }
        });
      });
    }

    var editBtn = document.getElementById('editTaskBtn');
    if (editBtn) {
      editBtn.addEventListener('click', function () {
        fetch('index.php?action=create-edit&id=<?php echo (int)$current_task['id']; ?>&modal=1')
          .then(function (res) { return res.text(); })
          .then(function (html) {
            var modalContent = document.querySelector('#taskEditModal .modal-content');
            if (modalContent) {
              modalContent.innerHTML = html;
              var modal = new bootstrap.Modal(document.getElementById('taskEditModal'));
              modal.show();
              var form = modalContent.querySelector('form');
              if (form) {
                form.addEventListener('submit', function (ev) {
                  ev.preventDefault();
                  var fd = new FormData(form);
                  fetch('index.php?action=save', {
                    method: 'POST',
                    body: fd
                  }).then(function () { location.reload(); });
                });
              }
            }
          });
      });
    }
  });
  </script>
<?php else: ?>
  <p>No task found.</p>
<?php endif; ?>
