<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'Annual income';
$adminCurrent = 'master-income';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-income';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Annual income';
$pmHeroLead = 'MySQL `incomes` (brackets).';
$pmHeroIcon = 'fas fa-indian-rupee-sign';
$pmItems = [];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
