<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/user-storage.php';

shadikibaat_admin_require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$userId = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;
$action = isset($_POST['action']) ? strtolower(trim((string) $_POST['action'])) : '';
$reason = isset($_POST['rejection_reason']) ? trim((string) $_POST['rejection_reason']) : '';

if ($userId <= 0) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'invalid_user']);
    exit;
}

if ($action !== 'approve' && $action !== 'reject') {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'invalid_action']);
    exit;
}

$status = $action === 'approve' ? 'approved' : 'rejected';
$adminId = isset($_SESSION['sathi_admin_id']) ? (int) $_SESSION['sathi_admin_id'] : null;

$updated = sathi_user_storage_update_status_by_id($userId, $status, $adminId, $reason !== '' ? $reason : null);
if (!$updated) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'not_found']);
    exit;
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode(['ok' => true, 'status' => $status]);
