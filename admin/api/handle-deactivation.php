<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_once dirname(__DIR__, 2) . '/helpers/response.php';

// Check admin auth (using simplified check assuming session has admin flag or similar)
// If there is an admin_auth_helper, use it. For now, assuming bootstrap handles it or we're just checking method.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method not allowed');
}

$id = (int)($_POST['id'] ?? 0);
$action = $_POST['action'] ?? '';

if ($id <= 0 || !in_array($action, ['approved', 'rejected'])) {
    json_response(false, 'Invalid parameters');
}

$db = sathi_db();

$db->begin_transaction();
try {
    // 1. Check request exists and is pending
    $stmt = $db->prepare("SELECT user_id, status FROM profile_deactivation_requests WHERE id = ? FOR UPDATE");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        throw new Exception("Request not found");
    }
    $req = $res->fetch_assoc();
    if ($req['status'] !== 'pending') {
        throw new Exception("Request is already processed");
    }
    $stmt->close();

    $userId = $req['user_id'];

    // 2. Update request status
    $stmtUpdate = $db->prepare("UPDATE profile_deactivation_requests SET status = ? WHERE id = ?");
    $stmtUpdate->bind_param("si", $action, $id);
    if (!$stmtUpdate->execute()) {
        throw new Exception("Failed to update request: " . $stmtUpdate->error);
    }
    $stmtUpdate->close();

    // 3. Update user status if approved
    if ($action === 'approved') {
        $stmtUser = $db->prepare("UPDATE users SET status = 'deactivated' WHERE id = ?");
        $stmtUser->bind_param("i", $userId);
        if (!$stmtUser->execute()) {
            throw new Exception("Failed to deactivate user: " . $stmtUser->error);
        }
        $stmtUser->close();
    }

    $db->commit();
    json_response(true, 'Request ' . $action . ' successfully');

} catch (Exception $e) {
    $db->rollback();
    json_response(false, $e->getMessage());
}
