<?php
/**
 * Registration Finalization API
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
$firstName = ucwords(strtolower(trim($_POST['first_name'] ?? '')));
$lastName = ucwords(strtolower(trim($_POST['last_name'] ?? '')));
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$password = $_POST['password'] ?? '';

if (!validate_required($firstName))
    json_response(false, 'First name is required');
if (!validate_email($email))
    json_response(false, 'Valid email is required');
if (!validate_mobile($mobile))
    json_response(false, '10-digit mobile is required');
if (strlen($password) < 8)
    json_response(false, 'Password must be at least 8 characters');

$db = sathi_db();

// 2. Check if email or mobile exists
$check = $db->prepare("SELECT id FROM users WHERE email = ? OR mobile = ? LIMIT 1");
$check->bind_param("ss", $email, $mobile);
$check->execute();
$res = $check->get_result();
if ($res->num_rows > 0) {
    json_response(false, 'Email or Mobile number already registered');
}
$check->close();

// 3. Handle File Uploads
$photo = upload_file($_FILES['photo'] ?? null, 'profiles');

// 4. Prepare Data for `users` table
$passHash = password_hash($password, PASSWORD_BCRYPT);
$profileId = 'SKB' . strtoupper(bin2hex(random_bytes(3)));
$gender = $_POST['gender'] ?? 'other';
$dob = !empty($_POST['birth_date']) ? $_POST['birth_date'] : null;
$status = 'pending';

$height = trim($_POST['height'] ?? '');
$weight = trim($_POST['weight'] ?? '');
$heightCm = 0;
$weightKg = (int)$weight;

if ($weightKg < 35 || $weightKg > 150) {
    json_response(false, 'Weight must be between 35kg and 150kg');
}

if (preg_match('/(\d+)\s*ft\s*(\d+)?/', $height, $matches)) {
    $ft = (int)$matches[1];
    $in = isset($matches[2]) ? (int)$matches[2] : 0;
    if ($ft > 7 || ($ft == 7 && $in > 11)) {
        json_response(false, 'Height must be maximum 7 ft 11 inch');
    }
    $heightCm = (int) round(($ft * 12 + $in) * 2.54);
} else {
    json_response(false, 'Valid height is required');
}

$db->begin_transaction();

try {
    // Insert into `users` table for core authentication/profile
    $mandir_id = !empty($_POST['mandir']) ? (int)$_POST['mandir'] : null;
    $subcast_id = !empty($_POST['subcast']) ? (int)$_POST['subcast'] : null;
    $gotra_id = !empty($_POST['gotra']) ? (int)$_POST['gotra'] : null;
    $ref1_name = trim($_POST['ref1_name'] ?? '');
    $ref1_mobile = trim($_POST['ref1_mobile'] ?? '');
    $ref1_relation = trim($_POST['ref1_relation'] ?? '');
    $ref2_name = trim($_POST['ref2_name'] ?? '');
    $ref2_mobile = trim($_POST['ref2_mobile'] ?? '');
    $ref2_relation = trim($_POST['ref2_relation'] ?? '');

    $stmtUsers = $db->prepare("
        INSERT INTO users (
            profile_id, first_name, last_name, email, mobile, password_hash, gender, dob, profile_photo, status, height_cm, weight_kg,
            mandir_id, subcast_id, gotra_id, 
            reference_person_1_name, reference_person_1_mobile, reference_person_1_relation,
            reference_person_2_name, reference_person_2_mobile, reference_person_2_relation
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmtUsers->bind_param("ssssssssssiiiiissssss", $profileId, $firstName, $lastName, $email, $mobile, $passHash, $gender, $dob, $photo, $status, $heightCm, $weightKg, $mandir_id, $subcast_id, $gotra_id, $ref1_name, $ref1_mobile, $ref1_relation, $ref2_name, $ref2_mobile, $ref2_relation);
    
    if (!$stmtUsers->execute()) {
        throw new Exception('User registration failed: ' . $stmtUsers->error);
    }
    $userId = $db->insert_id;
    $stmtUsers->close();

    // Insert into `candidates` table for the specific form data
    $stmtCand = $db->prepare("
        INSERT INTO candidates (
            email_address, are_you_digamber_jain, first_name, last_name, country_code, mobile_number,
            birth_date, birth_time, birth_place, native, gotra, horoscope, star, dosh, height, weight, gender,
            permanent_address, candidate_current_address, email, higher_education, hobbies, candidate_annual_income,
            widow_divorce, handicapped_physical_deficiency, language_known, candidate_occupation, occupation_firm, occupation_designation,
            father_name, father_mobile_number, father_annual_income, father_occupation, mother_name, mother_mobile_number, mother_annual_income,
            brothers, brothers_married_count, brothers_unmarried_count, sisters, sisters_married_count, sisters_unmarried_count, candidate_photo
        ) VALUES (
            ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?
        )
    ");
    
    $digamber = $_POST['digamber'] ?? 'yes';
    $countryCode = $_POST['country_code'] ?? '+91';
    $birthTime = $_POST['birth_time'] ?? '';
    $birthPlace = $_POST['birth_place'] ?? '';
    $nativePlace = $_POST['native_place'] ?? '';
    $gotra = $_POST['gotra'] ?? '';
    $horoscope = ''; // Not collected in the form directly unless you want to map it
    $star = $_POST['star'] ?? ''; // Mama Gotra mapped to star
    $dosh = $_POST['dosh'] ?? ''; // Manglik mapped to dosh
    $addrPerm = $_POST['addr_perm'] ?? '';
    $addrCurr = $_POST['addr_curr'] ?? '';
    
    $edu = $_POST['education'] ?? '';
    $hobbiesArr = $_POST['hobby'] ?? [];
    $hobbies = is_array($hobbiesArr) ? implode(', ', $hobbiesArr) : '';
    $annualIncome = $_POST['annual_income'] ?? '';
    $maritalStatus = $_POST['marital_status'] ?? '';
    $handicapped = $_POST['blood_group'] ?? ''; // Form uses blood_group name for Handicapped/Physical Deficiency
    $langArr = $_POST['languages_known'] ?? [];
    $languagesKnown = is_array($langArr) ? implode(', ', $langArr) : $langArr;
    $otherLang = trim($_POST['languages_known_other'] ?? '');
    if (!empty($otherLang)) {
        $languagesKnown .= empty($languagesKnown) ? $otherLang : ', ' . $otherLang;
    }
    $occupation = $_POST['occupation'] ?? '';
    $firmName = $_POST['firm_name'] ?? '';
    $designation = $_POST['designation'] ?? '';
    
    $fatherName = ucwords(strtolower(trim($_POST['father_name'] ?? '')));
    $fatherMobile = $_POST['father_mobile'] ?? '';
    $fatherIncome = $_POST['father_income'] ?? '';
    $fatherOcc = $_POST['father_occ'] ?? '';
    $motherName = ucwords(strtolower(trim($_POST['mother_name'] ?? '')));
    $motherMobile = $_POST['mother_mobile'] ?? '';
    $motherIncome = $_POST['mother_income'] ?? '';
    
    $broTotal = (int)($_POST['bro_total'] ?? 0);
    $broMarried = (int)($_POST['bro_married'] ?? 0);
    $broUnmarried = (int)($_POST['bro_unmarried'] ?? 0);
    $sisTotal = (int)($_POST['sis_total'] ?? 0);
    $sisMarried = (int)($_POST['sis_married'] ?? 0);
    $sisUnmarried = (int)($_POST['sis_unmarried'] ?? 0);

    $stmtCand->bind_param("ssssssssssssssssssssssssssssssssssssiiiiiis",
        $email, $digamber, $firstName, $lastName, $countryCode, $mobile,
        $dob, $birthTime, $birthPlace, $nativePlace, $gotra, $horoscope, $star, $dosh, $height, $weight, $gender,
        $addrPerm, $addrCurr, $email, $edu, $hobbies, $annualIncome,
        $maritalStatus, $handicapped, $languagesKnown, $occupation, $firmName, $designation,
        $fatherName, $fatherMobile, $fatherIncome, $fatherOcc, $motherName, $motherMobile, $motherIncome,
        $broTotal, $broMarried, $broUnmarried, $sisTotal, $sisMarried, $sisUnmarried, $photo
    );

    if (!$stmtCand->execute()) {
        throw new Exception('Candidate registration failed: ' . $stmtCand->error);
    }
    $stmtCand->close();

    // 6. Save Payment Record if payment is enabled
    $payment_enabled = sathi_site_setting('payment_enabled', '0') === '1';
    $payStmt = $db->prepare("INSERT INTO payments (user_id, amount, payment_method, status, transaction_id) VALUES (?, ?, ?, ?, ?)");
    
    $razorpayId = $_POST['razorpay_payment_id'] ?? '';
    if ($payment_enabled) {
        $amount = 999.00;
        $payMethod = 'Razorpay';
        $payStatus = 'paid';
    } else {
        $amount = 0.00;
        $payMethod = 'Free';
        $payStatus = 'free';
        $razorpayId = '';
    }

    $payStmt->bind_param("idsss", $userId, $amount, $payMethod, $payStatus, $razorpayId);
    $payStmt->execute();
    $payStmt->close();

    $db->commit();

    // 7. Initialize Session
    $_SESSION['sathi_user_id'] = $userId;
    $_SESSION['sathi_user_email'] = $email;
    $_SESSION['sathi_user_name'] = $firstName . ' ' . $lastName;
    $_SESSION['sathi_registration_complete'] = true;
    $_SESSION['sathi_registration_status'] = 'pending';

    json_response(true, 'Registration Successful');

} catch (Exception $e) {
    $db->rollback();
    json_response(false, 'Registration Error: ' . $e->getMessage());
}
