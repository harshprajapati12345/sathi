<?php
/**
 * User Storage using MySQLi (Aligned with Actual Schema)
 */
require_once dirname(__DIR__, 2) . '/config/database.php';

function sathi_user_repo_find_by_email($email)
{
    $db = sathi_db();
    $email = $db->real_escape_string(strtolower(trim($email)));
    
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    
    return sathi_user_normalize_row($row);
}

function sathi_user_repo_find_by_id($id)
{
    $db = sathi_db();
    $id = (int)$id;
    
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    return sathi_user_normalize_row($row);
}

function sathi_user_touch_login($userId)
{
    $db = sathi_db();
    $userId = (int)$userId;
    $db->query("UPDATE users SET last_login_at = NOW(), last_active_at = NOW() WHERE id = $userId");
}

function sathi_users_list_all($limit = 200)
{
    $db = sathi_db();
    $limit = (int)$limit;
    $result = $db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT $limit");
    
    $rows = [];
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Filter users by status
 */
function sathi_users_list_by_status($status, $limit = 200)
{
    $db = sathi_db();
    $status = $db->real_escape_string($status);
    $limit = (int)$limit;
    $result = $db->query("SELECT * FROM users WHERE status = '$status' ORDER BY created_at DESC LIMIT $limit");
    
    $rows = [];
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * List paid members
 */
function sathi_users_list_paid($limit = 200)
{
    $db = sathi_db();
    $limit = (int)$limit;
    $result = $db->query("SELECT * FROM users WHERE paid_member = 1 ORDER BY created_at DESC LIMIT $limit");
    
    $rows = [];
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Normalizes a user database row into a consistent format
 */
function sathi_user_normalize_row($row)
{
    if (!$row) return null;
    
    $row['name'] = trim(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''));
    if ($row['name'] === '') $row['name'] = 'Member';
    
    $row['status'] = $row['status'] ?? 'pending';
    $row['paid_member'] = (int)($row['paid_member'] ?? 0);
    $row['membership_status'] = $row['membership_status'] ?? 'free';
    
    return $row;
}

/**
 * Updated to match the parameters expected by existing code
 */
function sathi_user_storage_update_status_by_id($id, $status, $approvedBy = null, $reason = null)
{
    $db = sathi_db();
    $id = (int)$id;
    $status = $db->real_escape_string($status);
    
    $approvedAt = $status === 'approved' ? 'NOW()' : 'NULL';
    
    $stmt = $db->prepare("UPDATE users SET status = ?, approved_by = ?, rejection_reason = ?, approved_at = $approvedAt WHERE id = ?");
    $stmt->bind_param("sisi", $status, $approvedBy, $reason, $id);
    return $stmt->execute();
}

/** Alias for simpler calls */
function sathi_user_update_status($id, $status) {
    return sathi_user_storage_update_status_by_id($id, $status);
}
