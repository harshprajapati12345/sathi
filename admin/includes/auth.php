<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function shadikibaat_admin_require_auth(): void
{
    if (!empty($_SESSION['sathi_admin_id'])) {
        return;
    }
    header('Location: login.php', true, 302);
    exit;
}
