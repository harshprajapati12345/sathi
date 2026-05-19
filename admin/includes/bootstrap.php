<?php
declare(strict_types=1);

define('SATHI_ADMIN_ROOT', dirname(__DIR__));
define('SATHI_PROJECT_ROOT', dirname(SATHI_ADMIN_ROOT));

require_once SATHI_PROJECT_ROOT . '/config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ADMIN_NAV = require SATHI_ADMIN_ROOT . '/includes/nav-config.php';

$ADMIN_PAGES = [];
$ADMIN_DASHBOARD = null;
$ADMIN_NAV_GROUPS = [];
$__grp = null;

foreach ($ADMIN_NAV as $row) {
    $kind = $row[0] ?? '';
    if ($kind === 'link' && ($row[1] ?? '') === 'dashboard') {
        $ADMIN_DASHBOARD = $row;
        continue;
    }
    if ($kind === 'section') {
        if ($__grp !== null) {
            $ADMIN_NAV_GROUPS[] = $__grp;
        }
        $label = (string) ($row[1] ?? 'Section');
        $slugId = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($label)));
        $slugId = trim($slugId, '-');
        $__grp = [
            'id' => 'nav-grp-' . ($slugId !== '' ? $slugId : 'section'),
            'label' => $label,
            'links' => [],
        ];
        continue;
    }
    if ($kind === 'link' && $__grp !== null) {
        $__grp['links'][] = $row;
        $slug = (string) ($row[1] ?? '');
        if ($slug !== '' && $slug !== 'dashboard') {
            $ADMIN_PAGES[$slug] = [
                'title' => $row[2] ?? 'Admin',
                'icon' => $row[3] ?? 'fa-file',
            ];
        }
    }
}
if ($__grp !== null) {
    $ADMIN_NAV_GROUPS[] = $__grp;
}
