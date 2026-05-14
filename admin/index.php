<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION['sathi_admin_id'])) {
    header('Location: dashboard.php', true, 302);
    exit;
}

header('Location: login.php', true, 302);
exit;
