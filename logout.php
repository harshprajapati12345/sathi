<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

unset(
    $_SESSION['sathi_user_id'],
    $_SESSION['sathi_user_email'],
    $_SESSION['sathi_user_name'],
    $_SESSION['sathi_registration_complete'],
    $_SESSION['sathi_registration_status'],
    $_SESSION['sathi_membership_status']
);

header('Location: login.php', true, 302);
exit;
