<?php
/**
 * User Dashboard
 */
require_once __DIR__ . '/session_init.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/admin/includes/user-storage.php';

if (!isset($_SESSION['sathi_user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['sathi_user_id'];
$user = sathi_user_repo_find_by_id($userId);

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$pageTitle = 'Dashboard – Shadikibaat';
include 'header.php';
?>

<main class="reg-bg">
    <div class="container" style="padding-top: 40px; padding-bottom: 80px;">
        <div style="display: flex; gap: 30px; align-items: flex-start; flex-wrap: wrap;">
            
            <!-- Sidebar -->
            <aside style="flex: 0 0 300px; background: #fff; padding: 25px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; margin: 0 auto 15px; border: 4px solid #f45c93;">
                        <img src="<?php echo $user['profile_photo'] ? 'uploads/profiles/' . $user['profile_photo'] : 'assets/images/default-user.png'; ?>" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h2 style="font-size: 1.2rem; margin: 0;"><?php echo htmlspecialchars($user['name']); ?></h2>
                    <p style="color: #666; font-size: 0.9rem; margin: 5px 0;"><?php echo htmlspecialchars($user['profile_id']); ?></p>
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; background: #fff0f5; color: #f45c93; font-weight: 600; text-transform: uppercase;">
                        <?php echo htmlspecialchars($user['status']); ?>
                    </span>
                </div>
                
                <nav style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="dashboard.php" style="padding: 12px 15px; background: #f45c93; color: #fff; border-radius: 10px; text-decoration: none; font-weight: 600;">Dashboard</a>
                    <a href="profile.php" style="padding: 12px 15px; color: #333; border-radius: 10px; text-decoration: none;">My Profile</a>
                    <a href="matches.php" style="padding: 12px 15px; color: #333; border-radius: 10px; text-decoration: none;">Matches</a>
                    <a href="logout.php" style="padding: 12px 15px; color: #cc0000; border-radius: 10px; text-decoration: none;">Logout</a>
                </nav>
            </aside>

            <!-- Main Content -->
            <section style="flex: 1; min-width: 300px;">
                <div style="background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 30px;">
                    <h1 style="font-size: 1.5rem; margin-top: 0;">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
                    <p style="color: #666; line-height: 1.6;">Your profile is currently <strong><?php echo htmlspecialchars($user['status']); ?></strong>. Once approved by our team, it will be visible to other members.</p>
                    
                    <?php if ($user['status'] === 'pending'): ?>
                        <div style="background: #fff9e6; border-left: 4px solid #ffcc00; padding: 15px; margin-top: 20px; border-radius: 0 10px 10px 0;">
                            <p style="margin: 0; font-size: 0.9rem; color: #856404;">
                                <strong>Verification in progress:</strong> Our admin team is reviewing your documents and payment. This usually takes 24-48 hours.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div style="background: #fff; padding: 20px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
                        <span style="font-size: 2rem; display: block; margin-bottom: 10px;">👁️</span>
                        <h3 style="font-size: 0.9rem; color: #666; margin: 0;">Profile Views</h3>
                        <p style="font-size: 1.5rem; font-weight: 700; margin: 5px 0;">0</p>
                    </div>
                    <div style="background: #fff; padding: 20px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
                        <span style="font-size: 2rem; display: block; margin-bottom: 10px;">❤️</span>
                        <h3 style="font-size: 0.9rem; color: #666; margin: 0;">Interests</h3>
                        <p style="font-size: 1.5rem; font-weight: 700; margin: 5px 0;">0</p>
                    </div>
                    <div style="background: #fff; padding: 20px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
                        <span style="font-size: 2rem; display: block; margin-bottom: 10px;">📩</span>
                        <h3 style="font-size: 0.9rem; color: #666; margin: 0;">Messages</h3>
                        <p style="font-size: 1.5rem; font-weight: 700; margin: 5px 0;">0</p>
                    </div>
                </div>
            </section>

        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
