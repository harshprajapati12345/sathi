<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/user-storage.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$email = isset($_POST['email']) ? trim((string) $_POST['email']) : '';
$action = isset($_POST['action']) ? trim((string) $_POST['action']) : '';

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'invalid_email']);
    exit;
}

$action = strtolower($action);
if ($action !== 'approve' && $action !== 'reject') {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'invalid_action']);
    exit;
}

$status = $action === 'approve' ? 'approved' : 'rejected';

$updated = sathi_user_storage_update_status(strtolower($email), $status);
if (!$updated) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'not_found']);
    exit;
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode(['ok' => true, 'status' => $status]);
