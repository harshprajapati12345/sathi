<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Rasi (Moonsign)';
$adminCurrent = 'master-rasi';

require __DIR__ . '/includes/head.php';

$pmHeroTitle = 'Rasi';
$pmHeroLead = 'Optional — sample list for static admin UI.';
$pmHeroIcon = 'fas fa-moon';
$pmItems = ['Mesha (Aries)', 'Vrishabha (Taurus)', 'Mithuna (Gemini)', 'Karka (Cancer)', 'Simha (Leo)', 'Kanya (Virgo)'];

require __DIR__ . '/includes/partials/master-table-static.php';
require __DIR__ . '/includes/footer.php';
