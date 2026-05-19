<?php
require_once __DIR__ . '/config/database.php';
$db = sathi_db();

echo "<h3>Admin Debug Information</h3>";

$res = $db->query("SELECT id, name, email, password_hash, role, status FROM admins");
if ($res && $res->num_rows > 0) {
    echo "<table border='1' cellpadding='5' style='border-collapse:collapse'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Hash</th></tr>";
    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['role']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "<td><small>{$row['password_hash']}</small></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color:red'>No admin accounts found in 'admins' table.</p>";
}

// Test login logic manually
$testEmail = 'admin@shadikibaat.local';
$testPass = 'admin123';
$res = $db->query("SELECT password_hash FROM admins WHERE email = '$testEmail'");
if ($row = $res->fetch_assoc()) {
    $verify = password_verify($testPass, $row['password_hash']);
    echo "<p>Test Verification for <b>$testEmail</b> with <b>$testPass</b>: " . ($verify ? "<span style='color:green'>SUCCESS</span>" : "<span style='color:red'>FAILED</span>") . "</p>";
} else {
    echo "<p style='color:red'>User '$testEmail' not found for test.</p>";
}
?>
