<?php
declare(strict_types=1);

/**
 * Load master list labels for admin static tables (mirrors register.php options).
 *
 * @return array<int, string>
 */
function admin_master_items_from_config(string $masterKey): array
{
    $path = dirname(__DIR__, 2) . '/includes/registration-config.php';
    if (!is_file($path)) {
        return [];
    }
    require_once $path;
    $m = sathi_registration_masters();
    if (!isset($m[$masterKey]) || !is_array($m[$masterKey])) {
        return [];
    }
    $out = [];
    foreach ($m[$masterKey] as $row) {
        if (is_array($row) && isset($row['label'])) {
            $out[] = (string) $row['label'];
        }
    }
    return $out;
}
