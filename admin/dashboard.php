<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/dashboard-stats.php';

require_once __DIR__ . '/includes/user-storage.php';

$pageTitle = 'Dashboard';
$adminCurrent = 'dashboard';
$dashStats = sathi_admin_dashboard_stats();
$recentUsers = sathi_users_list_all(10); // Get latest 10 users

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/partials/dashboard-home.php';
require __DIR__ . '/includes/footer.php';
