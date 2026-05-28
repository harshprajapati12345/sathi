<?php
declare(strict_types=1);
require_once __DIR__ . '/session_init.php';
require_once __DIR__ . '/helpers/auth_helper.php';
sathi_require_approval();
require_once __DIR__ . '/includes/registration-config.php';
$masters = sathi_registration_masters();

// Make sure to include the file where sathi_user_repo_find_by_id is defined
require_once __DIR__ . '/admin/includes/user-storage.php';

$id = (int)($_SESSION['sathi_user_id'] ?? 0);
if ($id <= 0) {
    header("Location: login.php");
    exit;
}

$member = sathi_user_repo_find_by_id($id);

if (!$member) {
    $pageTitle = "Profile Not Found";
    require __DIR__ . '/header.php';
    echo "<div class='container' style='padding: 120px 0 80px; text-align: center; min-height: 60vh;'>";
    echo "<i class='fas fa-user-slash' style='font-size: 60px; color: #ccc; margin-bottom: 20px;'></i>";
    echo "<h2>Profile not found</h2>";
    echo "<p style='color:#666;'>We couldn't find your profile data.</p>";
    echo "<a href='index.php' class='btn-primary' style='display:inline-block; margin-top: 20px; padding: 10px 25px; border-radius: 25px; text-decoration: none; background: var(--match-pink); color: white;'>Go Home</a>";
    echo "</div>";
    require __DIR__ . '/footer.php';
    exit;
}

$pageTitle = htmlspecialchars((string) ($member['name'] ?? 'My Profile')) . " | ShadikiBaat";
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

$img = !empty($member['profile_photo']) 
    ? (strpos($member['profile_photo'], 'http') === 0 
        ? $member['profile_photo'] 
        : (file_exists(__DIR__ . '/uploads/profiles/' . $member['profile_photo']) 
            ? 'uploads/profiles/' . $member['profile_photo'] 
            : 'https://ui-avatars.com/api/?name=' . urlencode($member['name'] ?? 'User') . '&background=f45c93&color=fff&size=500'))
    : 'https://ui-avatars.com/api/?name=' . urlencode($member['name'] ?? 'User') . '&background=f45c93&color=fff&size=500';

// All fields
$name = htmlspecialchars((string) ($member['name'] ?? 'N/A'), ENT_QUOTES, 'UTF-8');
$gender = ucfirst($member['gender'] ?? 'N/A');
$joined = !empty($member['created_at']) ? date('M j, Y', strtotime($member['created_at'])) : 'N/A';
$mobile = htmlspecialchars((string) ($member['mobile'] ?? 'N/A'));
$email = htmlspecialchars((string) ($member['email'] ?? 'N/A'));
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

// Career & Income
$education = htmlspecialchars((string) ($member['higher_education'] ?? 'N/A'));
$occupation = htmlspecialchars((string) ($member['candidate_occupation'] ?? 'N/A'));
$annual_income = htmlspecialchars((string) ($member['candidate_annual_income'] ?? 'N/A'));
$firm_name = htmlspecialchars((string) ($member['occupation_firm'] ?? 'N/A'));
$designation = htmlspecialchars((string) ($member['occupation_designation'] ?? 'N/A'));

// Family
$father_name = htmlspecialchars((string) ($member['father_name'] ?? 'N/A'));
$father_mobile = htmlspecialchars((string) ($member['father_mobile'] ?? 'N/A'));
$father_income = htmlspecialchars((string) ($member['father_income'] ?? 'N/A'));
$father_occ = htmlspecialchars((string) ($member['father_occ'] ?? 'N/A'));
$mother_name = htmlspecialchars((string) ($member['mother_name'] ?? 'N/A'));
$mother_occ = htmlspecialchars((string) ($member['mother_occ'] ?? 'N/A'));
$bro_total = (int) ($member['bro_total'] ?? 0);
$bro_married = (int) ($member['bro_married'] ?? 0);
$sis_total = (int) ($member['sis_total'] ?? 0);
$sis_married = (int) ($member['sis_married'] ?? 0);

// Extra Fields
$mandir_name = htmlspecialchars((string) ($member['mandir_name'] ?? 'N/A'));
$subcast_name = htmlspecialchars((string) ($member['subcast_name'] ?? 'N/A'));
$complexion_pincode = htmlspecialchars((string) ($member['complexion'] ?? 'N/A'));
$height_cm = (int) ($member['height_cm'] ?? 0);
$weight_kg = (int) ($member['weight_kg'] ?? 0);
$handicapped = htmlspecialchars((string) ($member['blood_group'] ?? 'No'));

$ref1_name = htmlspecialchars((string) ($member['reference_person_1_name'] ?? 'N/A'));
$ref1_mobile = htmlspecialchars((string) ($member['reference_person_1_mobile'] ?? 'N/A'));
$ref1_rel = htmlspecialchars((string) ($member['reference_person_1_relation'] ?? 'N/A'));
$ref2_name = htmlspecialchars((string) ($member['reference_person_2_name'] ?? 'N/A'));
$ref2_mobile = htmlspecialchars((string) ($member['reference_person_2_mobile'] ?? 'N/A'));
$ref2_rel = htmlspecialchars((string) ($member['reference_person_2_relation'] ?? 'N/A'));

$about_text = nl2br(htmlspecialchars((string) ($member['about_me'] ?? 'N/A')));
$relatives = nl2br(htmlspecialchars((string) ($member['relative_details'] ?? 'N/A')));
$hobbies = htmlspecialchars((string) ($member['hobbies'] ?? 'N/A'));
$languages = htmlspecialchars((string) ($member['language_known'] ?? 'N/A'));
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

    .profile-hero {
        background: linear-gradient(135deg, rgba(244, 92, 147, 0.1), rgba(244, 92, 147, 0.02)); 
        padding: 40px; 
        position: relative; 
        display: flex; 
        align-items: center; 
        gap: 40px; 
        flex-wrap: wrap;
    }
    .profile-info {
        flex: 1; 
        min-width: 300px;
    }
    .profile-badges {
        margin-top: 20px; 
        display: flex; 
        gap: 15px; 
        flex-wrap: wrap;
    }
    .profile-sections-grid {
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); 
        gap: 30px;
    }
    .profile-quick-facts {
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
        gap: 20px;
    }
    .profile-content-body {
        padding: 40px;
    }
    
    @media (max-width: 768px) {
        .profile-page {
            padding: 60px 15px 40px !important;
        }
        .profile-hero {
            padding: 25px;
            gap: 25px;
            justify-content: center;
            text-align: center;
        }
        .profile-info {
            min-width: 100%;
        }
        .profile-badges {
            justify-content: center;
        }
        .profile-sections-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .profile-quick-facts {
            grid-template-columns: repeat(2, 1fr);
        }
        .profile-content-body {
            padding: 20px;
        }
    }
    @media (max-width: 480px) {
        .profile-quick-facts {
            grid-template-columns: 1fr;
        }
        .profile-hero h1 {
            font-size: 2rem !important;
        }
        .profile-hero p {
            font-size: 1.1rem !important;
        }
    }
</style>
<section class="profile-page" style="background: #fafafa; padding: 80px 0 60px;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">

        <div style="background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); overflow: hidden;">

            <!-- Hero Header -->
            <div class="profile-hero">
                <div style="position: relative;">
                    <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>"
                        style="width:200px; height:200px; border-radius:24px; object-fit:cover; border:6px solid #fff; box-shadow: 0 15px 35px rgba(244, 92, 147, 0.2);">
                    <div
                        style="position:absolute; bottom:-15px; left:50%; transform:translateX(-50%); background:#F54E7E; color:#fff; padding:6px 22px; border-radius:20px; font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; box-shadow:0 6px 12px rgba(245, 78, 126, 0.3); white-space: nowrap; z-index: 10;">
                        <?php echo $membership; ?> Member
                    </div>
                </div>

                <div class="profile-info">
                    <h1 style="font-size:2.8rem; color:#222; margin:0 0 10px 0; font-weight:800;">
                        <?php echo $name; ?> <i class="fas fa-check-circle"
                            style="color:#2ecc71; font-size:1.6rem; vertical-align: middle;"></i>
                    </h1>
                    <p style="color:#666; font-size:1.4rem; font-weight:500; margin:0;">
                        <?php echo $ageStr; ?> · <?php echo $marital_status; ?> · <?php echo $religion; ?>
                    </p>
                    <div class="profile-badges">
                        <span
                            style="background: #fff; padding: 8px 15px; border-radius: 12px; font-size: 0.9rem; color: #555; font-weight: 600; border: 1px solid #eee;">
                            <i class="fas fa-envelope" style="color: var(--match-pink); margin-right: 5px;"></i> <?php echo $email; ?>
                        </span>
                        <span
                            style="background: #fff; padding: 8px 15px; border-radius: 12px; font-size: 0.9rem; color: #555; font-weight: 600; border: 1px solid #eee;">
                            <i class="fas fa-id-card" style="color: var(--match-pink); margin-right: 5px;"></i> ID:
                            <?php echo $id; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content Body -->
            <div class="profile-content-body">

                <!-- Action Button -->
                <div style="margin-bottom: 30px; text-align: right;">
                    <a href="edit-profile.php" class="btn-primary"
                        style="padding: 12px 30px; font-size: 1rem; border-radius: 20px; text-decoration: none; display: inline-block;">
                        <i class="fas fa-edit" style="margin-right: 8px;"></i> Edit Profile
                    </a>
                </div>

                <!-- Quick Facts -->
                <div style="background:#fff; border-radius:18px; padding:25px; margin-bottom:30px; border:1px solid #eee; box-shadow:0 5px 15px rgba(0,0,0,0.02);">
                    <div class="profile-quick-facts">
                        <div><small style="display:block; color:#aaa; text-transform:uppercase; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Gender</small><span style="color:#333; font-weight:600; font-size:1.1rem;"><?php echo $gender; ?></span></div>
                        <div><small style="display:block; color:#aaa; text-transform:uppercase; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Joined</small><span style="color:#333; font-weight:600; font-size:1.1rem;"><?php echo $joined; ?></span></div>
                        <div><small style="display:block; color:#aaa; text-transform:uppercase; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Mobile</small><span style="color:#333; font-weight:600; font-size:1.1rem;"><?php echo $mobile; ?></span></div>
                        <div><small style="display:block; color:#aaa; text-transform:uppercase; font-size:0.75rem; font-weight:700; margin-bottom:5px;">WhatsApp</small><span style="color:#333; font-weight:600; font-size:1.1rem;"><?php echo $whatsapp; ?></span></div>
                    </div>
                </div>

                <!-- Sections -->
                <div class="profile-sections-grid">

                    <!-- Religious & Personal -->
                    <div>
                        <h4 style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-pray" style="color:var(--match-pink); margin-right:12px; font-size:1.4rem;"></i> Religious & Personal
                        </h4>
                        <div style="background:#fff; border-radius:18px; padding:20px; border:1px solid #eee;">
                            <table style="width:100%; border-collapse:collapse; font-size:1rem;">
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888; width:45%;">Digamber Jain</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $digamber; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Religion</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $religion; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Mother Tongue</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $mother_tongue; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Marital Status</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $marital_status; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Which Temple</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $which_temple; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#888;">Gotra</td>
                                    <td style="padding:12px 0; color:var(--match-pink); font-weight:800; text-align:right;"><?php echo $gotra; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#888;">Mandir</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $mandir_name; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#888;">Subcast</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $subcast_name; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#888;">Handicapped / Physical Deficiency</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $handicapped; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Birth & Horoscope -->
                    <div>
                        <h4 style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-star" style="color:#3498db; margin-right:12px; font-size:1.4rem;"></i> Birth & Horoscope
                        </h4>
                        <div style="background:#fff; border-radius:18px; padding:25px; border:1px solid #eee;">
                            <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:20px;">
                                <div style="grid-column: 1/-1;"><small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Birth Date</small><span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $dob; ?></span></div>
                                <div><small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Birth Time</small><span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $birth_time; ?></span></div>
                                <div><small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Birth Place</small><span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $birth_place; ?></span></div>
                                <div><small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Star (Mama Gotra)</small><span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $star; ?></span></div>
                                <div><small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Rasi</small><span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $rasi; ?></span></div>
                                <div><small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Manglik (Dosh)</small><span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $dosh; ?></span></div>
                                <div><small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Height</small><span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $height_cm > 0 ? $height_cm . ' cm' : 'N/A'; ?></span></div>
                                <div><small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:3px;">Weight</small><span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $weight_kg > 0 ? $weight_kg . ' kg' : 'N/A'; ?></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Career & Income -->
                    <div>
                        <h4 style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-briefcase" style="color:#2ecc71; margin-right:12px; font-size:1.4rem;"></i> Career & Education
                        </h4>
                        <div style="background:#fff; border-radius:18px; padding:20px; border:1px solid #eee;">
                            <table style="width:100%; border-collapse:collapse; font-size:1rem;">
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888; width:45%;">Education</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $education; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Occupation</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $occupation; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Company / Firm</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $firm_name; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Designation</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $designation; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#888;">Annual Income</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $annual_income; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Location Details -->
                    <div>
                        <h4 style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-map-marker-alt" style="color:#e74c3c; margin-right:12px; font-size:1.4rem;"></i> Location Details
                        </h4>
                        <div style="background:#fff; border-radius:18px; padding:25px; border:1px solid #eee;">
                            <div style="margin-bottom:20px;">
                                <small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Current Address</small>
                                <span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo htmlspecialchars((string)($member['candidate_current_address'] ?? 'N/A')); ?></span>
                            </div>
                            <div style="margin-bottom:20px;">
                                <small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Permanent Address</small>
                                <span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo htmlspecialchars((string)($member['permanent_address'] ?? 'N/A')); ?></span>
                            </div>
                            <div style="margin-bottom:20px;">
                                <small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Permanent Address Pin Code</small>
                                <span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $complexion_pincode; ?></span>
                            </div>
                            <div>
                                <small style="display:block; color:#aaa; font-size:0.75rem; font-weight:700; margin-bottom:5px;">Native Location</small>
                                <span style="color:#333; font-weight:600; font-size:1.05rem;"><?php echo $native_place; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Family Details -->
                    <div>
                        <h4 style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-users" style="color:#f39c12; margin-right:12px; font-size:1.4rem;"></i> Family Details
                        </h4>
                        <div style="background:#fff; border-radius:18px; padding:20px; border:1px solid #eee;">
                            <table style="width:100%; border-collapse:collapse; font-size:1rem;">
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Father's Name</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $father_name; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Father Occupation</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $father_occ; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Father Mobile</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $father_mobile; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Father Income</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;">₹<?php echo $father_income; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Mother's Name</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $mother_name; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Mother Occupation</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $mother_occ; ?></td>
                                </tr>
                                <tr style="border-bottom:1px solid #f9f9f9;">
                                    <td style="padding:12px 0; color:#888;">Brothers</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $bro_total; ?> (Married: <?php echo $bro_married; ?>)</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#888;">Sisters</td>
                                    <td style="padding:12px 0; color:#333; font-weight:600; text-align:right;"><?php echo $sis_total; ?> (Married: <?php echo $sis_married; ?>)</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div>
                        <h4 style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-info-circle" style="color:#9b59b6; margin-right:12px; font-size:1.4rem;"></i> Additional Information
                        </h4>
                        <div style="background:#fcfcfc; border-radius:18px; padding:25px; border:1px solid #eee; font-size:1rem; line-height:1.7; color:#555;">
                            <div style="margin-bottom:15px;">
                                <strong style="display:block; color:#222; margin-bottom:5px;">Languages Known:</strong>
                                <?php echo $languages; ?>
                            </div>
                            <div style="margin-bottom:15px;">
                                <strong style="display:block; color:#222; margin-bottom:5px;">Hobbies:</strong>
                                <?php echo $hobbies; ?>
                            </div>
                            <div style="margin-bottom:15px;">
                                <strong style="display:block; color:#222; margin-bottom:5px;">Preferences / Relative Details:</strong>
                                <?php echo $relatives; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Mandir References -->
                    <div style="grid-column: 1/-1;">
                        <h4 style="font-size:1.2rem; color:#222; font-weight:800; margin-bottom:15px; display:flex; align-items:center;">
                            <i class="fas fa-handshake" style="color:#16a085; margin-right:12px; font-size:1.4rem;"></i> Mandir Reference Persons
                        </h4>
                        <div style="background:#fff; border-radius:18px; padding:25px; border:1px solid #eee; display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px;">
                            <div>
                                <h5 style="margin:0 0 10px 0; color:#333; font-size:1rem;">Reference 1</h5>
                                <div style="margin-bottom:8px;"><small style="color:#aaa; font-weight:700;">Name:</small> <span style="font-weight:600;"><?php echo $ref1_name; ?></span></div>
                                <div style="margin-bottom:8px;"><small style="color:#aaa; font-weight:700;">Mobile:</small> <span style="font-weight:600;"><?php echo $ref1_mobile; ?></span></div>
                                <div><small style="color:#aaa; font-weight:700;">Relation:</small> <span style="font-weight:600;"><?php echo $ref1_rel; ?></span></div>
                            </div>
                            <div>
                                <h5 style="margin:0 0 10px 0; color:#333; font-size:1rem;">Reference 2</h5>
                                <div style="margin-bottom:8px;"><small style="color:#aaa; font-weight:700;">Name:</small> <span style="font-weight:600;"><?php echo $ref2_name; ?></span></div>
                                <div style="margin-bottom:8px;"><small style="color:#aaa; font-weight:700;">Mobile:</small> <span style="font-weight:600;"><?php echo $ref2_mobile; ?></span></div>
                                <div><small style="color:#aaa; font-weight:700;">Relation:</small> <span style="font-weight:600;"><?php echo $ref2_rel; ?></span></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

<?php require __DIR__ . '/footer.php'; ?>
