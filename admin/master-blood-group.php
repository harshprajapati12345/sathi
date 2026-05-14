<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';
$pageTitle = 'Blood Group';
$adminCurrent = 'master-blood-group';
require __DIR__ . '/includes/head.php';
$pmDbSlug = 'master-blood-group';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Blood Group';
$pmHeroLead = 'Manage blood group options.';
$pmHeroIcon = 'fas fa-droplet';
$pmItems = [];
require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
