<?php
/**
 * Master Setup Script for Shadikibaat
 * This script initializes the database schema and seeds all data.
 */
require_once __DIR__ . '/config/database.php';

echo "<h2>🚀 Starting Shadikibaat Master Setup</h2>";

function runSqlFile($db, $filePath)
{
    if (!file_exists($filePath)) {
        echo "<span style='color:orange'>⚠️ File not found: $filePath</span><br>";
        return false;
    }

    echo "Running <b>" . basename($filePath) . "</b>... ";
    $sql = file_get_contents($filePath);

    if ($db->multi_query($sql)) {
        $count = 0;
        do {
            if ($result = $db->store_result()) {
                $result->free();
            }
            $count++;
        } while ($db->more_results() && $db->next_result());
        echo "<span style='color:green'>✅ Success (" . $count . " statements executed)</span><br>";
        return true;
    } else {
        echo "<span style='color:red'>❌ Error: " . $db->error . "</span><br>";
        return false;
    }
}

$db = sathi_db();

// 1. Core Schema
runSqlFile($db, __DIR__ . '/data/schema.sql');

// 2. Additional Tables
runSqlFile($db, __DIR__ . '/data/additional_tables.sql');

// 3. Sample Users (Skipped as per user request)
// runSqlFile($db, __DIR__ . '/data/sample_users.sql');

// 4. Large Users Seeder (Skipped as per user request)
// runSqlFile($db, __DIR__ . '/data/users_seeder_162.sql');

// 5. Complete Candidates Seeder (206 records from MALE.csv)
runSqlFile($db, __DIR__ . '/data/complete_candidates_seeder.sql');

// 6. Reset Admin Account
echo "Initializing Admin Account... ";
$adminEmail = 'admin@shadikibaat.local';
$adminPass = 'admin123';
$hash = password_hash($adminPass, PASSWORD_DEFAULT);

// Delete existing to ensure clean state
$db->query("DELETE FROM admins WHERE email = '$adminEmail'");

// Insert fresh admin
$stmt = $db->prepare("INSERT INTO admins (name, email, password_hash, role, status) VALUES ('Super Admin', ?, ?, 'super_admin', 1)");
$stmt->bind_param("ss", $adminEmail, $hash);

if ($stmt->execute()) {
    echo "<span style='color:green'>✅ Admin account ready (email: $adminEmail, pass: $adminPass)</span><br>";
} else {
    echo "<span style='color:red'>❌ Error setting up admin: " . $db->error . "</span><br>";
}

echo "<br><div style='padding:15px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px;'>";
echo "<h3>🎉 Setup Complete!</h3>";
echo "<ul>";
echo "<li><b>Admin Login:</b> <a href='admin/login.php'>/admin/login.php</a></li>";
echo "<li><b>User Email:</b> admin@shadikibaat.local</li>";
echo "<li><b>User Password:</b> admin123</li>";
echo "</ul>";
echo "</div>";
?>