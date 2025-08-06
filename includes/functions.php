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
function audit_log($pdo, $userId, $table, $recordId, $action, $details = null){
  $stmt = $pdo->prepare('CALL sp_insert_audit_log(?,?,?,?,?)');
  $stmt->execute([$userId, $table, $recordId, $action, $details]);
}

?>
