<?php
require_once __DIR__ . '/../session_init.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

$userId = $_SESSION['sathi_user_id'] ?? $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['status' => 'logged_out']);
    exit;
}

$stmt = $db->prepare("SELECT status FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $dbStatus = strtolower($row['status']);
    
    // Update session so auth_helper knows
    $_SESSION['sathi_registration_status'] = $dbStatus;
    $_SESSION['approval_status'] = $dbStatus;
    
    echo json_encode(['status' => $dbStatus]);
} else {
    echo json_encode(['status' => 'not_found']);
}
