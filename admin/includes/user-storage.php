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
                COALESCE(r.name, u.religion) as religion,
                COALESCE(mt.name, u.mother_tongue_val) as mother_tongue_val,
                COALESCE(ms.name, u.marital_status_val) as marital_status_val,
                e.name as education_val,
                occ.name as occupation_val,
                COALESCE(fd.father_name, u.father_name) as father_name, 
                COALESCE(fd.father_mobile, u.father_mobile_number, u.father_mobile) as father_mobile, 
                COALESCE(fd.father_income, u.father_annual_income, u.father_income) as father_income, 
                COALESCE(fd.father_occupation, u.father_occupation, u.father_occ) as father_occ,
                COALESCE(fd.mother_name, u.mother_name) as mother_name, 
                COALESCE(fd.mother_mobile, u.mother_mobile_number, u.mother_mobile) as mother_mobile, 
                COALESCE(fd.mother_income, u.mother_annual_income, u.mother_income) as mother_income, 
                COALESCE(fd.mother_occupation, u.mother_occupation) as mother_occ,
                COALESCE(fd.brothers, u.bro_total, u.brothers) as bro_total, 
                COALESCE(fd.brothers_married, u.bro_married, u.brothers_married_count) as bro_married, 
                COALESCE(fd.brothers_unmarried, u.bro_unmarried, u.brothers_unmarried_count) as bro_unmarried,
                COALESCE(fd.sisters, u.sis_total, u.sisters) as sis_total, 
                COALESCE(fd.sisters_married, u.sis_married, u.sisters_married_count) as sis_married, 
                COALESCE(fd.sisters_unmarried, u.sis_unmarried, u.sisters_unmarried_count) as sis_unmarried,
                COALESCE(wd.occupation_firm, u.occupation_firm) as occupation_firm, 
                COALESCE(wd.occupation_designation, u.occupation_designation) as occupation_designation, 
                COALESCE(wd.annual_income, u.annual_income) as annual_income,
                COALESCE(ad.permanent_address, u.permanent_address) as permanent_address, 
                COALESCE(ad.current_address, u.current_address) as current_address,
                COALESCE(pa.height_cm, u.height_cm) as height_cm, 
                COALESCE(pa.weight_kg, u.weight_kg) as weight_kg, 
                COALESCE(pa.gotra, u.gotra) as gotra, 
                COALESCE(pa.horoscope, u.horoscope) as horoscope, 
                COALESCE(pa.handicapped, u.handicapped) as handicapped,
                COALESCE(pi.payment_upi_id, u.razorpay_payment_id) as razorpay_payment_id,
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
        u.id, 
        CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as candidate_full_name,
        u.email as email_address,
        u.gender,
        u.dob as birth_date,
        e.name as higher_education,
        u.annual_income as candidate_annual_income,
        occ.name as candidate_occupation,
        u.occupation_designation,
        u.permanent_address as native,
        u.birth_place,
        u.gotra,
        u.horoscope,
        u.mobile as mobile_number,
        u.candidate_photo
    FROM users u
    LEFT JOIN educations e ON u.education_id = e.id
    LEFT JOIN occupations occ ON u.occupation_id = occ.id
    ORDER BY u.id ASC 
    LIMIT $limit");

    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/** Alias for simpler calls */
function sathi_user_update_status($id, $status)
{
    return sathi_user_storage_update_status_by_id($id, $status);
}
