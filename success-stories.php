<?php
require_once __DIR__ . '/helpers/auth_helper.php';
require_once __DIR__ . '/config/database.php';
$db = sathi_db();

// Fetch all published success stories
$storiesQuery = $db->query("SELECT groom_name, bride_name, story, image, created_at FROM success_stories WHERE status = 1 ORDER BY id DESC");
$stories = $storiesQuery ? $storiesQuery->fetch_all(MYSQLI_ASSOC) : [];

if (empty($stories)) {
    $stories = [
        [
            'groom_name' => 'Rahul',
            'bride_name' => 'Sneha',
            'story' => 'We connected on Shadikibaat and within a week, we knew we were meant for each other. Our families met and the rest is a beautiful history. Thank you for helping me find my soulmate!',
            'image' => 'assets/images/story_1.png',
            'created_at' => '2025-10-12 10:00:00'
        ],
        [
            'groom_name' => 'Vikram',
            'bride_name' => 'Anjali',
            'story' => 'I was skeptical about finding love online, but Anjali changed my perspective completely. Her profile matched exactly what I was looking for. We clicked instantly!',
            'image' => 'assets/images/story_2.png',
            'created_at' => '2025-08-22 10:00:00'
        ],
        [
            'groom_name' => 'Amit',
            'bride_name' => 'Priya',
            'story' => 'From our first chat on Shadikibaat to our wedding day, everything felt so seamless. This platform made it so easy to filter and find someone with the same values.',
            'image' => 'assets/images/story_3.png',
            'created_at' => '2025-11-05 10:00:00'
        ],
        [
            'groom_name' => 'Siddharth',
            'bride_name' => 'Neha',
            'story' => 'Finding love during a busy career seemed impossible, but this platform proved me wrong. Neha understands my ambitions, and together we are building a life we always dreamed of.',
            'image' => 'assets/images/story_4.png',
            'created_at' => '2026-01-14 10:00:00'
        ]
    ];
}

$pageTitle = "Success Stories – Shadikibaat";
$navActive = 'stories';
include 'header.php';
?>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.story-card {
    opacity: 0;
    animation: fadeInUp 0.8s ease-out forwards;
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.story-card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
}
.story-card:hover .story-img-wrap img {
    transform: scale(1.1);
}
.story-img-wrap img {
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.btn-cta {
    display: inline-block;
    background: linear-gradient(135deg, #ff4b82 0%, #ff2a70 100%);
    color: white !important;
    font-size: 1.1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 50px;
    box-shadow: 0 10px 20px rgba(255, 75, 130, 0.3);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.btn-cta:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 15px 30px rgba(255, 75, 130, 0.4);
    color: white !important;
}
</style>

<main class="page-wrap">
    <header class="page-hero">
        <div class="container">
            <p class="page-kicker">Success stories</p>
            <h1>Real love stories</h1>
            <p class="page-lead">Celebrating the beautiful journeys of couples who found love through Shadikibaat.</p>
        </div>
    </header>

    <div class="container page-body">
        <div class="stories-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
            <?php if (empty($stories)): ?>
                <p style="grid-column: 1/-1; text-align: center; padding: 50px; color: #888;">No success stories shared yet. Be the first!</p>
            <?php else: ?>
                <?php $delay = 0; foreach ($stories as $s): 
                    $storyImg = !empty($s['image']) ? $s['image'] : 'assets/testimonial_couple.png';
                ?>
                <div class="story-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 45px rgba(0,0,0,0.05); padding: 40px; text-align: center; animation-delay: <?php echo $delay; ?>s;">
                    <div class="story-img-wrap" style="width: 120px; height: 120px; margin: 0 auto 25px; border-radius: 50%; overflow: hidden; border: 4px solid #fdf2f5;">
                        <img src="<?php echo htmlspecialchars($storyImg); ?>" alt="<?php echo htmlspecialchars($s['groom_name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <blockquote style="margin: 0 0 25px; font-style: italic; color: #444; font-size: 1.1rem; line-height: 1.8;">
                        “<?php echo htmlspecialchars($s['story']); ?>”
                    </blockquote>
                    <cite style="display: block; font-style: normal; font-weight: 700; color: var(--match-pink); font-size: 1.2rem; margin-bottom: 5px;">
                        <?php echo htmlspecialchars($s['groom_name'] . ' & ' . $s['bride_name']); ?>
                    </cite>
                    <div style="font-size: 0.9rem; color: #888;">Married <?php echo date('M Y', strtotime($s['created_at'])); ?></div>
                </div>
                <?php $delay += 0.15; endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="page-cta-wrap" style="text-align: center; margin-top: 60px;">
            <a href="eligibility.php" class="btn-cta" style="padding: 15px 40px; text-decoration: none;">Your story could be next</a>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
