<?php
require_once __DIR__ . '/helpers/auth_helper.php';
require_once __DIR__ . '/config/database.php';
$db = sathi_db();

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    header("Location: blog.php");
    exit;
}

$stmt = $db->prepare("SELECT title, content, image, created_at FROM blogs WHERE slug = ? AND status = 'published'");
$stmt->bind_param("s", $slug);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();

if (!$blog) {
    header("Location: blog.php");
    exit;
}

$pageTitle = htmlspecialchars($blog['title']) . " | Shadikibaat Blog";
$navActive = 'blog';
include 'header.php';

$blogImg = !empty($blog['image']) ? $blog['image'] : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=1000';
?>

<main class="page-wrap">
    <header class="page-hero" style="padding: 100px 0 60px;">
        <div class="container" style="max-width: 800px;">
            <p class="page-kicker" style="color: var(--match-pink); font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px;">
                <?php echo date('F j, Y', strtotime($blog['created_at'])); ?>
            </p>
            <h1 style="font-size: 3.5rem; line-height: 1.1; margin-bottom: 30px;"><?php echo htmlspecialchars($blog['title']); ?></h1>
        </div>
    </header>

    <div class="container" style="max-width: 800px; margin-bottom: 100px;">
        <div class="blog-featured-image" style="border-radius: 30px; overflow: hidden; margin-bottom: 50px; box-shadow: 0 30px 60px rgba(0,0,0,0.1);">
            <img src="<?php echo htmlspecialchars($blogImg); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" style="width: 100%; display: block;">
        </div>

        <div class="blog-content" style="font-size: 1.15rem; line-height: 1.8; color: #333;">
            <?php echo nl2br($blog['content']); ?>
        </div>

        <div style="margin-top: 80px; padding-top: 40px; border-top: 1px solid #eee;">
            <a href="blog.php" class="btn-outline">← Back to Blog</a>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
