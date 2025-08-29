<?php
// Test that list.php filters by q, event_type_id, start, and end parameters and returns valid JSON

$base = sys_get_temp_dir() . '/calendar_test_' . uniqid();
mkdir($base . '/includes', 0777, true);
mkdir($base . '/module/calendar/functions', 0777, true);

// Copy the list.php under test into the temporary structure so its relative include works.
copy(__DIR__ . '/../functions/list.php', $base . '/module/calendar/functions/list.php');

// Stub php_header.php with minimal environment and database schema.
file_put_contents($base . '/includes/php_header.php', <<<'PHP'
<?php
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('CREATE TABLE module_calendar (id INTEGER PRIMARY KEY, user_id INT, is_private TINYINT);');
$pdo->exec('CREATE TABLE module_calendar_events (id INTEGER PRIMARY KEY AUTOINCREMENT, calendar_id INT, user_id INT, title TEXT, memo TEXT, start_time TEXT, end_time TEXT, location TEXT, link_module TEXT, link_record_id INT, event_type_id INT, visibility_id INT);');
$pdo->exec('CREATE TABLE lookup_list_item_attributes (item_id INT, attr_code TEXT, attr_value TEXT);');
$pdo->exec('CREATE TABLE module_calendar_external_accounts (user_id INT, provider TEXT);');
$pdo->exec("INSERT INTO module_calendar (id, user_id, is_private) VALUES (1,1,0);");
$pdo->exec("INSERT INTO module_calendar_events (calendar_id, user_id, title, memo, start_time, end_time, event_type_id, visibility_id) VALUES (1,1,'Meeting','Discuss','2025-01-05 09:00:00','2025-01-05 10:00:00',1,198);");
$pdo->exec("INSERT INTO module_calendar_events (calendar_id, user_id, title, memo, start_time, end_time, event_type_id, visibility_id) VALUES (1,1,'Lunch','Team','2025-02-05 12:00:00','2025-02-05 13:00:00',2,198);");
$this_user_id = 1;
function require_permission($m,$a){}
function user_has_role($r){ return false; }
?>
PHP
);

// Stub external provider files expected by list.php
file_put_contents($base . '/module/calendar/functions/google_events.php', "<?php\nfunction fetch_google_events(){return [];}\n?>");
file_put_contents($base . '/module/calendar/functions/microsoft_events.php', "<?php\nfunction fetch_microsoft_events(){return [];}\n?>");

file_put_contents($base . '/env.php', <<<'PHP'
<?php
$_GET = [
  'calendar_ids' => '1',
  'q' => 'meet',
  'event_type_id' => 1,
  'start' => '2025-01-01 00:00:00',
  'end' => '2025-01-31 23:59:59'
];
?>
PHP
);

$cmd = sprintf('cd %s && php -d auto_prepend_file=%s list.php', escapeshellarg($base . '/module/calendar/functions'), escapeshellarg($base . '/env.php'));
$output = shell_exec($cmd);
$data = json_decode($output, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Invalid JSON\n";
    exit(1);
}
if (count($data) !== 1 || ($data[0]['title'] ?? '') !== 'Meeting') {
    echo "Filtering failed\n";
    exit(1);
}

echo "OK\n";
?>

