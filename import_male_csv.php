<?php
require_once 'admin/includes/bootstrap.php';
$db = sathi_db();

echo "Starting CSV Import...\n";

// Helper for lookups
function getLookupMap($db, $table) {
    $map = [];
    $res = $db->query("SELECT id, name FROM $table");
    while ($row = $res->fetch_assoc()) {
        $map[strtolower(trim($row['name']))] = $row['id'];
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
$defaultMaritalStatusId = 1; // Unmarried

$filename = 'MALE.csv';
if (!file_exists($filename)) {
    die("Error: $filename not found.\n");
}

$file = fopen($filename, 'r');
fgetcsv($file); // Skip headers

$count = 0;
$skipped = 0;

while (($row = fgetcsv($file)) !== FALSE) {
    if (count($row) < 18) continue;

    $email = strtolower(trim($row[17]));
    if (empty($email)) $email = strtolower(trim($row[1]));
    if (empty($email)) {
        $skipped++;
        continue;
    }

    // Name parsing
    $fullName = trim($row[3]);
    $parts = explode(' ', $fullName);
    $firstName = $parts[0];
    $lastName = count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : '';

    // Date parsing
    $dobRaw = trim($row[6]);
    $dob = null;
    if (!empty($dobRaw)) {
        $ts = strtotime($dobRaw);
        if ($ts) $dob = date('Y-m-d', $ts);
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

    // Prepare data
    $data = [
        'profile_id' => 'PROF' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'mobile' => trim($row[5]),
        'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
        'gender' => 'male',
        'dob' => $dob,
        'religion_id' => $defaultReligionId,
        'mother_tongue_id' => $defaultMotherTongueId,
        'marital_status_id' => (strpos(strtolower($row[21]), 'divorce') !== false) ? 2 : $defaultMaritalStatusId,
        'education_id' => $eduId,
        'occupation_id' => $occId,
        'country_id' => 1,
        'weight' => (int)$row[13],
        'permanent_address' => trim($row[15]),
        'current_address' => trim($row[16]),
        'hobbies' => trim($row[19]),
        'annual_income' => (float)preg_replace('/[^0-9.]/', '', $row[20]),
        'widow_divorce' => trim($row[21]),
        'handicapped' => trim($row[22]),
        'languages_known' => trim($row[23]),
        'occupation_firm' => trim($row[25]),
        'occupation_designation' => trim($row[26]),
        'father_name' => trim($row[27]),
        'father_mobile_number' => trim($row[28]),
        'father_annual_income' => (float)preg_replace('/[^0-9.]/', '', $row[29]),
        'father_occupation' => trim($row[30]),
        'mother_name' => trim($row[31]),
        'mother_mobile_number' => trim($row[32]),
        'mother_annual_income' => (float)preg_replace('/[^0-9.]/', '', $row[33]),
        'mother_occupation' => trim($row[34]),
        'brothers' => (int)$row[35],
        'brothers_married_count' => (int)$row[36],
        'brothers_unmarried_count' => (int)$row[37],
        'sisters' => (int)$row[38],
        'sisters_married_count' => (int)$row[39],
        'sisters_unmarried_count' => (int)$row[40],
        'candidate_photo' => trim($row[41]),
        'payment_qr_code' => trim($row[42]),
        'payment_screenshot' => trim($row[43]),
        'status' => 'approved',
        'membership_status' => 'free',
        'email_verified' => 1,
        'mobile_verified' => 1,
        'digamber_jain' => (strpos(strtolower($row[2]), 'yes') !== false) ? 'yes' : 'no',
        'birth_time' => trim($row[7]),
        'birth_place' => trim($row[8]),
        'gotra' => trim($row[10]),
        'horoscope' => trim($row[11]),
        'height' => trim($row[12])
    ];

    // Build query
    $cols = array_keys($data);
    $placeholders = array_fill(0, count($data), '?');
    $sql = "INSERT INTO users (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $placeholders) . ") 
            ON DUPLICATE KEY UPDATE updated_at = NOW()";
    
    $stmt = $db->prepare($sql);
    $types = str_repeat('s', count($data)); // simplified for string/null
    $vals = array_values($data);
    
    $stmt->bind_param($types, ...$vals);
    if ($stmt->execute()) {
        $count++;
    } else {
        echo "Error importing $email: " . $stmt->error . "\n";
    }
}

fclose($file);
echo "Import Complete! Total imported/updated: $count, Skipped: $skipped\n";
?>
