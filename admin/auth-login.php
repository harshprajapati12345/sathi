<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php', true, 302);
    exit;
}

$email = isset($_POST['email']) ? strtolower(trim((string) $_POST['email'])) : '';
$password = isset($_POST['password']) ? (string) $_POST['password'] : '';

if ($email === '' || $password === '') {
    header('Location: login.php?err=1', true, 302);
    exit;
}

try {
    $db = sathi_db();
    $st = $db->prepare('SELECT id, name, email, password_hash, role, status FROM admins WHERE email = ? LIMIT 1');
    $st->bind_param("s", $email);
    $st->execute();
    $row = $st->get_result()->fetch_assoc();
} catch (Throwable $e) {
    header('Location: login.php?err=db', true, 302);
    exit;
}

if (!$row || !(int) ($row['status'] ?? 0) || !password_verify($password, (string) ($row['password_hash'] ?? ''))) {
    header('Location: login.php?err=1', true, 302);
    exit;
}

session_regenerate_id(true);
$_SESSION['sathi_admin_id'] = (int) $row['id'];
$_SESSION['sathi_admin_email'] = (string) $row['email'];
$_SESSION['sathi_admin_name'] = (string) $row['name'];
$_SESSION['sathi_admin_role'] = (string) $row['role'];

header('Location: dashboard.php', true, 302);
exit;
