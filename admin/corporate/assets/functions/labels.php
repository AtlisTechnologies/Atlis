<?php
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('assets','read');

$ids = array_filter(array_map('intval', explode(',', $_GET['ids'] ?? '')));
?><html><head><link rel="stylesheet" href="../labels.css"></head><body>
<?php foreach ($ids as $id): ?>
<div class="label"><img src="label.php?id=<?= $id; ?>" alt="QR"></div>
<?php endforeach; ?>
</body></html>
