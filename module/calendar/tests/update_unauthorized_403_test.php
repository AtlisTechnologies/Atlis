<?php
// Manual test to verify 403 response when updating a private event not owned by the user.
// It sets up a temporary environment using SQLite so it can run from CLI without a full application stack.

$base = sys_get_temp_dir() . '/calendar_test_' . uniqid();
mkdir($base . '/includes', 0777, true);
mkdir($base . '/module/calendar/functions', 0777, true);

// Copy the update.php under test into the temporary structure so its relative include works.
copy(__DIR__ . '/../functions/update.php', $base . '/module/calendar/functions/update.php');

// Stub php_header.php with minimal environment and database schema.
file_put_contents($base . '/includes/php_header.php', <<<'PHP'
<?php
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('CREATE TABLE module_calendar (id INTEGER PRIMARY KEY, user_id INT, is_private TINYINT);');
$pdo->exec('CREATE TABLE module_calendar_events (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INT, calendar_id INT, title TEXT, location TEXT, start_time TEXT, end_time TEXT, event_type_id INT, link_module TEXT, link_record_id INT, visibility_id INT, timezone_id INT);');
$pdo->exec('CREATE TABLE module_calendar_person_attendees (user_id INT, event_id INT, attendee_person_id INT, attended TINYINT);');
$pdo->exec('CREATE TABLE lookup_lists (id INTEGER PRIMARY KEY, name TEXT);');
$pdo->exec('CREATE TABLE lookup_list_items (id INTEGER PRIMARY KEY, list_id INT);');
$pdo->exec("INSERT INTO lookup_lists (id, name) VALUES (1, 'TIMEZONE');");
$pdo->exec("INSERT INTO lookup_list_items (id, list_id) VALUES (1,1);");
$pdo->exec("INSERT INTO module_calendar (id, user_id, is_private) VALUES (1,1,1);");
$pdo->exec("INSERT INTO module_calendar_events (id, user_id, calendar_id, title, location, start_time, end_time, event_type_id, link_module, link_record_id, visibility_id, timezone_id) VALUES (1,1,1,'Original','Somewhere','2025-01-01 00:00:00','2025-01-01 01:00:00',NULL,NULL,NULL,199,1);");
$this_user_id = 2; // Simulate a different user
function require_permission($m,$a){}
function user_has_role($r){ return false; }
function get_user_default_lookup_item($pdo,$uid,$name){ return 1; }
?>
PHP
);

// Auto-prepend file to supply POST data and report HTTP status code after script exits.
$env = $base . '/env.php';
file_put_contents($env, <<<'PHP'
<?php
$_POST = [
  'id' => 1,
  'title' => 'Updated',
  'start_time' => '2025-01-01 00:00:00',
  'end_time' => '2025-01-01 01:00:00',
  'calendar_id' => 1,
  'visibility_id' => 199
];
register_shutdown_function(function(){
  echo "HTTP_CODE=" . http_response_code() . "\n";
});
?>
PHP
);

$cmd = sprintf('cd %s && php -d auto_prepend_file=%s update.php', escapeshellarg($base . '/module/calendar/functions'), escapeshellarg($env));
passthru($cmd);
?>

