<?php
require_once __DIR__ . '/config/database.php';
$db = sathi_db();
$db->query("ALTER TABLE candidates ADD COLUMN dosh VARCHAR(50) DEFAULT NULL AFTER horoscope");
$db->query("ALTER TABLE candidates ADD COLUMN star VARCHAR(100) DEFAULT NULL AFTER horoscope");
$db->query("ALTER TABLE candidates ADD COLUMN rasi VARCHAR(50) DEFAULT NULL AFTER horoscope");
echo "Done";
