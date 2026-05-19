<?php
/**
 * Migration and Seeder Runner
 * Executes additional_tables.sql and complete_seeder.sql
 */

require_once __DIR__ . '/config/database.php';

function runSqlFile($db, $filePath) {
    if (!file_exists($filePath)) {
        echo "File not found: $filePath\n";
        return false;
    }

    echo "Executing $filePath...\n";
    $sql = file_get_contents($filePath);
    
    // Split by semicolon, but be careful with triggers/stored procedures (not present here)
    // For simple migrations, multi_query works well
    if ($db->multi_query($sql)) {
        do {
            /* store first result set */
            if ($result = $db->store_result()) {
                $result->free();
            }
            /* print divider */
            if ($db->more_results()) {
                // next result
            }
        } while ($db->next_result());
        echo "Successfully executed $filePath\n";
        return true;
    } else {
        echo "Error executing $filePath: " . $db->error . "\n";
        return false;
    }
}

$db = sathi_db();

echo "Starting migration process...\n\n";

// 1. Run additional tables migration
if (runSqlFile($db, __DIR__ . '/data/additional_tables.sql')) {
    echo "\n";
    // 2. Run the 162 users seeder
    if (runSqlFile($db, __DIR__ . '/data/users_seeder_162.sql')) {
        echo "\n";
        // 3. Run the generated seeder
        runSqlFile($db, __DIR__ . '/complete_seeder.sql');
    }
}

echo "\nMigration process completed.\n";
