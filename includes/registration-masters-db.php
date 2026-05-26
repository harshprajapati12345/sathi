<?php
/**
 * Master lists for register.php (Logic Removed - Using Static Config)
 */
declare(strict_types=1);

require_once __DIR__ . '/registration-config.php';
require_once dirname(__DIR__) . '/config/database.php';

/**
 * Master lists for register.php
 *
 * @return array<string, mixed>
 */
function sathi_registration_masters_from_db(): array
{
    $masters = sathi_registration_masters();
    $db = sathi_db();

    // Fetch Mandirs
    $mandirs = [];
    $res = $db->query("SELECT id as value, name as label FROM mandirs WHERE status = 'Active' ORDER BY name ASC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $mandirs[] = $row;
        }
    }
    $masters['mandir'] = $mandirs;

    // Fetch Subcasts
    $subcasts = [];
    $res2 = $db->query("SELECT id as value, name as label FROM subcasts WHERE status = 'Active' ORDER BY name ASC");
    if ($res2) {
        while ($row = $res2->fetch_assoc()) {
            $subcasts[] = $row;
        }
    }
    $masters['subcast'] = $subcasts;

    // Fetch Gotras (overriding static config)
    $gotras = [];
    $res3 = $db->query("SELECT id as value, name as label FROM gotras WHERE status = 'Active' ORDER BY name ASC");
    if ($res3) {
        while ($row = $res3->fetch_assoc()) {
            $gotras[] = $row;
        }
    }
    if (!empty($gotras)) {
        $masters['gotra'] = $gotras;
    }

    return $masters;
}
