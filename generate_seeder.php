<?php
/**
 * CSV to SQL Seeder Generator
 * Run this script to generate complete SQL insert statements for all tables
 */

$csvFile = 'your_data.csv'; // Path to your CSV file

if (!file_exists($csvFile)) {
    die("CSV file not found: $csvFile\n");
}

$rows = array_map('str_getcsv', file($csvFile));
$header = array_shift($rows);

// Output SQL file
$outputFile = 'complete_seeder.sql';
$sql = "-- =====================================================\n";
$sql .= "-- COMPLETE SEEDER DATA FOR ALL TABLES\n";
$sql .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n";
$sql .= "-- =====================================================\n\n";

// Start transaction
$sql .= "START TRANSACTION;\n\n";

// Prepare arrays for batch inserts
$usersData = [];
$familyData = [];
$workData = [];
$addressData = [];
$physicalData = [];
$languagesData = [];
$hobbiesData = [];
$paymentsData = [];
$photosData = [];

require_once __DIR__ . '/config/database.php';
$db = sathi_db();
$res = $db->query("SELECT MAX(id) as max_id FROM users");
$row = $res->fetch_assoc();
$userId = ($row['max_id'] ?? 0) + 1;

foreach ($rows as $rowIndex => $row) {
    $data = array_combine($header, $row);
    
    // Skip empty rows
    if (empty($data['Candidate Full Name']) && empty($data['Email Address'])) {
        continue;
    }
    
    // Parse name
    $fullName = trim($data['Candidate Full Name'] ?? '');
    $nameParts = explode(' ', $fullName, 2);
    $firstName = $nameParts[0] ?? '';
    $lastName = $nameParts[1] ?? '';
    
    // Parse mobile
    $mobile = preg_replace('/[^0-9]/', '', $data['Mobile Number (WhatsApp)'] ?? '');
    if (strlen($mobile) > 10) {
        $mobile = substr($mobile, -10);
    }
    
    // Parse date of birth
    $dob = null;
    $birthDate = $data['Birth Date'] ?? '';
    if ($birthDate) {
        $dob = date('Y-m-d', strtotime(str_replace('-', '/', $birthDate)));
        if ($dob == '1970-01-01') $dob = null;
    }
    
    // Parse height (convert from feet/inches to cm)
    $heightCm = null;
    $height = $data['Height'] ?? '';
    if (preg_match('/(\d+)\s*ft\s*(\d+)\s*inch/', $height, $matches)) {
        $heightCm = ($matches[1] * 30.48) + ($matches[2] * 2.54);
        $heightCm = round($heightCm);
    }
    
    // Parse weight
    $weightKg = !empty($data['Weight']) ? (int)$data['Weight'] : null;
    
    // Parse marital status
    $maritalStatusId = 1; // Default: Never married
    $widowDivorce = strtolower($data['Widow / Divorce'] ?? '');
    if ($widowDivorce == 'divorce') {
        $maritalStatusId = 2;
    } elseif ($widowDivorce == 'widow') {
        $maritalStatusId = 3;
    }
    
    // Parse education
    $educationId = 11; // Default: Other
    $education = strtolower($data['Higher Education'] ?? '');
    if (strpos($education, 'b.tech') !== false || strpos($education, 'b.e') !== false) $educationId = 1;
    elseif (strpos($education, 'm.tech') !== false) $educationId = 2;
    elseif (strpos($education, 'mba') !== false) $educationId = 3;
    elseif (strpos($education, 'mbbs') !== false) $educationId = 4;
    elseif (strpos($education, 'b.com') !== false) $educationId = 5;
    elseif (strpos($education, 'm.com') !== false) $educationId = 6;
    elseif (strpos($education, 'ca') !== false) $educationId = 7;
    elseif (strpos($education, 'mca') !== false) $educationId = 8;
    elseif (strpos($education, 'bba') !== false) $educationId = 9;
    elseif (strpos($education, 'llb') !== false) $educationId = 10;
    
    // Parse occupation
    $occupationId = 6; // Default: Private service
    $occupation = strtolower($data['Candidate Occupation'] ?? '');
    if (strpos($occupation, 'doctor') !== false) $occupationId = 1;
    elseif (strpos($occupation, 'engineer') !== false) $occupationId = 2;
    elseif (strpos($occupation, 'ca') !== false) $occupationId = 3;
    elseif (strpos($occupation, 'business') !== false) $occupationId = 4;
    elseif (strpos($occupation, 'government') !== false || strpos($occupation, 'govt') !== false) $occupationId = 5;
    elseif (strpos($occupation, 'advocate') !== false) $occupationId = 7;
    elseif (strpos($occupation, 'entrepreneur') !== false) $occupationId = 8;
    
    // Parse mother tongue
    $motherTongueId = 8; // Default: Other
    $languages = strtolower($data['Language Known'] ?? '');
    if (strpos($languages, 'gujarati') !== false) $motherTongueId = 2;
    elseif (strpos($languages, 'hindi') !== false) $motherTongueId = 1;
    elseif (strpos($languages, 'marwari') !== false) $motherTongueId = 3;
    elseif (strpos($languages, 'marathi') !== false) $motherTongueId = 6;
    elseif (strpos($languages, 'english') !== false) $motherTongueId = 7;
    
    // Parse annual income (remove non-numeric)
    $annualIncome = null;
    $incomeStr = preg_replace('/[^0-9]/', '', $data['Candidate Annual Income (Only Amount In Number) Ex. 100000'] ?? '');
    if ($incomeStr && is_numeric($incomeStr)) {
        $annualIncome = (float)$incomeStr;
    }
    
    // Country ID (default India = 1)
    $countryId = 1;
    
    // User data
    $usersData[] = sprintf(
        "(%d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', %s, %d, %d, %d, %d, %d, %d, 'approved', 'free', 1, 1, NOW(), NOW())",
        $userId,
        'PROF' . str_pad($userId, 6, '0', STR_PAD_LEFT),
        addslashes($firstName),
        addslashes($lastName),
        addslashes($data['Email Address'] ?? ''),
        $mobile,
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password: password123
        strtolower($data['Gender'] ?? 'male'),
        $dob ? "'$dob'" : 'NULL',
        2, // religion_id = Jain
        $motherTongueId,
        $maritalStatusId,
        $educationId,
        $occupationId,
        $countryId
    );
    
    // Family details
    $brothers = !empty($data['Brothers']) ? (int)$data['Brothers'] : 0;
    $brothersMarried = !empty($data['Brothers Married Count (Only Number)']) ? (int)$data['Brothers Married Count (Only Number)'] : 0;
    $brothersUnmarried = !empty($data['Brothers Unmarried Count (Only Number)']) ? (int)$data['Brothers Unmarried Count (Only Number)'] : 0;
    $sisters = !empty($data['Sisters']) ? (int)$data['Sisters'] : 0;
    $sistersMarried = !empty($data['Sisters Married Count (Only Number)']) ? (int)$data['Sisters Married Count (Only Number)'] : 0;
    $sistersUnmarried = !empty($data['Sisters Unmarried Count (Only Number)']) ? (int)$data['Sisters Unmarried Count (Only Number)'] : 0;
    
    $fatherIncome = preg_replace('/[^0-9]/', '', $data['Father Annual Income (Only Amount In Number) Ex. 100000'] ?? '');
    $motherIncome = preg_replace('/[^0-9]/', '', $data['Mother Annual Income (Only Amount In Number) Ex. 100000'] ?? '');
    
    $familyData[] = sprintf(
        "(%d, '%s', '%s', %s, '%s', '%s', '%s', %s, '%s', %d, %d, %d, %d, %d, %d)",
        $userId,
        addslashes($data['Father Name'] ?? ''),
        addslashes($data['Father Mobile Number'] ?? ''),
        $fatherIncome ? $fatherIncome : 'NULL',
        addslashes($data['Father Occupation'] ?? ''),
        addslashes($data['Mother Name'] ?? ''),
        addslashes($data['Mother Mobile Number'] ?? ''),
        $motherIncome ? $motherIncome : 'NULL',
        addslashes($data['Mother Occupation'] ?? 'House Wife'),
        $brothers,
        $brothersMarried,
        $brothersUnmarried,
        $sisters,
        $sistersMarried,
        $sistersUnmarried
    );
    
    // Work details
    $workData[] = sprintf(
        "(%d, '%s', '%s', %s)",
        $userId,
        addslashes($data['Occupation Firm'] ?? ''),
        addslashes($data['Occupation Designation'] ?? ''),
        $annualIncome ? $annualIncome : 'NULL'
    );
    
    // Address details
    $permanentAddress = addslashes($data['Permanent Address'] ?? '');
    $currentAddress = addslashes($data['Candidate Current Address'] ?? '');
    if (empty($currentAddress)) {
        $currentAddress = 'NULL';
    } else {
        $currentAddress = "'$currentAddress'";
    }
    
    $addressData[] = sprintf(
        "(%d, '%s', %s)",
        $userId,
        $permanentAddress,
        $currentAddress
    );
    
    // Physical attributes
    $handicapped = strtolower($data['Handicapped / Physical Deficiency'] ?? '') == 'yes' ? "'yes'" : "'no'";
    $physicalData[] = sprintf(
        "(%d, %s, %s, '%s', '%s', %s)",
        $userId,
        $heightCm ? $heightCm : 'NULL',
        $weightKg ? $weightKg : 'NULL',
        addslashes($data['Gotra'] ?? ''),
        addslashes($data['Horoscope'] ?? 'Not Manglik'),
        $handicapped
    );
    
    // Languages (split by comma)
    $languagesList = explode(',', $data['Language Known'] ?? '');
    foreach ($languagesList as $lang) {
        $lang = trim($lang);
        if (!empty($lang)) {
            $languagesData[] = sprintf("(%d, '%s')", $userId, addslashes($lang));
        }
    }
    
    // Hobbies (split by comma)
    $hobbiesList = explode(',', $data['Hobbies'] ?? '');
    foreach ($hobbiesList as $hobby) {
        $hobby = trim($hobby);
        if (!empty($hobby)) {
            $hobbiesData[] = sprintf("(%d, '%s')", $userId, addslashes($hobby));
        }
    }
    
    // Payment info
    $paymentMethod = addslashes($data['Payment QR Code (Pay 1000 Rs)'] ?? '');
    $paymentScreenshot = addslashes($data['Payment Screen Shot'] ?? '');
    $paymentsData[] = sprintf(
        "(%d, %s, '%s', '%s', 1000.00, 'completed', NOW())",
        $userId,
        !empty($paymentMethod) && $paymentMethod != 'NULL' ? "'$paymentMethod'" : 'NULL',
        $paymentScreenshot,
        $paymentMethod
    );
    
    // Photo
    $photoUrl = addslashes($data['Candidate Photo'] ?? '');
    if (!empty($photoUrl)) {
        $photosData[] = sprintf("(%d, '%s', 1, 1)", $userId, $photoUrl);
    }
    
    $userId++;
}

// Generate INSERT statements
$sql .= "-- =====================================================\n";
$sql .= "-- INSERT INTO users table\n";
$sql .= "-- =====================================================\n";
$sql .= "INSERT INTO `users` (`id`, `profile_id`, `first_name`, `last_name`, `email`, `mobile`, `password_hash`, `gender`, `dob`, `religion_id`, `mother_tongue_id`, `marital_status_id`, `education_id`, `occupation_id`, `country_id`, `status`, `membership_status`, `email_verified`, `mobile_verified`, `created_at`, `updated_at`) VALUES\n";
$sql .= implode(",\n", $usersData);
$sql .= ";\n\n";

// Family details
if (!empty($familyData)) {
    $sql .= "-- =====================================================\n";
    $sql .= "-- INSERT INTO user_family_details\n";
    $sql .= "-- =====================================================\n";
    $sql .= "INSERT INTO `user_family_details` (`user_id`, `father_name`, `father_mobile`, `father_income`, `father_occupation`, `mother_name`, `mother_mobile`, `mother_income`, `mother_occupation`, `brothers`, `brothers_married`, `brothers_unmarried`, `sisters`, `sisters_married`, `sisters_unmarried`) VALUES\n";
    $sql .= implode(",\n", $familyData);
    $sql .= ";\n\n";
}

// Work details
if (!empty($workData)) {
    $sql .= "-- =====================================================\n";
    $sql .= "-- INSERT INTO user_work_details\n";
    $sql .= "-- =====================================================\n";
    $sql .= "INSERT INTO `user_work_details` (`user_id`, `occupation_firm`, `occupation_designation`, `annual_income`) VALUES\n";
    $sql .= implode(",\n", $workData);
    $sql .= ";\n\n";
}

// Address details
if (!empty($addressData)) {
    $sql .= "-- =====================================================\n";
    $sql .= "-- INSERT INTO user_addresses\n";
    $sql .= "-- =====================================================\n";
    $sql .= "INSERT INTO `user_addresses` (`user_id`, `permanent_address`, `current_address`) VALUES\n";
    $sql .= implode(",\n", $addressData);
    $sql .= ";\n\n";
}

// Physical attributes
if (!empty($physicalData)) {
    $sql .= "-- =====================================================\n";
    $sql .= "-- INSERT INTO user_physical_attributes\n";
    $sql .= "-- =====================================================\n";
    $sql .= "INSERT INTO `user_physical_attributes` (`user_id`, `height_cm`, `weight_kg`, `gotra`, `horoscope`, `handicapped`) VALUES\n";
    $sql .= implode(",\n", $physicalData);
    $sql .= ";\n\n";
}

// Languages
if (!empty($languagesData)) {
    $sql .= "-- =====================================================\n";
    $sql .= "-- INSERT INTO user_languages\n";
    $sql .= "-- =====================================================\n";
    $sql .= "INSERT INTO `user_languages` (`user_id`, `language_name`) VALUES\n";
    $sql .= implode(",\n", $languagesData);
    $sql .= ";\n\n";
}

// Hobbies
if (!empty($hobbiesData)) {
    $sql .= "-- =====================================================\n";
    $sql .= "-- INSERT INTO user_hobbies\n";
    $sql .= "-- =====================================================\n";
    $sql .= "INSERT INTO `user_hobbies` (`user_id`, `hobby_name`) VALUES\n";
    $sql .= implode(",\n", $hobbiesData);
    $sql .= ";\n\n";
}

// Payments info
if (!empty($paymentsData)) {
    $sql .= "-- =====================================================\n";
    $sql .= "-- INSERT INTO user_payments_info\n";
    $sql .= "-- =====================================================\n";
    $sql .= "INSERT INTO `user_payments_info` (`user_id`, `payment_method`, `payment_screenshot`, `transaction_id`, `amount`, `payment_status`, `paid_at`) VALUES\n";
    $sql .= implode(",\n", $paymentsData);
    $sql .= ";\n\n";
}

// Photos
if (!empty($photosData)) {
    $sql .= "-- =====================================================\n";
    $sql .= "-- INSERT INTO user_photos\n";
    $sql .= "-- =====================================================\n";
    $sql .= "INSERT INTO `user_photos` (`user_id`, `photo`, `is_primary`, `approved`) VALUES\n";
    $sql .= implode(",\n", $photosData);
    $sql .= ";\n\n";
}

// Commit transaction
$sql .= "COMMIT;\n";

// Write to file
file_put_contents($outputFile, $sql);

echo "SQL seeder generated successfully!\n";
echo "Output file: $outputFile\n";
echo "Total users processed: " . ($userId - 1) . "\n";
