<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Star (Nakshatra)';
$adminCurrent = 'master-star';

require __DIR__ . '/includes/head.php';

$pmHeroTitle = 'Star';
$pmHeroLead = 'Optional field — add to registration when needed. Sample rows for UI.';
$pmHeroIcon = 'fas fa-star-of-david';
$pmItems = ['Ashwini', 'Bharani', 'Krittika', 'Rohini', 'Mrigashira', 'Ardra'];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
