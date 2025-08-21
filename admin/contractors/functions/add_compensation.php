<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$cid  = (int)($_POST['contractor_id'] ?? 0);
$comp_type_id = (int)($_POST['compensation_type_id'] ?? 0);
$payment_method_id = (int)($_POST['payment_method_id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$pay_date = $_POST['pay_date'] ?? '';
$invoice_number = trim($_POST['invoice_number'] ?? '');
$existing_file_id = (int)($_POST['existing_file_id'] ?? 0);
$amount = trim($_POST['amount'] ?? '');
$start = $_POST['effective_start'] ?? '';
$end   = $_POST['effective_end'] ?? '';
$notes = trim($_POST['notes'] ?? '');

$file_id = $existing_file_id ?: null;

$ok = false;
if($cid && $comp_type_id && $payment_method_id && $title !== '' && $pay_date !== '' && $amount !== '' && $start !== ''){
  if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK){
    $max = (int)get_system_property($pdo,'contractor_file_max_size');
    if(!$max){ $max = 10 * 1024 * 1024; }
    $allowedStr = get_system_property($pdo,'contractor_file_allowed_ext') ?: 'pdf,docx,jpg,png';
    $allowed = array_map('trim', explode(',', strtolower($allowedStr)));
    $file = $_FILES['attachment'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if(in_array($ext,$allowed) && $file['size'] <= $max){
      $baseDir = dirname(__DIR__) . '/uploads/' . $cid . '/';
      if(!is_dir($baseDir)){ mkdir($baseDir,0777,true); }
      $fileName = basename($file['name']);
      $safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $fileName);
      $targetPath = $baseDir . $safeName;
      $relativePath = '/admin/contractors/uploads/'.$cid.'/'.$safeName;
      $stmt = $pdo->prepare('SELECT id,file_path,version FROM module_contractors_files WHERE contractor_id=:cid AND file_name=:name ORDER BY version DESC LIMIT 1');
      $stmt->execute([':cid'=>$cid, ':name'=>$fileName]);
      $prev = $stmt->fetch(PDO::FETCH_ASSOC);
      $version = 1;
      if($prev){
        $version = $prev['version'] + 1;
        $prevPath = $baseDir . basename($prev['file_path']);
        if(file_exists($prevPath)){
          $verDir = $baseDir . 'versioned/v' . $prev['version'] . '/';
          if(!is_dir($verDir)){ mkdir($verDir,0777,true); }
          rename($prevPath, $verDir . basename($prevPath));
        }
      }
      if(move_uploaded_file($file['tmp_name'],$targetPath)){
        $stmt = $pdo->prepare("SELECT id FROM lookup_list_items WHERE list_name='CONTRACTOR_FILE_TYPE' AND is_default=1 LIMIT 1");
        $stmt->execute();
        $ftid = $stmt->fetchColumn();
        if(!$ftid){
          $stmt = $pdo->prepare("SELECT id FROM lookup_list_items WHERE list_name='CONTRACTOR_FILE_TYPE' ORDER BY id LIMIT 1");
          $stmt->execute();
          $ftid = $stmt->fetchColumn();
        }
        $stmt = $pdo->prepare('INSERT INTO module_contractors_files (user_id,user_updated,contractor_id,file_type_id,file_name,file_path,version) VALUES (:uid,:uid,:cid,:ftype,:name,:path,:ver)');
        $stmt->execute([
          ':uid'=>$this_user_id,
          ':cid'=>$cid,
          ':ftype'=>$ftid,
          ':name'=>$fileName,
          ':path'=>$relativePath,
          ':ver'=>$version
        ]);
        $file_id = $pdo->lastInsertId();
        admin_audit_log($pdo,$this_user_id,'module_contractors_files',$file_id,'UPLOAD','',json_encode(['file'=>$fileName,'version'=>$version]));
      }
    }
  }

  $stmt = $pdo->prepare('INSERT INTO module_contractors_compensation (user_id,user_updated,contractor_id,compensation_type_id,payment_method_id,title,pay_date,invoice_number,file_id,amount,effective_start,effective_end,notes) VALUES (:uid,:uid,:cid,:ctype,:pmethod,:title,:pay_date,:invoice_number,:file_id,:amount,:start,:end,:notes)');
  $stmt->execute([
    ':uid'=>$this_user_id,
    ':cid'=>$cid,
    ':ctype'=>$comp_type_id,
    ':pmethod'=>$payment_method_id,
    ':title'=>$title,
    ':pay_date'=>$pay_date,
    ':invoice_number'=>$invoice_number !== '' ? $invoice_number : null,
    ':file_id'=>$file_id,
    ':amount'=>$amount,
    ':start'=>$start,
    ':end'=>$end !== '' ? $end : null,
    ':notes'=>$notes !== '' ? $notes : null
  ]);
  $compId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_contractors_compensation',$compId,'CREATE','',json_encode(['amount'=>$amount,'type'=>$comp_type_id,'title'=>$title]),'Added compensation');
  $ok = true;
}
$loc = '../contractor.php?id='.$cid;
$loc .= $ok ? '&msg=comp-saved#compensation' : '#compensation';
header('Location: '.$loc);
exit;
