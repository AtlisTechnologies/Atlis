<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'details') {
    $meeting_id = (int)($_GET['id'] ?? 0);
    $stmt = $pdo->prepare('SELECT * FROM module_meeting WHERE id = :id');
    $stmt->execute([':id' => $meeting_id]);
    $current_meeting = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$current_meeting) {
        http_response_code(404);
        exit;
    }
    $fileTypeItems = get_lookup_items($pdo, 'MEETING_FILE_TYPE');
    $filesStmt = $pdo->prepare('SELECT f.id, f.user_id, f.file_name, f.file_path, f.file_size, f.file_type, f.date_created, f.description, f.file_type_id, f.status_id, f.sort_order, CONCAT(p.first_name, " ", p.last_name) AS user_name, ft.code AS type_code, ft.label AS type_label, COALESCE(ft_color.attr_value, "secondary") AS type_color_class FROM module_meeting_files f LEFT JOIN users u ON f.user_id = u.id LEFT JOIN person p ON u.id = p.user_id LEFT JOIN lookup_list_items ft ON f.file_type_id = ft.id LEFT JOIN lookup_list_item_attributes ft_color ON ft.id = ft_color.item_id AND ft_color.attr_code = "COLOR-CLASS" WHERE f.meeting_id = :id ORDER BY f.sort_order, f.date_created DESC');
    $filesStmt->execute([':id' => $meeting_id]);
    $meetingFiles = $filesStmt->fetchAll(PDO::FETCH_ASSOC);
}

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <?php
      $viewMap = [
        'list' => 'list_view.php',
        'details' => 'details_view.php'
      ];
      $viewFile = $viewMap[$action] ?? 'list_view.php';
      require 'include/' . $viewFile;
    ?>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
