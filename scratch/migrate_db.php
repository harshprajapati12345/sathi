<?php
require_once 'config/database.php';
$db = sathi_db();

$columns = [
    'digamber_jain' => "ENUM('yes', 'no') DEFAULT 'no'",
    'religion' => "VARCHAR(100)",
    'which_temple' => "VARCHAR(255)",
    'birth_time' => "VARCHAR(20)",
    'birth_place' => "VARCHAR(255)",
    'birth_country' => "VARCHAR(100)",
    'birth_state' => "VARCHAR(100)",
    'birth_city' => "VARCHAR(100)",
    'native_country' => "VARCHAR(100)",
    'native_state' => "VARCHAR(100)",
    'native_city' => "VARCHAR(100)",
    'native_locality' => "VARCHAR(255)",
    'gotra' => "VARCHAR(100)",
    'star' => "VARCHAR(100)",
    'rasi' => "VARCHAR(100)",
    'dosh' => "VARCHAR(100)",
    'which_kundli' => "VARCHAR(100)",
    'kundli_image' => "VARCHAR(255)",
    'horoscope' => "VARCHAR(255)",
    'whatsapp' => "VARCHAR(20)",
    'father_name' => "VARCHAR(255)",
    'father_mobile' => "VARCHAR(20)",
    'father_income' => "VARCHAR(100)",
    'father_occ' => "VARCHAR(255)",
    'mother_name' => "VARCHAR(255)",
    'mother_mobile' => "VARCHAR(20)",
    'mother_income' => "VARCHAR(100)",
    'relative_details' => "TEXT",
    'bro_total' => "INT DEFAULT 0",
    'bro_married' => "INT DEFAULT 0",
    'bro_unmarried' => "INT DEFAULT 0",
    'sis_total' => "INT DEFAULT 0",
    'sis_married' => "INT DEFAULT 0",
    'sis_unmarried' => "INT DEFAULT 0",
    'mother_tongue_val' => "VARCHAR(100)",
    'marital_status_val' => "VARCHAR(100)",
    'razorpay_payment_id' => "VARCHAR(255)"
];

foreach ($columns as $col => $def) {
    $check = $db->query("SHOW COLUMNS FROM users LIKE '$col'");
    if ($check->num_rows == 0) {
        echo "Adding $col...\n";
        $db->query("ALTER TABLE users ADD $col $def");
    }
}

echo "Database updated.\n";
