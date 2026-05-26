<?php
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/helpers/response.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method Not Allowed');
}

$userId = (int)($_SESSION['sathi_user_id'] ?? 0);
if ($userId <= 0) {
    json_response(false, 'Unauthorized');
}

$reason = trim($_POST['reason'] ?? '');
if (empty($reason)) {
    json_response(false, 'Reason is required');
}

$db = sathi_db();

// Check if there is already a pending request
$stmt = $db->prepare("SELECT id FROM profile_deactivation_requests WHERE user_id = ? AND status = 'pending'");
$stmt->bind_param("i", $userId);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    json_response(false, 'You already have a pending deactivation request.');
}
$stmt->close();

// Insert the new request
$stmt = $db->prepare("INSERT INTO profile_deactivation_requests (user_id, reason) VALUES (?, ?)");
$stmt->bind_param("is", $userId, $reason);

if ($stmt->execute()) {
    json_response(true, 'Deactivation request submitted successfully.');
} else {
    json_response(false, 'Failed to submit request: ' . $stmt->error);
}
$stmt->close();
