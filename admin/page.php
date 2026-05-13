<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$raw = isset($_GET['p']) ? (string) $_GET['p'] : '';
$slug = preg_replace('/[^a-z0-9-]/', '', strtolower($raw));

if ($slug === '' || !isset($ADMIN_PAGES[$slug])) {
    header('Location: index.php');
    exit;
}

$meta = $ADMIN_PAGES[$slug];
$pageTitle = $meta['title'];
$adminCurrent = $slug;

$pageConfig = require __DIR__ . '/includes/page-config.php';
$pageConfig = $pageConfig[$slug] ?? [];
$pageConfig['slug'] = $slug;
if (isset($pageConfig['breadcrumb'])) {
    $breadcrumbExtra = $pageConfig['breadcrumb'];
}

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/user-storage.php';
require __DIR__ . '/includes/master-storage.php';
require __DIR__ . '/includes/page-builder.php';

$iconClass = (strpos($meta['icon'], 'fa-brands') !== false)
    ? htmlspecialchars($meta['icon'], ENT_QUOTES, 'UTF-8')
    : htmlspecialchars('fas ' . $meta['icon'], ENT_QUOTES, 'UTF-8');
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true">
      <i class="<?php echo $iconClass; ?>"></i>
    </span>
    <h2><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
    <?php if (!empty($pageConfig['description'])): ?>
      <p class="lead"><?php echo htmlspecialchars($pageConfig['description'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
  </div>

  <?php
  $handler = $pageConfig['handler'] ?? null;
  $type = $pageConfig['type'] ?? 'placeholder';
  if ($handler === 'members_approval') {
      admin_render_members_approval_page($pageConfig);
  } elseif ($handler === 'master_data') {
      admin_render_master_data_page($pageConfig);
  } else {
      switch ($type) {
          case 'table':
              admin_render_table_page($pageConfig);
              break;
          case 'form':
              admin_render_form_page($pageConfig);
              break;
          case 'approval':
              admin_render_approval_page($pageConfig);
              break;
          case 'settings':
              admin_render_settings_page($pageConfig);
              break;
          case 'action':
              admin_render_action_page($pageConfig);
              break;
          default:
              admin_render_unknown_page();
              break;
      }
  }
  ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
