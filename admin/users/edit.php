<?php
if (!defined('IN_APP')) { define('IN_APP', true); }
require '../admin_header.php';
require_permission('users','update');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header('Location: index.php');
    exit;
}

$username = $email = $first_name = $last_name = $type = 'ADMIN';
$status = 1;
$assigned = [];
$message = $error = '';
$btnClass = 'btn-warning';

$stmt = $pdo->prepare('SELECT u.username, u.email, u.type, u.status, p.first_name, p.last_name FROM users u LEFT JOIN person p ON u.id = p.user_id WHERE u.id = :id');
$stmt->execute([':id' => $id]);
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $username   = $row['username'];
    $email      = $row['email'];
    $type       = $row['type'];
    $status     = $row['status'];
    $first_name = $row['first_name'] ?? '';
    $last_name  = $row['last_name'] ?? '';
} else {
    die('User not found.');
}

$stmt = $pdo->prepare('SELECT role_id FROM admin_user_roles WHERE user_account_id = :id');
$stmt->execute([':id' => $id]);
$assigned = $stmt->fetchAll(PDO::FETCH_COLUMN);

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$roles = $pdo->query('SELECT id, name FROM admin_roles ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);

$typeStmt = $pdo->prepare("SELECT li.value, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'USER_TYPE' AND li.active_from <= CURDATE() AND (li.active_to IS NULL OR li.active_to >= CURDATE()) ORDER BY li.sort_order, li.label");
$typeStmt->execute();
$typeOptions = $typeStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$statusStmt = $pdo->prepare("SELECT li.value, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'USER_STATUS' AND li.active_from <= CURDATE() AND (li.active_to IS NULL OR li.active_to >= CURDATE()) ORDER BY li.sort_order, li.label");
$statusStmt->execute();
$statusOptions = $statusStmt->fetchAll(PDO::FETCH_KEY_PAIR);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }
    $username   = trim($_POST['username'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';
    $type       = $_POST['type'] ?? array_key_first($typeOptions);
    if (!array_key_exists($type, $typeOptions)) {
        $type = array_key_first($typeOptions);
    }
    $status = $_POST['status'] ?? array_key_first($statusOptions);
    if (!array_key_exists($status, $statusOptions)) {
        $status = array_key_first($statusOptions);
    }
    $status     = (int)$status;
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $roleIds    = $_POST['roles'] ?? [];

    if ($username === '' || $email === '') {
        $error = 'Username and email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username AND id != :id');
        $stmt->execute([':username'=>$username, ':id'=>$id]);
        if ($stmt->fetchColumn()) {
            $error = 'Username already exists.';
        }
        if (!$error) {
            $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email AND id != :id');
            $stmt->execute([':email'=>$email, ':id'=>$id]);
            if ($stmt->fetchColumn()) {
                $error = 'Email already exists.';
            }
        }
    }

    if (!$error) {
        if ($password !== '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('UPDATE users SET username=:username, email=:email, password=:password, type=:type, status=:status, user_updated=:uid WHERE id=:id');
            $stmt->execute([':username'=>$username, ':email'=>$email, ':password'=>$hash, ':type'=>$type, ':status'=>$status, ':uid'=>$this_user_id, ':id'=>$id]);
        } else {
            $stmt = $pdo->prepare('UPDATE users SET username=:username, email=:email, type=:type, status=:status, user_updated=:uid WHERE id=:id');
            $stmt->execute([':username'=>$username, ':email'=>$email, ':type'=>$type, ':status'=>$status, ':uid'=>$this_user_id, ':id'=>$id]);
        }
        audit_log($pdo, $this_user_id, 'users', $id, 'UPDATE', 'Updated user');
        $stmt = $pdo->prepare('SELECT id FROM person WHERE user_id = :id');
        $stmt->execute([':id' => $id]);
        if ($stmt->fetchColumn()) {
            $stmt = $pdo->prepare('UPDATE person SET first_name=:first_name, last_name=:last_name, user_updated=:uid WHERE user_id=:id');
            $stmt->execute([':first_name'=>$first_name, ':last_name'=>$last_name, ':uid'=>$this_user_id, ':id'=>$id]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, user_updated) VALUES (:user_id, :first_name, :last_name, :uid)');
            $stmt->execute([':user_id'=>$id, ':first_name'=>$first_name, ':last_name'=>$last_name, ':uid'=>$this_user_id]);
        }
        $stmt = $pdo->prepare('DELETE FROM admin_user_roles WHERE user_account_id = :id');
        $stmt->execute([':id' => $id]);
        foreach($roleIds as $roleId){
            $stmt = $pdo->prepare('INSERT INTO admin_user_roles (user_id, user_updated, user_account_id, role_id) VALUES (:uid, :uid, :uid_account, :role_id)');
            $stmt->execute([':uid'=>$this_user_id, ':uid_account'=>$id, ':role_id'=>$roleId]);
        }
        audit_log($pdo, $this_user_id, 'admin_user_roles', $id, 'UPDATE', 'Updated user roles');
        $message = 'User updated.';
    }
}
?>
<h2 class="mb-4">Edit User</h2>
<?php if($error){ echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>'; } ?>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<?php include 'form_edit.php'; ?>
<?php require '../admin_footer.php'; ?>

