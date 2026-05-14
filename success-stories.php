<?php
require_once __DIR__ . '/helpers/auth_helper.php';
$db = sathi_db();

// Fetch all published success stories
$storiesQuery = $db->query("SELECT groom_name, bride_name, story, image, created_at FROM success_stories WHERE status = 1 ORDER BY id DESC");
$stories = $storiesQuery ? $storiesQuery->fetch_all(MYSQLI_ASSOC) : [];

$pageTitle = "Success Stories – Shadikibaat";
$navActive = 'stories';
include 'header.php';
?>

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
                <?php foreach ($stories as $s): 
                    $storyImg = !empty($s['image']) ? $s['image'] : 'assets/testimonial_couple.png';
                ?>
                <div class="story-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 45px rgba(0,0,0,0.05); padding: 40px; text-align: center;">
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
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="page-cta-wrap" style="text-align: center; margin-top: 60px;">
            <a href="register.php" class="btn-cta" style="padding: 15px 40px; text-decoration: none;">Your story could be next</a>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
