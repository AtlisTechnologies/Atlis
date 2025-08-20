<?php
/**
 * Fetch the admin navigation links from the shared table.
 *
 * @return array<int, array<string, mixed>> List of navigation links
 */
global $pdo;

$sql = 'SELECT * FROM admin_navigation_links ORDER BY sort_order';
$stmt = $pdo->prepare($sql);
$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
