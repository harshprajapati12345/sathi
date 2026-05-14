<?php
declare(strict_types=1);

require_once __DIR__ . '/session_init.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/admin/includes/user-storage.php';

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$email = isset($_POST['email']) ? strtolower(trim((string) $_POST['email'])) : '';
$password = isset($_POST['password']) ? (string) $_POST['password'] : '';

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
    echo json_encode(['ok' => false, 'error' => 'invalid_credentials']);
    exit;
}

try {
    $user = sathi_user_repo_find_by_email($email);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'database']);
    exit;
}

if ($user === null || $user['password_hash'] === '' || !password_verify($password, $user['password_hash'])) {
    echo json_encode(['ok' => false, 'error' => 'invalid_credentials']);
    exit;
}

session_regenerate_id(true);
$_SESSION['sathi_user_id'] = $user['id'];
$_SESSION['sathi_user_email'] = $user['email'];
$_SESSION['sathi_user_name'] = $user['name'];
$_SESSION['sathi_registration_status'] = $user['status'];
$_SESSION['sathi_membership_status'] = $user['membership_status'];
$_SESSION['sathi_registration_complete'] = true;

sathi_user_touch_login($user['id']);

echo json_encode(['ok' => true, 'status' => $user['status']]);
