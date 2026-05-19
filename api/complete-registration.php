<?php
/**
 * Registration Finalization API (Aligned with Actual Schema)
 */
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/helpers/response.php';
require_once dirname(__DIR__) . '/helpers/validator.php';
require_once dirname(__DIR__) . '/helpers/uploads.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method Not Allowed');
}

// 1. Basic Validation
$fullName = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$password = $_POST['password'] ?? '';

if (!validate_required($fullName))
    json_response(false, 'Full name is required');
if (!validate_email($email))
    json_response(false, 'Valid email is required');
if (!validate_mobile($mobile))
    json_response(false, '10-digit mobile is required');
if (strlen($password) < 8)
    json_response(false, 'Password must be at least 8 characters');

// Split name into first and last
$nameParts = explode(' ', trim($fullName), 2);
$firstName = $nameParts[0];
$lastName = $nameParts[1] ?? '';

$db = sathi_db();

// 2. Check if email or mobile exists
$check = $db->prepare("SELECT id FROM users WHERE email = ? OR mobile = ? LIMIT 1");
$check->bind_param("ss", $email, $mobile);
$check->execute();
$res = $check->get_result();
if ($res->num_rows > 0) {
    json_response(false, 'Email or Mobile number already registered');
}

// 3. Handle File Uploads
$photo = upload_file($_FILES['photo'] ?? null, 'profiles');
$screenshot = upload_file($_FILES['payment_screenshot'] ?? null, 'payments');

// 4. Prepare Data
$passHash = password_hash($password, PASSWORD_BCRYPT);
$profileId = 'SKB' . strtoupper(bin2hex(random_bytes(3)));
$gender = $_POST['gender'] ?? 'other';
$dob = $_POST['birth_date'] ?? null;
$status = 'pending';

// Helper to get value or custom value
$getVal = function ($name) {
    $val = $_POST[$name] ?? '';
    if ($val === 'other') {
        return $_POST[$name . '_custom'] ?? 'Other';
    }
    return $val;
};

require_once dirname(__DIR__) . '/includes/registration-config.php';

// 5. Insert User with all new fields
$stmt = $db->prepare(
    "INSERT INTO users (
        profile_id, first_name, last_name, email, mobile, password_hash, gender, dob, profile_photo, status,
        digamber_jain, religion, which_temple, birth_time, birth_place, birth_country, birth_state, birth_city,
        native_country, native_state, native_city, native_locality, gotra, star, rasi, dosh, which_kundli,
        whatsapp, father_name, father_mobile, father_income, father_occ, mother_name, mother_mobile, mother_income,
        relative_details, bro_total, bro_married, bro_unmarried, sis_total, sis_married, sis_unmarried,
        mother_tongue_val, marital_status_val, razorpay_payment_id,
        permanent_address, current_address, education_id, occupation_id, occupation_firm, occupation_designation,
        hobbies, annual_income, kundli_image, horoscope,
        height, weight, height_cm, weight_kg, complexion, blood_group, profile_created_by, languages_known, handicapped, widow_divorce
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

$kundliImg = upload_file($_FILES['kundli_image'] ?? null, 'kundli');
$horoscope = upload_file($_FILES['horoscope'] ?? null, 'horoscope');
$razorpayId = $_POST['razorpay_payment_id'] ?? '';

$digamber = $_POST['digamber_jain'] ?? 'no';
$religion = $getVal('religion');
$whichTemple = $_POST['which_temple'] ?? '';
$birthTime = $_POST['birth_time'] ?? '';
$birthPlace = $_POST['birth_place'] ?? '';
$birthCountry = $getVal('birth_country');
$birthState = $getVal('birth_state');
$birthCity = $getVal('birth_city');
$nativeCountry = $getVal('native_country');
$nativeState = $getVal('native_state');
$nativeCity = $getVal('native_city');
$nativeLocality = $_POST['native_locality'] ?? '';
$gotra = $getVal('gotra');
$star = $getVal('star');
$rasi = $getVal('rasi');
$dosh = $getVal('dosh');
$whichKundli = $getVal('which_kundli');
$whatsapp = $_POST['whatsapp'] ?? '';
$fName = $_POST['father_name'] ?? '';
$fMob = $_POST['father_mobile'] ?? '';
$fInc = $getVal('father_income');
$fOcc = $getVal('father_occ');
$mName = $_POST['mother_name'] ?? '';
$mMob = $_POST['mother_mobile'] ?? '';
$mInc = $getVal('mother_income');
$relDet = $_POST['relative_details'] ?? '';
$bt = (int) ($_POST['bro_total'] ?? 0);
$bm = (int) ($_POST['bro_married'] ?? 0);
$bu = (int) ($_POST['bro_unmarried'] ?? 0);
$st = (int) ($_POST['sis_total'] ?? 0);
$sm = (int) ($_POST['sis_married'] ?? 0);
$su = (int) ($_POST['sis_unmarried'] ?? 0);
$mTongue = $getVal('mother_tongue');
$mStatus = $getVal('marital_status');

// New mapped fields
$masters = sathi_registration_masters();

$eduValue = $getVal('education');
$eduLabel = '';
foreach ($masters['education'] as $opt) {
    if ($opt['value'] === $eduValue) {
        $eduLabel = $opt['label'];
        break;
    }
}
$eduId = 0;
if ($eduLabel) {
    $res = $db->query("SELECT id FROM educations WHERE name = '" . $db->real_escape_string($eduLabel) . "' LIMIT 1");
    if ($row = $res->fetch_assoc())
        $eduId = (int) $row['id'];
}

$occValue = $getVal('occupation');
$occLabel = '';
foreach ($masters['occupation'] as $opt) {
    if ($opt['value'] === $occValue) {
        $occLabel = $opt['label'];
        break;
    }
}
$occId = 0;
if ($occLabel) {
    $res = $db->query("SELECT id FROM occupations WHERE name = '" . $db->real_escape_string($occLabel) . "' LIMIT 1");
    if ($row = $res->fetch_assoc())
        $occId = (int) $row['id'];
}

$addrPerm = $_POST['addr_perm'] ?? '';
$addrCurr = $_POST['addr_curr'] ?? '';
$sameAsPerm = $_POST['same_as_perm'] ?? '';
if ($sameAsPerm === 'on') {
    $addrCurr = $addrPerm;
}

$firmName = $_POST['firm_name'] ?? '';
$designation = $_POST['designation'] ?? '';

$hobbiesArr = $_POST['hobby'] ?? [];
$hobbies = is_array($hobbiesArr) ? implode(', ', $hobbiesArr) : '';

$aiRaw = $getVal('annual_income');
$annualIncome = 0;
if ($aiRaw === '0-2')
    $annualIncome = 200000;
elseif ($aiRaw === '2-5')
    $annualIncome = 500000;
elseif ($aiRaw === '5-10')
    $annualIncome = 1000000;
elseif ($aiRaw === '10-20')
    $annualIncome = 2000000;
elseif ($aiRaw === '20+')
    $annualIncome = 3000000;

$height = $_POST['height'] ?? '';
$weight = $_POST['weight'] ?? '';
$complexion = $_POST['complexion'] ?? '';
$bloodGroup = $_POST['blood_group'] ?? '';
$createdBy = $_POST['profile_created_by'] ?? 'self';
$languagesKnown = $_POST['languages_known'] ?? '';

$widowDivorce = 'Not Applicable';
if ($mStatus === 'divorced') {
    $widowDivorce = 'Divorced';
} elseif ($mStatus === 'widowed') {
    $widowDivorce = 'Widowed';
}

$handicapped = $_POST['handicapped'] ?? 'No';

// Parse height_cm and weight_kg
$heightCm = 0;
if (preg_match('/(\d+)\s*(cm|CM)/', $height, $matches)) {
    $heightCm = (int) $matches[1];
} else if (preg_match('/^(\d+)$/', trim($height), $matches)) {
    $heightCm = (int) $matches[1];
} else if (preg_match('/(\d+)\s*(?:ft|feet|\')\s*(?:(\d+)\s*(?:in|inches|"))?/', $height, $matches)) {
    $ft = (int) $matches[1];
    $in = isset($matches[2]) ? (int) $matches[2] : 0;
    $heightCm = (int) round(($ft * 12 + $in) * 2.54);
}

$weightKg = 0;
if (preg_match('/(\d+)\s*(kg|KG)/', $weight, $matches)) {
    $weightKg = (int) $matches[1];
} else if (preg_match('/^(\d+)$/', trim($weight), $matches)) {
    $weightKg = (int) $matches[1];
}

$stmt->bind_param(
    "ssssssssssssssssssssssssssssssssssssiiiiiisssssiisssdssssiissssss",
    $profileId,
    $firstName,
    $lastName,
    $email,
    $mobile,
    $passHash,
    $gender,
    $dob,
    $photo,
    $status,
    $digamber,
    $religion,
    $whichTemple,
    $birthTime,
    $birthPlace,
    $birthCountry,
    $birthState,
    $birthCity,
    $nativeCountry,
    $nativeState,
    $nativeCity,
    $nativeLocality,
    $gotra,
    $star,
    $rasi,
    $dosh,
    $whichKundli,
    $whatsapp,
    $fName,
    $fMob,
    $fInc,
    $fOcc,
    $mName,
    $mMob,
    $mInc,
    $relDet,
    $bt,
    $bm,
    $bu,
    $st,
    $sm,
    $su,
    $mTongue,
    $mStatus,
    $razorpayId,
    $addrPerm,
    $addrCurr,
    $eduId,
    $occId,
    $firmName,
    $designation,
    $hobbies,
    $annualIncome,
    $kundliImg,
    $horoscope,
    $height,
    $weight,
    $heightCm,
    $weightKg,
    $complexion,
    $bloodGroup,
    $createdBy,
    $languagesKnown,
    $handicapped,
    $widowDivorce
);

try {
    if ($stmt->execute()) {
        $userId = $db->insert_id;

        // 6. Save Payment Record
        $payment_enabled = sathi_site_setting('payment_enabled', '0') === '1';

        $payStmt = $db->prepare(
            "INSERT INTO payments (user_id, amount, payment_method, status, transaction_id) VALUES (?, ?, ?, ?, ?)"
        );

        if ($payment_enabled) {
            $amount = 999.00;
            $payMethod = 'Razorpay';
            $payStatus = 'paid';
        } else {
            $amount = 0.00;
            $payMethod = 'Free';
            $payStatus = 'free';
            $razorpayId = ''; // No ID for free
        }

        $payStmt->bind_param("idsss", $userId, $amount, $payMethod, $payStatus, $razorpayId);
        $payStmt->execute();

        // 7. Initialize Session
        $_SESSION['sathi_user_id'] = $userId;
        $_SESSION['sathi_user_email'] = $email;
        $_SESSION['sathi_user_name'] = $firstName . ' ' . $lastName;
        $_SESSION['sathi_registration_complete'] = true;
        $_SESSION['sathi_registration_status'] = 'pending';

        json_response(true, 'Registration Successful');
    } else {
        json_response(false, 'Registration Failed: ' . $db->error);
    }
} catch (Exception $e) {
    json_response(false, 'Registration Error: ' . $e->getMessage());
}
