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
        --match-bg: #ffe4ee;
        --match-text: #333;
        --match-muted: #666;
        --match-border: #eee;
    }

    .matches-page {
        background: var(--match-bg);
        padding-top: 120px;
        padding-bottom: 80px;
        min-height: 100vh;
    }

    .matches-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .matches-header h1 {
        font-size: 2.2rem;
        color: var(--match-text);
        margin-bottom: 5px;
    }

    .matches-header p {
        color: var(--match-muted);
        font-size: 1rem;
    }

    .matches-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .matches-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    @media (max-width: 640px) {
        .matches-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="matches-page">
    <div class="container">
        <div class="matches-container">

            <!-- FEATURED MATCHES HEADER -->
            <div class="featured-header fade-up" style="margin-bottom: 45px;">
                <div>
                    <div class="section-label"
                        style="font-size: 0.85rem; font-weight: 700; color: var(--match-pink); letter-spacing: 2px; margin-bottom: 12px;">
                        FEATURED MATCHES ——</div>
                    <h2
                        style="font-size: 2.6rem; font-family: 'Playfair Display', serif; color: #000; line-height: 1.2; margin: 0;">
                        Discover verified profiles that<br>match your preferences</h2>
                </div>
            </div>

            <div class="matches-grid">

                <?php
                // Dynamic Profile Fetching
                require_once __DIR__ . '/includes/registration-config.php';
                $masters = sathi_registration_masters();

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

                // Fetch Approved Users
                $rawRows = sathi_users_list_by_status('approved', 50);
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
                        'img' => !empty($r['profile_photo']) && file_exists(__DIR__ . '/' . $r['profile_photo'])
                            ? $r['profile_photo']
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
                        'native_place' => ($r['native_city'] ?? '') . ', ' . ($r['native_state'] ?? '') . ', ' . ($r['native_country'] ?? ''),
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
                    <div class="no-results"
                        style="grid-column: 1/-1; text-align: center; padding: 40px; background: white; border-radius: 20px;">
                        <i class="fas fa-search"
                            style="font-size: 48px; color: var(--match-pink); margin-bottom: 20px;"></i>
                        <h3>No matches found yet</h3>
                        <p>We're verifying new profiles. Please check back shortly!</p>
                    </div>
                <?php endif; ?>

                <?php foreach ($profiles as $p): ?>
                    <div class="profile-card">
                        <div class="profile-img-wrap">
                            <div class="profile-favorite"><i class="far fa-heart"></i></div>
                            <img src="<?php echo $p['img']; ?>" alt="<?php echo $p['name']; ?>">
                        </div>
                        <div class="profile-name">
                            <?php echo $p['name']; ?>
                            <span class="verified-tag"><i class="fas fa-check-circle"></i> Verified</span>
                        </div>
                        <div class="profile-meta-main"><?php echo $p['age']; ?></div>

                        <div class="profile-details-list">
                            <div class="profile-detail-item">
                                <i class="fas fa-map-marker-alt"></i> <?php echo $p['loc']; ?>
                            </div>
                            <div class="profile-detail-item">
                                <i class="fas fa-leaf"></i> Gotra: <?php echo $p['gotra']; ?>
                            </div>
                            <div class="profile-detail-item">
                                <i class="fas fa-graduation-cap"></i> <?php echo $p['edu']; ?>
                            </div>
                            <div class="profile-detail-item">
                                <i class="fas fa-briefcase"></i> <?php echo $p['job']; ?>
                            </div>
                        </div>

                        <div class="profile-actions">
                            <a href="view-profile.php?id=<?php echo $p['id']; ?>" class="btn-action btn-view-outline" style="text-decoration:none; display:flex; align-items:center; justify-content:center;">View</a>
                            <button class="btn-action btn-interest-solid"
                                onclick="openActionModal('interest', '<?php echo rawurlencode(json_encode(['id' => $p['id'], 'name' => $p['name']])); ?>')">Interest</button>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>