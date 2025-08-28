<?php
function recalc_invoice_total(PDO $pdo, int $invoice_id, int $user_id): void {
    $stmt = $pdo->prepare('SELECT COALESCE(SUM(amount),0) FROM admin_finances_invoice_items WHERE invoice_id = :id');
    $stmt->execute([':id'=>$invoice_id]);
    $itemTotal = (float)$stmt->fetchColumn();

    $stmt = $pdo->prepare('SELECT COALESCE(SUM(hours*rate),0) FROM admin_time_tracking_entries WHERE invoice_id = :id');
    $stmt->execute([':id'=>$invoice_id]);
    $timeTotal = (float)$stmt->fetchColumn();

    $total = $itemTotal + $timeTotal;
    $upd = $pdo->prepare('UPDATE admin_finances_invoices SET total_amount = :total, user_updated = :uid WHERE id = :id');
    $upd->execute([':total'=>$total, ':uid'=>$user_id, ':id'=>$invoice_id]);
}
?>
