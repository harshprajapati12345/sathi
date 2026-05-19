-- Additional tables for complete profile data
-- Run this if you haven't created these tables yet

-- Table for user family details
CREATE TABLE IF NOT EXISTS `user_family_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `father_name` varchar(150) DEFAULT NULL,
  `father_mobile` varchar(20) DEFAULT NULL,
  `father_income` decimal(12,2) DEFAULT NULL,
  `father_occupation` varchar(100) DEFAULT NULL,
  `mother_name` varchar(150) DEFAULT NULL,
  `mother_mobile` varchar(20) DEFAULT NULL,
  `mother_income` decimal(12,2) DEFAULT NULL,
  `mother_occupation` varchar(100) DEFAULT NULL,
  `brothers` int(11) DEFAULT 0,
  `brothers_married` int(11) DEFAULT 0,
  `brothers_unmarried` int(11) DEFAULT 0,
  `sisters` int(11) DEFAULT 0,
  `sisters_married` int(11) DEFAULT 0,
  `sisters_unmarried` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_user_family_details_user` (`user_id`),
  CONSTRAINT `fk_user_family_details_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for user work details
CREATE TABLE IF NOT EXISTS `user_work_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `occupation_firm` varchar(255) DEFAULT NULL,
  `occupation_designation` varchar(255) DEFAULT NULL,
  `annual_income` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_user_work_details_user` (`user_id`),
  CONSTRAINT `fk_user_work_details_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for user addresses
CREATE TABLE IF NOT EXISTS `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permanent_address` text DEFAULT NULL,
  `current_address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_user_addresses_user` (`user_id`),
  CONSTRAINT `fk_user_addresses_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for user physical attributes
CREATE TABLE IF NOT EXISTS `user_physical_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `height_cm` int(11) DEFAULT NULL,
  `weight_kg` int(11) DEFAULT NULL,
  `gotra` varchar(100) DEFAULT NULL,
  `horoscope` varchar(50) DEFAULT NULL,
  `handicapped` enum('yes','no') DEFAULT 'no',
  `handicapped_details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_user_physical_attributes_user` (`user_id`),
  CONSTRAINT `fk_user_physical_attributes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for user languages
CREATE TABLE IF NOT EXISTS `user_languages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `language_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_user_languages_user` (`user_id`),
  CONSTRAINT `fk_user_languages_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for user hobbies
CREATE TABLE IF NOT EXISTS `user_hobbies` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `hobby_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_user_hobbies_user` (`user_id`),
  CONSTRAINT `fk_user_hobbies_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for user payments info
CREATE TABLE IF NOT EXISTS `user_payments_info` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_qr_code` varchar(255) DEFAULT NULL,
  `payment_screenshot` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 1000.00,
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_user_payments_info_user` (`user_id`),
  CONSTRAINT `fk_user_payments_info_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
