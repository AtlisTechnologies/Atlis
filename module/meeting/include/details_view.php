<div class="container-fluid py-4">
  <div class="row mb-3">
    <div class="col">
      <h2><?php echo h($meeting['title'] ?? 'Meeting'); ?></h2>
      <p class="text-body-secondary mb-0"><?php echo !empty($meeting['meeting_date']) ? h(date('l, F j, Y g:i A', strtotime($meeting['meeting_date']))) : ''; ?></p>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <h4>Agenda</h4>
      <ul class="list-group mb-4">
        <?php
        $agenda = [];
        if (!empty($meeting['id'])) {
          $aStmt = $pdo->prepare('SELECT * FROM module_meeting_agenda WHERE meeting_id=? ORDER BY position');
          $aStmt->execute([$meeting['id']]);
          $agenda = $aStmt->fetchAll(PDO::FETCH_ASSOC);
        }
        if ($agenda):
          foreach ($agenda as $item): ?>
            <li class="list-group-item d-flex justify-content-between">
              <span><?php echo h($item['title']); ?><?php if(!empty($item['presenter'])) echo ' - '.h($item['presenter']); ?></span>
              <span class="text-body-secondary"><?php echo h($item['duration']); ?> min</span>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li class="list-group-item">No agenda items.</li>
        <?php endif; ?>
      </ul>
      <h4>Questions &amp; Answers</h4>
      <div class="mb-3" id="questionsList">
        <?php
        $questions = [];
        if (!empty($meeting['id'])) {
          $qStmt = $pdo->prepare('SELECT * FROM module_meeting_questions WHERE meeting_id=?');
          $qStmt->execute([$meeting['id']]);
          $questions = $qStmt->fetchAll(PDO::FETCH_ASSOC);
        }
        if ($questions):
          foreach ($questions as $q): ?>
            <div class="mb-3 border rounded p-3">
              <p class="mb-1 fw-bold"><?php echo h($q['question']); ?></p>
              <p class="mb-0"><?php echo h($q['answer']); ?></p>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-body-secondary">No questions yet.</p>
        <?php endif; ?>
      </div>
      <?php if(user_has_permission('meeting','update')): ?>
      <form id="questionForm" action="functions/add_question.php" method="post" class="border rounded p-3">
        <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
        <div class="mb-2">
          <label class="form-label">Question</label>
          <input type="text" name="question" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Answer</label>
          <textarea name="answer" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary btn-sm" type="submit">Add</button>
      </form>
      <?php endif; ?>
    </div>
    <div class="col-lg-4">
      <h4>Files</h4>
      <ul class="list-group" id="fileList">
        <?php
        $files = [];
        if (!empty($meeting['id'])) {
          $fStmt = $pdo->prepare('SELECT * FROM module_meeting_files WHERE meeting_id=?');
          $fStmt->execute([$meeting['id']]);
          $files = $fStmt->fetchAll(PDO::FETCH_ASSOC);
        }
        if ($files):
          foreach ($files as $file): ?>
            <li class="list-group-item"><a href="<?php echo getURLDir() . 'module/meeting/' . h($file['file_path']); ?>" target="_blank"><?php echo h($file['file_name']); ?></a></li>
          <?php endforeach; ?>
        <?php else: ?>
          <li class="list-group-item">No files uploaded.</li>
        <?php endif; ?>
      </ul>
      <?php if(user_has_permission('meeting','update')): ?>
      <form id="fileUploadForm" action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="mt-3">
        <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
        <input type="file" name="file" class="form-control mb-2" required>
        <button class="btn btn-secondary btn-sm" type="submit">Upload</button>
      </form>
      <?php endif; ?>
    </div>
  </div>
</div>
