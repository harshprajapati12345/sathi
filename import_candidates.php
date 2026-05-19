<?php
require_once 'config/database.php';

// Check if file exists
$sqlFile = 'data/complete_candidates_seeder.sql';
if (!file_exists($sqlFile)) {
    die("Error: SQL file not found at $sqlFile");
}

echo "Starting import of candidates...<br>";

// Read SQL file
$sql = file_get_contents($sqlFile);

try {
    $db = sathi_db();

    // Split the SQL into individual statements if necessary, 
    // but mysqli multi_query can handle it.
    if ($db->multi_query($sql)) {
        do {
            /* store first result set */
            if ($result = $db->store_result()) {
                $result->free();
            }
        } while ($db->more_results() && $db->next_result());

        echo "✅ Successfully imported records into 'candidates' table.<br>";
    } else {
        echo "❌ Error during import: " . $db->error . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Exception during import: " . $e->getMessage() . "<br>";
}
?>