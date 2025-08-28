<?php
require '../../../includes/config.php';

$calendarId = isset($_GET['calendar_id']) ? (int)$_GET['calendar_id'] : 0;
$token = $_GET['ics_token'] ?? '';

if (!$calendarId || $token === '') {
  http_response_code(400);
  exit('Invalid parameters');
}

$stmt = $pdo->prepare('SELECT id FROM module_calendar WHERE id = ? AND ics_token = ? LIMIT 1');
$stmt->execute([$calendarId, $token]);
if (!$stmt->fetchColumn()) {
  http_response_code(404);
  exit('Not found');
}

header('Content-Type: text/calendar; charset=utf-8');

$ev = $pdo->prepare('SELECT id, title, start_time, end_time, date_updated FROM module_calendar_events WHERE calendar_id = ? AND (visibility_id IS NULL OR visibility_id = 198)');
$ev->execute([$calendarId]);

$lines = [
  'BEGIN:VCALENDAR',
  'VERSION:2.0',
  'PRODID:-//Atlis//Calendar//EN',
  'CALSCALE:GREGORIAN'
];

while ($row = $ev->fetch(PDO::FETCH_ASSOC)) {
  $uid = $row['id'] . '@atlis';
  $dtstamp = gmdate('Ymd\THis\Z', strtotime($row['date_updated'] ?? $row['start_time']));
  $dtstart = gmdate('Ymd\THis\Z', strtotime($row['start_time']));
  $lines[] = 'BEGIN:VEVENT';
  $lines[] = 'UID:' . $uid;
  $lines[] = 'DTSTAMP:' . $dtstamp;
  $lines[] = 'DTSTART:' . $dtstart;
  if (!empty($row['end_time'])) {
    $lines[] = 'DTEND:' . gmdate('Ymd\THis\Z', strtotime($row['end_time']));
  }
  $summary = $row['title'] ?? '';
  $summary = str_replace(["\\", ",", ";", "\n"], ["\\\\", "\\,", "\\;", "\\n"], $summary);
  $lines[] = 'SUMMARY:' . $summary;
  $lines[] = 'END:VEVENT';
}

$lines[] = 'END:VCALENDAR';

echo implode("\r\n", $lines);
