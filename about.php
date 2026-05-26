<?php
$pageTitle = "About Us – Shadikibaat";
$navActive = 'about';
include 'header.php';
?>

<style>
/* ═══════════════════════════════════════════════
   ABOUT PAGE – PREMIUM DESIGN SYSTEM
   ═══════════════════════════════════════════════ */

/* Fonts */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

:root {
    --lf-dark: #1a1a2e;
    --lf-dark-mid: #2a2a4a;
    --lf-btn-hover: #e64680;
    --lf-body: #4a4a68;
    --lf-heading: #f45c93;
    --lf-accent: #ff7ab3;
    --lf-cta-bg: #f45c93;
    --lf-cta-hover: #e64680;
    --lf-pink: #f45c93;
    --lf-pink-light: #fce4ee;
}

.about-page {
    overflow-x: hidden;
}

/* ─── HERO SECTION ─── */
.about-hero-video {
    position: relative;
    width: 100%;
    height: 100vh;
    min-height: 600px;
    overflow: hidden;
}

.about-hero-video .hero-video-layer {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
}

.about-hero-video .hero-video-layer video,
.about-hero-video .hero-video-layer canvas {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* dark gradient overlay so text is readable */
.about-hero-video::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(180deg, rgba(26,26,46,0.35) 0%, rgba(26,26,46,0.10) 40%, rgba(26,26,46,0.55) 100%),
        radial-gradient(ellipse at 30% 80%, rgba(244,92,147,0.30), transparent 60%);
    pointer-events: none;
    z-index: 1;
}

/* ─── HERO COPY (center) ─── */
.hero-copy-center {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    z-index: 10;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 120px 24px 120px;
}

.hero-copy-center h1 {
    font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-weight: 400;
    font-size: clamp(2.2rem, 5.5vw, 5.25rem);
    line-height: 0.95;
    letter-spacing: -0.035em;
    color: #fff;
    max-width: 900px;
    margin: 0;
    opacity: 0;
    transform: translateY(30px);
    animation: heroFadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards;
}

.hero-copy-center h1 .accent {
    color: var(--lf-accent);
}

.hero-copy-center .hero-sub {
    margin-top: 28px;
    font-family: 'Inter', sans-serif;
    font-size: clamp(0.9rem, 1.8vw, 1.15rem);
    font-weight: 400;
    line-height: 1.7;
    color: rgba(255,255,255,0.82);
    max-width: 480px;
    opacity: 0;
    transform: translateY(20px);
    animation: heroFadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.6s forwards;
}

/* ─── BOTTOM-LEFT CTA ─── */
.hero-bl-cta {
    position: absolute;
    left: 24px;
    right: 24px;
    bottom: 28px;
    z-index: 10;
    max-width: 380px;
    opacity: 0;
    transform: translateY(20px);
    animation: heroFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.9s forwards;
}

@media (min-width: 640px) {
    .hero-bl-cta { left: 40px; right: auto; bottom: 40px; }
}

.hero-bl-cta .bl-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255,255,255,0.92);
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.hero-bl-cta .bl-label i {
    font-size: 0.9rem;
}

.hero-bl-cta .bl-desc {
    color: rgba(255,255,255,0.78);
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    line-height: 1.6;
    margin-bottom: 20px;
    max-width: 320px;
}

.hero-bl-cta .bl-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.bl-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    color: var(--lf-dark);
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 10px 22px;
    border-radius: 999px;
    border: none;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    text-decoration: none;
}

.bl-btn-primary:hover {
    background: rgba(255,255,255,0.92);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
    color: var(--lf-dark);
}

.bl-btn-text {
    color: #fff;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    background: none;
    border: none;
    cursor: pointer;
    transition: opacity 0.2s;
    text-decoration: none;
}

.bl-btn-text:hover {
    opacity: 0.75;
    color: #fff;
}

/* ─── BOTTOM-RIGHT PLAY ─── */
.hero-br-play {
    position: absolute;
    right: 40px;
    bottom: 40px;
    z-index: 10;
    display: none;
    align-items: center;
    gap: 10px;
    color: rgba(255,255,255,0.88);
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    opacity: 0;
    transform: translateY(20px);
    animation: heroFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 1.1s forwards;
}

@media (min-width: 640px) {
    .hero-br-play { display: flex; }
}

.play-circle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(255,255,255,0.18);
    backdrop-filter: blur(4px);
    cursor: pointer;
    transition: background 0.25s;
}

.play-circle:hover {
    background: rgba(255,255,255,0.30);
}

.play-circle i {
    font-size: 0.6rem;
    margin-left: 2px;
}

.hero-br-play .time-stamp {
    color: rgba(255,255,255,0.55);
}

/* ─── KEYFRAMES ─── */
@keyframes heroFadeUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ═══ SCROLL ANIMATION SYSTEM ═══ */
.anim-fade-up {
    opacity: 0;
    transform: translateY(45px);
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
}

.anim-fade-up.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.anim-fade-left {
    opacity: 0;
    transform: translateX(-50px);
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
}

.anim-fade-left.is-visible {
    opacity: 1;
    transform: translateX(0);
}

.anim-fade-right {
    opacity: 0;
    transform: translateX(50px);
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
}

.anim-fade-right.is-visible {
    opacity: 1;
    transform: translateX(0);
}

.anim-scale-in {
    opacity: 0;
    transform: scale(0.92);
    transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}

.anim-scale-in.is-visible {
    opacity: 1;
    transform: scale(1);
}

/* stagger delay utility */
.delay-1 { transition-delay: 0.08s; }
.delay-2 { transition-delay: 0.16s; }
.delay-3 { transition-delay: 0.24s; }
.delay-4 { transition-delay: 0.32s; }
.delay-5 { transition-delay: 0.40s; }
.delay-6 { transition-delay: 0.48s; }

/* ═══ SECTION: OUR STORY ═══ */
.about-story-section {
    padding: 110px 0;
    background: #fff;
}

.story-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 70px;
    align-items: center;
}

.story-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    background: rgba(244,92,147,0.12);
    color: var(--lf-heading);
    font-family: 'Inter', sans-serif;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.story-text h2 {
    font-family: 'Inter', sans-serif;
    font-size: clamp(2rem, 3.2vw, 2.8rem);
    font-weight: 700;
    color: var(--lf-dark);
    line-height: 1.15;
    margin-bottom: 28px;
    letter-spacing: -0.02em;
}

.story-text h2 .accent {
    color: var(--lf-heading);
}

.story-text p {
    font-family: 'Inter', sans-serif;
    font-size: 1.05rem;
    line-height: 1.8;
    color: var(--lf-body);
    margin-bottom: 18px;
}

/* Image composition */
.story-visuals {
    position: relative;
    height: 520px;
}

.img-box {
    position: absolute;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(26,26,46,0.12);
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease;
}

.img-box-1 {
    width: 68%;
    height: 78%;
    top: 0;
    left: 0;
    z-index: 2;
}

.img-box-2 {
    width: 58%;
    height: 65%;
    bottom: 0;
    right: 0;
    z-index: 1;
}

.story-visuals:hover .img-box-1 {
    transform: translate(-8px, -8px) scale(1.02);
}

.story-visuals:hover .img-box-2 {
    transform: translate(8px, 8px) scale(1.03);
}

.story-visuals:hover .img-box img {
    transform: scale(1.06);
}

/* floating stat badge */
.floating-stat {
    position: absolute;
    bottom: 30px;
    left: -20px;
    z-index: 5;
    background: #fff;
    border-radius: 16px;
    padding: 16px 22px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 12px;
    animation: floatBounce 3s ease-in-out infinite;
}

.floating-stat .fs-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: var(--lf-pink-light);
    color: var(--lf-pink);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.floating-stat .fs-num {
    font-family: 'Inter', sans-serif;
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--lf-dark);
    line-height: 1;
}

.floating-stat .fs-label {
    font-family: 'Inter', sans-serif;
    font-size: 0.75rem;
    color: var(--lf-body);
    margin-top: 2px;
}

@keyframes floatBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* ═══ SECTION: FEATURES ═══ */
.about-features-section {
    padding: 110px 0;
    background: linear-gradient(170deg, #f6faf6 0%, #f0f5ef 40%, #f9f5fb 100%);
}

.features-header {
    text-align: center;
    margin-bottom: 65px;
}

.features-header h2 {
    font-family: 'Inter', sans-serif;
    font-size: clamp(2rem, 3vw, 2.6rem);
    font-weight: 800;
    color: var(--lf-dark);
    margin-bottom: 14px;
    letter-spacing: -0.02em;
}

.features-header p {
    font-family: 'Inter', sans-serif;
    font-size: 1.05rem;
    color: var(--lf-body);
    max-width: 520px;
    margin: 0 auto;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

.feature-card {
    background: #fff;
    padding: 38px 30px;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(26,26,46,0.04);
    border: 1px solid rgba(244,92,147,0.12);
    transition: all 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    z-index: 1;
    cursor: default;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 0;
    background: linear-gradient(135deg, var(--lf-cta-bg), var(--lf-heading));
    z-index: -1;
    transition: height 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 20px;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(244,92,147,0.18);
    border-color: transparent;
}

.feature-card:hover::before {
    height: 100%;
}

.fc-icon {
    width: 56px;
    height: 56px;
    background: rgba(244,92,147,0.12);
    color: var(--lf-heading);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    margin-bottom: 24px;
    transition: all 0.45s ease;
}

.feature-card:hover .fc-icon {
    background: rgba(255,255,255,0.18);
    color: #fff;
    transform: scale(1.1) rotate(5deg);
}

.feature-card h3 {
    font-family: 'Inter', sans-serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--lf-dark);
    margin-bottom: 12px;
    transition: color 0.4s ease;
}

.feature-card p {
    font-family: 'Inter', sans-serif;
    font-size: 0.92rem;
    line-height: 1.65;
    color: var(--lf-body);
    transition: color 0.4s ease;
}

.feature-card:hover h3,
.feature-card:hover p {
    color: #fff;
}

/* ═══ SECTION: STATS COUNTER ═══ */
.about-stats-section {
    padding: 80px 0;
    background: var(--lf-dark);
    color: #fff;
    position: relative;
    overflow: hidden;
}

.about-stats-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 20% 50%, rgba(244,92,147,0.15), transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(244,92,147,0.08), transparent 50%);
    pointer-events: none;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
    text-align: center;
    position: relative;
    z-index: 1;
}

.stat-item .stat-number {
    font-family: 'Inter', sans-serif;
    font-size: clamp(2.2rem, 4vw, 3.5rem);
    font-weight: 800;
    line-height: 1;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #fff, var(--lf-accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.stat-item .stat-label {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 500;
    color: rgba(255,255,255,0.65);
    letter-spacing: 0.5px;
}

/* ═══ SECTION: CTA ═══ */
.about-cta-section {
    padding: 110px 0;
    background: #fff;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.about-cta-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(244,92,147,0.08), transparent 55%);
    pointer-events: none;
}

.about-cta-section h2 {
    font-family: 'Inter', sans-serif;
    font-size: clamp(2.2rem, 4vw, 3.2rem);
    font-weight: 800;
    color: var(--lf-dark);
    margin-bottom: 16px;
    letter-spacing: -0.02em;
    position: relative;
}

.about-cta-section .tagline {
    font-family: 'Inter', sans-serif;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--lf-heading);
    margin-bottom: 36px;
    position: relative;
}

.cta-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 40px;
    background: linear-gradient(135deg, var(--lf-cta-bg), var(--lf-heading));
    color: #fff;
    font-family: 'Inter', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    border-radius: 999px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px rgba(244,92,147,0.25);
    position: relative;
}

.cta-btn-primary:hover {
    transform: translateY(-3px) scale(1.04);
    box-shadow: 0 14px 36px rgba(244,92,147,0.35);
    color: #fff;
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 1024px) {
    .features-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }
}

@media (max-width: 900px) {
    .story-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .story-visuals {
        height: 380px;
        order: -1;
    }
    .floating-stat {
        left: 10px;
        bottom: 10px;
    }
}

@media (max-width: 640px) {
    .about-hero-video {
        height: 100svh;
        min-height: 500px;
    }
    .features-grid {
        grid-template-columns: 1fr;
    }
    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    .hero-copy-center {
        padding: 100px 20px 140px;
    }
}
</style>

<main class="page-wrap about-page">

    <!-- ═══ HERO: BOOMERANG VIDEO BACKGROUND ═══ -->
    <section class="about-hero-video">
        <div class="hero-video-layer" id="heroVideoLayer">
            <video
                id="heroVideo"
                src="https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260511_131941_d136af49-e243-493a-be14-6ff3f24e09e6.mp4"
                muted
                playsinline
                preload="auto"
                crossorigin="anonymous"
                style="display:block;"
            ></video>
            <canvas id="heroCanvas" style="display:none;"></canvas>
        </div>

        <!-- Hero Copy -->
        <div class="hero-copy-center">
            <h1>
                Where hearts find their
                <span class="accent"><br>perfect match</span>
            </h1>
            <p class="hero-sub">
                Trust, compatibility, and meaningful connections — built for those who are serious about finding a life partner.
            </p>
        </div>

        <!-- Bottom-left CTA -->
        <div class="hero-bl-cta">
            <div class="bl-label">
                <i class="fa-solid fa-sparkles"></i>
                <span>Shadikibaat<sup style="font-size:9px;">™</sup></span>
            </div>
            <p class="bl-desc">
                Shadikibaat connects genuine people seeking lifelong companionship, combining traditional values with modern matchmaking.
            </p>
            <div class="bl-actions">
                <a href="register.php" class="bl-btn-primary">
                    <i class="fa-solid fa-user-plus" style="font-size:0.8rem;"></i>
                    Create Profile
                </a>
                <a href="#about-story" class="bl-btn-text">Know More.</a>
            </div>
        </div>

        <!-- Bottom-right play link -->
        <div class="hero-br-play">
            <div class="play-circle">
                <i class="fa-solid fa-play"></i>
            </div>
            <span style="font-weight:500;">Our journey</span>
            <span class="time-stamp">1:35</span>
        </div>
    </section>

    <!-- ═══ OUR STORY ═══ -->
    <section class="about-story-section" id="about-story">
        <div class="container">
            <div class="story-grid">
                <div class="story-text">
                    <div class="story-badge anim-fade-up">OUR STORY</div>
                    <h2 class="anim-fade-up delay-1">
                        A modern approach to<br>
                        <span class="accent">timeless traditions.</span>
                    </h2>
                    <p class="anim-fade-up delay-2">
                        At Shadikibaat, we believe that marriages are built on trust, compatibility, and meaningful connections. Our platform is designed to bring together individuals who are genuinely looking for a life partner.
                    </p>
                    <p class="anim-fade-up delay-3">
                        We combine traditional values with modern technology to create a safe, reliable, and user-friendly matchmaking experience. Every profile goes through a verification process to ensure authenticity and trust.
                    </p>
                    <p class="anim-fade-up delay-4">
                        Our mission is simple — to help people find not just a match, but a lifelong companion who shares their values, dreams, and vision for the future.
                    </p>
                </div>
                <div class="story-visuals anim-fade-right delay-2">
                    <div class="img-box img-box-1">
                        <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?q=80&w=1000" alt="Happy couple smiling" loading="lazy">
                    </div>
                    <div class="img-box img-box-2">
                        <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=1000" alt="Wedding ceremony" loading="lazy">
                    </div>
                    <div class="floating-stat">
                        <div class="fs-icon"><i class="fa-solid fa-heart"></i></div>
                        <div>
                            <div class="fs-num">5K+</div>
                            <div class="fs-label">Happy Couples</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ STATS ═══ -->
    <section class="about-stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item anim-scale-in delay-1">
                    <div class="stat-number" data-target="5000" data-suffix="+">0</div>
                    <div class="stat-label">Happy Couples</div>
                </div>
                <div class="stat-item anim-scale-in delay-2">
                    <div class="stat-number" data-target="50000" data-suffix="+">0</div>
                    <div class="stat-label">Verified Profiles</div>
                </div>
                <div class="stat-item anim-scale-in delay-3">
                    <div class="stat-number" data-target="10" data-suffix="+ Years">0</div>
                    <div class="stat-label">Of Trust & Experience</div>
                </div>
                <div class="stat-item anim-scale-in delay-4">
                    <div class="stat-number" data-target="99" data-suffix="%">0</div>
                    <div class="stat-label">Customer Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ WHY CHOOSE US ═══ -->
    <section class="about-features-section">
        <div class="container">
            <div class="features-header">
                <div class="story-badge anim-fade-up">WHY CHOOSE US</div>
                <h2 class="anim-fade-up delay-1">The Shadikibaat Promise</h2>
                <p class="anim-fade-up delay-2">We provide a premium experience ensuring privacy, authenticity, and seamless connections.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card anim-fade-up delay-1">
                    <div class="fc-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <h3>100% Verified Profiles</h3>
                    <p>Our stringent verification process ensures you only interact with genuine, serious members seeking marriage.</p>
                </div>
                <div class="feature-card anim-fade-up delay-2">
                    <div class="fc-icon"><i class="fa-solid fa-user-lock"></i></div>
                    <h3>Privacy First</h3>
                    <p>Complete control over your photos and contact details to ensure a secure, stress-free experience.</p>
                </div>
                <div class="feature-card anim-fade-up delay-3">
                    <div class="fc-icon"><i class="fa-solid fa-brain"></i></div>
                    <h3>Smart Matchmaking</h3>
                    <p>Advanced algorithms suggest highly compatible profiles based on your unique preferences and values.</p>
                </div>
                <div class="feature-card anim-fade-up delay-4">
                    <div class="fc-icon"><i class="fa-solid fa-headset"></i></div>
                    <h3>Dedicated Support</h3>
                    <p>Our expert team is always here to assist you through every step of your partner search journey.</p>
                </div>
                <div class="feature-card anim-fade-up delay-5">
                    <div class="fc-icon"><i class="fa-solid fa-gem"></i></div>
                    <h3>Premium Community</h3>
                    <p>Join an exclusive community of like-minded individuals looking for meaningful and lifelong commitments.</p>
                </div>
                <div class="feature-card anim-fade-up delay-6">
                    <div class="fc-icon"><i class="fa-solid fa-heart-circle-check"></i></div>
                    <h3>Success Stories</h3>
                    <p>Thousands of successful marriages start right here. Be the next to find your happily ever after.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ CTA ═══ -->
    <section class="about-cta-section">
        <div class="container">
            <h2 class="anim-fade-up">Ready to find your life partner?</h2>
            <p class="tagline anim-fade-up delay-1" lang="hi">जहां रिश्ते बनते हैं दिल से ❤️</p>
            <div class="anim-fade-up delay-2">
                <a href="register.php" class="cta-btn-primary">
                    <i class="fa-solid fa-arrow-right"></i>
                    Create Free Profile
                </a>
            </div>
        </div>
    </section>

</main>

<script>
(function() {
    'use strict';

    /* ═══ BOOMERANG VIDEO ENGINE ═══ */
    const video = document.getElementById('heroVideo');
    const canvas = document.getElementById('heroCanvas');
    if (video && canvas) {
        const frames = [];
        let capturing = true;
        let lastTime = -1;
        const MAX_WIDTH = 960;

        function captureFrame() {
            if (!capturing || video.readyState < 2) return;
            if (video.currentTime === lastTime) return;
            lastTime = video.currentTime;

            const vw = video.videoWidth;
            const vh = video.videoHeight;
            if (!vw || !vh) return;

            const scale = Math.min(1, MAX_WIDTH / vw);
            const w = Math.round(vw * scale);
            const h = Math.round(vh * scale);

            const c = document.createElement('canvas');
            c.width = w;
            c.height = h;
            const ctx = c.getContext('2d');
            if (!ctx) return;
            ctx.drawImage(video, 0, 0, w, h);
            frames.push(c);
        }

        const hasVFC = typeof video.requestVideoFrameCallback === 'function';
        let rafId = 0;

        function rafLoop() {
            captureFrame();
            if (capturing) rafId = requestAnimationFrame(rafLoop);
        }

        function vfcLoop() {
            captureFrame();
            if (capturing) video.requestVideoFrameCallback(vfcLoop);
        }

        function onEnded() {
            capturing = false;
            if (frames.length > 0) startBoomerang();
        }

        function onLoaded() {
            video.play().catch(function(){});
            if (hasVFC) {
                video.requestVideoFrameCallback(vfcLoop);
            } else {
                rafId = requestAnimationFrame(rafLoop);
            }
        }

        function startBoomerang() {
            video.style.display = 'none';
            canvas.style.display = 'block';

            const first = frames[0];
            canvas.width = first.width;
            canvas.height = first.height;
            const ctx = canvas.getContext('2d');
            if (!ctx) return;

            let index = 0;
            let direction = 1;
            let last = performance.now();
            const interval = 1000 / 30;

            function render(now) {
                if (now - last >= interval) {
                    last = now;
                    ctx.drawImage(frames[index], 0, 0);
                    index += direction;
                    if (index >= frames.length - 1) {
                        index = frames.length - 1;
                        direction = -1;
                    } else if (index <= 0) {
                        index = 0;
                        direction = 1;
                    }
                }
                requestAnimationFrame(render);
            }
            requestAnimationFrame(render);
        }

        video.addEventListener('loadedmetadata', onLoaded);
        video.addEventListener('ended', onEnded);
        if (video.readyState >= 1) onLoaded();
    }

    /* ═══ SCROLL ANIMATIONS ═══ */
    const scrollObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                scrollObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.anim-fade-up, .anim-fade-left, .anim-fade-right, .anim-scale-in').forEach(function(el) {
        scrollObserver.observe(el);
    });

    /* ═══ STAT COUNTER ANIMATION ═══ */
    const statObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting && !entry.target.dataset.counted) {
                entry.target.dataset.counted = 'true';
                const nums = entry.target.querySelectorAll('.stat-number[data-target]');
                nums.forEach(function(el) {
                    const target = parseInt(el.dataset.target, 10);
                    const suffix = el.dataset.suffix || '';
                    let current = 0;
                    const increment = target / 70;
                    const timer = setInterval(function() {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        el.textContent = Math.floor(current).toLocaleString() + suffix;
                    }, 22);
                });
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('.stats-grid').forEach(function(el) {
        statObserver.observe(el);
    });

})();
</script>

<?php include 'footer.php'; ?>
</body>
</html>
