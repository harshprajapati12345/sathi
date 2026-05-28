<?php
declare(strict_types=1);

require_once __DIR__ . '/session_init.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/admin/includes/user-storage.php';

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$csrf = isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : '';
if ($csrf === '' || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'csrf_invalid']);
    exit;
}

$digamber = isset($_POST['digamber']) ? strtolower(trim((string) $_POST['digamber'])) : '';
if ($digamber !== 'yes') {
    echo json_encode(['ok' => false, 'error' => 'not_digamber_jain']);
    exit;
}

$email = isset($_POST['email']) ? strtolower(trim((string) $_POST['email'])) : '';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['ok' => false, 'error' => 'invalid_email']);
    exit;
}

if (sathi_user_repo_find_by_email($email) !== null) {
    echo json_encode(['ok' => false, 'error' => 'email_exists']);
    exit;
}

$password = isset($_POST['password']) ? (string) $_POST['password'] : '';
if (strlen($password) < 8) {
    echo json_encode(['ok' => false, 'error' => 'weak_password']);
    exit;
}
$passwordConfirm = isset($_POST['password_confirm']) ? (string) $_POST['password_confirm'] : '';
if (!hash_equals($password, $passwordConfirm)) {
    echo json_encode(['ok' => false, 'error' => 'password_mismatch']);
    exit;
}

$fullName = isset($_POST['full_name']) ? trim((string) $_POST['full_name']) : '';
$fullName = preg_replace('/[\x00-\x1F\x7F]/u', '', $fullName);
if ($fullName === '') {
    echo json_encode(['ok' => false, 'error' => 'invalid_name']);
    exit;
}
$parts = preg_split('/\s+/', $fullName, 2);
$firstName = $parts[0];
$lastName = $parts[1] ?? '';

$gender = isset($_POST['gender']) ? strtolower(trim((string) $_POST['gender'])) : '';
if (!in_array($gender, ['male', 'female', 'other'], true)) {
    echo json_encode(['ok' => false, 'error' => 'invalid_gender']);
    exit;
}

$mobileDigits = preg_replace('/\D/', '', (string) ($_POST['mobile'] ?? ''));
$cc = trim((string) ($_POST['country_code'] ?? '+91'));
if (strlen($mobileDigits) < 10) {
    echo json_encode(['ok' => false, 'error' => 'invalid_mobile']);
    exit;
}
$mobile = $cc . $mobileDigits;

$dob = isset($_POST['birth_date']) ? trim((string) $_POST['birth_date']) : '';
if ($dob === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
    echo json_encode(['ok' => false, 'error' => 'invalid_dob']);
    exit;
}

$toInt = static function ($v): ?int {
    if ($v === null || $v === '') {
        return null;
    }
    $i = (int) $v;
    return $i > 0 ? $i : null;
};

$religionId = $toInt($_POST['religion_status'] ?? null);
$casteId = $toInt($_POST['gotra'] ?? null);
$motherTongueId = $toInt($_POST['mother_tongue'] ?? null);
$maritalStatusId = $toInt($_POST['marital_status'] ?? null);
$educationId = $toInt($_POST['education'] ?? null);
$occupationId = $toInt($_POST['occupation'] ?? null);
$incomeId = $toInt($_POST['annual_income'] ?? null);
$countryId = $toInt($_POST['native_country'] ?? null);
$stateId = $toInt($_POST['native_state'] ?? null);
$cityId = $toInt($_POST['native_city'] ?? null);

$hobbies = isset($_POST['hobby']) && is_array($_POST['hobby']) ? array_map('strval', $_POST['hobby']) : [];

$extra = [
    'digamber' => (string) ($_POST['digamber'] ?? ''),
    'payment' => [
        'method' => (string) ($_POST['pay_method'] ?? ''),
        'agree' => !empty($_POST['pay_agree']),
    ],
    'files' => [
        'horoscope' => '',
        'payment_screenshot' => '',
    ],
];

// Physical attributes mapping
$heightStr = (string) ($_POST['height'] ?? '');
$heightCm = 0;
// Example: "5 ft 6 inch" -> convert to cm
if (preg_match('/(\d+)\s*ft\s*(?:(\d+)\s*inch)?/i', $heightStr, $m)) {
    $ft = (int)$m[1];
    $in = isset($m[2]) ? (int)$m[2] : 0;
    $heightCm = (int) round(($ft * 12 + $in) * 2.54);
}
$weightKg = (int) ($_POST['weight'] ?? 0);
$complexion = (string) ($_POST['complexion'] ?? ''); // Used as Pincode

$mandirId = $toInt($_POST['mandir'] ?? null);
$subcastId = $toInt($_POST['subcast'] ?? null);
$gotraId = $toInt($_POST['gotra'] ?? null);
$bloodGroup = (string) ($_POST['blood_group'] ?? ''); // Handicapped field
$languagesKnownOther = (string) ($_POST['languages_known_other'] ?? '');
$relativeDetails = (string) ($_POST['relative_details'] ?? ''); // Preference

$ref1Name = (string) ($_POST['ref1_name'] ?? '');
$ref1Mobile = (string) ($_POST['ref1_mobile'] ?? '');
$ref1Rel = (string) ($_POST['ref1_relation'] ?? '');
$ref2Name = (string) ($_POST['ref2_name'] ?? '');
$ref2Mobile = (string) ($_POST['ref2_mobile'] ?? '');
$ref2Rel = (string) ($_POST['ref2_relation'] ?? '');

$uploadDirBase = __DIR__ . '/uploads/profiles';

function sathi_safe_upload(?array $file, array $allowedMime, int $maxBytes, string $destPath): bool
{
    if ($file === null || !isset($file['tmp_name'], $file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    if ($file['size'] > $maxBytes) {
        return false;
    }
    $tmp = $file['tmp_name'];
    if (!class_exists('finfo', false)) {
        return false;
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($tmp) ?: '';
    if (!in_array($mime, $allowedMime, true)) {
        return false;
    }
    $dir = dirname($destPath);
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        return false;
    }
    return move_uploaded_file($tmp, $destPath);
}

try {
    $pdo = sathi_db();
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'database']);
    exit;
}

$profileId = sathi_user_generate_profile_id($pdo);
$destDir = $uploadDirBase . '/' . $profileId;

$horoscopeRel = '';
if (!empty($_FILES['horoscope']) && is_array($_FILES['horoscope'])) {
    $ext = strtolower(pathinfo((string) $_FILES['horoscope']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'], true)) {
        echo json_encode(['ok' => false, 'error' => 'invalid_horoscope']);
        exit;
    }
    $dest = $destDir . '/horoscope.' . $ext;
    if (sathi_safe_upload($_FILES['horoscope'], ['application/pdf', 'image/jpeg', 'image/png'], 5 * 1024 * 1024, $dest)) {
        $horoscopeRel = 'uploads/profiles/' . $profileId . '/horoscope.' . $ext;
        $extra['files']['horoscope'] = $horoscopeRel;
    }
}

$photoRel = '';
if (!empty($_FILES['photo']) && is_array($_FILES['photo'])) {
    $dest = $destDir . '/photo.jpg';
    if (sathi_safe_upload($_FILES['photo'], ['image/jpeg', 'image/png'], 5 * 1024 * 1024, $dest)) {
        $photoRel = 'uploads/profiles/' . $profileId . '/photo.jpg';
    }
}

$payShotRel = '';
if (!empty($_FILES['payment_screenshot']) && is_array($_FILES['payment_screenshot'])) {
    $dest = $destDir . '/payment.jpg';
    if (sathi_safe_upload($_FILES['payment_screenshot'], ['image/jpeg', 'image/png', 'image/webp'], 5 * 1024 * 1024, $dest)) {
        $payShotRel = 'uploads/profiles/' . $profileId . '/payment.jpg';
        $extra['files']['payment_screenshot'] = $payShotRel;
    }
}

$aboutJson = json_encode($extra, JSON_UNESCAPED_UNICODE);
if ($aboutJson === false) {
    $aboutJson = '{}';
}
$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = 'INSERT INTO users (
    profile_id, first_name, last_name, email, mobile, password_hash, gender, dob,
    religion_id, caste_id, mother_tongue_id, marital_status_id,
    education_id, occupation_id, income_id,
    country_id, state_id, city_id,
    mandir_id, subcast_id, gotra_id,
    height_cm, weight_kg, complexion, blood_group,
    reference_person_1_name, reference_person_1_mobile, reference_person_1_relation,
    reference_person_2_name, reference_person_2_mobile, reference_person_2_relation,
    about_me, profile_photo, status, membership_status
) VALUES (
    :profile_id, :first_name, :last_name, :email, :mobile, :password_hash, :gender, :dob,
    :religion_id, :caste_id, :mother_tongue_id, :marital_status_id,
    :education_id, :occupation_id, :income_id,
    :country_id, :state_id, :city_id,
    :mandir_id, :subcast_id, :gotra_id,
    :height_cm, :weight_kg, :complexion, :blood_group,
    :ref1_name, :ref1_mobile, :ref1_relation,
    :ref2_name, :ref2_mobile, :ref2_relation,
    :about_me, :profile_photo, :status, :membership_status
)';

try {
    $st = $pdo->prepare($sql);
    $st->execute([
        ':profile_id' => $profileId,
        ':first_name' => $firstName,
        ':last_name' => $lastName,
        ':email' => $email,
        ':mobile' => $mobile,
        ':password_hash' => $hash,
        ':gender' => $gender,
        ':dob' => $dob,
        ':religion_id' => $religionId,
        ':caste_id' => $casteId,
        ':mother_tongue_id' => $motherTongueId,
        ':marital_status_id' => $maritalStatusId,
        ':education_id' => $educationId,
        ':occupation_id' => $occupationId,
        ':income_id' => $incomeId,
        ':country_id' => $countryId,
        ':state_id' => $stateId,
        ':city_id' => $cityId,
        ':mandir_id' => $mandirId,
        ':subcast_id' => $subcastId,
        ':gotra_id' => $gotraId,
        ':height_cm' => $heightCm,
        ':weight_kg' => $weightKg,
        ':complexion' => $complexion,
        ':blood_group' => $bloodGroup,
        ':ref1_name' => $ref1Name,
        ':ref1_mobile' => $ref1Mobile,
        ':ref1_relation' => $ref1Rel,
        ':ref2_name' => $ref2Name,
        ':ref2_mobile' => $ref2Mobile,
        ':ref2_relation' => $ref2Rel,
        ':about_me' => $aboutJson,
        ':profile_photo' => $photoRel,
        ':status' => 'pending',
        ':membership_status' => 'free',
    ]);
    $newId = (int) $pdo->lastInsertId();
} catch (PDOException $e) {
    if ((int) $e->getCode() === 23000 || str_contains($e->getMessage(), 'Duplicate')) {
        echo json_encode(['ok' => false, 'error' => 'duplicate']);
        exit;
    }
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'save_failed']);
    exit;
}

if ($photoRel !== '') {
    $p = $pdo->prepare('INSERT INTO user_photos (user_id, photo, is_primary, approved, sort_order) VALUES (?,?,1,0,0)');
    $p->execute([$newId, $photoRel]);
}

// Insert related data
$pdo->prepare('INSERT INTO user_addresses (user_id, permanent_address, current_address) VALUES (?, ?, ?)')
    ->execute([$newId, (string)($_POST['addr_perm'] ?? ''), (string)($_POST['addr_curr'] ?? '')]);

$pdo->prepare('INSERT INTO user_family_details (user_id, father_name, father_mobile, father_income, father_occupation, mother_name, mother_mobile, mother_income, mother_occupation, brothers, brothers_married, brothers_unmarried, sisters, sisters_married, sisters_unmarried) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')
    ->execute([
        $newId,
        (string)($_POST['father_name'] ?? ''), (string)($_POST['father_mobile'] ?? ''), (string)($_POST['father_income'] ?? ''), (string)($_POST['father_occ'] ?? ''),
        (string)($_POST['mother_name'] ?? ''), (string)($_POST['mother_mobile'] ?? ''), (string)($_POST['mother_income'] ?? ''), (string)($_POST['mother_occ'] ?? ''),
        (int)($_POST['bro_total'] ?? 0), (int)($_POST['bro_married'] ?? 0), (int)($_POST['bro_unmarried'] ?? 0),
        (int)($_POST['sis_total'] ?? 0), (int)($_POST['sis_married'] ?? 0), (int)($_POST['sis_unmarried'] ?? 0)
    ]);

$pdo->prepare('INSERT INTO user_work_details (user_id, occupation_firm, occupation_designation, annual_income) VALUES (?, ?, ?, ?)')
    ->execute([$newId, (string)($_POST['firm_name'] ?? ''), (string)($_POST['designation'] ?? ''), (string)($_POST['annual_income'] ?? '')]);

$pdo->prepare('INSERT INTO user_physical_attributes (user_id, height_cm, weight_kg, gotra, horoscope, handicapped) VALUES (?, ?, ?, ?, ?, ?)')
    ->execute([$newId, $heightCm, $weightKg, (string)($_POST['star'] ?? ''), (string)($_POST['dosh'] ?? ''), $bloodGroup]);

foreach ($hobbies as $h) {
    $pdo->prepare('INSERT INTO user_hobbies (user_id, hobby_name) VALUES (?, ?)')
        ->execute([$newId, $h]);
}
$langs = isset($_POST['languages_known']) && is_array($_POST['languages_known']) ? $_POST['languages_known'] : [];
if ($languagesKnownOther !== '') $langs[] = $languagesKnownOther;
foreach ($langs as $l) {
    $pdo->prepare('INSERT INTO user_languages (user_id, language_name) VALUES (?, ?)')
        ->execute([$newId, $l]);
}

if (!empty($extra['payment']['method'])) {
    $pay = $pdo->prepare('INSERT INTO payments (user_id, membership_id, payment_method, transaction_id, amount, currency, status) VALUES (?,?,?,?,?,?,?)');
    $pay->execute([$newId, null, (string) $extra['payment']['method'], null, 999.00, 'INR', 'pending']);
}

session_regenerate_id(true);
$_SESSION['sathi_user_id'] = $newId;
$_SESSION['sathi_user_email'] = $email;
$_SESSION['sathi_user_name'] = trim($firstName . ' ' . $lastName);
$_SESSION['sathi_registration_status'] = 'pending';
$_SESSION['sathi_membership_status'] = 'free';
$_SESSION['sathi_registration_complete'] = true;

echo json_encode(['ok' => true]);
