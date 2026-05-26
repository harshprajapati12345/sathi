<?php
require_once __DIR__ . '/config/database.php';

$db = sathi_db();

$sql = "
CREATE TABLE IF NOT EXISTS `advertisements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `position` enum('top','bottom','left','right') NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if ($db->query($sql)) {
    echo "Advertisements table created successfully.\n";
} else {
    echo "Error creating table: " . $db->error . "\n";
}
