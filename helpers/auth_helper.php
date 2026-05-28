<?php
/**
 * Professional Membership Approval Flow - Authentication Helper
 */
require_once __DIR__ . '/../session_init.php';

function sathi_require_approval() {
    // Prevent recursive calls if already redirected
    if (defined('SATHI_AUTH_CHECKED')) return;
    define('SATHI_AUTH_CHECKED', true);

    $currentFile = basename($_SERVER['PHP_SELF']);
    
    $userId = $_SESSION['sathi_user_id'] ?? $_SESSION['user_id'] ?? null;
    $isLoggedIn = !empty($userId);
    
    $statusRaw = $_SESSION['sathi_registration_status'] ?? $_SESSION['approval_status'] ?? 'pending';
    $status = strtolower((string)$statusRaw);

    // Status pages
    $statusPages = ['pending.php', 'reject.php'];

    // 1. If logged in but trying to Register/Login -> Send them to the right place
    if ($isLoggedIn && ($currentFile === 'register.php' || $currentFile === 'login.php')) {
        if ($status === 'approved' || $status === 'active') {
            header("Location: index.php");
        } elseif ($status === 'rejected') {
            header("Location: reject.php");
        } else {
            header("Location: pending.php");
        }
        exit();
    }

    // 2. If NOT logged in -> Force them to Register (except for public pages)
    if (!$isLoggedIn) {
        $public = ['register.php', 'eligibility.php', 'login.php', 'logout.php', 'about.php', 'contact.php'];
        if (!in_array($currentFile, $public)) {
            header("Location: login.php");
            exit();
        }
        return;
    }

    // 3. If logged in, restrict access to all customer pages unless approved
    $allowedWhenPending = ['pending.php', 'reject.php', 'logout.php', 'complete-registration.php', 'api.php'];
    if ($isLoggedIn && !in_array($currentFile, $allowedWhenPending)) {
        if ($status === 'pending') {
            header("Location: pending.php");
            exit();
        } 
        if ($status === 'rejected') {
            header("Location: reject.php");
            exit();
        }
    }

    // 4. If approved but still on a status page -> Go to matches
    if ($isLoggedIn && in_array($currentFile, $statusPages)) {
        if ($status === 'approved' || $status === 'active') {
            header("Location: index.php");
            exit();
        }
    }
}
