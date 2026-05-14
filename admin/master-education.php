<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'Education';
$adminCurrent = 'master-education';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-education';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Education';
$pmHeroLead = 'MySQL `educations`.';
$pmHeroIcon = 'fas fa-graduation-cap';
$pmItems = [];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
