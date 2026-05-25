-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2026 at 09:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shadikibaat`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_type` enum('admin','user') NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `details` longtext DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('super_admin','moderator','support') DEFAULT 'moderator',
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password_hash`, `role`, `status`, `created_at`) VALUES
(1, 'Super Admin', 'admin@shadikibaat.local', '$2y$10$DwbD3D5Iy.2zjdQk1jAqq.HD4qt4Ntx9OhN8GZ4cFfyqmHk0VNJuu', 'super_admin', 1, '2026-05-13 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `castes`
--

CREATE TABLE IF NOT EXISTS `castes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `religion_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `castes`
--

INSERT INTO `castes` (`id`, `religion_id`, `name`, `status`, `created_at`) VALUES
(1, 1, 'Kashyap', 1, '2026-05-13 12:04:01'),
(2, 1, 'Bharadwaj', 1, '2026-05-13 12:04:01'),
(3, 1, 'Vasishtha', 1, '2026-05-13 12:04:01'),
(4, 1, 'Other', 1, '2026-05-13 12:04:01'),
(5, 1, 'Prefer not to say', 1, '2026-05-13 12:04:01'),
(6, 1, 'cfgbnm', 1, '2026-05-13 12:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `name`, `status`, `created_at`) VALUES
(1, 1, 'Ahmedabad', 1, '2026-05-13 12:04:01'),
(2, 1, 'Surat', 1, '2026-05-13 12:04:01'),
(3, 1, 'amd', 1, '2026-05-13 12:40:34'),
(4, 1, 'wedrfg,.', 1, '2026-05-13 12:56:07');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `phone_code`, `status`, `created_at`) VALUES
(1, 'India', '+91', 1, '2026-05-13 12:04:01'),
(2, 'United States', '+1', 1, '2026-05-13 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE IF NOT EXISTS `educations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'B.Tech', 1, '2026-05-13 12:04:01'),
(2, 'M.Tech', 1, '2026-05-13 12:04:01'),
(3, 'MBA', 1, '2026-05-13 12:04:01'),
(4, 'MBBS', 1, '2026-05-13 12:04:01'),
(5, 'B.Com', 1, '2026-05-13 12:04:01'),
(6, 'M.Com', 1, '2026-05-13 12:04:01'),
(7, 'CA', 1, '2026-05-13 12:04:01'),
(8, 'MCA', 1, '2026-05-13 12:04:01'),
(9, 'BBA', 1, '2026-05-13 12:04:01'),
(10, 'LLB', 1, '2026-05-13 12:04:01'),
(11, 'Other', 1, '2026-05-13 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_banners`
--

CREATE TABLE IF NOT EXISTS `homepage_banners` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE IF NOT EXISTS `incomes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incomes`
--

INSERT INTO `incomes` (`id`, `name`, `status`, `created_at`) VALUES
(1, '0–2 Lakh', 1, '2026-05-13 12:04:01'),
(2, '2–5 Lakh', 1, '2026-05-13 12:04:01'),
(3, '5–10 Lakh', 1, '2026-05-13 12:04:01'),
(4, '10–20 Lakh', 1, '2026-05-13 12:04:01'),
(5, '20+ Lakh', 1, '2026-05-13 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `marital_statuses`
--

CREATE TABLE IF NOT EXISTS `marital_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marital_statuses`
--

INSERT INTO `marital_statuses` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'Never married', 1, '2026-05-13 12:04:01'),
(2, 'Divorced', 1, '2026-05-13 12:04:01'),
(3, 'Widowed', 1, '2026-05-13 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

CREATE TABLE IF NOT EXISTS `membership_plans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_days` int(11) NOT NULL,
  `profile_views` int(11) DEFAULT 0,
  `contact_views` int(11) DEFAULT 0,
  `featured_profile` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_plans`
--

INSERT INTO `membership_plans` (`id`, `name`, `price`, `duration_days`, `profile_views`, `contact_views`, `featured_profile`, `status`, `created_at`) VALUES
(1, 'Standard', 999.00, 180, 100, 20, 0, 1, '2026-05-13 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `mother_tongues`
--

CREATE TABLE IF NOT EXISTS `mother_tongues` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mother_tongues`
--

INSERT INTO `mother_tongues` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'Hindi', 1, '2026-05-13 12:04:01'),
(2, 'Gujarati', 1, '2026-05-13 12:04:01'),
(3, 'Marwari', 1, '2026-05-13 12:04:01'),
(4, 'Tamil', 1, '2026-05-13 12:04:01'),
(5, 'Kannada', 1, '2026-05-13 12:04:01'),
(6, 'Marathi', 1, '2026-05-13 12:04:01'),
(7, 'English', 1, '2026-05-13 12:04:01'),
(8, 'Other', 1, '2026-05-13 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `occupations`
--

CREATE TABLE IF NOT EXISTS `occupations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `occupations`
--

INSERT INTO `occupations` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'Doctor', 1, '2026-05-13 12:04:01'),
(2, 'Engineer', 1, '2026-05-13 12:04:01'),
(3, 'CA', 1, '2026-05-13 12:04:01'),
(4, 'Business', 1, '2026-05-13 12:04:01'),
(5, 'Government job', 1, '2026-05-13 12:04:01'),
(6, 'Private service', 1, '2026-05-13 12:04:01'),
(7, 'Advocate', 1, '2026-05-13 12:04:01'),
(8, 'Entrepreneur', 1, '2026-05-13 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `membership_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) DEFAULT 'INR',
  `status` enum('pending','success','failed','refunded') DEFAULT 'pending',
  `gateway_response` longtext DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile_interests`
--

CREATE TABLE IF NOT EXISTS `profile_interests` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `from_user_id` bigint(20) UNSIGNED NOT NULL,
  `to_user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','rejected','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_interest` (`from_user_id`,`to_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_field_settings`
--

CREATE TABLE IF NOT EXISTS `registration_field_settings` (
  `field_key` varchar(100) NOT NULL,
  `is_visible` tinyint(1) DEFAULT 1,
  `is_required` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`field_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration_field_settings`
--

INSERT INTO `registration_field_settings` (`field_key`, `is_visible`, `is_required`, `updated_at`) VALUES
('addr_curr', 1, 1, '2026-05-13 12:50:52'),
('addr_perm', 1, 1, '2026-05-13 12:50:52'),
('annual_income', 1, 1, '2026-05-13 12:50:52'),
('birth_city', 1, 1, '2026-05-13 12:50:52'),
('birth_country', 1, 1, '2026-05-13 12:50:52'),
('birth_date', 1, 1, '2026-05-13 12:50:52'),
('birth_place', 1, 1, '2026-05-13 12:50:52'),
('birth_state', 1, 1, '2026-05-13 12:50:52'),
('birth_time', 1, 1, '2026-05-13 12:50:52'),
('designation', 1, 1, '2026-05-13 12:50:52'),
('digamber_jain', 1, 1, '2026-05-13 12:50:52'),
('dosh', 1, 0, '2026-05-13 12:58:48'),
('education', 1, 1, '2026-05-13 12:50:52'),
('email', 1, 1, '2026-05-13 12:50:52'),
('father_income', 1, 0, '2026-05-13 12:50:52'),
('father_mobile', 1, 0, '2026-05-13 12:50:52'),
('father_name', 1, 1, '2026-05-13 12:50:52'),
('father_occ', 1, 0, '2026-05-13 12:50:52'),
('firm_name', 1, 1, '2026-05-13 12:50:52'),
('full_name', 1, 1, '2026-05-13 12:50:52'),
('gender', 1, 1, '2026-05-13 12:50:52'),
('gotra', 1, 0, '2026-05-13 12:50:52'),
('hobbies', 1, 0, '2026-05-13 12:50:52'),
('horoscope', 1, 1, '2026-05-13 12:50:52'),
('marital_status', 1, 1, '2026-05-13 12:50:52'),
('mobile', 1, 1, '2026-05-13 12:50:52'),
('mother_income', 1, 0, '2026-05-13 12:50:52'),
('mother_mobile', 1, 0, '2026-05-13 12:50:52'),
('mother_name', 1, 1, '2026-05-13 12:50:52'),
('mother_occ', 1, 0, '2026-05-13 12:50:52'),
('mother_tongue', 1, 1, '2026-05-13 12:50:52'),
('native_city', 1, 1, '2026-05-13 12:50:52'),
('native_country', 1, 1, '2026-05-13 12:50:52'),
('native_place', 1, 1, '2026-05-13 12:50:52'),
('native_state', 1, 1, '2026-05-13 12:50:52'),
('occupation', 1, 1, '2026-05-13 12:50:52'),
('payment_screenshot', 1, 1, '2026-05-13 12:50:52'),
('pay_agree', 1, 1, '2026-05-13 12:50:52'),
('pay_method', 1, 1, '2026-05-13 12:50:52'),
('photo', 1, 1, '2026-05-13 12:50:52'),
('rasi', 1, 0, '2026-05-13 12:58:48'),
('religion', 1, 1, '2026-05-13 12:50:52'),
('siblings', 1, 1, '2026-05-13 12:50:52'),
('star', 1, 0, '2026-05-13 12:58:48');

-- --------------------------------------------------------

--
-- Table structure for table `religions`
--

CREATE TABLE IF NOT EXISTS `religions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `religions`
--

INSERT INTO `religions` (`id`, `name`, `status`, `sort_order`, `created_at`) VALUES
(1, 'Hindu', 1, 1, '2026-05-13 12:04:01'),
(2, 'Jain', 1, 2, '2026-05-13 12:04:01'),
(3, 'Muslim', 1, 3, '2026-05-13 12:04:01'),
(4, 'Christian', 1, 4, '2026-05-13 12:04:01'),
(5, 'Sikh', 1, 5, '2026-05-13 12:04:01'),
(6, 'Other', 1, 99, '2026-05-13 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(150) NOT NULL,
  `setting_value` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE IF NOT EXISTS `site_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
('currency', 'INR', '2026-05-13 12:50:52', '2026-05-13 12:50:52'),
('meta_description', 'Trusted matrimonial bureau for verified profiles.', '2026-05-13 12:50:52', '2026-05-13 12:50:52'),
('meta_title', 'Shadikibaat — Matrimonial', '2026-05-13 12:50:52', '2026-05-13 12:50:52'),
('site_name', 'Shadikibaat', '2026-05-13 12:50:52', '2026-05-13 12:50:52'),
('support_email', 'support@shadikibaat.com', '2026-05-13 12:50:52', '2026-05-13 12:50:52'),
('tax_label', 'GST', '2026-05-13 12:50:52', '2026-05-13 12:50:52');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `status`, `created_at`) VALUES
(1, 1, 'Gujarat', 1, '2026-05-13 12:04:01'),
(2, 1, 'Maharashtra', 1, '2026-05-13 12:04:01'),
(3, 1, 'Karnataka', 1, '2026-05-13 12:04:01'),
(4, 1, 'Delhi', 1, '2026-05-13 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `success_stories`
--

CREATE TABLE IF NOT EXISTS `success_stories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `groom_name` varchar(100) NOT NULL,
  `bride_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `story` longtext NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_id` varchar(30) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `dob` date DEFAULT NULL,
  `religion_id` bigint(20) UNSIGNED DEFAULT NULL,
  `caste_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mother_tongue_id` bigint(20) UNSIGNED DEFAULT NULL,
  `marital_status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `education_id` bigint(20) UNSIGNED DEFAULT NULL,
  `occupation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `income_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `height_cm` smallint(5) UNSIGNED DEFAULT NULL,
  `weight_kg` smallint(5) UNSIGNED DEFAULT NULL,
  `complexion` varchar(50) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `profile_created_by` enum('self','parent','sibling','relative','friend') DEFAULT 'self',
  `about_me` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','blocked','deactivated') DEFAULT 'pending',
  `membership_status` enum('free','paid','expired') DEFAULT 'free',
  `featured_profile` tinyint(1) DEFAULT 0,
  `paid_member` tinyint(1) DEFAULT 0,
  `email_verified` tinyint(1) DEFAULT 0,
  `mobile_verified` tinyint(1) DEFAULT 0,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `profile_views` int(10) UNSIGNED DEFAULT 0,
  `last_login_at` datetime DEFAULT NULL,
  `last_active_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profile_id` (`profile_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_memberships`
--

CREATE TABLE IF NOT EXISTS `user_memberships` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `membership_plan_id` bigint(20) UNSIGNED NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_photos`
--

CREATE TABLE IF NOT EXISTS `user_photos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `approved` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_shortlists`
--

CREATE TABLE IF NOT EXISTS `user_shortlists` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shortlisted_user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_shortlist` (`user_id`,`shortlisted_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
