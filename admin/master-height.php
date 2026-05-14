<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';
$pageTitle = 'Height';
$adminCurrent = 'master-height';
require __DIR__ . '/includes/head.php';
$pmDbSlug = 'master-height';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Height';
$pmHeroLead = 'Manage height options for user profiles.';
$pmHeroIcon = 'fas fa-arrows-up-down';
$pmItems = [];
require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
