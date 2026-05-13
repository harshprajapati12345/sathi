<?php
require_once __DIR__ . '/session_init.php';
if (empty($_SESSION['sathi_registration_complete'])) {
    header('Location: register.php');
    exit;
}

$approvalStatus = isset($_SESSION['sathi_registration_status']) ? strtolower((string) $_SESSION['sathi_registration_status']) : 'pending';
if ($approvalStatus !== 'approved') {
    $pageTitle = 'Awaiting Admin Approval';
    $navActive = 'home';
    include 'header.php';
    $statusLabel = $approvalStatus === 'rejected' ? 'rejected' : 'pending approval';
    ?>
    <main class="site-message">
        <div class="container" style="max-width: 680px; padding: 80px 20px; text-align: center;">
            <span style="display:inline-flex; align-items:center; gap:0.7rem; font-size:1.75rem;">🔒</span>
            <h1 style="margin: 24px 0 12px; font-size: 2.25rem;"><?php echo $approvalStatus === 'rejected' ? 'Profile Rejected' : 'Pending Approval'; ?></h1>
            <p style="font-size: 1rem; line-height: 1.8; color: #333; margin: 0 auto 24px; max-width: 520px;">
                <?php if ($approvalStatus === 'rejected'): ?>
                    Your account has been rejected by the admin. Please contact support if you believe this is a mistake.
                <?php else: ?>
                    Your profile is waiting for admin approval. You will receive access to the dashboard once your registration is approved.
                <?php endif; ?>
            </p>
            <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
                <a href="register.php" style="background:#e94e77;color:#fff;padding:14px 24px;border-radius:999px;text-decoration:none;">Edit registration</a>
                <a href="login.php" style="border:1px solid #e94e77;color:#e94e77;padding:14px 24px;border-radius:999px;text-decoration:none;">Return to login</a>
            </div>
        </div>
    </main>
    <?php
    include 'footer.php';
    exit;
}

$pageTitle = "ShadikiBaat – Where Relationships Begin | Find Your Perfect Match";
$navActive = 'home';
include 'header.php';
?>

<!-- ═══ HERO SECTION ═══ -->
<section class="hero hero--fullbleed" id="home">
    <div class="hero-bg" style="background-image: url('assets/hero_couple.png');" role="img"
        aria-label="Indian bride and groom in wedding attire"></div>
    <div class="hero-overlay" aria-hidden="true"></div>
    <div class="container hero-inner">
        <div class="hero-text-block fade-up">
            <div class="hero-label">WHERE RELATIONSHIPS BEGIN ❤️</div>
            <h1>Find Your <span class="accent">Perfect Match</span></h1>
            <p class="hero-sub">Smart matchmaking with real profiles, verified identities, and AI-powered suggestions.
            </p>

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
                <button type="button" class="btn-cta" onclick="location.href='register.php'"><i
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
            <button class="btn-outline" onclick="location.href='register.php'">View All Matches</button>
        </div>

        <div class="profiles-grid">
            <?php
            $profiles = [
                ['name' => 'Priya S.', 'age' => '26', 'rel' => 'Hindu', 'loc' => 'Mumbai, Maharashtra', 'edu' => 'MBA, IIM Bangalore', 'job' => 'Marketing Manager', 'img' => 'assets/profile_1.png'],
                ['name' => 'Ananya R.', 'age' => '24', 'rel' => 'Hindu', 'loc' => 'Bangalore, Karnataka', 'edu' => 'B.Tech, IIT Delhi', 'job' => 'Software Engineer', 'img' => 'assets/profile_2.png'],
                ['name' => 'Neha K.', 'age' => '27', 'rel' => 'Hindu', 'loc' => 'Delhi, Delhi', 'edu' => 'M.Com, Symbiosis', 'job' => 'HR Manager', 'img' => 'assets/profile_3.png'],
                ['name' => 'Pooja M.', 'age' => '25', 'rel' => 'Jain', 'loc' => 'Pune, Maharashtra', 'edu' => 'M.Com, Pune University', 'job' => 'Accountant', 'img' => 'assets/profile_4.png'],
                ['name' => 'Ritika T.', 'age' => '28', 'rel' => 'Hindu', 'loc' => 'Hyderabad, Telangana', 'edu' => 'BBA, Osmania University', 'job' => 'Business Analyst', 'img' => 'assets/profile_5.png'],
            ];
            foreach ($profiles as $p): ?>
                <div class="profile-card fade-up">
                    <div class="profile-img">
                        <img src="<?php echo $p['img']; ?>" alt="<?php echo $p['name']; ?>" loading="lazy">
                        <button class="heart-btn heart-beat">♡</button>
                    </div>
                    <div class="profile-info">
                        <div class="profile-name"><?php echo $p['name']; ?> <span class="verified"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Verified</span></div>
                        <div class="profile-meta"><?php echo $p['age']; ?> yrs · <?php echo $p['rel']; ?></div>
                        <div class="profile-details">
                            <span>📍 <?php echo $p['loc']; ?></span>
                            <span>🎓 <?php echo $p['edu']; ?></span>
                            <span>💼 <?php echo $p['job']; ?></span>
                        </div>
                        <div class="profile-actions">
                            <button class="btn-view" onclick="location.href='register.php'">View</button>
                            <button class="btn-interest" onclick="location.href='register.php'">Interest</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══ VIDEO STORY ═══ -->
<section class="video-story" id="blog">
    <div class="video-banner fade-up">
        <div class="video-overlay"></div>
        <div class="video-content">
            <div class="small-label">WE'RE A LEADING INDUSTRY COMPANY</div>
            <h3>We Are Always at the<br>Forefront of The Marriage Ceremony!</h3>
            <button class="play-btn" aria-label="Play video"><i class="fa-solid fa-play"></i></button>
            <a href="#" class="watch-link">Watch Our Story <i class="fa-solid fa-arrow-right"></i></a>
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
    document.querySelectorAll('.heart-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            this.textContent = this.textContent === '♡' ? '♥' : '♡';
            this.style.color = this.textContent === '♥' ? '#F54E7E' : '';
        });
    });

    /* ── Testimonial carousel ── */
    const testimonials = [
        { name: 'Riya & Aditya', loc: 'Mumbai to Pune 📍', quote: '"Shadikibaat made our journey so easy! We found each other through their AI recommendations and it was love at first chat. The verification process made us feel safe and confident. Forever grateful."', badge: 'Married Nov 2024', img: 'assets/testimonial_couple.png' },
        { name: 'Sneha & Vikram', loc: 'Delhi to Jaipur 📍', quote: '"We never thought online matchmaking could be this wonderful. The verified profiles gave us confidence, and the AI suggestions were incredibly accurate. Thank you ShadikiBaat!"', badge: 'Married Aug 2024', img: 'assets/hero_couple.png' },
        { name: 'Meera & Arjun', loc: 'Bangalore to Chennai 📍', quote: '"From the first match to our wedding day, ShadikiBaat was with us every step. The platform is intuitive, safe, and truly cares about bringing people together. Highly recommend!"', badge: 'Married Mar 2025', img: 'assets/profile_1.png' }
    ];
    let tIdx = 0;
    function changeTestimonial(dir) {
        tIdx = (tIdx + dir + testimonials.length) % testimonials.length;
        const t = testimonials[tIdx];
        const card = document.getElementById('testimonialCard');
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