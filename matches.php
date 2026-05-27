<?php
/**
 * Matches Page - Premium Matrimo Design
 * Sathi Matrimonial Platform
 */
require_once __DIR__ . '/helpers/auth_helper.php';
sathi_require_approval();

$pageTitle = "Matches - Find Your Perfect Match";
$navActive = 'matches';

// Include site header (navbar + head)
include 'header.php';

// Fetch data needed for filters
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/admin/includes/user-storage.php';
require_once __DIR__ . '/includes/registration-config.php';

$db = sathi_db();
$masters = sathi_registration_masters();

// Fetch marital statuses
$msRes = $db->query("SELECT id, name FROM marital_statuses ORDER BY id ASC");
$maritalStatuses = [];
if ($msRes) { while ($msRow = $msRes->fetch_assoc()) { $maritalStatuses[] = $msRow; } }

// Fetch occupations
$occRes = $db->query("SELECT id, name FROM occupations ORDER BY name ASC");
$occupationsList = [];
if ($occRes) { while ($occRow = $occRes->fetch_assoc()) { $occupationsList[] = $occRow; } }

// Get ALL filters from GET params
$search = trim($_GET['search'] ?? '');
$gender = trim($_GET['gender'] ?? '');
$marital_status = trim($_GET['marital_status'] ?? '');
$digamber_jain = trim($_GET['digamber_jain'] ?? '');
$gotra = trim($_GET['gotra'] ?? '');
$location = trim($_GET['location'] ?? '');
$occupation_filter = trim($_GET['occupation'] ?? '');
$education_filter = trim($_GET['education'] ?? '');
$age_max = trim($_GET['age_max'] ?? '32');
$height_filter = trim($_GET['height'] ?? '');
$weight_filter = trim($_GET['weight'] ?? '');

// Helper to get label from value
$getLabel = function ($listName, $value) use ($masters) {
    if (empty($value)) return '—';
    $list = $masters[$listName] ?? [];
    if ($listName === 'cities') {
        foreach ($masters['geo']['cities'] as $stateCode => $cityList) {
            foreach ($cityList as $item) { if ($item['value'] == $value) return $item['label']; }
        }
    } elseif ($listName === 'states') {
        foreach ($masters['geo']['states'] as $countryCode => $stateList) {
            foreach ($stateList as $item) { if ($item['value'] == $value) return $item['label']; }
        }
    } else {
        foreach ($list as $item) { if ($item['value'] == $value) return $item['label']; }
    }
    return ucfirst(str_replace('_', ' ', (string) $value));
};

// Age Calculator
$calculateAge = function ($dob) {
    if (empty($dob)) return '—';
    try {
        $birthDate = new DateTime($dob);
        $today = new DateTime();
        return $today->diff($birthDate)->y;
    } catch (Exception $e) { return '—'; }
};

// Build query with ALL working filters
$whereClauses = ["u.status = 'approved'"];

if ($gender !== '') {
    $whereClauses[] = "u.gender = '" . $db->real_escape_string($gender) . "'";
}
if ($marital_status !== '') {
    $whereClauses[] = "u.marital_status_id = " . (int)$marital_status;
}
if ($digamber_jain !== '') {
    $whereClauses[] = "c.are_you_digamber_jain = '" . $db->real_escape_string($digamber_jain) . "'";
}
if ($gotra !== '') {
    $gotEsc = $db->real_escape_string($gotra);
    $whereClauses[] = "(u.gotra LIKE '%$gotEsc%' OR c.gotra LIKE '%$gotEsc%')";
}
if ($occupation_filter !== '') {
    $whereClauses[] = "u.occupation_id = " . (int)$occupation_filter;
}
if ($education_filter !== '') {
    $whereClauses[] = "u.education_id = " . (int)$education_filter;
}
if ($location !== '') {
    $locEsc = $db->real_escape_string($location);
    $whereClauses[] = "(u.birth_place LIKE '%$locEsc%' OR u.native_place LIKE '%$locEsc%' OR u.permanent_address LIKE '%$locEsc%' OR u.current_address LIKE '%$locEsc%' OR c.birth_place LIKE '%$locEsc%' OR c.native LIKE '%$locEsc%' OR c.permanent_address LIKE '%$locEsc%' OR c.candidate_current_address LIKE '%$locEsc%')";
}
if ($search !== '') {
    $searchEsc = $db->real_escape_string($search);
    $whereClauses[] = "(u.first_name LIKE '%$searchEsc%' OR u.last_name LIKE '%$searchEsc%' OR u.gotra LIKE '%$searchEsc%' OR c.gotra LIKE '%$searchEsc%' OR u.profile_id LIKE '%$searchEsc%')";
}

// Age filter (based on DOB)
if ($age_max !== '' && is_numeric($age_max)) {
    $minDob = date('Y-m-d', strtotime("-{$age_max} years"));
    $whereClauses[] = "u.dob >= '$minDob'";
}

// Height filter (cm)
if ($height_filter !== '' && is_numeric($height_filter)) {
    $whereClauses[] = "u.height_cm = " . (int)$height_filter;
}

// Weight filter (kg)
if ($weight_filter !== '' && is_numeric($weight_filter)) {
    $whereClauses[] = "u.weight_kg = " . (int)$weight_filter;
}

$whereSql = implode(" AND ", $whereClauses);
$query = "SELECT u.*, 
                COALESCE(occ.name, c.candidate_occupation) as occupation_val,
                c.birth_place as fallback_city,
                c.candidate_current_address as fallback_address
          FROM users u
          LEFT JOIN candidates c ON u.email = c.email_address COLLATE utf8mb4_unicode_ci
          LEFT JOIN occupations occ ON u.occupation_id = occ.id
          WHERE $whereSql ORDER BY u.created_at DESC LIMIT 300";
$queryResult = $db->query($query);

$rawRows = [];
if ($queryResult) { while ($row = $queryResult->fetch_assoc()) { $rawRows[] = $row; } }

// Fetch educations for dropdown
$eduRes = $db->query("SELECT id, name FROM educations WHERE status = 'active' ORDER BY name ASC");
$educationsList = [];
if ($eduRes) { while ($eduRow = $eduRes->fetch_assoc()) { $educationsList[] = $eduRow; } }

$profiles = [];
foreach ($rawRows as $r) {
    $fullName = trim(($r['first_name'] ?? '') . ' ' . ($r['last_name'] ?? ''));
    if (empty($fullName)) $fullName = 'Member ' . ($r['id'] ?? '');

    $city = $getLabel('cities', $r['city_id'] ?? '');
    $locParts = [];
    if (!empty($city) && $city !== '—') {
        $locParts[] = $city;
        $locParts[] = 'India';
    }
    
    if (empty($locParts)) {
        if (!empty($r['fallback_city'])) {
            $fcity = trim($r['fallback_city']);
            if (strpos($fcity, ',') !== false) {
                $parts = array_map('trim', explode(',', $fcity));
                $locParts[] = $parts[0];
            } else {
                $locParts[] = $fcity;
            }
            $locParts[] = 'India';
        } elseif (!empty($r['fallback_address'])) {
            $parts = array_map('trim', explode(',', $r['fallback_address']));
            $c = count($parts);
            if ($c >= 3) {
                $locParts[] = $parts[$c-3];
                $locParts[] = $parts[$c-1];
            } elseif ($c == 2) {
                $locParts = $parts;
            } else {
                $locParts[] = $r['fallback_address'];
            }
        }
    }
    $locStr = implode(', ', $locParts);

    $job = !empty($r['occupation_val']) ? $r['occupation_val'] : $getLabel('occupation', $r['occupation_id'] ?? '');
    $age = $calculateAge($r['dob'] ?? '');
    $metaParts = [];
    if (!empty($age) && $age !== '—') $metaParts[] = $age;
    if (!empty($job) && $job !== '—') $metaParts[] = $job;
    $metaStr = implode(' · ', $metaParts);

    $profiles[] = [
        'id' => $r['id'],
        'profile_id' => $r['profile_id'] ?? 'N/A',
        'name' => $fullName,
        'img' => !empty($r['profile_photo'])
            ? (strpos($r['profile_photo'], 'http') === 0
                ? $r['profile_photo']
                : (file_exists(__DIR__ . '/uploads/profiles/' . $r['profile_photo'])
                    ? 'uploads/profiles/' . $r['profile_photo']
                    : 'https://ui-avatars.com/api/?name=' . urlencode($fullName) . '&background=c02d4d&color=fff&size=500'))
            : 'https://ui-avatars.com/api/?name=' . urlencode($fullName) . '&background=c02d4d&color=fff&size=500',
        'metaStr' => $metaStr,
        'locStr'  => htmlspecialchars($locStr),
    ];
}
$totalMatches = count($profiles);
?>

<style>
    /* ─── Matches Page Variables ─── */
    :root {
        --m-bg-cream: #fdf6f6;
        --m-bg-blush: #f7e9ea;
        --m-rose-dark: #c02d4d;
        --m-rose-medium: #d4445e;
        --m-rose-light: #f0d0d5;
        --m-rose-ultra-light: #fdf0f2;
        --m-text-dark: #1a1a2e;
        --m-text-body: #4a4a5a;
        --m-text-muted: #8e8ea0;
        --m-text-light: #b0b0c0;
        --m-shadow-card: 0 4px 24px rgba(192,45,77,0.06);
        --m-shadow-card-hover: 0 12px 48px rgba(192,45,77,0.12);
        --m-radius-sm: 12px;
        --m-radius-lg: 24px;
        --m-radius-xl: 28px;
        --m-font-sans: 'Inter', 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        --m-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .matches-page-wrap {
        background: var(--m-bg-cream);
        min-height: 100vh;
        padding-bottom: 60px;
    }

    /* ─── HERO BANNER ─── */
    .matri-hero {
        max-width: 1440px;
        margin: 28px auto 0;
        padding: 0 40px;
    }
    .matri-hero-banner {
        width: 100%;
        border-radius: var(--m-radius-xl);
        overflow: hidden;
        box-shadow: 0 4px 30px rgba(192,45,77,0.06);
    }
    .matri-hero-banner img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    /* ─── MAIN CONTENT LAYOUT ─── */
    .matri-content {
        max-width: 1440px;
        margin: 32px auto 0;
        padding: 0 40px;
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 28px;
        align-items: start;
    }

    /* ─── FILTER SIDEBAR ─── */
    .matri-sidebar { position: sticky; top: 108px; }
    .matri-filter-card {
        background: #fff;
        border-radius: var(--m-radius-lg);
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 28px 24px;
        border: 1px solid rgba(0,0,0,0.04);
    }
    .matri-filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }
    .matri-filter-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--m-text-dark);
    }
    .matri-filter-reset {
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--m-rose-dark);
        cursor: pointer;
        text-decoration: none;
        transition: var(--m-transition);
    }
    .matri-filter-reset:hover { opacity: 0.7; }
    .matri-filter-section { margin-bottom: 6px; }
    .matri-filter-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        cursor: pointer;
        border-top: 1px solid rgba(0,0,0,0.05);
        user-select: none;
    }
    .matri-filter-section:first-of-type .matri-filter-section-header { border-top: none; }
    .matri-filter-section-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--m-text-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .matri-filter-section-arrow {
        font-size: 12px;
        color: var(--m-text-muted);
        transition: transform 0.3s ease;
    }
    .matri-filter-section.collapsed .matri-filter-section-arrow { transform: rotate(180deg); }
    .matri-filter-section.collapsed .matri-filter-section-body { display: none; }
    .matri-filter-section-body { padding: 8px 0 16px; }
    .matri-filter-group { margin-bottom: 18px; }
    .matri-filter-group:last-child { margin-bottom: 0; }
    .matri-filter-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--m-text-dark);
        margin-bottom: 8px;
        display: block;
    }
    .matri-range-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--m-text-dark);
        margin-bottom: 6px;
    }
    .matri-range-slider {
        width: 100%;
        -webkit-appearance: none;
        appearance: none;
        height: 4px;
        background: var(--m-rose-light);
        border-radius: 4px;
        outline: none;
        cursor: pointer;
    }
    .matri-range-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px; height: 18px;
        border-radius: 50%;
        background: var(--m-rose-dark);
        cursor: pointer;
        border: 3px solid #fff;
        box-shadow: 0 1px 6px rgba(192,45,77,0.3);
    }
    .matri-range-slider::-moz-range-thumb {
        width: 18px; height: 18px;
        border-radius: 50%;
        background: var(--m-rose-dark);
        cursor: pointer;
        border: 3px solid #fff;
        box-shadow: 0 1px 6px rgba(192,45,77,0.3);
    }
    .matri-filter-input {
        width: 100%;
        height: 42px;
        padding: 0 14px;
        border-radius: 10px;
        border: 1.5px solid rgba(0,0,0,0.08);
        background: var(--m-bg-cream);
        color: var(--m-text-dark);
        font-family: var(--m-font-sans);
        font-size: 0.85rem;
        transition: var(--m-transition);
        outline: none;
    }
    .matri-filter-input:focus {
        border-color: var(--m-rose-dark);
        box-shadow: 0 0 0 3px rgba(192,45,77,0.08);
        background: #fff;
    }
    .matri-filter-input::placeholder { color: var(--m-text-light); }
    select.matri-filter-input {
        cursor: pointer;
        -webkit-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238e8ea0' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
    }
    .matri-filter-buttons {
        margin-top: 24px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .matri-btn-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        height: 48px;
        border: none;
        border-radius: var(--m-radius-sm);
        background: linear-gradient(135deg, var(--m-rose-dark), #d4445e);
        color: #fff;
        font-family: var(--m-font-sans);
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--m-transition);
        box-shadow: 0 4px 16px rgba(192,45,77,0.25);
    }
    .matri-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(192,45,77,0.35);
    }
    .matri-btn-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        height: 42px;
        border: none;
        border-radius: var(--m-radius-sm);
        background: transparent;
        color: var(--m-rose-dark);
        font-family: var(--m-font-sans);
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--m-transition);
    }
    .matri-btn-secondary:hover { background: var(--m-rose-ultra-light); }

    /* ─── RIGHT CONTENT AREA ─── */
    .matri-main { min-width: 0; }
    .matri-top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .matri-matches-count { font-size: 1rem; font-weight: 600; color: var(--m-text-dark); }
    .matri-matches-count span { color: var(--m-rose-dark); }
    .matri-top-bar-right { display: flex; align-items: center; gap: 16px; }
    .matri-sort { display: flex; align-items: center; gap: 6px; font-size: 0.85rem; color: var(--m-text-muted); }
    .matri-sort-label { font-weight: 400; }
    .matri-sort-value {
        font-weight: 600;
        color: var(--m-text-dark);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .matri-view-toggle { display: flex; gap: 4px; }
    .matri-view-btn {
        width: 36px; height: 36px;
        border-radius: 8px;
        border: 1px solid rgba(0,0,0,0.08);
        background: #fff;
        color: var(--m-text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        transition: var(--m-transition);
    }
    .matri-view-btn.active { background: var(--m-rose-dark); border-color: var(--m-rose-dark); color: #fff; }
    .matri-view-btn:hover:not(.active) { background: var(--m-rose-ultra-light); color: var(--m-rose-dark); }

    /* ─── PROFILE CARDS GRID ─── */
    .matri-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .matri-card {
        background: #fff;
        border-radius: 22px;
        box-shadow: var(--m-shadow-card);
        overflow: hidden;
        transition: var(--m-transition);
        border: 1px solid rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
    }
    .matri-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--m-shadow-card-hover);
    }
    .matri-card-img {
        position: relative;
        height: 300px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .matri-card-img img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .matri-card:hover .matri-card-img img { transform: scale(1.05); }

    /* Card body */
    .matri-card-body {
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .matri-card-name-row {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }
    .matri-card-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--m-text-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .matri-card-verified { width: 18px; height: 18px; flex-shrink: 0; }
    .matri-card-meta {
        font-size: 0.82rem;
        color: var(--m-text-muted);
        margin-bottom: 4px;
    }
    .matri-card-location {
        font-size: 0.82rem;
        color: var(--m-text-muted);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .matri-card-location i { font-size: 11px; color: var(--m-text-light); }

    /* Card actions — View Profile + Heart button */
    .matri-card-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: auto;
    }
    .matri-btn-view {
        flex: 1;
        height: 42px;
        border: 1.5px solid var(--m-rose-dark);
        background: transparent;
        color: var(--m-rose-dark);
        border-radius: 22px;
        font-family: var(--m-font-sans);
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--m-transition);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .matri-btn-view:hover { background: var(--m-rose-dark); color: #fff; }

    /* Heart button — now in the actions row */
    .matri-btn-heart {
        width: 42px; height: 42px;
        border-radius: 50%;
        border: none;
        background: var(--m-rose-dark);
        color: #fff;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--m-transition);
        flex-shrink: 0;
    }
    .matri-btn-heart:hover {
        background: #a82540;
        transform: scale(1.08);
    }
    .matri-btn-heart.liked {
        background: #e74c6f;
    }

    /* ─── EMPTY STATE ─── */
    .matri-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 32px;
        background: #fff;
        border-radius: 22px;
        border: 2px dashed var(--m-rose-light);
    }
    .matri-empty i { font-size: 56px; color: var(--m-rose-light); margin-bottom: 20px; display: block; }
    .matri-empty h3 { font-size: 1.3rem; font-weight: 700; color: var(--m-text-dark); margin-bottom: 8px; }
    .matri-empty p { color: var(--m-text-muted); font-size: 0.95rem; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1200px) { .matri-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 1024px) {
        .matri-content { grid-template-columns: 1fr; }
        .matri-sidebar { position: static; }
    }
    @media (max-width: 768px) {
        .matri-hero { padding: 0 20px; margin-top: 16px; }
        .matri-content { padding: 0 20px; }
        .matri-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) { .matri-card-img { height: 240px; } }
</style>

<!-- ═══════════════ PAGE CONTENT ═══════════════ -->
<div class="matches-page-wrap">

    <!-- ═══════════════ HERO BANNER ═══════════════ -->
    <section class="matri-hero">
        <div class="matri-hero-banner">
            <img src="assets/ChatGPT Image May 27, 2026, 11_12_50 AM.png" alt="Find your perfect match — Handpicked matches just for you">
        </div>
    </section>

    <!-- ═══════════════ MAIN CONTENT ═══════════════ -->
    <main class="matri-content">

        <!-- ─── LEFT SIDEBAR FILTERS ─── -->
        <aside class="matri-sidebar">
            <form method="GET" action="matches.php" class="matri-filter-card">
                <div class="matri-filter-header">
                    <h2 class="matri-filter-title">Filter Matches</h2>
                    <a href="matches.php" class="matri-filter-reset">Reset</a>
                </div>

                <!-- Basics Section -->
                <div class="matri-filter-section" id="filterBasics">
                    <div class="matri-filter-section-header" onclick="toggleSection('filterBasics')">
                        <span class="matri-filter-section-title">Basics</span>
                        <i class="fas fa-chevron-up matri-filter-section-arrow"></i>
                    </div>
                    <div class="matri-filter-section-body">

                        <!-- Age Slider -->
                        <div class="matri-filter-group">
                            <label class="matri-filter-label">Age (up to <span id="ageMaxVal"><?php echo htmlspecialchars($age_max); ?></span> yrs)</label>
                            <input type="range" class="matri-range-slider" name="age_max" min="18" max="60" value="<?php echo htmlspecialchars($age_max); ?>" id="ageSlider" oninput="document.getElementById('ageMaxVal').textContent=this.value">
                        </div>

                        <!-- Height (Single Select: 4 ft to 7 ft 12 in) -->
                        <div class="matri-filter-group">
                            <label class="matri-filter-label">Height</label>
                            <select class="matri-filter-input" name="height">
                                <option value="">Select Height</option>
                                <?php
                                for ($ft = 4; $ft <= 7; $ft++) {
                                    $maxIn = ($ft == 7) ? 12 : 11;
                                    for ($in = 0; $in <= $maxIn; $in++) {
                                        $cm = round(($ft * 12 + $in) * 2.54);
                                        $sel = ($height_filter == $cm) ? 'selected' : '';
                                        echo "<option value=\"$cm\" $sel>{$ft}'{$in}\"</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Weight (Single Select: 35 kg to 150 kg) -->
                        <div class="matri-filter-group">
                            <label class="matri-filter-label">Weight</label>
                            <select class="matri-filter-input" name="weight">
                                <option value="">Select Weight</option>
                                <?php for ($w = 35; $w <= 130; $w++): ?>
                                    <option value="<?php echo $w; ?>" <?php echo ($weight_filter == $w ? 'selected' : ''); ?>><?php echo $w; ?> kg</option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Location -->
                        <div class="matri-filter-group">
                            <label class="matri-filter-label">Location</label>
                            <input type="text" class="matri-filter-input" name="location" placeholder="Enter city or state" value="<?php echo htmlspecialchars($location); ?>">
                        </div>

                        <!-- Education -->
                        <div class="matri-filter-group">
                            <label class="matri-filter-label">Education</label>
                            <select class="matri-filter-input" name="education">
                                <option value="">Select education</option>
                                <?php foreach ($educationsList as $edu): ?>
                                    <option value="<?php echo $edu['id']; ?>" <?php echo ($education_filter == $edu['id'] ? 'selected' : ''); ?>>
                                        <?php echo htmlspecialchars($edu['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Profession -->
                        <div class="matri-filter-group">
                            <label class="matri-filter-label">Profession</label>
                            <select class="matri-filter-input" name="occupation">
                                <option value="">Select profession</option>
                                <?php foreach ($occupationsList as $occ): ?>
                                    <option value="<?php echo $occ['id']; ?>" <?php echo ($occupation_filter == $occ['id'] ? 'selected' : ''); ?>>
                                        <?php echo htmlspecialchars($occ['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Buttons -->
                <div class="matri-filter-buttons">
                    <button type="submit" class="matri-btn-primary">
                        Show Matches (<?php echo $totalMatches; ?>)
                    </button>
                    <button type="button" class="matri-btn-secondary" onclick="alert('Preferences saved!')">
                        <i class="far fa-heart"></i> Save Preferences
                    </button>
                </div>
            </form>
        </aside>

        <!-- ─── RIGHT CONTENT AREA ─── -->
        <div class="matri-main">

            <!-- Top Bar -->
            <div class="matri-top-bar">
                <div class="matri-matches-count">
                    <span><?php echo $totalMatches; ?></span> Matches Found
                </div>
                <div class="matri-top-bar-right">
                    <div class="matri-sort">
                        <span class="matri-sort-label">Sort by:</span>
                        <span class="matri-sort-value">Recommended <i class="fas fa-chevron-down" style="font-size:10px"></i></span>
                    </div>
                    <div class="matri-view-toggle">
                        <button class="matri-view-btn active" aria-label="Grid view"><i class="fas fa-th-large"></i></button>
                        <button class="matri-view-btn" aria-label="List view"><i class="fas fa-list"></i></button>
                    </div>
                </div>
            </div>

            <!-- Profile Cards Grid -->
            <div class="matri-grid" id="matchesGrid">

                <?php if (empty($profiles)):
                    $demoProfiles = [
                        ['name'=>'Ananya Sharma','age'=>27,'job'=>'Software Engineer','loc'=>'Delhi, India','img'=>'assets/images/match_ananya.png','new'=>true],
                        ['name'=>'Rohan Mehta','age'=>29,'job'=>'Product Manager','loc'=>'Mumbai, India','img'=>'assets/images/match_rohan.png','new'=>true],
                        ['name'=>'Meera Iyer','age'=>26,'job'=>'Architect','loc'=>'Bangalore, India','img'=>'assets/images/match_meera.png','new'=>false],
                        ['name'=>'Arjun Nair','age'=>28,'job'=>'Business Analyst','loc'=>'Pune, India','img'=>'assets/images/match_arjun.png','new'=>false],
                        ['name'=>'Priya Menon','age'=>25,'job'=>'HR Manager','loc'=>'Kochi, India','img'=>'assets/images/match_priya.png','new'=>false],
                        ['name'=>'Vikram Rao','age'=>30,'job'=>'Consultant','loc'=>'Hyderabad, India','img'=>'assets/images/match_vikram.png','new'=>false],
                    ];
                    foreach ($demoProfiles as $dp): ?>
                        <div class="matri-card">
                            <div class="matri-card-img">
                                <img src="<?php echo $dp['img']; ?>" alt="<?php echo $dp['name']; ?>" loading="lazy">
                            </div>
                            <div class="matri-card-body">
                                <div class="matri-card-name-row">
                                    <span class="matri-card-name"><?php echo $dp['name']; ?></span>
                                    <svg class="matri-card-verified" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#22c55e"/><path d="M8 12l3 3 5-5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div class="matri-card-meta"><?php echo $dp['age']; ?> · <?php echo $dp['job']; ?></div>
                                <div class="matri-card-location"><i class="fas fa-map-marker-alt"></i> <?php echo $dp['loc']; ?></div>
                                <div class="matri-card-actions">
                                    <a href="#" class="matri-btn-view">View Profile</a>
                                    <button class="matri-btn-heart" aria-label="Like"><i class="far fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <?php foreach ($profiles as $i => $p): ?>
                        <div class="matri-card">
                            <div class="matri-card-img">
                                <img src="<?php echo htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" loading="lazy">
                            </div>
                            <div class="matri-card-body">
                                <div class="matri-card-name-row">
                                    <span class="matri-card-name"><?php echo htmlspecialchars($p['name']); ?></span>
                                    <svg class="matri-card-verified" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#22c55e"/><path d="M8 12l3 3 5-5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <?php if (!empty($p['metaStr'])): ?>
                                    <div class="matri-card-meta"><?php echo $p['metaStr']; ?></div>
                                <?php endif; ?>
                                <?php if (!empty($p['locStr'])): ?>
                                    <div class="matri-card-location"><i class="fas fa-map-marker-alt"></i> <?php echo $p['locStr']; ?></div>
                                <?php endif; ?>
                                <div class="matri-card-actions">
                                    <a href="view-profile.php?id=<?php echo $p['id']; ?>" class="matri-btn-view">View Profile</a>
                                    <button class="matri-btn-heart" aria-label="Like"><i class="far fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>

    </main>

</div><!-- /.matches-page-wrap -->

<script>
    // Toggle filter sections
    function toggleSection(id) {
        document.getElementById(id).classList.toggle('collapsed');
    }

    // Heart toggle
    document.querySelectorAll('.matri-btn-heart').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('liked');
            const icon = this.querySelector('i');
            if (this.classList.contains('liked')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.style.transform = 'scale(1.2)';
                setTimeout(() => this.style.transform = '', 200);
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
            }
        });
    });

    // View toggle
    document.querySelectorAll('.matri-view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.matri-view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Animate cards on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.matri-card').forEach((card, i) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.5s ease ${i * 0.08}s, transform 0.5s ease ${i * 0.08}s`;
        observer.observe(card);
    });
</script>

<?php include 'footer.php'; ?>