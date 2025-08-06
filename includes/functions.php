<?php

function getURLDir(){
  return '/Atlis/';
}

/**
 * Writes an entry to the audit_log table using a stored procedure.
 *
 * @param PDO    $pdo      Active PDO connection.
 * @param int    $userId   ID of the acting user.
 * @param string $table    Name of the table acted upon.
 * @param int    $recordId Primary key of the affected record.
 * @param string $action   CRUD action (CREATE, READ, UPDATE, DELETE).
 * @param string $details  Optional description of the change.
 */
  
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
