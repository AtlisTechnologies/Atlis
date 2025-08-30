<?php
function generate_asset_tag(PDO $pdo): string {
    $year = date('Y');
    $seqStmt = $pdo->prepare('SELECT id, seq FROM module_asset_tag_seq WHERE type_id=0 AND year=:yr');
    $seqStmt->execute([':yr'=>$year]);
    $row = $seqStmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $seq = $row['seq'] + 1;
        $pdo->prepare('UPDATE module_asset_tag_seq SET seq=:seq WHERE id=:id')->execute([':seq'=>$seq, ':id'=>$row['id']]);
    } else {
        $seq = 1;
        $pdo->prepare('INSERT INTO module_asset_tag_seq (type_id, year, seq) VALUES (0,:yr,1)')->execute([':yr'=>$year]);
    }
    return sprintf('AT-%s-%04d', $year, $seq);
}
?>
