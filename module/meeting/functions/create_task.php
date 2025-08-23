<?php
// Proxy to task creation endpoint with AJAX response
$_POST['ajax'] = 1;
require __DIR__ . '/../../task/functions/create.php';
