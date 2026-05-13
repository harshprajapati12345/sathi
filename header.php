<?php
require_once __DIR__ . '/session_init.php';
$sathiLoggedIn = !empty($_SESSION['sathi_registration_complete']);
$sathiUserName = isset($_SESSION['sathi_user_name']) ? trim((string) $_SESSION['sathi_user_name']) : '';
$navUserLabel = ($sathiUserName !== '') ? $sathiUserName : ($sathiLoggedIn ? 'Member' : '');
$sathiRegistrationStatus = isset($_SESSION['sathi_registration_status']) ? strtolower(trim((string) $_SESSION['sathi_registration_status'])) : '';
$navStatusLabel = '';
if ($sathiRegistrationStatus === 'pending') {
    $navStatusLabel = 'Pending approval';
} elseif ($sathiRegistrationStatus === 'rejected') {
    $navStatusLabel = 'Rejected';
} elseif ($sathiRegistrationStatus === 'approved') {
    $navStatusLabel = 'Approved';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ShadikiBaat – India's most trusted matrimonial platform. Find your perfect match with verified profiles and AI-powered suggestions.">
    <meta name="keywords" content="matrimonial, shaadi, marriage, Indian wedding, matchmaking, bride, groom">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'ShadikiBaat – Where Relationships Begin'; ?></title>
    <!-- Google Fonts: Playfair Display + Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <?php if (!empty($extraCss ?? '')): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($extraCss, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>
</head>
<body<?php echo !empty($bodyClass ?? '') ? ' class="' . htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>

<!-- ═══ NAVBAR ═══ -->
<header class="navbar" id="navbar">
  <div class="container navbar-inner">
    <a href="index.php" class="logo">
      <div class="logo-rings" aria-hidden="true">
        <span class="logo-ring logo-ring--a"></span>
        <span class="logo-ring logo-ring--b"></span>
      </div>
      <div class="logo-info">
        <span class="logo-text">SHADIKI<span>BAAT</span></span>
      </div>
    </a>

    <nav class="navbar-center" aria-label="Primary">
      <ul class="nav-links" id="navLinks">
        <?php $na = $navActive ?? ''; ?>
        <li><a href="index.php"<?php echo $na === 'home' ? ' class="active"' : ''; ?>>Home</a></li>
        <li><a href="about.php"<?php echo $na === 'about' ? ' class="active"' : ''; ?>>About Us</a></li>
        <li><a href="membership.php"<?php echo $na === 'membership' ? ' class="active"' : ''; ?>>Membership</a></li>
        <li><a href="success-stories.php"<?php echo $na === 'stories' ? ' class="active"' : ''; ?>>Success Stories</a></li>
        <li><a href="blog.php"<?php echo $na === 'blog' ? ' class="active"' : ''; ?>>Blog</a></li>
        <li><a href="contact.php"<?php echo $na === 'contact' ? ' class="active"' : ''; ?>>Contact</a></li>
      </ul>
    </nav>

    <div class="nav-right">
      <?php if ($sathiLoggedIn): ?>
      <span class="nav-user-name" title="Signed in"><?php echo htmlspecialchars($navUserLabel, ENT_QUOTES, 'UTF-8'); ?></span>
      <?php if ($navStatusLabel !== ''): ?>
      <span class="nav-user-status"><?php echo htmlspecialchars($navStatusLabel, ENT_QUOTES, 'UTF-8'); ?></span>
      <?php endif; ?>
      <?php else: ?>
      <button type="button" class="btn-login" onclick="location.href='login.php'">Login</button>
      <button type="button" class="btn-signup" onclick="location.href='register.php'">Sign Up</button>
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