<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'Religion';
$adminCurrent = 'master-religion';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-religion';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Religion';
$pmHeroLead = 'Manage religions (MySQL `religions`).';
$pmHeroIcon = 'fas fa-place-of-worship';
$pmItems = [];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
