<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    try {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } catch (Throwable $e) {
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }
}

$userStorage = __DIR__ . '/admin/includes/user-storage.php';
if (!empty($_SESSION['sathi_user_id']) && is_file($userStorage)) {
    require_once __DIR__ . '/config/database.php';
    require_once $userStorage;
    try {
        $storedUser = sathi_user_repo_find_by_id((int) $_SESSION['sathi_user_id']);
        if ($storedUser === null) {
            unset($_SESSION['sathi_user_id'], $_SESSION['sathi_user_email'], $_SESSION['sathi_user_name'], $_SESSION['sathi_registration_complete'], $_SESSION['sathi_registration_status'], $_SESSION['sathi_membership_status']);
        } else {
            $_SESSION['sathi_registration_status'] = $storedUser['status'];
            $_SESSION['sathi_membership_status'] = $storedUser['membership_status'];
            $_SESSION['sathi_user_name'] = $storedUser['name'];
            $_SESSION['sathi_user_email'] = $storedUser['email'];
        }
    } catch (Throwable $e) {
        // leave session as-is if DB unavailable
    }
} elseif (!empty($_SESSION['sathi_user_email']) && is_file($userStorage)) {
    require_once __DIR__ . '/config/database.php';
    require_once $userStorage;
    try {
        $storedUser = sathi_user_repo_find_by_email((string) $_SESSION['sathi_user_email']);
        if (is_array($storedUser)) {
            $_SESSION['sathi_user_id'] = $storedUser['id'];
            $_SESSION['sathi_registration_status'] = $storedUser['status'];
            $_SESSION['sathi_membership_status'] = $storedUser['membership_status'];
            if (!empty($storedUser['name'])) {
                $_SESSION['sathi_user_name'] = (string) $storedUser['name'];
            }
        }
    } catch (Throwable $e) {
    }
}
