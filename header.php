<?php
require_once __DIR__ . '/session_init.php';
require_once __DIR__ . '/helpers/auth_helper.php';
sathi_require_approval();
require_once __DIR__ . '/config/database.php';
$siteName = sathi_site_setting('site_name', 'ShadikiBaat');
$metaTitle = sathi_site_setting('meta_title', 'ShadikiBaat – Where Relationships Begin');
$metaDesc = sathi_site_setting('meta_description', 'ShadikiBaat – India\'s most trusted matrimonial platform.');

$sathiUserId = $_SESSION['sathi_user_id'] ?? $_SESSION['user_id'] ?? null;
$sathiLoggedIn = !empty($sathiUserId);

$sathiUserName = $_SESSION['sathi_user_name'] ?? $_SESSION['user_name'] ?? $_SESSION['name'] ?? '';
$navUserLabel = ($sathiUserName !== '') ? trim((string) $sathiUserName) : ($sathiLoggedIn ? 'Member' : '');

$statusRaw = $_SESSION['sathi_registration_status'] ?? $_SESSION['approval_status'] ?? '';
$sathiRegistrationStatus = strtolower(trim((string) $statusRaw));

$navStatusLabel = '';
if ($sathiRegistrationStatus === 'pending') {
  $navStatusLabel = 'Pending approval';
} elseif ($sathiRegistrationStatus === 'rejected') {
  $navStatusLabel = 'Rejected';
} elseif ($sathiRegistrationStatus === 'approved' || $sathiRegistrationStatus === 'active') {
  $navStatusLabel = 'Approved';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo htmlspecialchars($metaDesc); ?>">
  <meta name="keywords" content="matrimonial, shaadi, marriage, Indian wedding, matchmaking, bride, groom">
  <title><?php echo isset($pageTitle) ? $pageTitle : htmlspecialchars($metaTitle); ?></title>
  <!-- Google Fonts: Playfair Display + Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap"
    rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <?php if (!empty($extraCss ?? '')): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($extraCss, ENT_QUOTES, 'UTF-8'); ?>?v=<?php echo time(); ?>">
  <?php endif; ?>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body<?php echo !empty($bodyClass ?? '') ? ' class="' . htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>

  <?php if (!empty($hideNavAndFooter)): ?>
  <style>
    #navbar, #contact { display: none !important; }
    body { padding-top: 0 !important; }
  </style>
  <?php endif; ?>

  <!-- ═══ NAVBAR ═══ -->
  <header class="navbar" id="navbar">
    <div class="container navbar-inner">
      <a href="index.php" class="logo">
        <div class="logo-rings" aria-hidden="true">
          <span class="logo-ring logo-ring--a"></span>
          <span class="logo-ring logo-ring--b"></span>
        </div>
        <div class="logo-info">
          <span class="logo-text"><?php echo strtoupper(htmlspecialchars($siteName)); ?></span>
        </div>
      </a>

      <?php if (empty($hideNavLinks)): ?>
        <nav class="navbar-center" aria-label="Primary">
          <ul class="nav-links" id="navLinks">
            <?php $na = $navActive ?? ''; ?>
            <li><a href="index.php" <?php echo $na === 'home' ? ' class="active"' : ''; ?>>Home</a></li>
            <?php if ($sathiLoggedIn): ?>
              <li><a href="matches.php" <?php echo $na === 'matches' ? ' class="active"' : ''; ?>>Matches</a></li>
            <?php endif; ?>
            <li><a href="about.php" <?php echo $na === 'about' ? ' class="active"' : ''; ?>>About Us</a></li>
            <li><a href="membership.php" <?php echo $na === 'membership' ? ' class="active"' : ''; ?>>Membership</a></li>
            <li><a href="success-stories.php" <?php echo $na === 'stories' ? ' class="active"' : ''; ?>>Success Stories</a>
            </li>
            <li><a href="blog.php" <?php echo $na === 'blog' ? ' class="active"' : ''; ?>>Blog</a></li>
            <li><a href="contact.php" <?php echo $na === 'contact' ? ' class="active"' : ''; ?>>Contact</a></li>
            <li class="mobile-auth-links">
              <?php if ($sathiLoggedIn): ?>
                <a href="profile.php">My Profile</a>
                <a href="logout.php" style="color: var(--pink); font-weight: 600;">Logout</a>
              <?php else: ?>
                <a href="login.php">Login</a>
                <a href="eligibility.php" style="color: var(--pink); font-weight: 600;">Sign Up</a>
              <?php endif; ?>
            </li>
          </ul>
        </nav>
      <?php endif; ?>

      <div class="nav-right">
        <?php if ($sathiLoggedIn): ?>
          <a href="profile.php" class="nav-user-name" style="text-decoration:none;" title="My Profile">My Profile</a>
          <a href="logout.php" class="btn-login" style="margin-left:8px;text-decoration:none;">Logout</a>
        <?php else: ?>
          <button type="button" class="btn-login" onclick="location.href='login.php'">Login</button>
          <button type="button" class="btn-signup" onclick="location.href='eligibility.php'">Sign Up</button>
        <?php endif; ?>
        <button class="hamburger" id="menuToggle" aria-label="Open menu" aria-expanded="false">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </header>

  <script>
    /* Navbar scroll effect */
    window.addEventListener('scroll', () => {
      const nb = document.getElementById('navbar');
      if (window.scrollY > 40) {
        nb.classList.add('scrolled');
      } else {
        nb.classList.remove('scrolled');
      }
    });

    /* Mobile menu toggle */
    document.getElementById('menuToggle').addEventListener('click', function () {
      const nav = document.getElementById('navLinks');
      const isOpen = nav.classList.toggle('open');
      this.setAttribute('aria-expanded', isOpen);
    });
  </script>