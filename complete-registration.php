<?php
require_once __DIR__ . '/session_init.php';
require_once __DIR__ . '/admin/includes/user-storage.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$email = isset($_POST['email']) ? trim((string) $_POST['email']) : '';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'invalid_email']);
    exit;
}

$fullName = isset($_POST['full_name']) ? trim((string) $_POST['full_name']) : '';
$fullName = preg_replace('/[\x00-\x1F\x7F]/u', '', $fullName);
if (function_exists('mb_strlen') && mb_strlen($fullName) > 120) {
    $fullName = mb_substr($fullName, 0, 120);
} elseif (strlen($fullName) > 120) {
    $fullName = substr($fullName, 0, 120);
}

$emailKey = strtolower($email);
$displayName = $fullName !== '' ? $fullName : 'Member';

sathi_user_storage_upsert([
    'email' => $emailKey,
    'name' => $displayName,
    'status' => 'pending',
    'registered_at' => date('c'),
]);

$_SESSION['sathi_registration_complete'] = true;
$_SESSION['sathi_registration_status'] = 'pending';
$_SESSION['sathi_user_name'] = $displayName;
$_SESSION['sathi_user_email'] = $emailKey;

header('Content-Type: application/json; charset=UTF-8');
echo json_encode(['ok' => true]);
