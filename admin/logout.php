<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

unset(
    $_SESSION['sathi_admin_id'],
    $_SESSION['sathi_admin_email'],
    $_SESSION['sathi_admin_name'],
    $_SESSION['sathi_admin_role']
);

header('Location: login.php', true, 302);
exit;
