<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'Occupation';
$adminCurrent = 'master-occupation';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-occupation';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Occupation';
$pmHeroLead = 'MySQL `occupations`.';
$pmHeroIcon = 'fas fa-briefcase';
$pmItems = [];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
