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
$blogsQuery = $db->query("SELECT title, slug, image, content, created_at FROM blogs WHERE status = 'published' ORDER BY id DESC LIMIT 3");
$latestBlogs = $blogsQuery ? $blogsQuery->fetch_all(MYSQLI_ASSOC) : [];
?>

<!-- ═══ HERO SECTION ═══ -->
<section class="hero hero--fullbleed" id="home">
    <div class="hero-bg" style="background-image: url('<?php echo htmlspecialchars($heroBg, ENT_QUOTES, 'UTF-8'); ?>');" role="img"
        aria-label="Hero background image"></div>
    <div class="hero-overlay" aria-hidden="true"></div>
    <div class="container hero-inner">
        <div class="hero-text-block fade-up">
            <div class="hero-label">WHERE RELATIONSHIPS BEGIN ❤️</div>
            <h1><?php echo $heroTitle; ?></h1>
            <p class="hero-sub"><?php echo $heroSub; ?></p>

            <!-- Search/Filter Bar -->
            <div class="search-bar">
                <div class="search-group">
                    <label>I am looking for</label>
                    <div class="toggle-pills">
                        <button type="button" class="active" onclick="togglePill(this)">Bride</button>
                        <button type="button" onclick="togglePill(this)">Groom</button>
                    </div>
                </div>
                <div class="search-group search-group--age">
                    <label>Age Range</label>
                    <div class="dual-range-wrap">
                        <div class="dual-range-track" id="ageTrack" aria-hidden="true"></div>
                        <input type="range" min="18" max="50" value="21" id="ageMin" class="dual-range dual-range--min"
                            aria-label="Minimum age">
                        <input type="range" min="18" max="50" value="30" id="ageMax" class="dual-range dual-range--max"
                            aria-label="Maximum age">
                    </div>
                    <span class="range-val" id="ageVal">21 – 30 Years</span>
                </div>
                <div class="search-group">
                    <label>Religion</label>
                    <select aria-label="Religion">
                        <option>Any</option>
                        <option>Hindu</option>
                        <option>Muslim</option>
                        <option>Christian</option>
                        <option>Sikh</option>
                        <option>Jain</option>
                    </select>
                </div>
                <div class="search-group">
                    <label>City</label>
                    <select aria-label="City">
                        <option>All Cities</option>
                        <option>Mumbai</option>
                        <option>Delhi</option>
                        <option>Bangalore</option>
                        <option>Pune</option>
                        <option>Hyderabad</option>
                    </select>
                </div>
                <button type="button" class="btn-cta" onclick="location.href='matches.php'"><i
                        class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><span>Show Matches</span></button>
            </div>
        </div>
    </div>
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
                <button class="btn-outline" onclick="location.href='register.php'">Make Your Profile →</button>
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

<!-- ═══ FEATURED MATCHES ═══ -->
<section class="featured" id="membership">
    <div class="container">
        <div class="featured-header fade-up">
            <div>
                <div class="section-label">FEATURED MATCHES ——</div>
                <h2>Discover verified profiles that match your preferences</h2>
            </div>
            <button class="btn-outline" onclick="location.href='matches.php'">View All Matches</button>
        </div>

        <div class="profiles-grid">
            <?php
            // Dynamic Profile Fetching (Homepage)
            require_once __DIR__ . '/includes/registration-config.php';
            // Ensure DB and storage are available
            if (!function_exists('sathi_users_list_by_status')) {
                require_once __DIR__ . '/admin/includes/user-storage.php';
            }
            if (!function_exists('sathi_db')) {
                require_once __DIR__ . '/config/database.php';
            }
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
            $rawRows = sathi_users_list_by_status('approved', 8);
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
                    <i class="fas fa-search" style="font-size: 48px; color: var(--match-pink); margin-bottom: 20px;"></i>
                    <h3>No matches found yet</h3>
                    <p>We're verifying new profiles. Please check back shortly!</p>
                </div>
            <?php endif; ?>
            <?php foreach ($profiles as $p): ?>
                <div class="profile-card fade-up">
                    <div class="profile-img-wrap">
                        <div class="profile-favorite"><i class="far fa-heart"></i></div>
                        <img src="<?php echo $p['img']; ?>" alt="<?php echo $p['name']; ?>" loading="lazy">
                    </div>
                    <div class="profile-info">
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
                            <a href="view-profile.php?id=<?php echo $p['id']; ?>" class="btn-action btn-view-outline"
                                style="text-decoration:none; display:flex; align-items:center; justify-content:center;">View</a>
                            <button class="btn-action btn-interest-solid"
                                onclick="openActionModal('interest', '<?php echo rawurlencode(json_encode(['id' => $p['id'], 'name' => $p['name']])); ?>')">Interest</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══ LATEST BLOGS ═══ -->
<section class="latest-blogs" id="blog" style="padding: 100px 0; background: #fdf2f5;">
    <div class="container">
        <div class="section-header fade-up" style="text-align: center; margin-bottom: 50px;">
            <div class="section-label">LATEST FROM BLOG ———</div>
            <h2>Relationship & Marriage Insights</h2>
        </div>
        
        <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <?php if (empty($latestBlogs)): ?>
                <div class="blog-topic-card fade-up">
                    <div style="padding: 30px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <h3><i class="fa-solid fa-lightbulb" aria-hidden="true" style="color: var(--match-pink);"></i> How to choose the right life partner</h3>
                        <p>Understand compatibility, values, and long-term goals.</p>
                        <a href="blog.php" style="color: var(--match-pink); text-decoration: none; font-weight: 600; margin-top: 15px; display: inline-block;">Read More →</a>
                    </div>
                </div>
                <div class="blog-topic-card fade-up">
                    <div style="padding: 30px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <h3><i class="fa-solid fa-comments" aria-hidden="true" style="color: var(--match-pink);"></i> First conversation tips</h3>
                        <p>Make a great first impression with confidence.</p>
                        <a href="blog.php" style="color: var(--match-pink); text-decoration: none; font-weight: 600; margin-top: 15px; display: inline-block;">Read More →</a>
                    </div>
                </div>
                <div class="blog-topic-card fade-up">
                    <div style="padding: 30px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <h3><i class="fa-solid fa-heart" aria-hidden="true" style="color: var(--match-pink);"></i> Arranged vs love marriage</h3>
                        <p>Finding the balance between tradition and choices.</p>
                        <a href="blog.php" style="color: var(--match-pink); text-decoration: none; font-weight: 600; margin-top: 15px; display: inline-block;">Read More →</a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($latestBlogs as $b): 
                    $blogImg = !empty($b['image']) ? $b['image'] : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=1000';
                    $excerpt = substr(strip_tags($b['content']), 0, 100) . '...';
                ?>
                <div class="blog-card fade-up" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
                    <div class="blog-img-wrap" style="height: 200px; overflow: hidden;">
                        <img src="<?php echo htmlspecialchars($blogImg); ?>" alt="<?php echo htmlspecialchars($b['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 25px;">
                        <div style="font-size: 0.8rem; color: #888; margin-bottom: 10px;"><?php echo date('M j, Y', strtotime($b['created_at'])); ?></div>
                        <h3 style="font-size: 1.25rem; margin-bottom: 15px; line-height: 1.4;"><?php echo htmlspecialchars($b['title']); ?></h3>
                        <p style="color: #666; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;"><?php echo htmlspecialchars($excerpt); ?></p>
                        <a href="blog.php?slug=<?php echo $b['slug']; ?>" style="color: var(--match-pink); text-decoration: none; font-weight: 600; display: inline-block;">Read More →</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div style="text-align: center; margin-top: 50px;">
            <a href="blog.php" class="btn-outline">View All Articles</a>
        </div>
    </div>
</section>

<!-- ═══ TESTIMONIAL ═══ -->
<section class="testimonial" id="stories">
    <div class="container">
        <h2>What Our Couples Say</h2>
        <div class="testimonial-card fade-up" id="testimonialCard">
            <img src="assets/testimonial_couple.png" alt="Riya & Aditya" class="testimonial-photo" loading="lazy">
            <div class="testimonial-content">
                <div class="testimonial-name">Riya &amp; Aditya</div>
                <div class="testimonial-loc">Mumbai to Pune 📍</div>
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"Shadikibaat made our journey so easy! We found each other through their AI
                    recommendations and it was love at first chat. The verification process made us feel safe and
                    confident. Forever grateful."</p>
                <span class="testimonial-badge">Married Nov 2024</span>
            </div>
        </div>
        <div class="testimonial-nav">
            <button aria-label="Previous" onclick="changeTestimonial(-1)">❮</button>
            <button aria-label="Next" onclick="changeTestimonial(1)">❯</button>
        </div>
    </div>
</section>

<script>
    /* ── Toggle Bride/Groom pills ── */
    function togglePill(btn) {
        btn.parentElement.querySelectorAll('button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
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

<?php include 'footer.php'; ?>
</body>

</html>