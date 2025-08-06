<?php

function getURLDir(){
  return '/Atlis/';
}

// Records CRUD actions into the audit_log table
function audit_log($pdo, $userId, $table, $recordId, $action, $details){
  $sql = "INSERT INTO audit_log (user_id, user_updated, table_name, record_id, action, details)
          VALUES (:user_id, :user_updated, :table_name, :record_id, :action, :details)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':user_id' => $userId,
    ':user_updated' => $userId,
    ':table_name' => $table,
    ':record_id' => $recordId,
    ':action' => $action,
    ':details' => $details,
  ]);
}

?>
