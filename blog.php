<?php
require_once __DIR__ . '/helpers/auth_helper.php';
$db = sathi_db();

// Fetch all published blogs
$blogsQuery = $db->query("SELECT title, slug, image, content, created_at FROM blogs WHERE status = 'published' ORDER BY id DESC");
$blogs = $blogsQuery ? $blogsQuery->fetch_all(MYSQLI_ASSOC) : [];

$pageTitle = "Blog – Relationship & Marriage Insights | Shadikibaat";
$navActive = 'blog';
include 'header.php';
?>

<main class="page-wrap">
    <header class="page-hero">
        <div class="container">
            <p class="page-kicker">Blog</p>
            <h1>Relationship &amp; marriage insights</h1>
            <p class="page-lead">Explore tips, advice, and inspiring stories to guide you on your journey to love and marriage.</p>
        </div>
    </header>

    <div class="container page-body" id="topics">
        <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
            <?php if (empty($blogs)): ?>
                <p style="grid-column: 1/-1; text-align: center; padding: 50px; color: #888;">No blog posts available yet. Check back soon!</p>
            <?php else: ?>
                <?php foreach ($blogs as $b): 
                    $blogImg = !empty($b['image']) ? $b['image'] : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=1000';
                    $excerpt = substr(strip_tags($b['content']), 0, 150) . '...';
                ?>
                <article class="blog-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 45px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
                    <div class="blog-img-wrap" style="height: 250px; overflow: hidden;">
                        <img src="<?php echo htmlspecialchars($blogImg); ?>" alt="<?php echo htmlspecialchars($b['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 30px;">
                        <div style="font-size: 0.85rem; color: var(--match-pink); font-weight: 600; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px;">
                            <?php echo date('F j, Y', strtotime($b['created_at'])); ?>
                        </div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 15px; line-height: 1.3;"><?php echo htmlspecialchars($b['title']); ?></h3>
                        <p style="color: #666; font-size: 1rem; line-height: 1.7; margin-bottom: 25px;"><?php echo htmlspecialchars($excerpt); ?></p>
                        <a href="blog-detail.php?slug=<?php echo $b['slug']; ?>" class="btn-outline" style="padding: 10px 25px; font-size: 0.9rem;">Read Full Article</a>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
