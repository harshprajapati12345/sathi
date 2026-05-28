<?php
require_once __DIR__ . '/helpers/auth_helper.php';
sathi_require_approval();

$pageTitle = "ShadikiBaat – Where Relationships Begin | Find Your Perfect Match";
$navActive = 'home';
include 'header.php';
?>
<?php
$db = sathi_db();

// Fetch Homepage Banner
$bannerQuery = $db->query("SELECT title, subtitle, image FROM homepage_banners WHERE status = 1 ORDER BY id DESC LIMIT 1");
$banner = $bannerQuery ? $bannerQuery->fetch_assoc() : null;

$heroBg = !empty($banner['image']) ? $banner['image'] : 'assets/hero_couple.png';
if (!empty($banner['image']) && strpos($banner['image'], 'uploads/') === 0) {
    $heroBg = $banner['image'];
}

$heroTitle = !empty($banner['title']) ? htmlspecialchars($banner['title'], ENT_QUOTES, 'UTF-8') : 'Find Your <span class="accent">Perfect Match</span>';
$heroSub = !empty($banner['subtitle']) ? htmlspecialchars($banner['subtitle'], ENT_QUOTES, 'UTF-8') : 'Smart matchmaking with real profiles, verified identities, and AI-powered suggestions.';

// Fetch Success Stories
$storiesQuery = $db->query("SELECT groom_name, bride_name, story, image, created_at FROM success_stories WHERE status = 1 ORDER BY id DESC LIMIT 5");
$storiesData = $storiesQuery ? $storiesQuery->fetch_all(MYSQLI_ASSOC) : [];
$dynamicTestimonials = [];
foreach ($storiesData as $s) {
    $img = !empty($s['image']) ? $s['image'] : 'assets/testimonial_couple.png';
    if (!empty($s['image']) && strpos($s['image'], 'uploads/') === 0) {
        $img = $s['image'];
    }
    $dynamicTestimonials[] = [
        'name' => htmlspecialchars(trim($s['groom_name'] . ' & ' . $s['bride_name']), ENT_QUOTES, 'UTF-8'),
        'loc' => 'Verified Couple 📍',
        'quote' => '"' . htmlspecialchars($s['story'], ENT_QUOTES, 'UTF-8') . '"',
        'badge' => 'Married ' . date('M Y', strtotime($s['created_at'])),
        'img' => htmlspecialchars($img, ENT_QUOTES, 'UTF-8')
    ];
}
// Fallback if no stories
if (empty($dynamicTestimonials)) {
    $dynamicTestimonials[] = [
        'name' => 'Riya & Aditya',
        'loc' => 'Mumbai to Pune 📍',
        'quote' => '"Shadikibaat made our journey so easy! We found each other through their AI recommendations and it was love at first chat."',
        'badge' => 'Married Nov 2024',
        'img' => 'assets/testimonial_couple.png'
    ];
}

// Fetch Blogs
$blogsQuery = $db->query("SELECT title, slug, image, content, created_at FROM blogs WHERE status = 'published' ORDER BY id DESC LIMIT 4");
$latestBlogs = $blogsQuery ? $blogsQuery->fetch_all(MYSQLI_ASSOC) : [];

// Fetch Advertisements
$adsQuery = $db->query("SELECT title, image, position, link FROM advertisements WHERE status = 1 ORDER BY id DESC");
$ads = ['top' => [], 'bottom' => [], 'left' => [], 'right' => []];
if ($adsQuery) {
    while ($adRow = $adsQuery->fetch_assoc()) {
        $ads[$adRow['position']][] = $adRow;
    }
}
?>

<?php if (!empty($ads['top'])): ?>
<div class="top-ads-container" style="width:100%; text-align:center; padding: 20px 15px; background: #fff; border-bottom: 1px solid #eee; z-index: 100; position: relative;">
    <div class="container">
        <?php foreach($ads['top'] as $ad): ?>
            <a href="<?php echo htmlspecialchars($ad['link'] ?? '#'); ?>" target="_blank" style="display:inline-block; width: 100%; max-width: 1100px; margin: 10px auto;">
                <img src="<?php echo htmlspecialchars($ad['image']); ?>" alt="<?php echo htmlspecialchars($ad['title']); ?>" style="width: 100%; height: auto; max-height: 400px; object-fit: contain; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ═══ HERO SECTION ═══ -->
<style>
    #home.hero {
        min-height: auto !important;
        padding-top: 80px !important;
        align-items: flex-start;
    }
    .stats-bar {
        padding-top: 10px !important; 
    }
    @media (max-width: 768px) {
        #home.hero {
            padding-top: 56px !important; /* Matches mobile navbar height */
        }
        .stats-bar {
            padding-top: 0px !important;
        }
    }
</style>
<section class="hero hero--fullbleed" id="home">
    <div class="hero-slider" style="position: relative; width: 100%; overflow: hidden; z-index: 0;">
        <div class="hero-slider-track" style="display: flex; width: 100%;">
            <?php
            $sliderImages = [
                'assets/sliders images on home page/ChatGPT Image May 27, 2026, 12_05_15 PM.png',
                'assets/sliders images on home page/ChatGPT Image May 27, 2026, 12_05_37 PM.png',
                'assets/sliders images on home page/ChatGPT Image May 27, 2026, 12_10_17 PM.png'
            ];
            foreach ($sliderImages as $img): ?>
                <div class="hero-slide" style="flex: 0 0 100%;">
                    <img src="<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>" alt="Hero Banner" style="width: 100%; height: auto; display: block;">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.querySelector('.hero-slider-track');
        if (!track) return;
        
        setInterval(() => {
            track.style.transition = 'transform 1s ease-in-out';
            track.style.transform = 'translateX(-100%)';
            
            setTimeout(() => {
                track.style.transition = 'none';
                track.appendChild(track.firstElementChild);
                track.style.transform = 'translateX(0)';
            }, 1000); 
        }, 4000); 
    });
    </script>
</section>

<!-- ═══ STATS BAR ═══ -->
<section class="stats-bar">
    <div class="container fade-up">
        <div class="stat-card">
            <div class="stat-icon">🛡️</div>
            <div>
                <h4>ID Verified Profiles</h4>
                <p>100% authentic profiles</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💞</div>
            <div>
                <h4>5M+ Success Stories</h4>
                <p>Millions found their perfect match</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔒</div>
            <div>
                <h4>Safe &amp; Private</h4>
                <p>Your data is always secure</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✨</div>
            <div>
                <h4>Match Faster with AI</h4>
                <p>Smart recommendations just for you</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ ABOUT US ═══ -->
<section class="about" id="about">
    <div class="container">
        <div class="about-img-wrap fade-up">
            <img src="assets/hero_couple.png" alt="Happy married couple">
            <div class="about-badge">
                <span>+2M</span>
                Join 2M+ happy members
            </div>
        </div>
        <div class="about-content fade-up">
            <div class="about-text">
                <div class="section-label">ABOUT US ~~~</div>
                <h2>Welcome to the<br><span class="accent">Shadi Ki Baat</span></h2>
                <p>Your wedding day is a once-in-a-lifetime event, and choosing the right partner is the first step
                    towards a beautiful journey together. At Shadikibaat.com, we help you find that partner through our
                    AI-powered matching system and verified community.</p>
                <p>With over a decade of experience and millions of happy couples, we remain India's most trusted
                    matrimonial platform — connecting hearts across communities, cultures, and borders.</p>
                <button class="btn-outline" onclick="location.href='eligibility.php'">Make Your Profile →</button>
            </div>
            <div class="about-stats">
                <div class="about-stat-item">
                    <div class="num">2M+</div>
                    <div class="label">Active Members</div>
                </div>
                <div class="about-stat-item">
                    <div class="num">1M+</div>
                    <div class="label">Successful Marriages</div>
                </div>
                <div class="about-stat-item">
                    <div class="num">10+</div>
                    <div class="label">Years of Trust</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ STYLE FOR MATCH CARDS ═══ -->
<style>
    .featured-matches-section {
        padding: 80px 0;
        background: #fdf2f7; /* Very light pink background to make white cards pop */
    }

    .matches-slider-container {
        position: relative;
        width: 100%;
        margin-top: 30px;
    }

    .matches-slider-wrapper {
        overflow: hidden;
        padding: 10px 5px;
    }

    .matches-grid {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        scroll-snap-type: x mandatory;
        padding-bottom: 20px; /* Space for scrollbar */
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE/Edge */
    }

    .matches-grid::-webkit-scrollbar {
        display: none; /* Safari/Chrome */
    }

    .pm-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        flex: 0 0 280px; /* Fixed width for slider items */
        scroll-snap-align: start;
        position: relative;
    }

    .pm-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .pm-card__img-wrap {
        width: 100%;
        height: 280px;
        position: relative;
    }

    .pm-card__badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #cc2b5e;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        z-index: 10;
        text-transform: uppercase;
    }

    .pm-card__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pm-card__body {
        padding: 20px 18px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        text-align: left;
    }

    .pm-card__body-name {
        font-size: 1.15rem;
        font-weight: 800;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pm-card__status-icon {
        color: #22c55e;
        font-size: 0.95rem;
    }

    .pm-card__body-details {
        font-size: 0.9rem;
        color: #888;
        font-weight: 500;
    }

    .pm-card__actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        align-items: center;
    }

    .pm-btn-view {
        flex: 1;
        border: 1.5px solid #cc2b5e;
        color: #cc2b5e;
        background: transparent;
        padding: 10px 0;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s;
    }

    .pm-btn-view:hover {
        background: #cc2b5e;
        color: white;
    }

    .pm-btn-heart {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #cc2b5e;
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
        font-size: 1.1rem;
    }

    .pm-btn-heart:hover {
        transform: scale(1.05);
        background: #b02250;
    }

    /* Slider controls */
    .slider-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: white;
        border: 1px solid #eee;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 20;
        color: #cc2b5e;
        font-size: 1.1rem;
        transition: all 0.2s;
    }
    
    .slider-nav-btn:hover {
        background: #cc2b5e;
        color: white;
        border-color: #cc2b5e;
    }

    .slider-nav-btn.prev {
        left: -20px;
    }

    .slider-nav-btn.next {
        right: -20px;
    }
    
    @media (max-width: 768px) {
        .slider-nav-btn {
            display: none;
        }
        .pm-card {
            flex: 0 0 250px;
        }
        .pm-card__img-wrap {
            height: 250px;
        }
    }
</style>

<!-- ═══ FEATURED MATCHES ═══ -->
<section class="featured-matches-section" id="featured-matches">
    <div class="container">
        <div class="section-header fade-up" style="display: flex; justify-content: space-between; align-items: flex-end;">
            <h2 style="font-size: 1.8rem; margin: 0; color: #111; font-family: 'Playfair Display', serif; font-weight: 700;">Matches for you</h2>
            <a href="matches.php" style="color: #d13b6c; font-weight: 600; text-decoration: none; font-size: 0.9rem;">View all matches &rarr;</a>
        </div>

        <div class="matches-slider-container fade-up">
            <button class="slider-nav-btn prev" onclick="slideMatches(-1)"><i class="fas fa-chevron-left"></i></button>
            <div class="matches-slider-wrapper">
                <div class="matches-grid" id="matchesSlider">
                    <?php
                    // Fetch verified members (limit to 10 for slider)
                    require_once __DIR__ . '/admin/includes/user-storage.php';
                    require_once __DIR__ . '/includes/registration-config.php';

                    $masters = sathi_registration_masters();

                    $getLabel = function ($listName, $value) use ($masters) {
                        if (empty($value)) return '—';
                        $list = $masters[$listName] ?? [];
                        if ($listName === 'cities') {
                            foreach ($masters['geo']['cities'] as $stateCode => $cityList) {
                                foreach ($cityList as $item) {
                                    if ($item['value'] == $value) return $item['label'];
                                }
                            }
                        } elseif ($listName === 'states') {
                            foreach ($masters['geo']['states'] as $countryCode => $stateList) {
                                foreach ($stateList as $item) {
                                    if ($item['value'] == $value) return $item['label'];
                                }
                            }
                        } else {
                            foreach ($list as $item) {
                                if ($item['value'] == $value) return $item['label'];
                            }
                        }
                        return ucfirst(str_replace('_', ' ', (string) $value));
                    };

                    $calculateAge = function ($dob) {
                        if (empty($dob)) return '—';
                        try {
                            $birthDate = new DateTime($dob);
                            $today = new DateTime();
                            return $today->diff($birthDate)->y;
                        } catch (Exception $e) {
                            return '—';
                        }
                    };

                    // Fetch Approved Users (limit to 10)
                    $rawRows = sathi_users_list_by_status('approved', 10);
                    $profiles = [];

                    foreach ($rawRows as $r) {
                        $detailedUser = sathi_user_repo_find_by_id($r['id']);
                        if (!$detailedUser) continue;

                        $fullName = trim(($detailedUser['first_name'] ?? '') . ' ' . ($detailedUser['last_name'] ?? ''));
                        if (empty($fullName)) $fullName = 'Member ' . ($detailedUser['id'] ?? '');

                        $age = $calculateAge($detailedUser['dob'] ?? '');
                        $job = $detailedUser['occupation_val'] ?? '';
                        
                        $metaParts = [];
                        if (!empty($age) && $age !== '—') $metaParts[] = $age;
                        if (!empty($job) && $job !== '—') $metaParts[] = $job;
                        $metaStr = implode(' · ', $metaParts);

                        $locParts = [];
                        if (!empty($detailedUser['city_val']) && $detailedUser['city_val'] !== '—') {
                            $locParts[] = $detailedUser['city_val'];
                            $locParts[] = 'India';
                        }
                        
                        if (empty($locParts)) {
                            if (!empty($detailedUser['birth_place'])) {
                                $fcity = trim($detailedUser['birth_place']);
                                if (strpos($fcity, ',') !== false) {
                                    $parts = array_map('trim', explode(',', $fcity));
                                    $locParts[] = $parts[0];
                                } else {
                                    $locParts[] = $fcity;
                                }
                                $locParts[] = 'India';
                            } elseif (!empty($detailedUser['current_address'])) {
                                $parts = array_map('trim', explode(',', $detailedUser['current_address']));
                                $c = count($parts);
                                if ($c >= 3) {
                                    $locParts[] = $parts[$c-3];
                                    $locParts[] = $parts[$c-1];
                                } elseif ($c == 2) {
                                    $locParts = $parts;
                                } else {
                                    $locParts[] = $detailedUser['current_address'];
                                }
                            }
                        }
                        $realLocStr = implode(', ', $locParts);

                        $profiles[] = [
                            'id' => $r['id'],
                            'name' => $fullName,
                            'meta_str' => $metaStr,
                            'loc_str' => $realLocStr,
                            'img' => !empty($r['profile_photo']) 
                                ? (strpos($r['profile_photo'], 'http') === 0 
                                    ? $r['profile_photo'] 
                                    : (file_exists(__DIR__ . '/uploads/profiles/' . $r['profile_photo']) 
                                        ? 'uploads/profiles/' . $r['profile_photo'] 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($fullName) . '&background=fdf2f7&color=d13b6c&size=500'))
                                : 'https://ui-avatars.com/api/?name=' . urlencode($fullName) . '&background=fdf2f7&color=d13b6c&size=500'
                        ];
                    }

                    if (empty($profiles)): ?>
                        <div class="pm-empty" style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 20px; width: 100%;">
                            <i class="fas fa-heart-broken" style="font-size: 42px; color: #fce4ee; margin-bottom: 20px; display: block;"></i>
                            <p style="color: #666;">No matches found yet.</p>
                        </div>
                    <?php endif; ?>

                    <?php foreach ($profiles as $p): ?>
                        <div class="pm-card">
                            <div class="pm-card__img-wrap">
                                <img class="pm-card__img" src="<?php echo htmlspecialchars($p['img']); ?>"
                                    alt="<?php echo htmlspecialchars($p['name']); ?>" loading="lazy">
                            </div>
                            <div class="pm-card__body">
                                <div class="pm-card__body-name">
                                    <?php echo htmlspecialchars($p['name']); ?>
                                    <i class="fas fa-check-circle pm-card__status-icon"></i>
                                </div>
                                <?php if (!empty($p['meta_str'])): ?>
                                    <div class="pm-card__body-details"><?php echo htmlspecialchars($p['meta_str']); ?></div>
                                <?php endif; ?>
                                <?php if (!empty($p['loc_str'])): ?>
                                    <div class="pm-card__body-details" style="display: flex; align-items: center; gap: 4px; margin-bottom: 5px;">
                                        <i class="fas fa-map-marker-alt" style="font-size: 11px; color: #b0b0c0;"></i> 
                                        <?php echo htmlspecialchars($p['loc_str']); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="pm-card__actions">
                                    <a href="view-profile.php?id=<?php echo $p['id']; ?>" class="pm-btn-view">View Profile</a>
                                    <button class="pm-btn-heart" onclick="openActionModal('interest', '<?php echo rawurlencode(json_encode(['id' => $p['id'], 'name' => $p['name']])); ?>')"><i class="fas fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <button class="slider-nav-btn next" onclick="slideMatches(1)"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

<script>
    function slideMatches(direction) {
        const slider = document.getElementById('matchesSlider');
        if (slider) {
            const scrollAmount = 300; // width of card + gap
            slider.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
        }
    }
</script>
<!-- ═══ LATEST BLOGS ═══ -->
<section class="latest-blogs" id="blog" style="padding: 80px 0; background: #ffffff;">
    <div class="container">
        <div class="section-header fade-up" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
            <h2 style="font-size: 1.8rem; margin: 0; color: #111; font-family: 'Playfair Display', serif; font-weight: 700;">From our blog</h2>
            <a href="blog.php" style="color: #d13b6c; font-weight: 600; text-decoration: none; font-size: 0.9rem;">View all articles &rarr;</a>
        </div>
        
        <div class="blog-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;">
            <?php if (empty($latestBlogs)): 
                $fakeBlogImages = [
                    'https://images.unsplash.com/photo-1511895426328-dc8714191300?w=500&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=500&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=500&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=500&h=300&fit=crop'
                ];
                $fakeTitles = [
                    'How to build a strong foundation for marriage',
                    '5 things to know before your first meeting',
                    'Understanding your partner\'s love language',
                    'Planning a wedding that reflects your bond'
                ];
                $fakeTags = ['Relationship', 'Tips', 'Guides', 'Lifestyle'];
                for($i=0; $i<4; $i++): 
            ?>
                <div class="blog-card fade-up" style="display: flex; flex-direction: column; background: white; border-radius: 12px; overflow: hidden; border: 1px solid #f0f0f0;">
                    <div class="blog-img-wrap" style="height: 160px; background: #fdf2f7; border-radius: 12px; margin: 10px; overflow: hidden;">
                        <img src="<?php echo $fakeBlogImages[$i]; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Blog image">
                    </div>
                    <div style="padding: 0 15px 15px;">
                        <span style="display: inline-block; padding: 4px 10px; background: #fce4ee; color: #d13b6c; font-size: 0.7rem; font-weight: 600; border-radius: 20px; margin-bottom: 10px;"><?php echo $fakeTags[$i]; ?></span>
                        <h3 style="font-size: 1rem; margin-bottom: 10px; line-height: 1.4; font-weight: 700;"><?php echo $fakeTitles[$i]; ?></h3>
                        <div style="font-size: 0.75rem; color: #888;">May <?php echo 20 - $i; ?>, 2024</div>
                    </div>
                </div>
                <?php endfor; ?>
            <?php else: ?>
                <?php foreach ($latestBlogs as $b): 
                    $blogImg = !empty($b['image']) ? $b['image'] : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=1000';
                    $excerpt = substr(strip_tags($b['content']), 0, 100) . '...';
                ?>
                <div class="blog-card fade-up" style="display: flex; flex-direction: column; background: white; border-radius: 12px; overflow: hidden; border: 1px solid #f0f0f0;">
                    <div class="blog-img-wrap" style="height: 160px; border-radius: 12px; margin: 10px; overflow: hidden; background: #fdf2f7;">
                        <img src="<?php echo htmlspecialchars($blogImg); ?>" alt="<?php echo htmlspecialchars($b['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 0 15px 15px;">
                        <span style="display: inline-block; padding: 4px 10px; background: #fce4ee; color: #d13b6c; font-size: 0.7rem; font-weight: 600; border-radius: 20px; margin-bottom: 10px;">Tips</span>
                        <h3 style="font-size: 1rem; margin-bottom: 10px; line-height: 1.4; font-weight: 700;"><?php echo htmlspecialchars($b['title']); ?></h3>
                        <div style="font-size: 0.75rem; color: #888;"><?php echo date('M j, Y', strtotime($b['created_at'])); ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ═══ TESTIMONIAL / SUCCESS STORIES ═══ -->
<section class="testimonial" id="stories" style="padding: 80px 0; background: #ffffff;">
    <div class="container">
        <div class="section-header fade-up" style="position: relative; margin-bottom: 40px; display: flex; align-items: flex-end; justify-content: center; border-bottom: 1px solid #eee; padding-bottom: 15px;">
            <h2 style="font-size: 1.8rem; margin: 0; color: #111; font-family: 'Playfair Display', serif; font-weight: 700;">Success stories</h2>
            <a href="success-stories.php" style="color: #d13b6c; font-weight: 600; text-decoration: none; font-size: 0.9rem; position: absolute; right: 0; bottom: 15px;">View all stories &rarr;</a>
        </div>

        <div class="stories-slider-container fade-up" style="position: relative; width: 100%;">
            <div style="overflow: hidden; padding: 10px 5px;">
                <div id="storiesSlider" style="display: flex; gap: 30px; overflow-x: auto; scroll-behavior: smooth; scroll-snap-type: x mandatory; padding-bottom: 10px; scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        #storiesSlider::-webkit-scrollbar { display: none; }
                    </style>
                    <?php
                    // Merge dynamic testimonials with fake ones to ensure we have enough for a slider
                    $allStories = $dynamicTestimonials ?? [];
                    
                    $fakeStories = [
                        [
                            'name' => 'Ankit & Priya',
                            'quote' => '"ShaadikiBaat helped us find each other and start our beautiful journey together. The matching algorithm is truly magical!"',
                            'badge' => 'Married on Feb 2024',
                            'img' => 'https://images.unsplash.com/photo-1543165365-07232ed12fad?w=300&h=400&fit=crop'
                        ],
                        [
                            'name' => 'Rohan & Sneha',
                            'quote' => '"We connected, talked and realized we were meant to be. Thank you ShaadikiBaat for making this happen!"',
                            'badge' => 'Married on Dec 2023',
                            'img' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=300&h=400&fit=crop'
                        ],
                        [
                            'name' => 'Karan & Neha',
                            'quote' => '"The best decision we made was to trust ShaadikiBaat with our future. Couldn\'t have asked for a better life partner."',
                            'badge' => 'Married on Aug 2023',
                            'img' => 'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=300&h=400&fit=crop'
                        ],
                        [
                            'name' => 'Rahul & Meera',
                            'quote' => '"From our first conversation, everything just clicked. The platform made it so easy to find verified profiles."',
                            'badge' => 'Married on Jun 2023',
                            'img' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=300&h=400&fit=crop'
                        ]
                    ];
                    
                    // If we have less than 4 real stories, append fake ones
                    if (count($allStories) < 4) {
                        foreach ($fakeStories as $fs) {
                            if (count($allStories) >= 6) break;
                            $allStories[] = $fs;
                        }
                    }

                    foreach ($allStories as $st):
                    ?>
                    <div class="story-card-item" style="display: flex; gap: 20px; background: white; border: 1px solid #eee; border-radius: 12px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); flex: 0 0 calc(50% - 15px); scroll-snap-align: start; min-width: 400px;">
                        <div style="width: 120px; height: 140px; background: #fdf2f7; border-radius: 8px; flex-shrink: 0; overflow: hidden;">
                            <img src="<?php echo htmlspecialchars($st['img']); ?>" alt="Couple" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div style="display: flex; flex-direction: column; justify-content: center;">
                            <p style="font-size: 0.95rem; line-height: 1.5; color: #333; margin-bottom: 15px; font-style: italic;">
                                <?php echo $st['quote']; ?>
                            </p>
                            <div style="font-weight: 700; font-size: 0.95rem; margin-bottom: 5px;">- <?php echo htmlspecialchars($st['name']); ?></div>
                            <div style="font-size: 0.8rem; color: #888;"><?php echo htmlspecialchars($st['badge']); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div id="storiesDots" style="text-align: center; margin-top: 20px; display: flex; justify-content: center; gap: 8px;">
            <!-- Dots populated via JS -->
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('storiesSlider');
        const dotsContainer = document.getElementById('storiesDots');
        
        if (slider && dotsContainer) {
            const storyCards = Array.from(slider.querySelectorAll('.story-card-item'));
            if(storyCards.length === 0) return;
            
            // Create dots
            storyCards.forEach((_, index) => {
                const dot = document.createElement('span');
                dot.style.width = '10px';
                dot.style.height = '10px';
                dot.style.borderRadius = '50%';
                dot.style.display = 'inline-block';
                dot.style.cursor = 'pointer';
                dot.style.background = index === 0 ? '#d13b6c' : '#f0f0f0';
                dot.style.transition = 'background 0.3s ease';
                
                dot.addEventListener('click', () => {
                    const scrollTarget = index * (storyCards[0].offsetWidth + 30);
                    slider.scrollTo({ left: scrollTarget, behavior: 'smooth' });
                });
                
                dotsContainer.appendChild(dot);
            });
            
            // Update dots on scroll
            slider.addEventListener('scroll', () => {
                const cardWidth = storyCards[0].offsetWidth + 30; // gap is 30
                const activeIndex = Math.round(slider.scrollLeft / cardWidth);
                
                Array.from(dotsContainer.children).forEach((dot, index) => {
                    dot.style.background = index === activeIndex ? '#d13b6c' : '#f0f0f0';
                });
            });
            
            // Auto scroll logic
            let autoScrollInterval = setInterval(autoScroll, 3500);
            
            function autoScroll() {
                const cardWidth = storyCards[0].offsetWidth + 30;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                
                if (slider.scrollLeft >= maxScroll - 10) {
                    // Loop back to start smoothly
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    // Scroll to next card
                    slider.scrollBy({ left: cardWidth, behavior: 'smooth' });
                }
            }
            
            // Pause on hover
            slider.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
            slider.addEventListener('mouseleave', () => {
                autoScrollInterval = setInterval(autoScroll, 3500);
            });
            dotsContainer.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
            dotsContainer.addEventListener('mouseleave', () => {
                autoScrollInterval = setInterval(autoScroll, 3500);
            });
        }
    });
</script>

<script>
    /* ── UI Logic ── */
    function togglePill(btn, genderValue) {
        btn.parentElement.querySelectorAll('button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const input = document.getElementById('genderInput');
        if (input && genderValue) {
            input.value = genderValue;
        }
    }

    /* ── Dual age range sliders ── */
    function updateAgeRange() {
        const minEl = document.getElementById('ageMin');
        const maxEl = document.getElementById('ageMax');
        const track = document.getElementById('ageTrack');
        if (!minEl || !maxEl) return;
        let min = parseInt(minEl.value, 10);
        let max = parseInt(maxEl.value, 10);
        if (min > max) {
            if (document.activeElement === minEl) maxEl.value = min;
            else minEl.value = max;
            min = parseInt(minEl.value, 10);
            max = parseInt(maxEl.value, 10);
        }
        if (max - min < 1) {
            if (document.activeElement === minEl) minEl.value = Math.min(min, max - 1);
            else maxEl.value = Math.max(max, min + 1);
            min = parseInt(minEl.value, 10);
            max = parseInt(maxEl.value, 10);
        }
        document.getElementById('ageVal').textContent = min + ' – ' + max + ' Years';
        if (track) {
            const lowPct = ((min - 18) / (50 - 18)) * 100;
            const highPct = ((max - 18) / (50 - 18)) * 100;
            track.style.setProperty('--range-low', lowPct + '%');
            track.style.setProperty('--range-high', highPct + '%');
        }
    }
    document.getElementById('ageMin')?.addEventListener('input', updateAgeRange);
    document.getElementById('ageMax')?.addEventListener('input', updateAgeRange);
    updateAgeRange();

    /* ── Scroll fade-up animation ── */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

    /* ── Count-up animation for stats ── */
    function animateCount(el, target, suffix = '') {
        let current = 0;
        const increment = target / 60;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = Math.floor(current) + suffix;
        }, 25);
    }

    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.counted) {
                entry.target.dataset.counted = 'true';
                const nums = entry.target.querySelectorAll('.about-stat-item .num');
                if (nums[0]) animateCount(nums[0], 2, 'M+');
                if (nums[1]) animateCount(nums[1], 1, 'M+');
                if (nums[2]) animateCount(nums[2], 10, '+');
            }
        });
    }, { threshold: 0.3 });
    document.querySelectorAll('.about-stats').forEach(el => statsObserver.observe(el));

    /* ── Heart button click ── */
    document.querySelectorAll('.profile-favorite').forEach(btn => {
        btn.addEventListener('click', function () {
            const icon = this.querySelector('i');
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                icon.style.color = '#F54E7E';
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                icon.style.color = '';
            }
        });
    });

    /* ── Testimonial carousel ── */
    const testimonials = <?php echo json_encode($dynamicTestimonials); ?>;
    let tIdx = 0;
    
    // Auto-populate the first testimonial on load if available
    if (testimonials.length > 0) {
        const card = document.getElementById('testimonialCard');
        if (card) {
            card.querySelector('.testimonial-photo').src = testimonials[0].img;
            card.querySelector('.testimonial-name').textContent = testimonials[0].name;
            card.querySelector('.testimonial-loc').textContent = testimonials[0].loc;
            card.querySelector('.testimonial-quote').textContent = testimonials[0].quote;
            card.querySelector('.testimonial-badge').textContent = testimonials[0].badge;
        }
    }

    function changeTestimonial(dir) {
        if (testimonials.length <= 1) return; // No need to slide if only 1
        tIdx = (tIdx + dir + testimonials.length) % testimonials.length;
        const t = testimonials[tIdx];
        const card = document.getElementById('testimonialCard');
        if (!card) return;
        card.style.opacity = '0';
        card.style.transform = 'translateX(' + (dir > 0 ? '30px' : '-30px') + ')';
        setTimeout(() => {
            card.querySelector('.testimonial-photo').src = t.img;
            card.querySelector('.testimonial-name').textContent = t.name;
            card.querySelector('.testimonial-loc').textContent = t.loc;
            card.querySelector('.testimonial-quote').textContent = t.quote;
            card.querySelector('.testimonial-badge').textContent = t.badge;
            card.style.transition = 'all 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateX(0)';
        }, 250);
    }

</script>

<?php if (!empty($ads['bottom'])): ?>
<div class="bottom-ads-container" style="width:100%; text-align:center; padding: 40px 15px; background: #fff; border-top: 1px solid #eee;">
    <div class="container">
        <?php foreach($ads['bottom'] as $ad): ?>
            <a href="<?php echo htmlspecialchars($ad['link'] ?? '#'); ?>" target="_blank" style="display:inline-block; width: 100%; max-width: 1100px; margin: 10px auto;">
                <img src="<?php echo htmlspecialchars($ad['image']); ?>" alt="<?php echo htmlspecialchars($ad['title']); ?>" style="width: 100%; height: auto; max-height: 400px; object-fit: contain; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($ads['left'])): ?>
<div class="left-ads-container" style="position: fixed; top: 50%; left: 10px; transform: translateY(-50%); z-index: 999; display: flex; flex-direction: column; gap: 15px;">
    <?php foreach($ads['left'] as $ad): ?>
        <a href="<?php echo htmlspecialchars($ad['link'] ?? '#'); ?>" target="_blank" style="display: block;">
            <img src="<?php echo htmlspecialchars($ad['image']); ?>" alt="<?php echo htmlspecialchars($ad['title']); ?>" style="max-width: 160px; max-height: 600px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (!empty($ads['right'])): ?>
<div class="right-ads-container" style="position: fixed; top: 50%; right: 10px; transform: translateY(-50%); z-index: 999; display: flex; flex-direction: column; gap: 15px;">
    <?php foreach($ads['right'] as $ad): ?>
        <a href="<?php echo htmlspecialchars($ad['link'] ?? '#'); ?>" target="_blank" style="display: block;">
            <img src="<?php echo htmlspecialchars($ad['image']); ?>" alt="<?php echo htmlspecialchars($ad['title']); ?>" style="max-width: 160px; max-height: 600px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<style>
/* Hide side banners on smaller screens */
@media (max-width: 1200px) {
    .left-ads-container, .right-ads-container {
        display: none !important;
    }
}
</style>

<?php include 'footer.php'; ?>
</body>

</html>