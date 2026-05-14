<?php
declare(strict_types=1);
require_once __DIR__ . '/helpers/auth_helper.php';
sathi_require_approval();
require_once __DIR__ . '/includes/registration-config.php';
$masters = sathi_registration_masters();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$member = $id > 0 ? sathi_user_repo_find_by_id($id) : null;

// Allow viewing if approved. Also could allow if it's the currently logged-in user viewing their own profile, but we'll stick to approved for public matching.
if (!$member || strtolower((string) $member['status']) !== 'approved') {
    $pageTitle = "Profile Not Found";
    require __DIR__ . '/header.php';
    echo "<div class='container' style='padding: 120px 0 80px; text-align: center; min-height: 60vh;'>";
    echo "<i class='fas fa-user-slash' style='font-size: 60px; color: #ccc; margin-bottom: 20px;'></i>";
    echo "<h2>Profile not found</h2>";
    echo "<p style='color:#666;'>This profile may have been removed or is not yet approved.</p>";
    echo "<a href='matches.php' class='btn-primary' style='display:inline-block; margin-top: 20px; padding: 10px 25px; border-radius: 25px; text-decoration: none; background: var(--match-pink); color: white;'>Back to Matches</a>";
    echo "</div>";
    require __DIR__ . '/footer.php';
    exit;
}

$pageTitle = htmlspecialchars((string) $member['name']) . " | ShadikiBaat";
require __DIR__ . '/header.php';

// Helper for labels
$getLabel = function ($type, $value) use ($siteConfig) {
    if (empty($value))
        return 'N/A';
    if (!isset($siteConfig[$type]))
        return ucfirst(str_replace('_', ' ', (string) $value));
    foreach ($siteConfig[$type] as $opt) {
        if ((string) $opt['value'] === (string) $value) {
            return $opt['label'];
        }
    }
    return ucfirst(str_replace('_', ' ', (string) $value));
};

// Calculate age
$dob = $member['dob'] ?? '';
$ageStr = '—';
if (!empty($dob)) {
    try {
        $bd = new DateTime($dob);
        $ageStr = (new DateTime())->diff($bd)->y . ' yrs';
    } catch (Exception $e) {
    }
}

$img = !empty($member['profile_photo']) && file_exists(__DIR__ . '/' . $member['profile_photo'])
    ? $member['profile_photo']
    : ($member['gender'] === 'female'
        ? 'https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?q=80&w=1000'
        : 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=1000');

// All fields
$name = htmlspecialchars((string) $member['name'], ENT_QUOTES, 'UTF-8');
$gender = ucfirst($member['gender'] ?? 'N/A');
$joined = !empty($member['created_at']) ? date('M j, Y', strtotime($member['created_at'])) : 'N/A';
$mobile = htmlspecialchars((string) ($member['mobile'] ?? 'N/A'));
$whatsapp = htmlspecialchars((string) ($member['whatsapp'] ?? 'N/A'));
$membership = ucfirst($member['membership_status'] ?? 'Free');

// Religion & Personal
$digamber = strtoupper($member['digamber_jain'] ?? 'NO');
$religion = htmlspecialchars((string) ($member['religion'] ?? $getLabel('religion', $member['religion_id'] ?? '')));
$mother_tongue = htmlspecialchars((string) ($member['mother_tongue_val'] ?? $getLabel('mother_tongue', $member['mother_tongue_id'] ?? '')));
$marital_status = htmlspecialchars((string) ($member['marital_status_val'] ?? $getLabel('marital_status', $member['marital_status_id'] ?? '')));
$which_temple = htmlspecialchars((string) ($member['which_temple'] ?? 'N/A'));
$gotra = htmlspecialchars((string) ($member['gotra'] ?? $getLabel('gotra', $member['caste_id'] ?? '')));

// Birth
$birth_time = htmlspecialchars((string) ($member['birth_time'] ?? 'N/A'));
$birth_place = htmlspecialchars((string) ($member['birth_place'] ?? 'N/A'));
$star = htmlspecialchars((string) ($member['star'] ?? 'N/A'));
$rasi = htmlspecialchars((string) ($member['rasi'] ?? 'N/A'));
$dosh = htmlspecialchars((string) ($member['dosh'] ?? 'N/A'));

// Location
$loc = htmlspecialchars((string) ($getLabel('cities', $member['city_id'] ?? '') . ', ' . $getLabel('states', $member['state_id'] ?? '')));
$native_place = trim(($member['native_city'] ?? '') . ', ' . ($member['native_state'] ?? '') . ', ' . ($member['native_country'] ?? ''), ', ');
if (empty($native_place))
    $native_place = 'N/A';
$native_place = htmlspecialchars($native_place);

// Family
$father_name = htmlspecialchars((string) ($member['father_name'] ?? 'N/A'));
$father_mobile = htmlspecialchars((string) ($member['father_mobile'] ?? 'N/A'));
$father_income = htmlspecialchars((string) ($member['father_income'] ?? 'N/A'));
$mother_name = htmlspecialchars((string) ($member['mother_name'] ?? 'N/A'));
$bro_total = (int) ($member['bro_total'] ?? 0);
$bro_married = (int) ($member['bro_married'] ?? 0);
$sis_total = (int) ($member['sis_total'] ?? 0);
$sis_married = (int) ($member['sis_married'] ?? 0);

$about_text = nl2br(htmlspecialchars((string) ($member['about_me'] ?? 'N/A')));
$relatives = nl2br(htmlspecialchars((string) ($member['relative_details'] ?? 'N/A')));
?>

<style>
    .profile-page .profile-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 20px;
    }

    .profile-page .profile-details-list {
        text-align: left;
    }
</style>
<section class="profile-page" style="background: #fafafa; padding: 80px 0 60px;">
    <div class="container" style="max-width: 2200px; margin: 0 auto;">

        <div style="background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); overflow: hidden;">

            <!-- Hero Header -->
            <div
                style="background: linear-gradient(135deg, rgba(244, 92, 147, 0.1), rgba(244, 92, 147, 0.02)); padding: 40px; position: relative; display: flex; align-items: center; gap: 40px; flex-wrap: wrap;">
                <div style="position: relative;">
                    <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>"
                        style="width:200px; height:200px; border-radius:24px; object-fit:cover; border:6px solid #fff; box-shadow: 0 15px 35px rgba(244, 92, 147, 0.2);">
                    <div
                        style="position:absolute; bottom:-15px; left:50%; transform:translateX(-50%); background:#F54E7E; color:#fff; padding:6px 22px; border-radius:20px; font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; box-shadow:0 6px 12px rgba(245, 78, 126, 0.3); white-space: nowrap; z-index: 10;">
                        <?php echo $membership; ?> Member
                    </div>
                </div>

                <div style="flex: 1; min-width: 300px;">
                    <h1 style="font-size:2.8rem; color:#222; margin:0 0 10px 0; font-weight:800;">
                        <?php echo $name; ?> <i class="fas fa-check-circle"
                            style="color:#2ecc71; font-size:1.6rem; vertical-align: middle;"></i>
                    </h1>
                    <p style="color:#666; font-size:1.4rem; font-weight:500; margin:0;">
                        <?php echo $ageStr; ?> · <?php echo $marital_status; ?> · <?php echo $religion; ?>
                    </p>
                    <div style="margin-top: 20px; display: flex; gap: 15px;">
                        <span
                            style="background: #fff; padding: 8px 15px; border-radius: 12px; font-size: 0.9rem; color: #555; font-weight: 600; border: 1px solid #eee;">
                            <i class="fas fa-id-card" style="color: var(--match-pink); margin-right: 5px;"></i> ID:
                            <?php echo $id; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content Body -->
            <div style="padding: 40px;">

                <!-- Quick Facts -->
                <div
                    style="background:#fff; border-radius:18px; padding:25px; margin-bottom:30px; border:1px solid #eee; box-shadow:0 5px 15px rgba(0,0,0,0.02);">
                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px;">
                        <div><small
                                style="display:block; color:#aaa; text-transform:uppercase; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Gender</small><span
                                style="color:#333; font-weight:600; font-size:1.1rem;"><?php echo $gender; ?></span>
                        </div>
                        <div><small
                                style="display:block; color:#aaa; text-transform:uppercase; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Joined</small><span
                                style="color:#333; font-weight:600; font-size:1.1rem;"><?php echo $joined; ?></span>
                        </div>
                        <div><small
                                style="display:block; color:#aaa; text-transform:uppercase; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Mobile</small><span
                                style="color:#333; font-weight:600; font-size:1.1rem;"><?php echo $mobile; ?></span>
                        </div>
                        <div><small
                                style="display:block; color:#aaa; text-transform:uppercase; font-size:0.75rem; font-weight:700; margin-bottom:5px;">WhatsApp</small><span
                                style="color:#333; font-weight:600; font-size:1.1rem;"><?php echo $whatsapp; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Sections -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 30px;">

                    <!-- Religious & Personal -->
                    <div>
                        <h4
                            style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-pray"
                                style="color:var(--match-pink); margin-right:12px; font-size:1.4rem;"></i> Religious &
                            Personal
                        </h4>
                        <div style="background:#fff; border-radius:18px; padding:20px; border:1px solid #eee;">
                            <table style="width:100%; border-collapse:collapse; font-size:1rem;">
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888; width:45%;">Digamber Jain</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $digamber; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Religion</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $religion; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Mother Tongue</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $mother_tongue; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Marital Status</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $marital_status; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Which Temple</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $which_temple; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#888;">Gotra</td>
                                    <td
                                        style="padding:12px 0; color:var(--match-pink); font-weight:800; text-align:right;">
                                        <?php echo $gotra; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Birth & Horoscope -->
                    <div>
                        <h4
                            style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-star" style="color:#3498db; margin-right:12px; font-size:1.4rem;"></i>
                            Birth & Horoscope
                        </h4>
                        <div style="background:#fff; border-radius:18px; padding:25px; border:1px solid #eee;">
                            <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:20px;">
                                <div style="grid-column: 1/-1;"><small
                                        style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Birth
                                        Date</small><span
                                        style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $dob; ?></span>
                                </div>
                                <div><small
                                        style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Birth
                                        Time</small><span
                                        style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $birth_time; ?></span>
                                </div>
                                <div><small
                                        style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Birth
                                        Place</small><span
                                        style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $birth_place; ?></span>
                                </div>
                                <div><small
                                        style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Star</small><span
                                        style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $star; ?></span>
                                </div>
                                <div><small
                                        style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Rasi</small><span
                                        style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $rasi; ?></span>
                                </div>
                                <div style="grid-column: 1/-1;"><small
                                        style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Dosh</small><span
                                        style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $dosh; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Details -->
                    <div>
                        <h4
                            style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-map-marker-alt"
                                style="color:#e74c3c; margin-right:12px; font-size:1.4rem;"></i> Location Details
                        </h4>
                        <div style="background:#fff; border-radius:18px; padding:25px; border:1px solid #eee;">
                            <div style="margin-bottom:20px;">
                                <small
                                    style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Current
                                    Location</small>
                                <span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $loc; ?></span>
                            </div>
                            <div>
                                <small
                                    style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Native
                                    Location</small>
                                <span
                                    style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $native_place; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Family Details -->
                    <div>
                        <h4
                            style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-users" style="color:#f39c12; margin-right:12px; font-size:1.4rem;"></i>
                            Family Details
                        </h4>
                        <div style="background:#fff; border-radius:18px; padding:20px; border:1px solid #eee;">
                            <table style="width:100%; border-collapse:collapse; font-size:1rem;">
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Father's Name</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $father_name; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Father Mobile</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $father_mobile; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Father Income</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $father_income; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Mother's Name</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $mother_name; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Brothers</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $bro_total; ?> (Married: <?php echo $bro_married; ?>)
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#888;">Sisters</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">
                                        <?php echo $sis_total; ?> (Married: <?php echo $sis_married; ?>)
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div style="grid-column: 1 / -1;">
                        <h4
                            style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-info-circle"
                                style="color:#9b59b6; margin-right:12px; font-size:1.4rem;"></i> Additional Information
                        </h4>
                        <div
                            style="background:#fcfcfc; border-radius:18px; padding:25px; border:1px solid #eee; font-size:1rem; line-height:1.7; color:#555;">
                            <div style="margin-bottom:20px;">
                                <strong style="display:block; color:#222; margin-bottom:5px;">About Member:</strong>
                                <?php echo $about_text; ?>
                            </div>
                            <div>
                                <strong style="display:block; color:#222; margin-bottom:5px;">Relative Details:</strong>
                                <?php echo $relatives; ?>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Action Button -->
                <div style="margin-top: 40px; text-align: center;">
                    <button class="btn-primary"
                        style="padding: 18px 45px; font-size: 1.2rem; border-radius: 40px;"
                        onclick="openActionModal('interest', '<?php echo htmlspecialchars(json_encode(['id' => $id, 'name' => $name]), ENT_QUOTES, 'UTF-8'); ?>')">
                        <i class="fas fa-heart" style="margin-right: 10px;"></i> Send Interest
                    </button>
                    <div style="margin-top: 15px;">
                        <a href="matches.php"
                            style="color: #888; text-decoration: none; font-size: 0.95rem; font-weight: 500;">&larr;
                            Back to Matches</a>
                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>

    <?php require __DIR__ . '/footer.php'; ?>