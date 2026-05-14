<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'Marital status';
$adminCurrent = 'master-marital-status';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-marital-status';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Marital status';
$pmHeroLead = 'MySQL `marital_statuses`.';
$pmHeroIcon = 'fas fa-heart';
$pmItems = [];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
