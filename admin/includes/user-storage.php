<?php
/**
 * User Storage using MySQLi (Aligned with Actual Schema)
 */
require_once dirname(__DIR__, 2) . '/config/database.php';

function sathi_user_repo_find_by_email($email)
{
    $db = sathi_db();
    $email = $db->real_escape_string(strtolower(trim($email)));

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    return sathi_user_normalize_row($row);
}

function sathi_user_repo_find_by_id($id)
{
    $db = sathi_db();
    $id = (int) $id;

    $query = "SELECT u.*, 
                r.name as religion,
                mt.name as mother_tongue_val,
                ms.name as marital_status_val,
                e.name as education_val,
                occ.name as occupation_val,
                fd.father_name as father_name, 
                fd.father_mobile as father_mobile, 
                fd.father_income as father_income, 
                fd.father_occupation as father_occ,
                fd.mother_name as mother_name, 
                fd.mother_mobile as mother_mobile, 
                fd.mother_income as mother_income, 
                fd.mother_occupation as mother_occ,
                fd.brothers as bro_total, 
                fd.brothers_married as bro_married, 
                fd.brothers_unmarried as bro_unmarried,
                fd.sisters as sis_total, 
                fd.sisters_married as sis_married, 
                fd.sisters_unmarried as sis_unmarried,
                wd.occupation_firm as occupation_firm, 
                wd.occupation_designation as occupation_designation, 
                wd.annual_income as annual_income,
                ad.permanent_address as permanent_address, 
                ad.current_address as current_address,
                pa.height_cm as height_cm, 
                pa.weight_kg as weight_kg, 
                pa.gotra as gotra, 
                pa.horoscope as horoscope, 
                               pa.handicapped as handicapped,
                pi.transaction_id as razorpay_payment_id,
                u.profile_photo as profile_photo_url
              FROM users u
              LEFT JOIN religions r ON u.religion_id = r.id
              LEFT JOIN mother_tongues mt ON u.mother_tongue_id = mt.id
              LEFT JOIN marital_statuses ms ON u.marital_status_id = ms.id
              LEFT JOIN educations e ON u.education_id = e.id
              LEFT JOIN occupations occ ON u.occupation_id = occ.id
              LEFT JOIN user_family_details fd ON u.id = fd.user_id
              LEFT JOIN user_work_details wd ON u.id = wd.user_id
              LEFT JOIN user_addresses ad ON u.id = ad.user_id
              LEFT JOIN user_physical_attributes pa ON u.id = pa.user_id
              LEFT JOIN user_payments_info pi ON u.id = pi.user_id
              WHERE u.id = ? LIMIT 1";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if ($row) {
        // Fetch Hobbies
        $hRes = $db->query("SELECT hobby_name FROM user_hobbies WHERE user_id = $id");
        $hobbies = [];
        if ($hRes) {
            while ($h = $hRes->fetch_assoc()) {
                $hobbies[] = $h['hobby_name'];
            }
        }
        if (!empty($hobbies)) {
            $row['hobbies'] = implode(', ', $hobbies);
        }

        // Fetch Languages
        $lRes = $db->query("SELECT language_name FROM user_languages WHERE user_id = $id");
        $langs = [];
        if ($lRes) {
            while ($l = $lRes->fetch_assoc()) {
                $langs[] = $l['language_name'];
            }
        }
        if (!empty($langs)) {
            $row['languages_known'] = implode(', ', $langs);
        }
    }

    return sathi_user_normalize_row($row);
}



function sathi_user_touch_login($userId)
{
    $db = sathi_db();
    $userId = (int) $userId;
    $db->query("UPDATE users SET last_login_at = NOW(), last_active_at = NOW() WHERE id = $userId");
}

function sathi_users_list_all($limit = 50, $offset = 0, $filters = [], $sort = 'u.id ASC')
{
    $db = sathi_db();
    $limit = (int) $limit;
    $offset = (int) $offset;

    $where = ["1=1"];
    if (!empty($filters['gender'])) {
        $where[] = "u.gender = '" . $db->real_escape_string($filters['gender']) . "'";
    }
    if (!empty($filters['digamber_jain'])) {
        $where[] = "u.digamber_jain = '" . $db->real_escape_string($filters['digamber_jain']) . "'";
    }
    if (!empty($filters['marital_status'])) {
        $where[] = "u.marital_status_id = " . (int) $filters['marital_status'];
    }
    if (!empty($filters['gotra'])) {
        $where[] = "u.gotra LIKE '%" . $db->real_escape_string($filters['gotra']) . "%'";
    }
    if (!empty($filters['temple'])) {
        $where[] = "u.which_temple LIKE '%" . $db->real_escape_string($filters['temple']) . "%'";
    }
    if (!empty($filters['location'])) {
        $loc = $db->real_escape_string($filters['location']);
        $where[] = "(u.birth_place LIKE '%$loc%' OR u.native_place LIKE '%$loc%' OR u.permanent_address LIKE '%$loc%' OR u.current_address LIKE '%$loc%')";
    }
    if (!empty($filters['age_min'])) {
        $where[] = "TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) >= " . (int) $filters['age_min'];
    }
    if (!empty($filters['age_max'])) {
        $where[] = "TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) <= " . (int) $filters['age_max'];
    }

    $whereSql = implode(" AND ", $where);

    $query = "SELECT u.*, 
                e.name as education_val,
                occ.name as occupation_val,
                r.name as religion,
                ms.name as marital_status_val
              FROM users u
              LEFT JOIN educations e ON u.education_id = e.id
              LEFT JOIN occupations occ ON u.occupation_id = occ.id
              LEFT JOIN religions r ON u.religion_id = r.id
              LEFT JOIN marital_statuses ms ON u.marital_status_id = ms.id
              WHERE $whereSql
              ORDER BY $sort LIMIT $limit OFFSET $offset";

    $result = $db->query($query);

    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = sathi_user_normalize_row($row);
        }
    }
    return $rows;
}

function sathi_users_count_all($filters = [])
{
    $db = sathi_db();

    $where = ["1=1"];
    if (!empty($filters['gender'])) {
        $where[] = "u.gender = '" . $db->real_escape_string($filters['gender']) . "'";
    }
    if (!empty($filters['digamber_jain'])) {
        $where[] = "u.digamber_jain = '" . $db->real_escape_string($filters['digamber_jain']) . "'";
    }
    if (!empty($filters['marital_status'])) {
        $where[] = "u.marital_status_id = " . (int) $filters['marital_status'];
    }
    if (!empty($filters['gotra'])) {
        $where[] = "u.gotra LIKE '%" . $db->real_escape_string($filters['gotra']) . "%'";
    }
    if (!empty($filters['temple'])) {
        $where[] = "u.which_temple LIKE '%" . $db->real_escape_string($filters['temple']) . "%'";
    }
    if (!empty($filters['location'])) {
        $loc = $db->real_escape_string($filters['location']);
        $where[] = "(u.birth_place LIKE '%$loc%' OR u.native_place LIKE '%$loc%' OR u.permanent_address LIKE '%$loc%' OR u.current_address LIKE '%$loc%')";
    }
    if (!empty($filters['age_min'])) {
        $where[] = "TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) >= " . (int) $filters['age_min'];
    }
    if (!empty($filters['age_max'])) {
        $where[] = "TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) <= " . (int) $filters['age_max'];
    }

    $whereSql = implode(" AND ", $where);

    $res = $db->query("SELECT COUNT(*) as total FROM users u WHERE $whereSql");
    $row = $res->fetch_assoc();
    return (int) ($row['total'] ?? 0);
}


/**
 * Filter users by status
 */
function sathi_users_list_by_status($status, $limit = 200)
{
    $db = sathi_db();
    $status = $db->real_escape_string($status);
    $limit = (int) $limit;
    $result = $db->query("SELECT * FROM users WHERE status = '$status' ORDER BY created_at DESC LIMIT $limit");

    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * List paid members
 */
function sathi_users_list_paid($limit = 200)
{
    $db = sathi_db();
    $limit = (int) $limit;
    $result = $db->query("SELECT * FROM users WHERE paid_member = 1 ORDER BY created_at DESC LIMIT $limit");

    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Normalizes a user database row into a consistent format
 */
function sathi_user_normalize_row($row)
{
    if (!$row)
        return null;

    $row['name'] = trim(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''));
    if ($row['name'] === '')
        $row['name'] = 'Member';

    $row['status'] = $row['status'] ?? 'pending';
    $row['paid_member'] = (int) ($row['paid_member'] ?? 0);
    $row['membership_status'] = $row['membership_status'] ?? 'free';

    return $row;
}

/**
 * Updated to match the parameters expected by existing code
 */
function sathi_user_storage_update_status_by_id($id, $status, $approvedBy = null, $reason = null)
{
    $db = sathi_db();
    $id = (int) $id;
    $status = $db->real_escape_string($status);

    $approvedAt = $status === 'approved' ? 'NOW()' : 'NULL';

    $stmt = $db->prepare("UPDATE users SET status = ?, approved_by = ?, rejection_reason = ?, approved_at = $approvedAt WHERE id = ?");
    $stmt->bind_param("sisi", $status, $approvedBy, $reason, $id);
    return $stmt->execute();
}

/**
 * List candidates from the CSV-imported table
 */
function sathi_candidates_list_all($limit = 300)
{
    $db = sathi_db();
    $limit = (int) $limit;
    $result = $db->query("SELECT 
        id, 
        candidate_full_name,
        email_address,
        gender,
        birth_date,
        higher_education,
        candidate_annual_income,
        candidate_occupation,
        occupation_designation,
        native,
        birth_place,
        gotra,
        horoscope,
        mobile_number,
        candidate_photo
    FROM candidates
    ORDER BY id ASC 
    LIMIT $limit");

    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Find candidate by ID from the CSV-imported table
 */
function sathi_candidate_find_by_id($id)
{
    $db = sathi_db();
    $id = (int) $id;
    $stmt = $db->prepare("SELECT * FROM candidates WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) {
        return null;
    }

    // Map candidate fields to match standard user fields expected by member-view.php
    return [
        'id' => $row['id'],
        'profile_id' => 'CSV' . str_pad((string)$row['id'], 6, '0', STR_PAD_LEFT),
        'first_name' => $row['candidate_full_name'],
        'last_name' => '',
        'name' => $row['candidate_full_name'],
        'email' => $row['email_address'] ?: ($row['email'] ?? 'N/A'),
        'mobile' => $row['mobile_number'],
        'whatsapp' => $row['mobile_number'],
        'gender' => $row['gender'],
        'dob' => $row['birth_date'],
        'birth_time' => $row['birth_time'] ?? 'N/A',
        'birth_place' => $row['birth_place'],
        'native_place' => $row['native'],
        'religion' => 'Jain',
        'mother_tongue_val' => $row['language_known'] ?? 'N/A',
        'marital_status_val' => $row['widow_divorce'] ?? 'N/A',
        'which_temple' => 'N/A',
        'gotra' => $row['gotra'],
        'horoscope' => $row['horoscope'],
        'star' => 'N/A',
        'rasi' => 'N/A',
        'dosh' => 'N/A',
        'permanent_address' => $row['permanent_address'],
        'current_address' => $row['candidate_current_address'] ?? $row['permanent_address'],
        'education_val' => $row['higher_education'],
        'occupation_val' => $row['candidate_occupation'],
        'occupation_designation' => $row['occupation_designation'],
        'occupation_firm' => $row['occupation_firm'] ?? 'N/A',
        'annual_income' => $row['candidate_annual_income'],
        'hobbies' => $row['hobbies'],
        'languages_known' => $row['language_known'],
        'weight_kg' => (int)($row['weight'] ?? 0),
        'height_cm' => (int)($row['height'] ?? 0),
        'handicapped' => $row['handicapped_physical_deficiency'] ?? 'No',
        'widow_divorce' => $row['widow_divorce'] ?? 'N/A',
        'complexion' => 'N/A',
        'blood_group' => 'N/A',
        'profile_created_by' => 'Self',
        'father_name' => $row['father_name'] ?? 'N/A',
        'father_mobile' => $row['father_mobile_number'] ?? 'N/A',
        'father_income' => $row['father_annual_income'] ?? 0,
        'father_occ' => $row['father_occupation'] ?? 'N/A',
        'mother_name' => $row['mother_name'] ?? 'N/A',
        'mother_mobile' => $row['mother_mobile_number'] ?? 'N/A',
        'mother_income' => $row['mother_annual_income'] ?? 0,
        'mother_occ' => $row['mother_occupation'] ?? 'N/A',
        'bro_total' => (int)($row['brothers'] ?? 0),
        'bro_married' => (int)($row['brothers_married_count'] ?? 0),
        'bro_unmarried' => (int)($row['brothers_unmarried_count'] ?? 0),
        'sis_total' => (int)($row['sisters'] ?? 0),
        'sis_married' => (int)($row['sisters_married_count'] ?? 0),
        'sis_unmarried' => (int)($row['sisters_unmarried_count'] ?? 0),
        'about_me' => 'N/A',
        'relative_details' => 'N/A',
        'profile_photo_url' => $row['candidate_photo'],
        'status' => 'approved',
        'membership_status' => 'free',
        'razorpay_payment_id' => 'N/A',
        'created_at' => $row['created_at'] ?? ($row['timestamp'] ?? 'N/A')
    ];
}

/** Alias for simpler calls */
function sathi_user_update_status($id, $status)
{
    return sathi_user_storage_update_status_by_id($id, $status);
}
