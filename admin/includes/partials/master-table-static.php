<?php
declare(strict_types=1);
/** @var array<int, string>|null $pmItems */
/** @var string|null $pmHeroTitle */
/** @var string|null $pmHeroLead */
/** @var string|null $pmHeroIcon classes e.g. fas fa-place-of-worship */
/** @var string|null $pmDbSlug slug sent to master-action.php */
/** @var list<array{id: string, name: string, status: string}>|null $pmDbRows */
$pmItems = $pmItems ?? [];
$pmDbSlug = $pmDbSlug ?? null;
$pmDbRows = $pmDbRows ?? null;
$useDb = $pmDbSlug !== null && $pmDbSlug !== '' && is_array($pmDbRows);
?>
<section class="admin-page-placeholder">
  <?php if (!empty($pmHeroTitle)): ?>
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="<?php echo htmlspecialchars($pmHeroIcon ?? 'fas fa-database', ENT_QUOTES, 'UTF-8'); ?>"></i></span>
    <h2><?php echo htmlspecialchars((string) $pmHeroTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
    <?php if (!empty($pmHeroLead)): ?>
      <p class="lead"><?php echo htmlspecialchars((string) $pmHeroLead, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <div class="admin-static-toolbar">
    <?php if ($useDb): ?>
    <button type="button" class="admin-btn admin-btn-primary admin-master-add" data-master-slug="<?php echo htmlspecialchars($pmDbSlug, ENT_QUOTES, 'UTF-8'); ?>">Add</button>
    <?php else: ?>
    <button type="button" class="admin-btn admin-btn-primary" data-static-alert="Add row — static UI">Add</button>
    <?php endif; ?>
    <input type="search" class="admin-input-search" placeholder="Search…" aria-label="Search" readonly style="max-width:320px;">
    <div class="admin-switch" title="Status filter (preview)">
      <input type="checkbox" checked aria-label="Show active only" id="master-filter-active">
      <span class="admin-switch-slider"></span>
    </div>
    <span class="admin-sort-hint"><?php echo $useDb ? 'MySQL' : 'Drag sort · UI placeholder'; ?></span>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Status</th>
            <th style="width:160px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($useDb): ?>
            <?php foreach ($pmDbRows as $i => $row): ?>
            <?php
              $rid = htmlspecialchars((string) ($row['id'] ?? ''), ENT_QUOTES, 'UTF-8');
              $rname = htmlspecialchars((string) ($row['name'] ?? ''), ENT_QUOTES, 'UTF-8');
              $rst = htmlspecialchars((string) ($row['status'] ?? ''), ENT_QUOTES, 'UTF-8');
              $badge = ((string) ($row['status'] ?? '')) === 'Active' ? 'ok' : 'pending';
            ?>
          <tr>
            <td><?php echo (int) ($i + 1); ?></td>
            <td><?php echo $rname; ?></td>
            <td><span class="admin-badge <?php echo $badge; ?>"><?php echo $rst; ?></span></td>
            <td>
              <div class="admin-actions-inline">
                <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm admin-master-edit" data-master-slug="<?php echo htmlspecialchars($pmDbSlug, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?php echo $rid; ?>" data-name="<?php echo $rname; ?>" data-status="<?php echo $rst; ?>">Edit</button>
                <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm admin-master-delete" data-master-slug="<?php echo htmlspecialchars($pmDbSlug, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?php echo $rid; ?>">Delete</button>
              </div>
            </td>
          </tr>
            <?php endforeach; ?>
          <?php else: ?>
          <?php foreach ($pmItems as $i => $name): ?>
          <tr>
            <td><?php echo (int) ($i + 1); ?></td>
            <td><?php echo htmlspecialchars((string) $name, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><span class="admin-badge ok">Active</span></td>
            <td>
              <div class="admin-actions-inline">
                <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" data-static-alert>Edit</button>
                <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" data-static-alert>Delete</button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
