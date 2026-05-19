-- =====================================================
-- COMPLETE SEEDER DATA FOR ALL TABLES
-- Generated on: 2026-05-14 14:56:41
-- =====================================================

START TRANSACTION;

-- =====================================================
-- INSERT INTO users table
-- =====================================================
INSERT INTO `users` (`id`, `profile_id`, `first_name`, `last_name`, `email`, `mobile`, `password_hash`, `gender`, `dob`, `religion_id`, `mother_tongue_id`, `marital_status_id`, `education_id`, `occupation_id`, `country_id`, `status`, `membership_status`, `email_verified`, `mobile_verified`, `created_at`, `updated_at`) VALUES
(4, 'PROF000004', 'Sachin', 'Bhavarlal Jain', 'kalpanaviral222@gmail.com', '9376121836', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'male', '1993-07-08', 2, 2, 1, 11, 4, 1, 'approved', 'free', 1, 1, NOW(), NOW()),
(5, 'PROF000005', 'AAKASH', 'JAIN', 'grivafin@gmail.com', '9737067941', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'male', '1996-01-01', 2, 2, 1, 11, 4, 1, 'approved', 'free', 1, 1, NOW(), NOW());

-- =====================================================
-- INSERT INTO user_family_details
-- =====================================================
INSERT INTO `user_family_details` (`user_id`, `father_name`, `father_mobile`, `father_income`, `father_occupation`, `mother_name`, `mother_mobile`, `mother_income`, `mother_occupation`, `brothers`, `brothers_married`, `brothers_unmarried`, `sisters`, `sisters_married`, `sisters_unmarried`) VALUES
(4, 'Bhavarlal Jain', '9876543210', 300000, 'Business', 'Kalpana Jain', '9876543211', NULL, 'House Wife', 1, 1, 0, 1, 1, 0),
(5, 'Sunil Jain', '9876543220', 400000, 'Business', 'Sarita Jain', '9876543221', NULL, 'House Wife', 2, 1, 1, 0, 0, 0);

-- =====================================================
-- INSERT INTO user_work_details
-- =====================================================
INSERT INTO `user_work_details` (`user_id`, `occupation_firm`, `occupation_designation`, `annual_income`) VALUES
(4, 'Jain Enterprise', 'Manager', 500000),
(5, 'Griva Fin', 'Owner', 600000);

-- =====================================================
-- INSERT INTO user_addresses
-- =====================================================
INSERT INTO `user_addresses` (`user_id`, `permanent_address`, `current_address`) VALUES
(4, 'Ahmedabad, Gujarat', 'Ahmedabad, Gujarat'),
(5, 'Surat, Gujarat', 'Surat, Gujarat');

-- =====================================================
-- INSERT INTO user_physical_attributes
-- =====================================================
INSERT INTO `user_physical_attributes` (`user_id`, `height_cm`, `weight_kg`, `gotra`, `horoscope`, `handicapped`) VALUES
(4, 173, 70, 'Kashyap', 'Not Manglik', 'no'),
(5, 178, 75, 'Bharadwaj', 'Not Manglik', 'no');

-- =====================================================
-- INSERT INTO user_languages
-- =====================================================
INSERT INTO `user_languages` (`user_id`, `language_name`) VALUES
(4, 'Gujarati'),
(4, 'Hindi'),
(5, 'Gujarati'),
(5, 'Hindi');

-- =====================================================
-- INSERT INTO user_hobbies
-- =====================================================
INSERT INTO `user_hobbies` (`user_id`, `hobby_name`) VALUES
(4, 'Reading'),
(4, 'Traveling'),
(5, 'Cricket'),
(5, 'Music');

-- =====================================================
-- INSERT INTO user_payments_info
-- =====================================================
INSERT INTO `user_payments_info` (`user_id`, `payment_method`, `payment_screenshot`, `transaction_id`, `amount`, `payment_status`, `paid_at`) VALUES
(4, 'UPI', 'screenshot1.jpg', 'UPI', 1000.00, 'completed', NOW()),
(5, 'UPI', 'screenshot2.jpg', 'UPI', 1000.00, 'completed', NOW());

-- =====================================================
-- INSERT INTO user_photos
-- =====================================================
INSERT INTO `user_photos` (`user_id`, `photo`, `is_primary`, `approved`) VALUES
(4, 'photo1.jpg', 1, 1),
(5, 'photo2.jpg', 1, 1);

COMMIT;
