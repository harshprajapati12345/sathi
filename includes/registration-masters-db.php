<?php
/**
 * Master lists for register.php (Logic Removed - Using Static Config)
 */
declare(strict_types=1);

require_once __DIR__ . '/registration-config.php';

/**
 * Master lists for register.php — Returns static hardcoded lists.
 *
 * @return array<string, mixed>
 */
function sathi_registration_masters_from_db(): array
{
    // The user requested to remove the DB logic for master data.
    // We now return the static hardcoded lists directly from the config.
    return sathi_registration_masters();
}
