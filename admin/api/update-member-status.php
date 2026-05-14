<?php
/**
 * Admin API: Update Member Status
 */
require_once dirname(dirname(__DIR__)) . '/config/database.php';
require_once dirname(dirname(__DIR__)) . '/helpers/response.php';

session_start();

// Basic security check (Optional: Add admin session check here)
// if(empty($_SESSION['admin_id'])) json_response(false, 'Unauthorized');

$id = (int)($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';

if (!$id || !$status) {
    json_response(false, 'Missing required fields');
}

$allowedStatuses = ['pending', 'approved', 'rejected', 'active'];
if (!in_array($status, $allowedStatuses)) {
    json_response(false, 'Invalid status');
}

$db = sathi_db();
$stmt = $db->prepare("UPDATE users SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    json_response(true, 'Member status updated to ' . $status);
} else {
    json_response(false, 'Failed to update status: ' . $db->error);
}
