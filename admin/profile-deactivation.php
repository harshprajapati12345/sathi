<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Profile Deactivation';
$adminCurrent = 'members-deactivation';

$db = sathi_db();
$query = "SELECT p.*, u.first_name, u.last_name, u.email 
          FROM profile_deactivation_requests p 
          JOIN users u ON p.user_id = u.id 
          ORDER BY p.requested_at DESC";
$result = $db->query($query);
$requests = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-user-slash"></i></span>
    <h2>Profile deactivation requests</h2>
    <p class="lead">Approve or reject member-initiated deactivation.</p>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Member</th>
            <th>Email</th>
            <th>Reason</th>
            <th>Requested At</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($requests)): ?>
            <tr><td colspan="6" style="text-align: center;">No deactivation requests found.</td></tr>
          <?php else: ?>
            <?php foreach ($requests as $req): ?>
            <tr id="req-<?php echo $req['id']; ?>">
                <td><?php echo htmlspecialchars($req['first_name'] . ' ' . $req['last_name']); ?></td>
                <td><?php echo htmlspecialchars($req['email']); ?></td>
                <td><?php echo htmlspecialchars($req['reason']); ?></td>
                <td><?php echo date('Y-m-d H:i', strtotime($req['requested_at'])); ?></td>
                <td class="status-cell">
                    <?php if ($req['status'] === 'pending'): ?>
                        <span class="admin-badge admin-badge-warning">Pending</span>
                    <?php elseif ($req['status'] === 'approved'): ?>
                        <span class="admin-badge admin-badge-success">Approved</span>
                    <?php else: ?>
                        <span class="admin-badge admin-badge-danger">Rejected</span>
                    <?php endif; ?>
                </td>
                <td class="action-cell">
                <?php if ($req['status'] === 'pending'): ?>
                    <div class="admin-actions-inline">
                    <button type="button" class="admin-btn admin-btn-primary admin-btn-sm" onclick="handleDeactivation(<?php echo $req['id']; ?>, 'approved')">Approve</button>
                    <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" onclick="handleDeactivation(<?php echo $req['id']; ?>, 'rejected')">Reject</button>
                    </div>
                <?php else: ?>
                    -
                <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
function handleDeactivation(reqId, action) {
    if (!confirm('Are you sure you want to ' + (action === 'approved' ? 'approve' : 'reject') + ' this request?')) return;
    
    fetch('api/handle-deactivation.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + reqId + '&action=' + action
    })
    .then(r => r.json())
    .then(data => {
        if (data.ok) {
            alert('Request ' + action + ' successfully.');
            location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Network error.');
    });
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
