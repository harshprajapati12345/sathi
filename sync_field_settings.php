<?php
require_once 'admin/includes/bootstrap.php';
require_once 'includes/registration-config.php';

$db = sathi_db();
$fields = sathi_registration_field_labels();

echo "Synchronizing registration_field_settings table...\n";

foreach ($fields as $key => $label) {
    // Check if exists
    $stmt = $db->prepare("SELECT field_key FROM registration_field_settings WHERE field_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    if (!$stmt->get_result()->fetch_assoc()) {
        echo "Adding $key...\n";
        $ins = $db->prepare("INSERT INTO registration_field_settings (field_key, is_visible, is_required) VALUES (?, 1, 0)");
        $ins->bind_param("s", $key);
        $ins->execute();
    }
}

echo "Done.\n";
?>