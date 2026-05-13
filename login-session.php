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

$emailKey = strtolower($email);
$user = sathi_user_storage_find($emailKey);

if ($user === null) {
    $local = strstr($email, '@', true);
    $display = $local !== false ? $local : $email;
    $display = preg_replace('/[.\-_]+/', ' ', $display);
    $display = preg_replace('/\s+/', ' ', trim($display));
    if ($display !== '') {
        $display = function_exists('mb_convert_case')
            ? mb_convert_case($display, MB_CASE_TITLE, 'UTF-8')
            : ucwords(strtolower($display));
    }
    $displayName = $display !== '' ? $display : 'Member';
    sathi_user_storage_upsert([
        'email' => $emailKey,
        'name' => $displayName,
        'status' => 'pending',
        'registered_at' => date('c'),
    ]);
    $status = 'pending';
} else {
    $displayName = trim((string) ($user['name'] ?? 'Member')) ?: 'Member';
    $status = strtolower(trim((string) ($user['status'] ?? 'pending')));
    if ($status === '') {
        $status = 'pending';
    }
}

$_SESSION['sathi_registration_complete'] = true;
$_SESSION['sathi_registration_status'] = $status;
$_SESSION['sathi_user_name'] = $displayName;
$_SESSION['sathi_user_email'] = $emailKey;

header('Content-Type: application/json; charset=UTF-8');
echo json_encode(['ok' => true, 'status' => $status]);
