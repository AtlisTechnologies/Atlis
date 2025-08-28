<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'delete') {
  require_permission('conference','delete');
  require 'functions/delete.php';
  exit;
}

if ($action === 'create-edit') {
  $id = (int)($_GET['id'] ?? 0);
  if ($id) {
    require_permission('conference','update');
    $stmt = $pdo->prepare('SELECT *, event_type_id AS conference_type_id FROM module_conferences WHERE id=?');
    $stmt->execute([$id]);
    $conference = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
  } else {
    require_permission('conference','create');
    $conference = ['latitude' => null, 'longitude' => null];
  }
} elseif ($action === 'details') {
  require_permission('conference','read');
  $id = (int)($_GET['id'] ?? 0);
  $stmt = $pdo->prepare('SELECT *, event_type_id AS conference_type_id FROM module_conferences WHERE id=?');
  $stmt->execute([$id]);
  $conference = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$conference) {
    http_response_code(404);
    exit;
  }
} else {
  require_permission('conference','read');
  $stmt = $pdo->query('SELECT id,name,start_datetime,end_datetime,venue FROM module_conferences ORDER BY start_datetime DESC');
  $conferences = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (in_array($action, ['create-edit', 'details'])) {
  if (!empty($id)) {
    // Child tables
    $imgStmt = $pdo->prepare('SELECT id,file_name,file_path,file_size,file_type,is_banner FROM module_conference_images WHERE conference_id=?');
    $imgStmt->execute([$id]);
    $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);

    $tagStmt = $pdo->prepare('SELECT tag FROM module_conference_tags WHERE conference_id=?');
    $tagStmt->execute([$id]);
    $tags = array_column($tagStmt->fetchAll(PDO::FETCH_ASSOC), 'tag');

    $ticketStmt = $pdo->prepare('SELECT option_name,price FROM module_conference_ticket_options WHERE conference_id=?');
    $ticketStmt->execute([$id]);
    $tickets = $ticketStmt->fetchAll(PDO::FETCH_ASSOC);

    $attendeeStmt = $pdo->prepare('SELECT attendee_user_id,status FROM module_conference_attendees WHERE conference_id=?');
    $attendeeStmt->execute([$id]);
    $attendees = $attendeeStmt->fetchAll(PDO::FETCH_ASSOC);

    // Counter totals
    $countStmt = $pdo->prepare("SELECT SUM(status='GOING') AS going_count, SUM(status='INTERESTED') AS interested_count, SUM(status='SHARED') AS share_count FROM module_conference_attendees WHERE conference_id=?");
    $countStmt->execute([$id]);
    $counts = $countStmt->fetch(PDO::FETCH_ASSOC) ?: ['going_count'=>0,'interested_count'=>0,'share_count'=>0];
    $conference = array_merge($conference, $counts);
  } else {
    $images = $tags = $tickets = $attendees = [];
  }
}

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php // require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <?php
      $viewMap = [
        'list' => 'list_view.php',
        'details' => 'details_view.php',
        'create-edit' => 'create_edit_view.php'
      ];
      $viewFile = $viewMap[$action] ?? 'list_view.php';
      require 'include/' . $viewFile;
      require '../../includes/html_footer.php';
    ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
