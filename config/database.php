<?php
/**
 * Core Database Connection (Simplified Plan using MySQLi)
 */
function sathi_db()
{
    static $conn;

    if ($conn) {
        return $conn;
    }

    $config = require __DIR__ . '/db.local.php';

    $conn = new mysqli(
        $config['host'],
        $config['user'],
        $config['password'],
        $config['database']
    );

    if ($conn->connect_error) {
        die('Database Connection Failed: ' . $conn->connect_error);
    }

    $conn->set_charset('utf8mb4');

    return $conn;
}

/**
 * Site Setting Helper
 */
function sathi_site_setting($key, $default = '')
{
    $db = sathi_db();

    $stmt = $db->prepare(
        "SELECT setting_value
         FROM site_settings
         WHERE setting_key = ?"
    );

    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    return $result['setting_value'] ?? $default;
}

/**
 * Get all site settings
 */
function sathi_site_settings_all()
{
    $db = sathi_db();
    $result = $db->query("SELECT setting_key, setting_value FROM site_settings");
    $settings = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    return $settings;
}

/** Alias for compatibility */
function site_setting($key, $default = '') {
    return sathi_site_setting($key, $default);
}
