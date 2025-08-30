<?php
function generate_asset_tag(PDO $pdo, int $type_id): string {
    $stmt = $pdo->prepare('SELECT code FROM lookup_list_items WHERE id=:id');
    $stmt->execute([':id'=>$type_id]);
    $code = $stmt->fetchColumn();
    if (!$code) { throw new Exception('Type code not found'); }
    $year = date('Y');
    $seqStmt = $pdo->prepare('SELECT id, seq FROM module_asset_tag_seq WHERE type_id=:type_id AND year=:yr');
    $seqStmt->execute([':type_id'=>$type_id, ':yr'=>$year]);
    $row = $seqStmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $seq = $row['seq'] + 1;
        $pdo->prepare('UPDATE module_asset_tag_seq SET seq=:seq WHERE id=:id')->execute([':seq'=>$seq, ':id'=>$row['id']]);
    } else {
        $seq = 1;
        $pdo->prepare('INSERT INTO module_asset_tag_seq (type_id, year, seq) VALUES (:type_id,:yr,1)')->execute([':type_id'=>$type_id, ':yr'=>$year]);
    }
    return sprintf('%s-%s-%04d', $code, $year, $seq);
}
?>
