<?php
$formSent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $formSent = true;
}

$pageTitle = "Contact Us – Shadikibaat";
$navActive = 'contact';
include 'header.php';
?>

<main class="page-wrap">
    <header class="page-hero">
        <div class="container">
            <p class="page-kicker">Contact</p>
            <h1>Get in touch</h1>
            <p class="page-lead">We’re here to help you at every step of your journey.</p>
        </div>
    </header>

    <div class="container page-body">
        <div class="contact-layout">
            <div class="contact-info-box">
                <h2>Contact information</h2>
                <ul class="contact-info-list">
                    <li>
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <span><strong>Email:</strong><br><a href="mailto:support@shadikibaat.com">support@shadikibaat.com</a></span>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <span><strong>Phone:</strong><br><a href="tel:+919876543210">+91 98765 43210</a></span>
                    </li>
                    <li>
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        <span><strong>Address:</strong><br>Ahmedabad, Gujarat, India</span>
                    </li>
                </ul>
                <p class="support-note"><strong>Customer support:</strong> Our support team is available 24/7 to assist you with any queries or concerns.</p>
            </div>

            <div class="contact-form-box">
                <h2>Send a message</h2>
                <?php if ($formSent): ?>
                    <p class="form-success" role="status">Thank you — your message has been received. We’ll get back to you soon.<br><br><strong>आपका फॉर्म सफलतापूर्वक जमा हो गया है।</strong></p>
                <?php endif; ?>
                <form method="post" action="contact.php" novalidate>
                    <div class="form-row">
                        <label for="full_name">Full name / पूरा नाम / પૂરું નામ</label>
                        <input type="text" id="full_name" name="full_name" required autocomplete="name"
                            placeholder="Your full name">
                    </div>
                    <div class="form-row">
                        <label for="email">Email address / ईमेल पता / ઇમેઇલ સરનામું</label>
                        <input type="email" id="email" name="email" required autocomplete="email"
                            placeholder="you@example.com">
                    </div>
                    <div class="form-row">
                        <label for="phone">Phone number / फोन नंबर / ફોન નંબર</label>
                        <input type="tel" id="phone" name="phone" autocomplete="tel"
                            placeholder="+91 …">
                    </div>
                    <div class="form-row">
                        <label for="message">Message / संदेश / સંદેશ</label>
                        <textarea id="message" name="message" required placeholder="How can we help you? / हम आपकी कैसे मदद कर सकते हैं? / અમે તમને કેવી રીતે મદદ કરી શકીએ?"></textarea>
                    </div>
                    <button type="submit" name="contact_submit" value="1" class="page-cta" style="width: 100%; justify-content: center;">Send message संदेश भेजें સંદેશ મોકલો</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
