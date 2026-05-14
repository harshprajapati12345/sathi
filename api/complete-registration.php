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

// 5. Insert User with all new fields
$stmt = $db->prepare(
    "INSERT INTO users (
        profile_id, first_name, last_name, email, mobile, password_hash, gender, dob, profile_photo, status,
        digamber_jain, religion, which_temple, birth_time, birth_place, birth_country, birth_state, birth_city,
        native_country, native_state, native_city, native_locality, gotra, star, rasi, dosh, which_kundli,
        whatsapp, father_name, father_mobile, father_income, father_occ, mother_name, mother_mobile, mother_income,
        relative_details, bro_total, bro_married, bro_unmarried, sis_total, sis_married, sis_unmarried,
        mother_tongue_val, marital_status_val, razorpay_payment_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
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

$stmt->bind_param(
    "ssssssssssssssssssssssssssssssssssssiiiiiisss",
    $profileId, $firstName, $lastName, $email, $mobile, $passHash, $gender, $dob, $photo, $status,
    $digamber, $religion, $whichTemple, $birthTime, $birthPlace, $birthCountry, $birthState, $birthCity,
    $nativeCountry, $nativeState, $nativeCity, $nativeLocality, $gotra, $star, $rasi, $dosh, $whichKundli,
    $whatsapp, $fName, $fMob, $fInc, $fOcc, $mName, $mMob, $mInc,
    $relDet, $bt, $bm, $bu, $st, $sm, $su,
    $mTongue, $mStatus, $razorpayId
);

try {
    if ($stmt->execute()) {
        $userId = $db->insert_id;

        // 6. Save Payment Record
        $payStmt = $db->prepare(
            "INSERT INTO payments (user_id, amount, payment_method, status, transaction_id) VALUES (?, ?, ?, ?, ?)"
        );
        $amount = 999.00;
        $payMethod = 'Razorpay';
        $payStatus = 'paid';

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
