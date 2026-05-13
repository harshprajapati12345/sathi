<?php
$pageTitle = "Membership Plans – Shadikibaat";
$navActive = 'membership';
include 'header.php';
?>

<main class="page-wrap">
    <header class="page-hero">
        <div class="container">
            <p class="page-kicker">Membership</p>
            <h1>Membership Plans</h1>
            <p class="page-lead">Choose a plan that suits your journey to finding the perfect match.</p>
        </div>
    </header>

    <div class="container page-body">
        <div class="plans-grid">
            <div class="plan-card">
                <p class="plan-badge">Free</p>
                <h2>Free membership</h2>
                <ul class="plan-features">
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Create profile</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Browse profiles</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Limited interests</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Basic match suggestions</li>
                </ul>
            </div>
            <div class="plan-card plan-card--featured">
                <p class="plan-badge">Most popular</p>
                <h2>Premium membership</h2>
                <ul class="plan-features">
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Unlimited profile views</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Send &amp; receive unlimited interests</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Direct chat &amp; messaging</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Contact details access</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Priority customer support</li>
                </ul>
            </div>
            <div class="plan-card">
                <p class="plan-badge">Elite</p>
                <h2>Elite membership</h2>
                <ul class="plan-features">
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Dedicated relationship manager</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Personalized matchmaking</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Profile highlighting</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Exclusive verified matches</li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Privacy control options</li>
                </ul>
            </div>
        </div>

        <div class="page-cta-wrap">
            <a href="register.php" class="page-cta">Upgrade now &amp; find your perfect match</a>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
