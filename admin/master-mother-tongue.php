<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'Mother tongue';
$adminCurrent = 'master-mother-tongue';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-mother-tongue';
$pmDbRows = sathi_master_storage_get($pmDbSlug);
$pmHeroTitle = 'Mother tongue';
$pmHeroLead = 'MySQL `mother_tongues`.';
$pmHeroIcon = 'fas fa-language';
$pmItems = [];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
