<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION['sathi_user_email'])) {
    $storedUser = null;
    $storagePath = __DIR__ . '/admin/includes/user-storage.php';
    if (is_file($storagePath)) {
        require_once $storagePath;
        $storedUser = sathi_user_storage_find((string) $_SESSION['sathi_user_email']);
    }
    if (is_array($storedUser)) {
        $_SESSION['sathi_registration_status'] = strtolower((string) ($storedUser['status'] ?? 'pending'));
        if (!empty($storedUser['name'])) {
            $_SESSION['sathi_user_name'] = (string) $storedUser['name'];
        }
    }
}
