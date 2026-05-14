<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'Caste';
$adminCurrent = 'master-caste';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-caste';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Caste';
$pmHeroLead = 'MySQL `castes` (same table as Gotra; uses first active religion if parent not sent).';
$pmHeroIcon = 'fas fa-users';
$pmItems = [];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
