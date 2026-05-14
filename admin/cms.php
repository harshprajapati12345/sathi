<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'CMS Overview';
$adminCurrent = 'cms-home';

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-layer-group"></i></span>
    <h2>Content management</h2>
    <p class="lead">Jump to static CMS sections.</p>
  </div>

  <div class="admin-cms-grid">
    <a class="admin-cms-tile" href="homepage-banner.php">
      <i class="fas fa-image" aria-hidden="true"></i>
      <h3>Homepage banner</h3>
      <p>Hero imagery &amp; copy.</p>
    </a>
    <a class="admin-cms-tile" href="blogs.php">
      <i class="fas fa-newspaper" aria-hidden="true"></i>
      <h3>Blogs</h3>
      <p>Articles &amp; editorials.</p>
    </a>
    <a class="admin-cms-tile" href="success-stories.php">
      <i class="fas fa-heart" aria-hidden="true"></i>
      <h3>Success stories</h3>
      <p>Couple testimonials.</p>
    </a>
    <a class="admin-cms-tile" href="#" onclick="return false;" style="opacity:0.65;cursor:not-allowed;">
      <i class="fas fa-quote-right" aria-hidden="true"></i>
      <h3>Testimonials</h3>
      <p>Coming soon — wire when needed.</p>
    </a>
    <a class="admin-cms-tile" href="#" onclick="return false;" style="opacity:0.65;cursor:not-allowed;">
      <i class="fas fa-circle-question" aria-hidden="true"></i>
      <h3>FAQ</h3>
      <p>Placeholder.</p>
    </a>
    <a class="admin-cms-tile" href="../about.php">
      <i class="fas fa-circle-info" aria-hidden="true"></i>
      <h3>About us (site)</h3>
      <p>Open public About page.</p>
    </a>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
