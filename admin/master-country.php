<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'Country';
$adminCurrent = 'master-country';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-country';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Country';
$pmHeroLead = 'MySQL `countries`.';
$pmHeroIcon = 'fas fa-globe';
$pmItems = [];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
