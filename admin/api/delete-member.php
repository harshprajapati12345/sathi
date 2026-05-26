<?php
/**
 * Admin API: Delete Member
 */
require_once dirname(dirname(__DIR__)) . '/config/database.php';
require_once dirname(dirname(__DIR__)) . '/helpers/response.php';

session_start();

$id = (int)($_POST['id'] ?? 0);

if (!$id) {
    json_response(false, 'Missing member ID');
}

$db = sathi_db();

// Optional: delete related records first like photos, preferences etc. 
// For now, we assume simple user deletion or cascading is set up on DB level.
$stmt = $db->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        json_response(true, 'Member deleted successfully');
    } else {
        json_response(false, 'Member not found or already deleted');
    }
} else {
    json_response(false, 'Failed to delete member: ' . $db->error);
}
