<?php
/**
 * Auto-Login Script
 * This script manually sets the admin session to bypass the login form.
 * For development use only.
 */
require_once __DIR__ . '/admin/includes/bootstrap.php';
require_once __DIR__ . '/config/database.php';

$db = sathi_db();
$email = 'admin@shadikibaat.local';

// Fetch the admin record to get the correct ID and details
$res = $db->query("SELECT * FROM admins WHERE email = '$email' LIMIT 1");
$row = $res->fetch_assoc();

if ($row) {
    // Manually set the session variables to log you in
    $_SESSION['sathi_admin_id'] = (int) $row['id'];
    $_SESSION['sathi_admin_email'] = (string) $row['email'];
    $_SESSION['sathi_admin_name'] = (string) $row['name'];
    $_SESSION['sathi_admin_role'] = (string) $row['role'];

    echo "<div style='font-family:sans-serif; text-align:center; margin-top:100px;'>";
    echo "<h2>✅ Admin Session Initialized!</h2>";
    echo "<p>Logged in as: <b>" . htmlspecialchars($row['name']) . "</b></p>";
    echo "<p>Redirecting you to the dashboard in 2 seconds...</p>";
    echo "<a href='admin/dashboard.php' style='color:#e94e77; font-weight:bold;'>Click here if not redirected</a>";
    echo "</div>";
    
    echo "<script>setTimeout(function(){ window.location.href = 'admin/dashboard.php'; }, 2000);</script>";
} else {
    echo "<div style='color:red; font-family:sans-serif; text-align:center; margin-top:100px;'>";
    echo "<h2>❌ Admin account not found!</h2>";
    echo "<p>Please run <b>setup.php</b> first to create the admin account.</p>";
    echo "<a href='setup.php'>Go to Setup</a>";
    echo "</div>";
}
?>
