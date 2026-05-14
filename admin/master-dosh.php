<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Dosh';
$adminCurrent = 'master-dosh';

require __DIR__ . '/includes/head.php';

$pmHeroTitle = 'Dosh';
$pmHeroLead = 'Optional — sample list for static admin UI.';
$pmHeroIcon = 'fas fa-yin-yang';
$pmItems = ['None', 'Manglik', 'Nadi', 'Bhakoot', 'Gana', 'Other'];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
