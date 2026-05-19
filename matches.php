<?php
/**
 * Discover Verified Profiles - Shadikibaat
 */
require_once __DIR__ . '/helpers/auth_helper.php';
sathi_require_approval(); // Gated access

$pageTitle = "Discover Verified Profiles - ShadikiBaat";
$navActive = 'home';
include 'header.php';
?>

<style>
    :root {
        --match-pink: #f45c93;
        --match-pink-hover: #e64680;
        --match-bg: #fdf2f7;
        --match-text: #1a1a2e;
        --match-muted: #7b7b99;
        --match-border: rgba(244, 92, 147, 0.15);
        --card-radius: 24px;
        --card-shadow: 0 8px 32px rgba(244, 92, 147, 0.10);
        --card-shadow-hover: 0 24px 56px rgba(244, 92, 147, 0.22);
    }

    .matches-page {
        background: linear-gradient(155deg, #fdf2f7 0%, #fce4ee 40%, #f7eaff 100%);
        padding-top: 120px;
        padding-bottom: 100px;
        min-height: 100vh;
    }

    .matches-container {
        max-width: 1340px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ── GRID ── */
    .matches-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        gap: 28px;
    }

    /* ── PREMIUM PROFILE CARD ── */
    .pm-card {
        background: #ffffff;
        border-radius: var(--card-radius);
        box-shadow: var(--card-shadow);
        border: 1px solid var(--match-border);
        overflow: hidden;
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .pm-card:hover {
        transform: translateY(-8px) scale(1.012);
        box-shadow: var(--card-shadow-hover);
    }

    /* image area */
    .pm-card__img-wrap {
        position: relative;
        aspect-ratio: 4 / 4.5;
        overflow: hidden;
        flex-shrink: 0;
    }

    .pm-card__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.55s ease;
    }

    .pm-card:hover .pm-card__img {
        transform: scale(1.07);
    }

    /* gradient overlay at bottom of image */
    .pm-card__img-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(20, 10, 28, 0.72) 0%, transparent 55%);
        pointer-events: none;
    }

    /* favourite heart */
    .pm-card__heart {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.92);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #ccc;
        cursor: pointer;
        z-index: 5;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
        transition: all 0.25s;
        border: none;
    }

    .pm-card__heart:hover {
        background: var(--match-pink);
        color: #fff;
        transform: scale(1.18);
    }

    /* verified badge on image */
    .pm-card__verified {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(46, 204, 113, 0.92);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 4px;
        z-index: 5;
        backdrop-filter: blur(4px);
    }

    /* name + age overlay on image bottom */
    .pm-card__overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 18px 16px 14px;
        z-index: 4;
    }

    .pm-card__name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pm-card__age-loc {
        font-size: 0.78rem;
        color: rgba(255, 255, 255, 0.82);
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .pm-card__dot {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        flex-shrink: 0;
    }

    /* body section */
    .pm-card__body {
        padding: 16px 18px 18px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
    }

    /* name inside body */
    .pm-card__body-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--match-text);
        line-height: 1.25;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* detail rows */
    .pm-card__details {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
    }

    .pm-detail-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        color: #555;
        line-height: 1.3;
    }

    .pm-detail-row i {
        width: 14px;
        font-size: 11px;
        flex-shrink: 0;
        color: var(--match-pink);
    }

    .pm-detail-row i.fa-leaf {
        color: #7c3aed;
    }

    .pm-detail-row i.fa-graduation-cap {
        color: #2c3e50;
    }

    .pm-detail-row i.fa-briefcase {
        color: #d35400;
    }

    .pm-detail-row i.fa-pray {
        color: #e74c3c;
    }

    /* action buttons */
    .pm-card__actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .pm-btn {
        padding: 10px 0;
        border-radius: 12px;
        font-size: 0.82rem;
        font-weight: 700;
        text-align: center;
        cursor: pointer;
        transition: all 0.22s;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
    }

    .pm-btn--outline {
        background: transparent;
        border: 1.5px solid var(--match-pink);
        color: var(--match-pink);
    }

    .pm-btn--outline:hover {
        background: var(--match-pink);
        color: #fff;
        transform: scale(1.03);
        box-shadow: 0 4px 14px rgba(244, 92, 147, 0.28);
    }

    .pm-btn--solid {
        background: linear-gradient(135deg, #f45c93, #ff7ab3);
        color: #fff;
        box-shadow: 0 4px 16px rgba(244, 92, 147, 0.30);
    }

    .pm-btn--solid:hover {
        background: linear-gradient(135deg, #e64680, #f45c93);
        box-shadow: 0 6px 22px rgba(244, 92, 147, 0.45);
        transform: scale(1.03);
    }

    /* no results */
    .pm-empty {
        grid-column: 1/-1;
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: var(--card-radius);
        border: 1px dashed var(--match-border);
    }

    .pm-empty i {
        font-size: 52px;
        color: var(--match-pink);
        margin-bottom: 20px;
        display: block;
    }

    .pm-empty h3 {
        font-size: 1.3rem;
        color: var(--match-text);
        margin-bottom: 8px;
    }

    .pm-empty p {
        color: var(--match-muted);
        font-size: 0.95rem;
    }

    /* ── PAGE TITLE HERO ── */
    .matches-hero {
        text-align: center;
        padding: 0 20px 56px;
        position: relative;
    }

    .matches-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(244, 92, 147, 0.10);
        border: 1px solid rgba(244, 92, 147, 0.25);
        color: var(--match-pink);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 22px;
    }

    .matches-hero__title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.2rem, 5vw, 3.6rem);
        font-weight: 800;
        color: var(--match-text);
        line-height: 1.15;
        margin: 0 0 18px;
    }

    .matches-hero__title span {
        background: linear-gradient(135deg, #f45c93, #c026d3);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .matches-hero__subtitle {
        font-size: 1.05rem;
        color: var(--match-muted);
        max-width: 520px;
        margin: 0 auto;
        line-height: 1.65;
    }

    .matches-hero__divider {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        margin-top: 32px;
    }

    .matches-hero__divider-line {
        width: 60px;
        height: 2px;
        background: linear-gradient(to right, transparent, rgba(244, 92, 147, 0.4));
        border-radius: 2px;
    }

    .matches-hero__divider-line:last-child {
        background: linear-gradient(to left, transparent, rgba(244, 92, 147, 0.4));
    }

    .matches-hero__divider-icon {
        font-size: 1.1rem;
        color: var(--match-pink);
        animation: heartbeat 1.6s ease-in-out infinite;
    }

    @keyframes heartbeat {

        0%,
        100% {
            transform: scale(1);
        }

        25% {
            transform: scale(1.25);
        }

        50% {
            transform: scale(1);
        }

        75% {
            transform: scale(1.15);
        }
    }

    @media (max-width: 640px) {
        .matches-grid {
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .matches-hero__title {
            font-size: 2rem;
        }
    }

    @media (min-width: 641px) and (max-width: 900px) {
        .matches-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Search & Filter Bar Styling */
    .search-filter-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(244, 92, 147, 0.2);
        border-radius: 24px;
        padding: 28px;
        margin-bottom: 45px;
        box-shadow: 0 10px 30px rgba(244, 92, 147, 0.05);
    }
    .search-filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 20px;
        align-items: end;
    }
    .search-input-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .search-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--match-text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .search-label i {
        color: var(--match-pink);
    }
    .search-control {
        width: 100%;
        height: 48px;
        padding: 0 16px;
        border-radius: 12px;
        border: 1.5px solid rgba(244, 92, 147, 0.15);
        background: #fff;
        color: var(--match-text);
        font-size: 0.9rem;
        transition: all 0.25s ease;
        outline: none;
    }
    .search-control:focus {
        border-color: var(--match-pink);
        box-shadow: 0 0 0 4px rgba(244, 92, 147, 0.1);
    }
    .search-btn-group {
        display: flex;
        gap: 12px;
    }
    .search-btn {
        height: 48px;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.25s ease;
        border: none;
        padding: 0 20px;
    }
    .search-btn--submit {
        background: linear-gradient(135deg, #f45c93, #ff7ab3);
        color: #fff;
        flex: 2;
        box-shadow: 0 4px 14px rgba(244, 92, 147, 0.25);
    }
    .search-btn--submit:hover {
        background: linear-gradient(135deg, #e64680, #f45c93);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(244, 92, 147, 0.35);
    }
    .search-btn--clear {
        background: rgba(244, 92, 147, 0.08);
        color: var(--match-pink);
        flex: 1;
        border: 1px solid rgba(244, 92, 147, 0.15);
        text-decoration: none;
    }
    .search-btn--clear:hover {
        background: rgba(244, 92, 147, 0.15);
        transform: translateY(-2px);
    }
    @media (max-width: 768px) {
        .search-filter-grid {
            grid-template-columns: 1fr;
        }
        .search-btn-group {
            width: 100%;
        }
    }
</style>

<div class="matches-page">
    <div class="container">
        <div class="matches-container">

            <!-- PAGE TITLE HERO -->
            <div class="matches-hero">
                <div class="matches-hero__eyebrow">
                    <i class="fas fa-star"></i> Verified Profiles
                </div>
                <h1 class="matches-hero__title">
                    Find Your <span>Perfect Match</span>
                </h1>
                <p class="matches-hero__subtitle">
                    Browse through our curated collection of verified matrimonial profiles.
                    Every profile is carefully reviewed for authenticity and compatibility.
                </p>
                <div class="matches-hero__divider">
                    <div class="matches-hero__divider-line"></div>
                    <i class="fas fa-heart matches-hero__divider-icon"></i>
                    <div class="matches-hero__divider-line"></div>
                </div>
            </div>

            <?php
            // Dynamic Profile Fetching
            require_once __DIR__ . '/config/database.php';
            require_once __DIR__ . '/admin/includes/user-storage.php';
            require_once __DIR__ . '/includes/registration-config.php';

            $db = sathi_db();
            $masters = sathi_registration_masters();

            // Fetch marital statuses for dropdown
            $msRes = $db->query("SELECT id, name FROM marital_statuses ORDER BY id ASC");
            $maritalStatuses = [];
            if ($msRes) {
                while ($msRow = $msRes->fetch_assoc()) {
                    $maritalStatuses[] = $msRow;
                }
            }

            // Get filters
            $search = trim($_GET['search'] ?? '');
            $gender = trim($_GET['gender'] ?? '');
            $marital_status = trim($_GET['marital_status'] ?? '');
            $digamber_jain = trim($_GET['digamber_jain'] ?? '');
            $gotra = trim($_GET['gotra'] ?? '');
            $location = trim($_GET['location'] ?? '');
            ?>

            <!-- SEARCH AND FILTER BAR -->
            <div class="search-filter-card">
                <form method="GET" action="matches.php">
                    <div class="search-filter-grid">
                        
                        <!-- Keyword Search -->
                        <div class="search-input-group">
                            <label class="search-label" for="search-input">
                                <i class="fas fa-search"></i> Keyword Search
                            </label>
                            <input type="text" id="search-input" name="search" class="search-control" placeholder="Name, Gotra, City..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>

                        <!-- Gender -->
                        <div class="search-input-group">
                            <label class="search-label" for="gender-select">
                                <i class="fas fa-venus-mars"></i> Gender
                            </label>
                            <select id="gender-select" name="gender" class="search-control">
                                <option value="">All Genders</option>
                                <option value="male" <?php echo ($gender === 'male' ? 'selected' : ''); ?>>Male</option>
                                <option value="female" <?php echo ($gender === 'female' ? 'selected' : ''); ?>>Female</option>
                            </select>
                        </div>

                        <!-- Marital Status -->
                        <div class="search-input-group">
                            <label class="search-label" for="marital-status-select">
                                <i class="fas fa-heart"></i> Marital Status
                            </label>
                            <select id="marital-status-select" name="marital_status" class="search-control">
                                <option value="">All Statuses</option>
                                <?php foreach ($maritalStatuses as $ms): ?>
                                    <option value="<?php echo $ms['id']; ?>" <?php echo ($marital_status == $ms['id'] ? 'selected' : ''); ?>>
                                        <?php echo htmlspecialchars($ms['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Digamber Jain -->
                        <div class="search-input-group">
                            <label class="search-label" for="digamber-select">
                                <i class="fas fa-om"></i> Digamber Jain
                            </label>
                            <select id="digamber-select" name="digamber_jain" class="search-control">
                                <option value="">All</option>
                                <option value="yes" <?php echo ($digamber_jain === 'yes' ? 'selected' : ''); ?>>Yes</option>
                                <option value="no" <?php echo ($digamber_jain === 'no' ? 'selected' : ''); ?>>No</option>
                            </select>
                        </div>

                        <!-- Gotra -->
                        <div class="search-input-group">
                            <label class="search-label" for="gotra-input">
                                <i class="fas fa-id-card"></i> Gotra
                            </label>
                            <input type="text" id="gotra-input" name="gotra" class="search-control" placeholder="Gotra..." value="<?php echo htmlspecialchars($gotra); ?>">
                        </div>

                        <!-- Location -->
                        <div class="search-input-group">
                            <label class="search-label" for="location-input">
                                <i class="fas fa-map-marker-alt"></i> Location
                            </label>
                            <input type="text" id="location-input" name="location" class="search-control" placeholder="City or State..." value="<?php echo htmlspecialchars($location); ?>">
                        </div>

                        <!-- Actions -->
                        <div class="search-btn-group">
                            <button type="submit" class="search-btn search-btn--submit">
                                <i class="fas fa-filter"></i> Search
                            </button>
                            <a href="matches.php" class="search-btn search-btn--clear">
                                <i class="fas fa-undo"></i> Clear
                            </a>
                        </div>

                    </div>
                </form>
            </div>

            <div class="matches-grid">

                <?php
                // Helper to get label from value
                $getLabel = function ($listName, $value) use ($masters) {
                    if (empty($value))
                        return '—';
                    $list = $masters[$listName] ?? [];
                    // Handle nested geo lists
                    if ($listName === 'cities') {
                        foreach ($masters['geo']['cities'] as $stateCode => $cityList) {
                            foreach ($cityList as $item) {
                                if ($item['value'] == $value)
                                    return $item['label'];
                            }
                        }
                    } elseif ($listName === 'states') {
                        foreach ($masters['geo']['states'] as $countryCode => $stateList) {
                            foreach ($stateList as $item) {
                                if ($item['value'] == $value)
                                    return $item['label'];
                            }
                        }
                    } else {
                        foreach ($list as $item) {
                            if ($item['value'] == $value)
                                return $item['label'];
                        }
                    }
                    return ucfirst(str_replace('_', ' ', (string) $value));
                };

                // Age Calculator
                $calculateAge = function ($dob) {
                    if (empty($dob))
                        return '—';
                    try {
                        $birthDate = new DateTime($dob);
                        $today = new DateTime();
                        return $today->diff($birthDate)->y . ' yrs';
                    } catch (Exception $e) {
                        return '—';
                    }
                };

                // Query approved users with search conditions
                $whereClauses = ["status = 'approved'"];

                if ($gender !== '') {
                    $whereClauses[] = "gender = '" . $db->real_escape_string($gender) . "'";
                }
                if ($marital_status !== '') {
                    $whereClauses[] = "marital_status_id = " . (int)$marital_status;
                }
                if ($digamber_jain !== '') {
                    $whereClauses[] = "digamber_jain = '" . $db->real_escape_string($digamber_jain) . "'";
                }
                if ($gotra !== '') {
                    $whereClauses[] = "gotra LIKE '%" . $db->real_escape_string($gotra) . "%'";
                }
                if ($location !== '') {
                    $locEsc = $db->real_escape_string($location);
                    $whereClauses[] = "(birth_place LIKE '%$locEsc%' OR native_place LIKE '%$locEsc%' OR permanent_address LIKE '%$locEsc%' OR current_address LIKE '%$locEsc%')";
                }
                if ($search !== '') {
                    $searchEsc = $db->real_escape_string($search);
                    $whereClauses[] = "(
                        first_name LIKE '%$searchEsc%' 
                        OR last_name LIKE '%$searchEsc%' 
                        OR gotra LIKE '%$searchEsc%' 
                        OR birth_place LIKE '%$searchEsc%' 
                        OR native_place LIKE '%$searchEsc%' 
                        OR permanent_address LIKE '%$searchEsc%' 
                        OR current_address LIKE '%$searchEsc%'
                        OR profile_id LIKE '%$searchEsc%'
                    )";
                }

                $whereSql = implode(" AND ", $whereClauses);
                $query = "SELECT * FROM users WHERE $whereSql ORDER BY created_at DESC LIMIT 300";
                $queryResult = $db->query($query);

                $rawRows = [];
                if ($queryResult) {
                    while ($row = $queryResult->fetch_assoc()) {
                        $rawRows[] = $row;
                    }
                }
                
                $profiles = [];

                foreach ($rawRows as $r) {
                    $fullName = trim(($r['first_name'] ?? '') . ' ' . ($r['last_name'] ?? ''));
                    if (empty($fullName))
                        $fullName = 'Member ' . ($r['id'] ?? '');

                    // Decode extra details from about_me
                    $extra = [];
                    if (!empty($r['about_me'])) {
                        $extra = json_decode($r['about_me'], true) ?: [];
                    }

                    // Format data for the card and modal
                    $profiles[] = [
                        'id' => $r['id'],
                        'profile_id' => $r['profile_id'] ?? 'N/A',
                        'name' => $fullName,
                        'gender' => ucfirst($r['gender'] ?? 'N/A'),
                        'mobile' => $r['mobile'] ?? 'N/A',
                        'whatsapp' => $r['whatsapp'] ?? 'N/A',
                        'joined' => !empty($r['created_at']) ? date('M j, Y', strtotime($r['created_at'])) : 'N/A',
                        'membership' => ucfirst($r['membership_status'] ?? 'Free'),
                        'payment_id' => $r['razorpay_payment_id'] ?? 'N/A',
                        'age_val' => $calculateAge($r['dob'] ?? ''),
                        'age' => $calculateAge($r['dob'] ?? '') . ' · ' . ($r['religion'] ?? $getLabel('religion', $r['religion_id'] ?? '')),
                        'dob' => $r['dob'] ?? 'N/A',
                        'loc' => $getLabel('cities', $r['city_id'] ?? '') . ', ' . $getLabel('states', $r['state_id'] ?? ''),
                        'edu' => $getLabel('education', $r['education_id'] ?? ''),
                        'job' => $getLabel('occupation', $r['occupation_id'] ?? ''),
                        'religion' => $r['religion'] ?? $getLabel('religion', $r['religion_id'] ?? ''),
                        'mother_tongue' => $r['mother_tongue_val'] ?? $getLabel('mother_tongue', $r['mother_tongue_id'] ?? ''),
                        'marital_status' => $r['marital_status_val'] ?? $getLabel('marital_status', $r['marital_status_id'] ?? ''),
                        'which_temple' => $r['which_temple'] ?? 'N/A',
                        'img' => !empty($r['profile_photo']) 
                            ? (strpos($r['profile_photo'], 'http') === 0 ? $r['profile_photo'] : (file_exists(__DIR__ . '/' . $r['profile_photo']) ? $r['profile_photo'] : ($r['gender'] === 'female' ? 'https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?q=80&w=1000' : 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=1000')))
                            : ($r['gender'] === 'female'
                                ? 'https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?q=80&w=1000'
                                : 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=1000'),

                        // Extra Details directly from row
                        'digamber' => strtoupper($r['digamber_jain'] ?? 'NO'),
                        'birth_time' => $r['birth_time'] ?? 'N/A',
                        'birth_place' => $r['birth_place'] ?? 'N/A',
                        'star' => $r['star'] ?? 'N/A',
                        'rasi' => $r['rasi'] ?? 'N/A',
                        'dosh' => $r['dosh'] ?? 'N/A',
                        'native_place' => !empty($r['native_place']) ? $r['native_place'] : (($r['native_city'] ?? '') . ', ' . ($r['native_state'] ?? '') . ', ' . ($r['native_country'] ?? '')),
                        'gotra' => $r['gotra'] ?? $getLabel('gotra', $r['caste_id'] ?? ''),

                        // Family
                        'father_name' => $r['father_name'] ?? 'N/A',
                        'father_mobile' => $r['father_mobile'] ?? 'N/A',
                        'father_income' => $r['father_income'] ?? 'N/A',
                        'mother_name' => $r['mother_name'] ?? 'N/A',
                        'bro_total' => $r['bro_total'] ?? 0,
                        'bro_married' => $r['bro_married'] ?? 0,
                        'sis_total' => $r['sis_total'] ?? 0,
                        'sis_married' => $r['sis_married'] ?? 0,
                        'about_text' => $r['about_me'] ?? 'N/A',
                        'relatives' => $r['relative_details'] ?? 'N/A'
                    ];
                }

                if (empty($profiles)): ?>
                    <div class="pm-empty">
                        <i class="fas fa-heart-broken"></i>
                        <h3>No matches found yet</h3>
                        <p>We're verifying new profiles. Please check back shortly!</p>
                    </div>
                <?php endif; ?>

                <?php foreach ($profiles as $p): ?>
                    <div class="pm-card">

                        <!-- Image -->
                        <div class="pm-card__img-wrap">
                            <img class="pm-card__img" src="<?php echo htmlspecialchars($p['img']); ?>"
                                alt="<?php echo htmlspecialchars($p['name']); ?>" loading="lazy">
                        </div>

                        <!-- Body -->
                        <div class="pm-card__body">

                            <!-- Name only -->
                            <div class="pm-card__body-name"><?php echo htmlspecialchars($p['name']); ?></div>

                            <!-- Actions -->
                            <div class="pm-card__actions">
                                <a href="view-profile.php?id=<?php echo $p['id']; ?>" class="pm-btn pm-btn--outline">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button class="pm-btn pm-btn--solid"
                                    onclick="openActionModal('interest', '<?php echo rawurlencode(json_encode(['id' => $p['id'], 'name' => $p['name']])); ?>')">
                                    <i class="fas fa-heart"></i> Interest
                                </button>
                            </div>

                        </div><!-- /.pm-card__body -->
                    </div><!-- /.pm-card -->
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>