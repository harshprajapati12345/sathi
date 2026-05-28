<?php
require_once __DIR__ . '/helpers/auth_helper.php';
require_once __DIR__ . '/config/database.php';
$db = sathi_db();

// Fetch all published blogs
$blogsQuery = $db->query("SELECT title, slug, image, content, created_at FROM blogs WHERE status = 'published' ORDER BY id DESC");
$blogs = $blogsQuery ? $blogsQuery->fetch_all(MYSQLI_ASSOC) : [];

if (empty($blogs)) {
    $blogs = [
        [
            'title' => '5 Signs You Have Found the One',
            'slug' => '5-signs-you-have-found-the-one',
            'image' => 'assets/images/blog_1.png',
            'content' => 'Finding your life partner is one of the most significant moments in your life. But how do you know if the person you are dating is "the one"? Here are five unmistakable signs that indicate you have found your soulmate...',
            'created_at' => '2026-05-20 10:00:00'
        ],
        [
            'title' => 'Navigating the First Meeting with Families',
            'slug' => 'navigating-first-meeting-with-families',
            'image' => 'assets/images/blog_2.png',
            'content' => 'Meeting your partner\'s family for the first time can be nerve-wracking. It is a crucial step towards marriage in many cultures. Prepare yourself with these essential tips to make a lasting, positive impression...',
            'created_at' => '2026-05-15 10:00:00'
        ],
        [
            'title' => 'How to Communicate Effectively in a Relationship',
            'slug' => 'communicate-effectively-relationship',
            'image' => 'assets/images/blog_3.png',
            'content' => 'Communication is the foundation of any strong relationship. Without it, misunderstandings can quickly escalate into conflicts. Learn the art of active listening and expressing your feelings clearly and respectfully...',
            'created_at' => '2026-05-10 10:00:00'
        ],
        [
            'title' => 'Planning a Wedding on a Budget',
            'slug' => 'planning-wedding-on-budget',
            'image' => 'assets/images/blog_4.png',
            'content' => 'Dreaming of a beautiful wedding but worried about the costs? It is entirely possible to have a magical day without breaking the bank. Discover creative ways to save money while planning the perfect celebration...',
            'created_at' => '2026-05-02 10:00:00'
        ]
    ];
}

$pageTitle = "Blog – Relationship & Marriage Insights | Shadikibaat";
$navActive = 'blog';
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
.blog-card {
    opacity: 0;
    animation: fadeInUp 0.8s ease-out forwards;
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.blog-card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
}
.blog-card:hover .blog-img-wrap img {
    transform: scale(1.05);
}
</style>

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
                <?php $delay = 0; foreach ($blogs as $b): 
                    $blogImg = !empty($b['image']) ? $b['image'] : 'assets/images/blog_1.png';
                    $excerpt = substr(strip_tags($b['content']), 0, 150) . '...';
                ?>
                <article class="blog-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 45px rgba(0,0,0,0.05); display: flex; flex-direction: column; animation-delay: <?php echo $delay; ?>s;">
                    <div class="blog-img-wrap" style="height: 250px; overflow: hidden;">
                        <img src="<?php echo htmlspecialchars($blogImg); ?>" alt="<?php echo htmlspecialchars($b['title']); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);">
                    </div>
                    <div style="padding: 30px; display: flex; flex-direction: column; flex-grow: 1;">
                        <div style="font-size: 0.85rem; color: var(--match-pink); font-weight: 600; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px;">
                            <?php echo date('F j, Y', strtotime($b['created_at'])); ?>
                        </div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 15px; line-height: 1.3;"><?php echo htmlspecialchars($b['title']); ?></h3>
                        <p style="color: #666; font-size: 1rem; line-height: 1.7; margin-bottom: 25px;"><?php echo htmlspecialchars($excerpt); ?></p>
                        <a href="blog-detail.php?slug=<?php echo $b['slug']; ?>" class="btn-outline" style="padding: 10px 25px; font-size: 0.9rem; margin-top: auto; align-self: flex-start;">Read Full Article</a>
                    </div>
                </article>
                <?php $delay += 0.15; endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
