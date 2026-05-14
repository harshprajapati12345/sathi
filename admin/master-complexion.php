<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';
$pageTitle = 'Complexion';
$adminCurrent = 'master-complexion';
require __DIR__ . '/includes/head.php';
$pmDbSlug = 'master-complexion';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Complexion';
$pmHeroLead = 'Manage complexion (skin tone) options.';
$pmHeroIcon = 'fas fa-palette';
$pmItems = [];
require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
