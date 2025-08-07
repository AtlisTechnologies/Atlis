<?php

function generate_csrf_token(){
  $token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
  $_SESSION['csrf_token'] = $token;
  return $token;
}

function verify_csrf_token($token){
  if(!hash_equals($_SESSION['csrf_token'] ?? '', $token ?? '')){
    die('Invalid CSRF token');
  }
  return true;
}

function flash_message($type, $message){
  if($message){
    echo '<div class="alert alert-' . htmlspecialchars($type) . '">' . htmlspecialchars($message) . '</div>';
  }
}

?>
