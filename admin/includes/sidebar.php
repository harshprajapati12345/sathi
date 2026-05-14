<?php
declare(strict_types=1);
$cur = $adminCurrent ?? '';
?>
<aside class="admin-sidebar" id="adminSidebar">
  <div class="admin-sidebar-brand">
    <span class="admin-sidebar-logo" aria-hidden="true">💍</span>
    <div>
      <span class="admin-sidebar-title">Shadikibaat</span>
      <span class="admin-sidebar-sub">Admin Panel</span>
    </div>
  </div>

  <nav class="admin-sidebar-nav" aria-label="Admin">
    <ul class="admin-nav-root">
      <?php
      $dash = $ADMIN_DASHBOARD ?? null;
      if ($dash && (($dash[0] ?? '') === 'link')):
          $dslug = (string) ($dash[1] ?? '');
          $dlabel = (string) ($dash[2] ?? 'Dashboard');
          $dicon = (string) ($dash[3] ?? 'fa-gauge-high');
          $dhref = $dash[4] ?? 'index.php';
          $dActive = ($cur === 'dashboard');
          $dIconClass = (strpos(trim($dicon), 'fa-brands') !== false) ? trim($dicon) : ('fas ' . trim($dicon));
      ?>
      <li class="admin-nav-dashboard">
        <a href="<?php echo htmlspecialchars((string) $dhref, ENT_QUOTES, 'UTF-8'); ?>" class="admin-nav-link<?php echo $dActive ? ' is-active' : ''; ?>">
          <i class="<?php echo htmlspecialchars($dIconClass, ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
          <span><?php echo htmlspecialchars($dlabel, ENT_QUOTES, 'UTF-8'); ?></span>
        </a>
      </li>
      <?php endif; ?>

      <?php foreach ($ADMIN_NAV_GROUPS ?? [] as $group):
          $gLabel = (string) ($group['label'] ?? '');
          $gId = (string) ($group['id'] ?? 'nav-grp');
          $gLinks = $group['links'] ?? [];
          $isOpen = false;
          foreach ($gLinks as $gl) {
              if (($gl[1] ?? '') === $cur) {
                  $isOpen = true;
                  break;
              }
          }
      ?>
      <li class="admin-nav-dropdown-wrap">
        <details class="admin-nav-dropdown" id="<?php echo htmlspecialchars($gId, ENT_QUOTES, 'UTF-8'); ?>"<?php echo $isOpen ? ' open' : ''; ?>>
          <summary class="admin-nav-dropdown-summary">
            <span class="admin-nav-dropdown-label"><?php echo htmlspecialchars($gLabel, ENT_QUOTES, 'UTF-8'); ?></span>
            <i class="fas fa-chevron-down admin-nav-dropdown-chevron" aria-hidden="true"></i>
          </summary>
          <ul class="admin-nav-submenu">
            <?php foreach ($gLinks as $row):
                if (($row[0] ?? '') !== 'link') {
                    continue;
                }
                $slug = (string) ($row[1] ?? '');
                $label = (string) ($row[2] ?? '');
                $icon = (string) ($row[3] ?? 'fa-circle');
                $hrefOverride = $row[4] ?? null;
                $href = $hrefOverride !== null ? $hrefOverride : ('page.php?p=' . rawurlencode($slug));
                $isActive = ($slug !== 'dashboard' && $cur === $slug);
                $iconTrim = trim($icon);
                $iconClass = (strpos($iconTrim, 'fa-brands') !== false) ? $iconTrim : ('fas ' . $iconTrim);
            ?>
            <li>
              <a href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>" class="admin-nav-link admin-nav-sublink<?php echo $isActive ? ' is-active' : ''; ?>">
                <i class="<?php echo htmlspecialchars($iconClass, ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
                <span><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </details>
      </li>
      <?php endforeach; ?>

      <li class="admin-nav-logout">
        <a href="logout.php" class="admin-nav-link">
          <i class="fas fa-right-from-bracket" aria-hidden="true"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
  </nav>
</aside>
<div class="admin-sidebar-backdrop" id="adminSidebarBackdrop" hidden></div>
