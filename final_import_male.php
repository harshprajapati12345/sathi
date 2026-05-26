<?php
/**
 * Final Import Script for MALE.csv
 * Correctly distributes data across all normalized tables.
 */
require_once 'admin/includes/bootstrap.php';
$db = sathi_db();

echo "<h2>Starting Deep CSV Import...</h2>";

// 1. Truncate tables for a clean start (only if confirmed or if it's a seeder phase)
// The user said "not prper excel data", so we clear it.
$tablesToClear = [
    'user_shortlists',
    'user_photos',
    'user_payments_info',
    'user_languages',
    'user_hobbies',
    'user_physical_attributes',
    'user_addresses',
    'user_work_details',
    'user_family_details',
    'user_memberships',
    'users'
];

$db->query("SET FOREIGN_KEY_CHECKS = 0");
foreach ($tablesToClear as $tbl) {
    echo "Clearing $tbl... ";
    if ($db->query("TRUNCATE TABLE $tbl")) {
        echo "✅<br>";
    } else {
        echo "❌ (" . $db->error . ")<br>";
    }
}
$db->query("SET FOREIGN_KEY_CHECKS = 1");

// 2. Helper for lookups
function getLookupMap($db, $table)
{
    $map = [];
    $res = $db->query("SELECT id, name FROM $table");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $map[strtolower(trim($row['name']))] = $row['id'];
        }
    }
    return $map;
}

$educationMap = getLookupMap($db, 'educations');
$occupationMap = getLookupMap($db, 'occupations');
$religionMap = getLookupMap($db, 'religions');
$motherTongueMap = getLookupMap($db, 'mother_tongues');
$maritalStatusMap = getLookupMap($db, 'marital_statuses');

// Default IDs
$defaultEducationId = 11; // Other
$defaultOccupationId = 6;  // Private service
$defaultReligionId = 2;    // Jain
$defaultMotherTongueId = 2; // Gujarati
$defaultMaritalStatusId = 1; // Never married

// 3. Height Parser
function parseHeightToCm($str)
{
    if (empty($str))
        return null;
    // Matches "5 ft 8 inch" or "5ft 8inch" or "5' 8\""
    if (preg_match('/(\d+)\s*(?:ft|\'|feet)\s*(\d+)?\s*(?:inch|\"|in)?/i', $str, $matches)) {
        $ft = (int) $matches[1];
        $in = isset($matches[2]) ? (int) $matches[2] : 0;
        return (int) round(($ft * 30.48) + ($in * 2.54));
    }
    return (int) preg_replace('/[^0-9]/', '', $str); // fallback to just digits
}

// 4. Money Parser
function parseAmount($str)
{
    if (empty($str))
        return 0;
    return (float) preg_replace('/[^0-9.]/', '', $str);
}

// 5. Open CSV
$filename = 'MALE.csv';
if (!file_exists($filename)) {
    die("Error: $filename not found.");
}

$file = fopen($filename, 'r');
$headers = fgetcsv($file); // Skip headers

$count = 0;
$skipped = 0;

while (($row = fgetcsv($file)) !== FALSE) {
    if (count($row) < 18) {
        $skipped++;
        continue;
    }

    // Basic Info
    $email = strtolower(trim($row[1]));
    if (empty($email))
        $email = strtolower(trim($row[17]));
    if (empty($email)) {
        $skipped++;
        continue;
    }

    $fullName = trim($row[3]);
    $parts = explode(' ', $fullName);
    $firstName = $parts[0];
    $lastName = count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : '';

    $dobRaw = trim($row[6]);
    $dob = null;
    if (!empty($dobRaw)) {
        $ts = strtotime($dobRaw);
        if ($ts)
            $dob = date('Y-m-d', $ts);
    }

    // Lookups
    $eduStr = strtolower(trim($row[18]));
    $eduId = $defaultEducationId;
    foreach ($educationMap as $name => $id) {
        if (strpos($eduStr, $name) !== false) {
            $eduId = $id;
            break;
        }
    }

    $occStr = strtolower(trim($row[24]));
    $occId = $defaultOccupationId;
    foreach ($occupationMap as $name => $id) {
        if (strpos($occStr, $name) !== false) {
            $occId = $id;
            break;
        }
    }

    $maritalStr = strtolower(trim($row[21]));
    $maritalId = $defaultMaritalStatusId;
    if (strpos($maritalStr, 'divorce') !== false)
        $maritalId = 2;
    elseif (strpos($maritalStr, 'widow') !== false)
        $maritalId = 3;

    // A. Insert into users
    $profileId = 'M' . str_pad((string) (200000 + $count), 6, '0', STR_PAD_LEFT);
    $stmt = $db->prepare("INSERT INTO users (profile_id, first_name, last_name, email, mobile, password_hash, gender, digamber_jain, dob, birth_time, birth_place, native_place, religion_id, mother_tongue_id, marital_status_id, education_id, occupation_id, status, membership_status, email_verified, mobile_verified, profile_photo) VALUES (?, ?, ?, ?, ?, ?, 'male', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'approved', 'free', 1, 1, ?)");

    $passHash = password_hash('password123', PASSWORD_DEFAULT);
    $mobile = trim($row[5]);
    $photoUrl = trim($row[41]);
    $digamber = (strpos(strtolower($row[2]), 'yes') !== false) ? 'yes' : 'no';
    $bTime = trim($row[7]);
    $bPlace = trim($row[8]);
    $native = trim($row[9]);

    $stmt->bind_param(
        "sssssssssssiiiiis",
        $profileId,
        $firstName,
        $lastName,
        $email,
        $mobile,
        $passHash,
        $digamber,
        $dob,
        $bTime,
        $bPlace,
        $native,
        $defaultReligionId,
        $defaultMotherTongueId,
        $maritalId,
        $eduId,
        $occId,
        $photoUrl
    );

    if (!$stmt->execute()) {
        echo "Error inserting user $email: " . $stmt->error . "<br>";
        $skipped++;
        continue;
    }

    $userId = $db->insert_id;

    // B. user_family_details
    $fName = trim($row[27]);
    $fMob = trim($row[28]);
    $fInc = parseAmount($row[29]);
    $fOcc = trim($row[30]);
    $mName = trim($row[31]);
    $mMob = trim($row[32]);
    $mInc = parseAmount($row[33]);
    $mOcc = trim($row[34]);
    $bros = (int) $row[35];
    $brosM = (int) $row[36];
    $brosU = (int) $row[37];
    $sis = (int) $row[38];
    $sisM = (int) $row[39];
    $sisU = (int) $row[40];

    $stmtFam = $db->prepare("INSERT INTO user_family_details (user_id, father_name, father_mobile, father_income, father_occupation, mother_name, mother_mobile, mother_income, mother_occupation, brothers, brothers_married, brothers_unmarried, sisters, sisters_married, sisters_unmarried) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtFam->bind_param("issdsssdsiiiiii", $userId, $fName, $fMob, $fInc, $fOcc, $mName, $mMob, $mInc, $mOcc, $bros, $brosM, $brosU, $sis, $sisM, $sisU);
    $stmtFam->execute();

    // C. user_work_details
    $firm = trim($row[25]);
    $desig = trim($row[26]);
    $annInc = parseAmount($row[20]);
    $stmtWork = $db->prepare("INSERT INTO user_work_details (user_id, occupation_firm, occupation_designation, annual_income) VALUES (?, ?, ?, ?)");
    $stmtWork->bind_param("issd", $userId, $firm, $desig, $annInc);
    $stmtWork->execute();

    // D. user_addresses
    $permAddr = trim($row[15]);
    $currAddr = trim($row[16]);
    if (empty($currAddr))
        $currAddr = $permAddr;
    $stmtAddr = $db->prepare("INSERT INTO user_addresses (user_id, permanent_address, current_address) VALUES (?, ?, ?)");
    $stmtAddr->bind_param("iss", $userId, $permAddr, $currAddr);
    $stmtAddr->execute();

    // E. user_physical_attributes
    $height = parseHeightToCm($row[12]);
    $weight = (int) preg_replace('/[^0-9]/', '', $row[13]);
    $gotra = trim($row[10]);
    $horoscope = trim($row[11]);
    $handicapped = (strpos(strtolower($row[22]), 'yes') !== false) ? 'yes' : 'no';

    $stmtPhys = $db->prepare("INSERT INTO user_physical_attributes (user_id, height_cm, weight_kg, gotra, horoscope, handicapped) VALUES (?, ?, ?, ?, ?, ?)");
    $stmtPhys->bind_param("iiisss", $userId, $height, $weight, $gotra, $horoscope, $handicapped);
    $stmtPhys->execute();

    // F. user_hobbies
    $hobbies = explode(',', $row[19]);
    $stmtHobby = $db->prepare("INSERT INTO user_hobbies (user_id, hobby_name) VALUES (?, ?)");
    foreach ($hobbies as $h) {
        $h = trim($h);
        if (!empty($h)) {
            $stmtHobby->bind_param("is", $userId, $h);
            $stmtHobby->execute();
        }
    }

    // G. user_languages
    $langs = explode(',', $row[23]);
    $stmtLang = $db->prepare("INSERT INTO user_languages (user_id, language_name) VALUES (?, ?)");
    foreach ($langs as $l) {
        $l = trim($l);
        if (!empty($l)) {
            $stmtLang->bind_param("is", $userId, $l);
            $stmtLang->execute();
        }
    }

    // H. user_payments_info
    $qr = trim($row[42]);
    $screenshot = trim($row[43]);
    $upiId = "";
    if (preg_match('/(?:ID|Transaction ID|Ref)[:\s]+(\d+)/i', $qr, $m)) {
        $upiId = $m[1];
    } elseif (preg_match('/(\d{10,})/i', $qr, $m)) {
        $upiId = $m[1]; // fallback to any long sequence of digits
    }
    $stmtPay = $db->prepare("INSERT INTO user_payments_info (user_id, payment_qr_code, payment_screenshot, payment_upi_id, payment_status, amount) VALUES (?, ?, ?, ?, 'completed', 1000.00)");

    $stmtPay->bind_param("isss", $userId, $qr, $screenshot, $upiId);
    $stmtPay->execute();


    // I. user_photos (also add to this table)
    if (!empty($photoUrl)) {
        $stmtPhoto = $db->prepare("INSERT INTO user_photos (user_id, photo, is_primary) VALUES (?, ?, 1)");
        $stmtPhoto->bind_param("is", $userId, $photoUrl);
        $stmtPhoto->execute();
    }

    // J. user_memberships (Add a free membership record)
    $stmtMem = $db->prepare("INSERT INTO user_memberships (user_id, membership_plan_id, amount_paid, payment_status, start_date, end_date) VALUES (?, 1, 0, 'paid', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR))");
    $stmtMem->bind_param("i", $userId);
    $stmtMem->execute();

    $count++;
}

fclose($file);
echo "<h3>Import Complete!</h3>";
echo "Total Records Imported: $count<br>";
echo "Total Records Skipped: $skipped<br>";
?>