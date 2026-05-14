<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';
$pageTitle = 'Profile Created By';
$adminCurrent = 'master-created-by';
require __DIR__ . '/includes/head.php';
$pmDbSlug = 'master-created-by';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Profile Created By';
$pmHeroLead = 'Manage options for who created the user profile (Self, Parent, etc.).';
$pmHeroIcon = 'fas fa-user-plus';
$pmItems = [];
require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
