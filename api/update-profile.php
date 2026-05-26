<?php
/**
 * Profile Update API
 */
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/helpers/response.php';
require_once dirname(__DIR__) . '/helpers/validator.php';
require_once dirname(__DIR__) . '/helpers/uploads.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method Not Allowed');
}

$userId = (int)($_SESSION['sathi_user_id'] ?? 0);
if ($userId <= 0) {
    json_response(false, 'Unauthorized');
}

$db = sathi_db();

// 1. Fetch current user data to retain email and existing photo if not changed
$stmt = $db->prepare("SELECT email, profile_photo, mobile FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$currentUser = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$currentUser) {
    json_response(false, 'User not found');
}

$email = $currentUser['email'];
$oldMobile = $currentUser['mobile'];
$existingPhoto = $currentUser['profile_photo'];

// Basic Validation
$firstName = ucwords(strtolower(trim($_POST['first_name'] ?? '')));
$lastName = ucwords(strtolower(trim($_POST['last_name'] ?? '')));
$mobile = $_POST['mobile'] ?? '';

if (!validate_required($firstName))
    json_response(false, 'First name is required');
if (!validate_mobile($mobile))
    json_response(false, '10-digit mobile is required');

// Check if new mobile belongs to another user
if ($mobile !== $oldMobile) {
    $check = $db->prepare("SELECT id FROM users WHERE mobile = ? AND id != ? LIMIT 1");
    $check->bind_param("si", $mobile, $userId);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        json_response(false, 'Mobile number already registered by another account');
    }
    $check->close();
}

// Split name logic removed
// 3. Handle File Uploads
$photo = $existingPhoto;
if (!empty($_FILES['photo']['tmp_name'])) {
    $uploaded = upload_file($_FILES['photo'], 'profiles');
    if ($uploaded) {
        $photo = $uploaded;
    }
}

// 4. Prepare Data for `users` table
$gender = $_POST['gender'] ?? 'other';
$dob = !empty($_POST['birth_date']) ? $_POST['birth_date'] : null;

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
    $mandir_id = !empty($_POST['mandir']) ? (int)$_POST['mandir'] : null;
    $subcast_id = !empty($_POST['subcast']) ? (int)$_POST['subcast'] : null;
    $gotra_id = !empty($_POST['gotra']) ? (int)$_POST['gotra'] : null;
    $ref1_name = trim($_POST['ref1_name'] ?? '');
    $ref1_mobile = trim($_POST['ref1_mobile'] ?? '');
    $ref1_relation = trim($_POST['ref1_relation'] ?? '');
    $ref2_name = trim($_POST['ref2_name'] ?? '');
    $ref2_mobile = trim($_POST['ref2_mobile'] ?? '');
    $ref2_relation = trim($_POST['ref2_relation'] ?? '');

    // Update `users` table
    $stmtUsers = $db->prepare("
        UPDATE users SET 
            first_name = ?, last_name = ?, mobile = ?, gender = ?, dob = ?, profile_photo = ?, height_cm = ?, weight_kg = ?,
            mandir_id = ?, subcast_id = ?, gotra_id = ?, 
            reference_person_1_name = ?, reference_person_1_mobile = ?, reference_person_1_relation = ?,
            reference_person_2_name = ?, reference_person_2_mobile = ?, reference_person_2_relation = ?
        WHERE id = ?
    ");
    $stmtUsers->bind_param("ssssssiiiiiiissssssi", $firstName, $lastName, $mobile, $gender, $dob, $photo, $heightCm, $weightKg, $mandir_id, $subcast_id, $gotra_id, $ref1_name, $ref1_mobile, $ref1_relation, $ref2_name, $ref2_mobile, $ref2_relation, $userId);
    
    if (!$stmtUsers->execute()) {
        throw new Exception('User update failed: ' . $stmtUsers->error);
    }
    $stmtUsers->close();

    // Data mapping for candidates table
    $digamber = $_POST['digamber'] ?? 'yes';
    $countryCode = $_POST['country_code'] ?? '+91';
    $birthTime = $_POST['birth_time'] ?? '';
    $birthPlace = $_POST['birth_place'] ?? '';
    $nativePlace = $_POST['native_place'] ?? '';
    $gotra = $_POST['gotra'] ?? '';
    $horoscope = '';
    $star = $_POST['star'] ?? ''; 
    $dosh = $_POST['dosh'] ?? ''; 
    $addrPerm = $_POST['addr_perm'] ?? '';
    $addrCurr = $_POST['addr_curr'] ?? '';
    
    $edu = $_POST['education'] ?? '';
    $hobbiesArr = $_POST['hobby'] ?? [];
    $hobbies = is_array($hobbiesArr) ? implode(', ', $hobbiesArr) : '';
    $annualIncome = $_POST['annual_income'] ?? '';
    $maritalStatus = $_POST['marital_status'] ?? '';
    $handicapped = $_POST['blood_group'] ?? ''; 
    $langArr = $_POST['languages_known'] ?? [];
    $languagesKnown = is_array($langArr) ? implode(', ', $langArr) : $langArr;
    $otherLang = trim($_POST['languages_known_other'] ?? '');
    if (!empty($otherLang)) {
        $languagesKnown .= empty($languagesKnown) ? $otherLang : ', ' . $otherLang;
    }
    $occupation = $_POST['occupation'] ?? '';
    $firmName = $_POST['firm_name'] ?? '';
    $designation = $_POST['designation'] ?? '';
    $relativeDetails = $_POST['relative_details'] ?? '';
    $complexion = $_POST['complexion'] ?? '';
    
    $fatherName = ucwords(strtolower(trim($_POST['father_name'] ?? '')));
    $fatherMobile = $_POST['father_mobile'] ?? '';
    $fatherIncome = $_POST['father_income'] ?? '';
    $fatherOcc = $_POST['father_occ'] ?? '';
    $motherName = ucwords(strtolower(trim($_POST['mother_name'] ?? '')));
    $motherMobile = $_POST['mother_mobile'] ?? '';
    $motherIncome = $_POST['mother_income'] ?? '';
    $motherOcc = $_POST['mother_occ'] ?? '';
    
    $broTotal = (int)($_POST['bro_total'] ?? 0);
    $broMarried = (int)($_POST['bro_married'] ?? 0);
    $broUnmarried = (int)($_POST['bro_unmarried'] ?? 0);
    $sisTotal = (int)($_POST['sis_total'] ?? 0);
    $sisMarried = (int)($_POST['sis_married'] ?? 0);
    $sisUnmarried = (int)($_POST['sis_unmarried'] ?? 0);

    // Update `candidates` table. Match by email or mobile.
    // If it doesn't exist, we should theoretically INSERT, but we assume it exists since it's an update.
    $stmtCand = $db->prepare("
        UPDATE candidates SET
            are_you_digamber_jain=?, first_name=?, last_name=?, country_code=?, mobile_number=?,
            birth_date=?, birth_time=?, birth_place=?, native=?, gotra=?, horoscope=?, star=?, dosh=?, height=?, weight=?, gender=?,
            permanent_address=?, candidate_current_address=?, higher_education=?, hobbies=?, candidate_annual_income=?,
            widow_divorce=?, handicapped_physical_deficiency=?, language_known=?, candidate_occupation=?, occupation_firm=?, occupation_designation=?,
            father_name=?, father_mobile_number=?, father_annual_income=?, father_occupation=?, mother_name=?, mother_mobile_number=?, mother_annual_income=?,
            brothers=?, brothers_married_count=?, brothers_unmarried_count=?, sisters=?, sisters_married_count=?, sisters_unmarried_count=?, candidate_photo=?
        WHERE email = ?
    ");
    
    $stmtCand->bind_param("ssssssssssssssssssssssssssssssssssiiiiiiss",
        $digamber, $firstName, $lastName, $countryCode, $mobile,
        $dob, $birthTime, $birthPlace, $nativePlace, $gotra, $horoscope, $star, $dosh, $height, $weight, $gender,
        $addrPerm, $addrCurr, $edu, $hobbies, $annualIncome,
        $maritalStatus, $handicapped, $languagesKnown, $occupation, $firmName, $designation,
        $fatherName, $fatherMobile, $fatherIncome, $fatherOcc, $motherName, $motherMobile, $motherIncome,
        $broTotal, $broMarried, $broUnmarried, $sisTotal, $sisMarried, $sisUnmarried, $photo,
        $email
    );

    if (!$stmtCand->execute()) {
        throw new Exception('Candidate update failed: ' . $stmtCand->error);
    }
    
    // Fallback if candidate record didn't exist for some reason
    if ($stmtCand->affected_rows === 0) {
        $checkCand = $db->prepare("SELECT id FROM candidates WHERE email = ?");
        $checkCand->bind_param("s", $email);
        $checkCand->execute();
        if ($checkCand->get_result()->num_rows === 0) {
            // Need to insert
            $stmtCandIns = $db->prepare("
                INSERT INTO candidates (
                    email_address, are_you_digamber_jain, first_name, last_name, country_code, mobile_number,
                    birth_date, birth_time, birth_place, native, gotra, horoscope, star, dosh, height, weight, gender,
                    permanent_address, candidate_current_address, email, higher_education, hobbies, candidate_annual_income,
                    widow_divorce, handicapped_physical_deficiency, language_known, candidate_occupation, occupation_firm, occupation_designation,
                    father_name, father_mobile_number, father_annual_income, father_occupation, mother_name, mother_mobile_number, mother_annual_income,
                    brothers, brothers_married_count, brothers_unmarried_count, sisters, sisters_married_count, sisters_unmarried_count, candidate_photo
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                )
            ");
            $stmtCandIns->bind_param("ssssssssssssssssssssssssssssssssssssiiiiiiis",
                $email, $digamber, $firstName, $lastName, $countryCode, $mobile,
                $dob, $birthTime, $birthPlace, $nativePlace, $gotra, $horoscope, $star, $dosh, $height, $weight, $gender,
                $addrPerm, $addrCurr, $email, $edu, $hobbies, $annualIncome,
                $maritalStatus, $handicapped, $languagesKnown, $occupation, $firmName, $designation,
                $fatherName, $fatherMobile, $fatherIncome, $fatherOcc, $motherName, $motherMobile, $motherIncome,
                $broTotal, $broMarried, $broUnmarried, $sisTotal, $sisMarried, $sisUnmarried, $photo
            );
            $stmtCandIns->execute();
            $stmtCandIns->close();
        }
        $checkCand->close();
    }
    
    $stmtCand->close();

    $db->commit();

    // Update Session
    $_SESSION['sathi_user_name'] = $firstName . ' ' . $lastName;

    json_response(true, 'Profile Updated Successfully');

} catch (Exception $e) {
    $db->rollback();
    json_response(false, 'Update Error: ' . $e->getMessage());
}
