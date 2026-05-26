<?php
require_once __DIR__ . '/session_init.php';

// If not logged in, go to register
if (empty($_SESSION['sathi_user_id'])) {
    header('Location: register.php');
    exit;
}

$status = $_SESSION['sathi_registration_status'] ?? 'pending';

// If approved, go to index
if ($status === 'approved' || $status === 'active') {
    header('Location: index.php');
    exit;
}

// If rejected, go to reject
if ($status === 'rejected') {
    header('Location: reject.php');
    exit;
}

$bodyClass = 'reg-page reg-page-register';
$extraCss = 'register-wizard.css';
$pageTitle = 'Pending Approval - ShadikiBaat';
$hideNavAndFooter = true;
include 'header.php';
?>

<style>
    .reg-card-msg {
        text-align: center;
        padding: 60px 40px;
        opacity: 1;
        transform: none;
        position: relative;
        z-index: 3;
        display: block !important;
    }

    @media (max-width: 768px) {
        .reg-card-msg {
            padding: 40px 20px !important;
        }

        .reg-card-msg h1 {
            font-size: 1.8rem !important;
        }
    }

    /* Preloader Styles */
    #approval-preloader {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.5s ease;
    }
    #approval-preloader.show {
        opacity: 1;
        visibility: visible;
    }
    .spinner {
        width: 60px;
        height: 60px;
        border: 5px solid rgba(244, 92, 147, 0.2);
        border-top-color: var(--match-pink, #f45c93);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 20px;
    }
    @keyframes spin { 
        to { transform: rotate(360deg); } 
    }
    .preloader-text {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: #333;
    }
</style>

<!-- Full Screen Preloader -->
<div id="approval-preloader">
    <div class="spinner"></div>
    <div class="preloader-text">Approval successful! Redirecting...</div>
</div>

<main class="reg-bg reg-bg--photo"
    style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px 15px; position: relative;">
    <div class="container" style="max-width: 600px; position: relative; z-index: 2; width: 100%;">
        <div class="reg-card reg-card-msg">
            <div style="font-size: 4rem; margin-bottom: 20px;">⏳</div>
            <h1
                style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--text); margin-bottom: 15px;">
                Application Under Review</h1>
            <p style="font-size: 1.1rem; color: #666; line-height: 1.6; margin-bottom: 30px;">
                Thank you for your interest in ShadikiBaat! <br>
                Your application has been successfully submitted and is now <strong>under review</strong> by our
                verification team.<br><br>
                <strong style="color: #2e7d32; font-size: 1.2rem;">आपका फॉर्म सफलतापूर्वक जमा हो गया है।</strong>
            </p>
            <div
                style="background: var(--bg-soft); padding: 25px; border-radius: 12px; margin-bottom: 30px; text-align: left;">
                <h3 style="font-size: 1rem; color: var(--text); margin-bottom: 10px;">What happens next?</h3>
                <ul style="font-size: 0.9rem; color: #555; padding-left: 20px; line-height: 1.7;">
                    <li>Our team verifies your profile details and documents.</li>
                    <li>We confirm your payment status.</li>
                    <li>Once approved, you will automatically be redirected to find your match.</li>
                </ul>
            </div>
            <div class="reg-actions"
                style="justify-content: center; gap: 15px; margin-top: 30px; padding-top: 0; border-top: none;">
                <a href="logout.php" class="reg-btn reg-btn-secondary"
                    style="text-decoration: none; display: inline-block;">Logout</a>
            </div>
        </div>
    </div>
</main>

<script>
    // Poll the server every 3 seconds to check approval status
    setInterval(() => {
        fetch('api/check-status.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'approved' || data.status === 'active') {
                    // Show preloader
                    document.getElementById('approval-preloader').classList.add('show');
                    // Wait a moment so the user sees the preloader, then redirect
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 1500);
                } else if (data.status === 'rejected') {
                    window.location.href = 'reject.php';
                }
            })
            .catch(err => console.error("Error polling status:", err));
    }, 3000);
</script>

<?php include 'footer.php'; ?>
</body>

</html>