<?php
require_once __DIR__ . '/session_init.php';
require_once __DIR__ . '/includes/registration-config.php';
require_once __DIR__ . '/includes/registration-masters-db.php';
$masters = sathi_registration_masters_from_db();
require_once __DIR__ . '/config/database.php';
$payment_enabled = sathi_site_setting('payment_enabled', '0') === '1';

$pageTitle = 'Register ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Å“ Shadikibaat | Marriage Bureau Onboarding';
$bodyClass = 'reg-page reg-page-register';
$extraCss = 'register-wizard.css';
$hideNavLinks = true;
include 'header.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<main class="reg-bg reg-bg--photo">
    <div class="container reg-shell reg-shell--hero">
        <div class="reg-form-column">
            <div class="reg-card">
                <header class="reg-card-head">
                    <p class="reg-badge"><span aria-hidden="true">ÃƒÂ°Ã…Â¸Ã¢â‚¬â„¢Ã‚Â</span> Trusted matrimonial bureau
                    </p>
                    <h1>Create your profile</h1>
                    <p class="reg-card-lead">A secure onboarding ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Â verified profiles for families
                        serious about finding
                        the right match.</p>
                </header>

                <div class="reg-stepper-wrap">
                    <ol class="reg-stepper" role="list">
                        <li class="reg-step-item active" data-step="0"><span class="num">1</span><span>Basic Info</span>
                        </li>
                        <li class="reg-step-item" data-step="1"><span class="num">2</span><span>Contact</span></li>
                        <li class="reg-step-item" data-step="2"><span class="num">3</span><span>Career</span></li>
                        <li class="reg-step-item" data-step="3"><span class="num">4</span><span>Family</span></li>
                        <li class="reg-step-item" data-step="4"><span class="num">5</span><span>Upload</span></li>
                        <?php if ($payment_enabled): ?>
                            <li class="reg-step-item" data-step="5"><span class="num">6</span><span>Payment</span></li>
                        <?php endif; ?>
                    </ol>
                </div>

                <form id="regWizard" class="reg-form" action="#" method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="csrf_token"
                        value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <!-- STEP 1 -->
                    <div class="reg-panel active" data-panel="0">
                        <h2 class="reg-section-title">Basic Information</h2>
                        <div class="reg-grid">
                            <!-- 1. Full Name -->
                            <div<?php echo sathi_reg_field_wrap_attrs('full_name', 'reg-grid-full'); ?>>
                                <div class="reg-float reg-grid-full">
                                    <input type="text" id="full_name" name="full_name" placeholder=" " <?php echo sathi_reg_field_required_attr('full_name'); ?> autocomplete="name">
                                    <label for="full_name">Full Name</label>
                                </div>
                        </div>

                        <!-- 2. Gender -->
                        <div<?php echo sathi_reg_field_wrap_attrs('gender'); ?>>
                            <div class="reg-float reg-float-select">
                                <select id="gender" name="gender" <?php echo sathi_reg_field_required_attr('gender'); ?>>
                                    <option value="" disabled selected></option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <label for="gender">Gender</label>
                            </div>
                    </div>

                    <!-- 3. Marital Status -->
                    <div<?php echo sathi_reg_field_wrap_attrs('marital_status'); ?>>
                        <div class="reg-float reg-float-select">
                            <select id="marital_status" name="marital_status" <?php echo sathi_reg_field_required_attr('marital_status'); ?>>
                                <?php sathi_reg_render_select_options($masters['marital_status']); ?>
                            </select>
                            <label for="marital_status">Marital Status</label>
                        </div>
            </div>

            <!-- 4. Mother Tongue -->
            <div<?php echo sathi_reg_field_wrap_attrs('mother_tongue'); ?>>
                <div class="reg-float reg-float-select">
                    <select id="mother_tongue" name="mother_tongue" <?php echo sathi_reg_field_required_attr('mother_tongue'); ?>>
                        <?php sathi_reg_render_select_options($masters['mother_tongue']); ?>
                    </select>
                    <label for="mother_tongue">Mother Tongue</label>
                </div>
        </div>
        <!-- 5. Email Address -->
        <div<?php echo sathi_reg_field_wrap_attrs('email'); ?>>
            <div class="reg-float">
                <input type="email" id="email" name="email" placeholder=" " <?php echo sathi_reg_field_required_attr('email'); ?> autocomplete="email">
                <label for="email">Email Address</label>
                <span class="reg-error-msg">Enter a valid email</span>
            </div>
    </div>

    <!-- 6. Password -->
    <div class="reg-float">
        <input type="password" id="password" name="password" placeholder=" " required autocomplete="new-password"
            minlength="8">
        <label for="password">Password (Minimum 8 Characters)</label>
    </div>

    <!-- 7. Confirm Password -->
    <div class="reg-float">
        <input type="password" id="password_confirm" name="password_confirm" placeholder=" " required
            autocomplete="new-password" minlength="8">
        <label for="password_confirm">Confirm Password</label>
    </div>

    <!-- 8. Are You Digamber Jain? -->
    <div<?php echo sathi_reg_field_wrap_attrs('digamber_jain'); ?>>
        <div class="reg-float reg-float-select">
            <select id="digamber" name="digamber" <?php echo sathi_reg_field_required_attr('digamber_jain'); ?>>
                <option value="yes" selected>Yes</option>
                <option value="no">No</option>
            </select>
            <label for="digamber">Are You Digamber Jain?</label>
        </div>
        </div>

        <!-- 9. Religion -->
        <div<?php echo sathi_reg_field_wrap_attrs('religion'); ?>>
            <div class="reg-float reg-float-select">
                <select id="religion_status" name="religion_status" <?php echo sathi_reg_field_required_attr('religion'); ?>>
                    <?php sathi_reg_render_select_options($masters['religion']); ?>
                </select>
                <label for="religion_status">Religion</label>
            </div>
            </div>

            <!-- 10. Temple -->
            <div<?php echo sathi_reg_field_wrap_attrs('temple', 'reg-grid-full'); ?>>
                <div class="reg-float reg-grid-full">
                    <input type="text" id="temple" name="temple" placeholder=" " <?php echo sathi_reg_field_required_attr('temple'); ?>>
                    <label for="temple">Which Temple (Atishay Kshetra / Local)?</label>
                </div>
                </div>
                </div>

                <h2 class="reg-section-title" style="margin-top:2rem;">Birth Details</h2>
                <div class="reg-grid">
                    <div<?php echo sathi_reg_field_wrap_attrs('birth_date'); ?>>
                        <div class="reg-float">
                            <input type="date" id="birth_date" name="birth_date" placeholder=" " <?php echo sathi_reg_field_required_attr('birth_date'); ?>>
                            <label for="birth_date">Birth Date (MM/DD/YYYY)</label>
                        </div>
                </div>
                <div<?php echo sathi_reg_field_wrap_attrs('birth_time'); ?>>
                    <div class="reg-float">
                        <input type="time" id="birth_time" name="birth_time" placeholder=" " <?php echo sathi_reg_field_required_attr('birth_time'); ?>>
                        <label for="birth_time">Birth Time</label>
                    </div>
                    </div>
                    <div<?php echo sathi_reg_field_wrap_attrs('birth_country'); ?>>
                        <div class="reg-float reg-float-select">
                            <select id="birth_country" name="birth_country" <?php echo sathi_reg_field_required_attr('birth_country'); ?> data-geo-role="country"
                                data-geo-prefix="birth_">
                                <?php sathi_reg_render_select_options($masters['geo']['countries']); ?>
                            </select>
                            <label for="birth_country">Birth Country</label>
                        </div>
                        </div>
                        <div<?php echo sathi_reg_field_wrap_attrs('birth_state'); ?>>
                            <div class="reg-float reg-float-select">
                                <select id="birth_state" name="birth_state" <?php echo sathi_reg_field_required_attr('birth_state'); ?> data-geo-role="state"
                                    data-geo-prefix="birth_">
                                    <option value="" disabled selected>Select State</option>
                                </select>
                                <label for="birth_state">Birth State</label>
                            </div>
                            </div>
                            <div<?php echo sathi_reg_field_wrap_attrs('birth_city'); ?>>
                                <div class="reg-float reg-float-select">
                                    <select id="birth_city" name="birth_city" <?php echo sathi_reg_field_required_attr('birth_city'); ?> data-geo-role="city"
                                        data-geo-prefix="birth_">
                                        <option value="" disabled selected>Select City</option>
                                    </select>
                                    <label for="birth_city">Birth City</label>
                                </div>
                                </div>
                                <div<?php echo sathi_reg_field_wrap_attrs('birth_place'); ?>>
                                    <div class="reg-float">
                                        <input type="text" id="birth_place" name="birth_place" placeholder=" " <?php echo sathi_reg_field_required_attr('birth_place'); ?>>
                                        <label for="birth_place">Birth Place (Locality / Hospital)</label>
                                    </div>
                                    </div>
                                    </div>

                                    <h2 class="reg-section-title" style="margin-top:2rem;">Native Details</h2>
                                    <div class="reg-grid">
                                        <div<?php echo sathi_reg_field_wrap_attrs('native_country'); ?>>
                                            <div class="reg-float reg-float-select">
                                                <select id="native_country" name="native_country" <?php echo sathi_reg_field_required_attr('native_country'); ?>
                                                    data-geo-role="country" data-geo-prefix="native_">
                                                    <?php sathi_reg_render_select_options($masters['geo']['countries']); ?>
                                                </select>
                                                <label for="native_country">Native Country</label>
                                            </div>
                                    </div>
                                    <div<?php echo sathi_reg_field_wrap_attrs('native_state'); ?>>
                                        <div class="reg-float reg-float-select">
                                            <select id="native_state" name="native_state" <?php echo sathi_reg_field_required_attr('native_state'); ?> data-geo-role="state"
                                                data-geo-prefix="native_">
                                                <option value="" disabled selected>Select State</option>
                                            </select>
                                            <label for="native_state">Native State</label>
                                        </div>
                                        </div>
                                        <div<?php echo sathi_reg_field_wrap_attrs('native_city'); ?>>
                                            <div class="reg-float reg-float-select">
                                                <select id="native_city" name="native_city" <?php echo sathi_reg_field_required_attr('native_city'); ?>
                                                    data-geo-role="city" data-geo-prefix="native_">
                                                    <option value="" disabled selected>Select City</option>
                                                </select>
                                                <label for="native_city">Native City</label>
                                            </div>
                                            </div>
                                            <div<?php echo sathi_reg_field_wrap_attrs('native_place'); ?>>
                                                <div class="reg-float">
                                                    <input type="text" id="native_place" name="native_place"
                                                        placeholder=" " <?php echo sathi_reg_field_required_attr('native_place'); ?>>
                                                    <label for="native_place">Native Locality</label>
                                                </div>
                                                </div>
                                                </div>

                                                <h2 class="reg-section-title" style="margin-top:2rem;">Astro & Horoscope
                                                </h2>
                                                <div class="reg-grid">
                                                    <!-- 21. Gotra -->
                                                    <div<?php echo sathi_reg_field_wrap_attrs('gotra'); ?>>
                                                        <div class="reg-float reg-float-select">
                                                            <select id="gotra" name="gotra" <?php echo sathi_reg_field_required_attr('gotra'); ?>>
                                                                <?php sathi_reg_render_select_options($masters['gotra']); ?>
                                                            </select>
                                                            <label for="gotra">Gotra</label>
                                                        </div>
                                                </div>
                                                <!-- 22. Star -->
                                                <div<?php echo sathi_reg_field_wrap_attrs('star'); ?>>
                                                    <div class="reg-float reg-float-select">
                                                        <select id="star" name="star" <?php echo sathi_reg_field_required_attr('star'); ?>>
                                                            <?php sathi_reg_render_select_options($masters['star']); ?>
                                                        </select>
                                                        <label for="star">Star (Nakshatra)</label>
                                                    </div>
                                                    </div>

                                                    <!-- 23. Rasi -->
                                                    <div<?php echo sathi_reg_field_wrap_attrs('rasi'); ?>>
                                                        <div class="reg-float reg-float-select">
                                                            <select id="rasi" name="rasi" <?php echo sathi_reg_field_required_attr('rasi'); ?>>
                                                                <?php sathi_reg_render_select_options($masters['rasi']); ?>
                                                            </select>
                                                            <label for="rasi">Rasi (Moon Sign)</label>
                                                        </div>
                                                        </div>

                                                        <!-- 24. Dosh -->
                                                        <div<?php echo sathi_reg_field_wrap_attrs('dosh'); ?>>
                                                            <div class="reg-float reg-float-select">
                                                                <select id="dosh" name="dosh" <?php echo sathi_reg_field_required_attr('dosh'); ?>>
                                                                    <?php sathi_reg_render_select_options($masters['dosh']); ?>
                                                                </select>
                                                                <label for="dosh">Dosh (Mangal etc.)</label>
                                                            </div>
                                                            </div>
                                                            <!-- 25. Which Kundli -->
                                                            <div<?php echo sathi_reg_field_wrap_attrs('kundli_type', 'reg-grid-full'); ?>>
                                                                <div class="reg-float reg-grid-full">
                                                                    <input type="text" id="kundli_type"
                                                                        name="kundli_type" placeholder=" " <?php echo sathi_reg_field_required_attr('kundli_type'); ?>>
                                                                    <label for="kundli_type">Which Kundli (Ashtakvarga /
                                                                        Lagna etc.)?</label>
                                                                </div>
                                                                </div>
                                                                <div<?php echo sathi_reg_field_wrap_attrs('kundli_image', 'reg-grid-full reg-upload-field'); ?>>
                                                                    <p class="reg-upload-heading">Kundli
                                                                        Image (JPG / PNG - Optional)</p>
                                                                    <label class="reg-upload" id="kundliZone">
                                                                        <input type="file" id="kundli_image"
                                                                            name="kundli_image"
                                                                            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                                                            <?php echo sathi_reg_field_required_attr('kundli_image'); ?> aria-label="Upload kundli image">
                                                                        <span class="reg-upload-body">
                                                                            <span class="reg-upload-icon"
                                                                                aria-hidden="true"><i
                                                                                    class="fa-solid fa-wand-magic-sparkles"></i></span>
                                                                            <span class="reg-upload-title">Click to
                                                                                upload Kundli Image</span>
                                                                            <span id="kundliName"
                                                                                class="reg-file-name"></span>
                                                                        </span>
                                                                    </label>
                                                                    </div>
                                                                    <div<?php echo sathi_reg_field_wrap_attrs('horoscope', 'reg-grid-full reg-upload-field'); ?>>
                                                                        <p class="reg-upload-heading">
                                                                            Horoscope (PDF / JPG / PNG)</p>
                                                                        <label class="reg-upload" id="horoscopeZone">
                                                                            <input type="file" id="horoscope"
                                                                                name="horoscope"
                                                                                accept=".pdf,.jpg,.jpeg,.png,application/pdf"
                                                                                <?php echo sathi_reg_field_required_attr('horoscope'); ?> aria-label="Upload horoscope file">
                                                                            <span class="reg-upload-body">
                                                                                <span class="reg-upload-icon"
                                                                                    aria-hidden="true"><i
                                                                                        class="fa-solid fa-file-lines"></i></span>
                                                                                <span class="reg-upload-title">Click to
                                                                                    upload Horoscope</span>
                                                                                <span id="horoscopeName"
                                                                                    class="reg-file-name"></span>
                                                                            </span>
                                                                        </label>
                                                                        </div>
                                                                        </div>
                                                                        </div>

                                                                        <!-- STEP 2 -->
                                                                        <div class="reg-panel" data-panel="1">
                                                                            <h2 class="reg-section-title">
                                                                                Contact &amp; address</h2>
                                                                            <div class="reg-split">
                                                                                <div class="reg-subcard">
                                                                                    <h3><i
                                                                                            class="fa-solid fa-phone"></i>
                                                                                        Contact</h3>
                                                                                    <div<?php echo sathi_reg_field_wrap_attrs('mobile'); ?>>
                                                                                        <div class="reg-phone-row">
                                                                                            <div
                                                                                                class="reg-float reg-float-select reg-cc">
                                                                                                <select
                                                                                                    id="country_code"
                                                                                                    name="country_code">
                                                                                                    <option value="+91"
                                                                                                        selected>+91
                                                                                                    </option>
                                                                                                    <option value="+1">
                                                                                                        +1</option>
                                                                                                    <option value="+44">
                                                                                                        +44</option>
                                                                                                </select>
                                                                                                <label
                                                                                                    for="country_code">Code</label>
                                                                                            </div>
                                                                                            <div class="reg-float"
                                                                                                style="flex:1;">
                                                                                                <input type="tel"
                                                                                                    id="mobile"
                                                                                                    name="mobile"
                                                                                                    placeholder=" "
                                                                                                    <?php echo sathi_reg_field_required_attr('mobile'); ?> maxlength="10"
                                                                                                    pattern="[0-9]{10}"
                                                                                                    inputmode="numeric">
                                                                                                <label
                                                                                                    for="mobile">Contact
                                                                                                    Number</label>
                                                                                                <span
                                                                                                    class="reg-error-msg">Enter
                                                                                                    10-digit mobile
                                                                                                    number</span>
                                                                                            </div>
                                                                                        </div>
                                                                                </div>

                                                                                <label class="reg-checkbox-row"
                                                                                    style="margin-top: 10px; margin-bottom: 10px;">
                                                                                    <input type="checkbox"
                                                                                        id="whatsapp_same"
                                                                                        name="whatsapp_same">
                                                                                    <span>WhatsApp number is same as
                                                                                        contact number</span>
                                                                                </label>

                                                                                <div<?php echo sathi_reg_field_wrap_attrs('whatsapp_number'); ?>>
                                                                                    <div class="reg-phone-row">
                                                                                        <div
                                                                                            class="reg-float reg-float-select reg-cc">
                                                                                            <select id="wa_country_code"
                                                                                                name="wa_country_code">
                                                                                                <option value="+91"
                                                                                                    selected>+91
                                                                                                </option>
                                                                                                <option value="+1">+1
                                                                                                </option>
                                                                                                <option value="+44">+44
                                                                                                </option>
                                                                                            </select>
                                                                                            <label
                                                                                                for="wa_country_code">Code</label>
                                                                                        </div>
                                                                                        <div class="reg-float"
                                                                                            style="flex:1;">
                                                                                            <input type="tel"
                                                                                                id="whatsapp_number"
                                                                                                name="whatsapp_number"
                                                                                                placeholder=" " <?php echo sathi_reg_field_required_attr('whatsapp_number'); ?> maxlength="10"
                                                                                                pattern="[0-9]{10}"
                                                                                                inputmode="numeric">
                                                                                            <label
                                                                                                for="whatsapp_number">WhatsApp
                                                                                                Number</label>
                                                                                            <span
                                                                                                class="reg-error-msg">Enter
                                                                                                10-digit WhatsApp
                                                                                                number</span>
                                                                                        </div>
                                                                                    </div>
                                                                            </div>

                                                                            <p class="reg-otp-note"><i
                                                                                    class="fa-solid fa-shield-halved"></i>
                                                                                OTP verification can be enabled before
                                                                                profile goes live.</p>
                                                                        </div>
                                                                        <div class="reg-subcard">
                                                                            <h3><i class="fa-solid fa-location-dot"></i>
                                                                                Address</h3>
                                                                            <div<?php echo sathi_reg_field_wrap_attrs('addr_perm'); ?>>
                                                                                <div class="reg-float">
                                                                                    <textarea id="addr_perm"
                                                                                        name="addr_perm" placeholder=" "
                                                                                        <?php echo sathi_reg_field_required_attr('addr_perm'); ?> rows="3"></textarea>
                                                                                    <label for="addr_perm">Permanent
                                                                                        address</label>
                                                                                </div>
                                                                        </div>
                                                                        <label class="reg-checkbox-row">
                                                                            <input type="checkbox" id="same_as_perm"
                                                                                name="same_as_perm">
                                                                            <span>Same as permanent for
                                                                                current address</span>
                                                                        </label>
                                                                        <div<?php echo sathi_reg_field_wrap_attrs('addr_curr'); ?>
                                                                            style="margin-top:14px;">
                                                                            <div class="reg-float">
                                                                                <textarea id="addr_curr"
                                                                                    name="addr_curr" placeholder=" "
                                                                                    <?php echo sathi_reg_field_required_attr('addr_curr'); ?> rows="3"></textarea>
                                                                                <label for="addr_curr">Current
                                                                                    address</label>
                                                                            </div>
                                                                            </div>
                                                                            </div>
                                                                            </div>
                                                                            </div>

                                                                            <!-- STEP 3 -->
                                                                            <div class="reg-panel" data-panel="2">
                                                                                <h2 class="reg-section-title">
                                                                                    Education &amp; career</h2>
                                                                                <div class="reg-grid">
                                                                                    <div<?php echo sathi_reg_field_wrap_attrs('education', 'reg-grid-full'); ?>>
                                                                                        <div
                                                                                            class="reg-float reg-float-select reg-grid-full">
                                                                                            <select id="education"
                                                                                                name="education" <?php echo sathi_reg_field_required_attr('education'); ?>>
                                                                                                <?php sathi_reg_render_select_options($masters['education']); ?>
                                                                                            </select>
                                                                                            <label
                                                                                                for="education">Higher
                                                                                                education</label>
                                                                                        </div>
                                                                                </div>
                                                                                <div<?php echo sathi_reg_field_wrap_attrs('hobbies', 'reg-grid-full'); ?>>
                                                                                    <div class="reg-grid-full">
                                                                                        <p
                                                                                            style="font-size:13px;font-weight:600;color:#333;margin-bottom:10px;">
                                                                                            Hobbies</p>
                                                                                        <div class="reg-chips">
                                                                                            <label
                                                                                                class="reg-chip"><input
                                                                                                    type="checkbox"
                                                                                                    name="hobby[]"
                                                                                                    value="reading"><span>Reading</span></label>
                                                                                            <label
                                                                                                class="reg-chip"><input
                                                                                                    type="checkbox"
                                                                                                    name="hobby[]"
                                                                                                    value="travelling"><span>Travelling</span></label>
                                                                                            <label
                                                                                                class="reg-chip"><input
                                                                                                    type="checkbox"
                                                                                                    name="hobby[]"
                                                                                                    value="music"><span>Music</span></label>
                                                                                            <label
                                                                                                class="reg-chip"><input
                                                                                                    type="checkbox"
                                                                                                    name="hobby[]"
                                                                                                    value="sports"><span>Sports</span></label>
                                                                                            <label
                                                                                                class="reg-chip"><input
                                                                                                    type="checkbox"
                                                                                                    name="hobby[]"
                                                                                                    value="meditation"><span>Meditation</span></label>
                                                                                        </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div<?php echo sathi_reg_field_wrap_attrs('occupation'); ?>>
                                                                                <div class="reg-float reg-float-select">
                                                                                    <select id="occupation"
                                                                                        name="occupation" <?php echo sathi_reg_field_required_attr('occupation'); ?>>
                                                                                        <?php sathi_reg_render_select_options($masters['occupation']); ?>
                                                                                    </select>
                                                                                    <label
                                                                                        for="occupation">Occupation</label>
                                                                                </div>
                                                                                </div>
                                                                                <div<?php echo sathi_reg_field_wrap_attrs('firm_name'); ?>>
                                                                                    <div class="reg-float">
                                                                                        <input type="text"
                                                                                            id="firm_name"
                                                                                            name="firm_name"
                                                                                            placeholder=" " <?php echo sathi_reg_field_required_attr('firm_name'); ?>>
                                                                                        <label for="firm_name">Firm
                                                                                            / company
                                                                                            name</label>
                                                                                    </div>
                                                                                    </div>
                                                                                    <div<?php echo sathi_reg_field_wrap_attrs('designation'); ?>>
                                                                                        <div class="reg-float">
                                                                                            <input type="text"
                                                                                                id="designation"
                                                                                                name="designation"
                                                                                                placeholder=" " <?php echo sathi_reg_field_required_attr('designation'); ?>>
                                                                                            <label
                                                                                                for="designation">Designation</label>
                                                                                        </div>
                                                                                        </div>
                                                                                        <div<?php echo sathi_reg_field_wrap_attrs('annual_income'); ?>>
                                                                                            <div
                                                                                                class="reg-float reg-float-select">
                                                                                                <select
                                                                                                    id="annual_income"
                                                                                                    name="annual_income"
                                                                                                    <?php echo sathi_reg_field_required_attr('annual_income'); ?>>
                                                                                                    <?php sathi_reg_render_select_options($masters['annual_income']); ?>
                                                                                                </select>
                                                                                                <label
                                                                                                    for="annual_income">Annual
                                                                                                    income
                                                                                                    (bracket)</label>
                                                                                            </div>
                                                                                            <div<?php echo sathi_reg_field_wrap_attrs('height'); ?>>
                                                                                                <div class="reg-float">
                                                                                                    <input type="text"
                                                                                                        id="height"
                                                                                                        name="height"
                                                                                                        placeholder=" "
                                                                                                        <?php echo sathi_reg_field_required_attr('height'); ?>>
                                                                                                    <label
                                                                                                        for="height">Height
                                                                                                        (e.g. 5ft 6in or
                                                                                                        168 cm)</label>
                                                                                                </div>
                                                                                                </div>
                                                                                                <div<?php echo sathi_reg_field_wrap_attrs('weight'); ?>>
                                                                                                    <div
                                                                                                        class="reg-float">
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            id="weight"
                                                                                                            name="weight"
                                                                                                            placeholder=" "
                                                                                                            <?php echo sathi_reg_field_required_attr('weight'); ?>>
                                                                                                        <label
                                                                                                            for="weight">Weight
                                                                                                            (e.g. 65
                                                                                                            kg)</label>
                                                                                                    </div>
                                                                                                    </div>
                                                                                                    <div<?php echo sathi_reg_field_wrap_attrs('complexion'); ?>>
                                                                                                        <div
                                                                                                            class="reg-float">
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                id="complexion"
                                                                                                                name="complexion"
                                                                                                                placeholder=" "
                                                                                                                <?php echo sathi_reg_field_required_attr('complexion'); ?>>
                                                                                                            <label
                                                                                                                for="complexion">Complexion
                                                                                                                (e.g.
                                                                                                                Fair,
                                                                                                                Medium,
                                                                                                                Wheatish)</label>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                        <div<?php echo sathi_reg_field_wrap_attrs('blood_group'); ?>>
                                                                                                            <div
                                                                                                                class="reg-float">
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    id="blood_group"
                                                                                                                    name="blood_group"
                                                                                                                    placeholder=" "
                                                                                                                    <?php echo sathi_reg_field_required_attr('blood_group'); ?>>
                                                                                                                <label
                                                                                                                    for="blood_group">Blood
                                                                                                                    Group
                                                                                                                    (e.g.
                                                                                                                    O+,
                                                                                                                    A+)</label>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            <div<?php echo sathi_reg_field_wrap_attrs('profile_created_by'); ?>>
                                                                                                                <div
                                                                                                                    class="reg-float reg-float-select">
                                                                                                                    <select
                                                                                                                        id="profile_created_by"
                                                                                                                        name="profile_created_by"
                                                                                                                        <?php echo sathi_reg_field_required_attr('profile_created_by'); ?>>
                                                                                                                        <option
                                                                                                                            value="self"
                                                                                                                            selected>
                                                                                                                            Self
                                                                                                                        </option>
                                                                                                                        <option
                                                                                                                            value="parent">
                                                                                                                            Parent
                                                                                                                        </option>
                                                                                                                        <option
                                                                                                                            value="sibling">
                                                                                                                            Sibling
                                                                                                                        </option>
                                                                                                                        <option
                                                                                                                            value="relative">
                                                                                                                            Relative
                                                                                                                        </option>
                                                                                                                        <option
                                                                                                                            value="friend">
                                                                                                                            Friend
                                                                                                                        </option>
                                                                                                                    </select>
                                                                                                                    <label
                                                                                                                        for="profile_created_by">Profile
                                                                                                                        Created
                                                                                                                        By</label>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                <div class="reg-field-wrap"
                                                                                                                    data-reg-field="languages_known">
                                                                                                                    <div
                                                                                                                        class="reg-float">
                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            id="languages_known"
                                                                                                                            name="languages_known"
                                                                                                                            placeholder=" ">
                                                                                                                        <label
                                                                                                                            for="languages_known">Languages
                                                                                                                            Known
                                                                                                                            (e.g.
                                                                                                                            Hindi,
                                                                                                                            English)</label>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                </div>


                                                                                                                <!-- STEP 4 ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Â Family -->
                                                                                                                <div class="reg-panel"
                                                                                                                    data-panel="3">
                                                                                                                    <h2
                                                                                                                        class="reg-section-title">
                                                                                                                        Family
                                                                                                                        details
                                                                                                                    </h2>
                                                                                                                    <div
                                                                                                                        class="reg-split">
                                                                                                                        <div
                                                                                                                            class="reg-subcard">
                                                                                                                            <h3><i
                                                                                                                                    class="fa-solid fa-user-tie"></i>
                                                                                                                                Father
                                                                                                                            </h3>
                                                                                                                            <div<?php echo sathi_reg_field_wrap_attrs('father_name'); ?>>
                                                                                                                                <div
                                                                                                                                    class="reg-float">
                                                                                                                                    <input
                                                                                                                                        type="text"
                                                                                                                                        id="father_name"
                                                                                                                                        name="father_name"
                                                                                                                                        placeholder=" "
                                                                                                                                        <?php echo sathi_reg_field_required_attr('father_name'); ?>>
                                                                                                                                    <label
                                                                                                                                        for="father_name">Father's
                                                                                                                                        name
                                                                                                                                        (Optional)</label>
                                                                                                                                </div>
                                                                                                                        </div>
                                                                                                                        <div<?php echo sathi_reg_field_wrap_attrs('father_mobile'); ?>>
                                                                                                                            <div
                                                                                                                                class="reg-float">
                                                                                                                                <input
                                                                                                                                    type="tel"
                                                                                                                                    id="father_mobile"
                                                                                                                                    name="father_mobile"
                                                                                                                                    placeholder=" "
                                                                                                                                    maxlength="10"
                                                                                                                                    pattern="[0-9]{10}"
                                                                                                                                    <?php echo sathi_reg_field_required_attr('father_mobile'); ?>>
                                                                                                                                <label
                                                                                                                                    for="father_mobile">Mobile
                                                                                                                                    (Optional)</label>
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                                    <div<?php echo sathi_reg_field_wrap_attrs('father_income'); ?>>
                                                                                                                        <div
                                                                                                                            class="reg-float">
                                                                                                                            <input
                                                                                                                                type="text"
                                                                                                                                id="father_income"
                                                                                                                                name="father_income"
                                                                                                                                placeholder=" "
                                                                                                                                inputmode="numeric"
                                                                                                                                <?php echo sathi_reg_field_required_attr('father_income'); ?>>
                                                                                                                            <label
                                                                                                                                for="father_income">Annual
                                                                                                                                income
                                                                                                                                (Optional)</label>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                                <div<?php echo sathi_reg_field_wrap_attrs('father_occ'); ?>>
                                                                                                                    <div
                                                                                                                        class="reg-float">
                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            id="father_occ"
                                                                                                                            name="father_occ"
                                                                                                                            placeholder=" "
                                                                                                                            <?php echo sathi_reg_field_required_attr('father_occ'); ?>>
                                                                                                                        <label
                                                                                                                            for="father_occ">Occupation</label>
                                                                                                                    </div>
                                                                                                                    </div>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="reg-subcard">
                                                                                                                        <h3><i
                                                                                                                                class="fa-solid fa-user"></i>
                                                                                                                            Mother
                                                                                                                        </h3>
                                                                                                                        <div<?php echo sathi_reg_field_wrap_attrs('mother_name'); ?>>
                                                                                                                            <div
                                                                                                                                class="reg-float">
                                                                                                                                <input
                                                                                                                                    type="text"
                                                                                                                                    id="mother_name"
                                                                                                                                    name="mother_name"
                                                                                                                                    placeholder=" "
                                                                                                                                    <?php echo sathi_reg_field_required_attr('mother_name'); ?>>
                                                                                                                                <label
                                                                                                                                    for="mother_name">Mother's
                                                                                                                                    name
                                                                                                                                    (Optional)</label>
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                                    <div<?php echo sathi_reg_field_wrap_attrs('mother_mobile'); ?>>
                                                                                                                        <div
                                                                                                                            class="reg-float">
                                                                                                                            <input
                                                                                                                                type="tel"
                                                                                                                                id="mother_mobile"
                                                                                                                                name="mother_mobile"
                                                                                                                                placeholder=" "
                                                                                                                                maxlength="10"
                                                                                                                                pattern="[0-9]{10}"
                                                                                                                                <?php echo sathi_reg_field_required_attr('mother_mobile'); ?>>
                                                                                                                            <label
                                                                                                                                for="mother_mobile">Mobile
                                                                                                                                (Optional)</label>
                                                                                                                        </div>
                                                                                                                        </div>
                                                                                                                        <div<?php echo sathi_reg_field_wrap_attrs('mother_income'); ?>>
                                                                                                                            <div
                                                                                                                                class="reg-float">
                                                                                                                                <input
                                                                                                                                    type="text"
                                                                                                                                    id="mother_income"
                                                                                                                                    name="mother_income"
                                                                                                                                    placeholder=" "
                                                                                                                                    inputmode="numeric"
                                                                                                                                    <?php echo sathi_reg_field_required_attr('mother_income'); ?>>
                                                                                                                                <label
                                                                                                                                    for="mother_income">Annual
                                                                                                                                    income
                                                                                                                                    (Optional)</label>
                                                                                                                            </div>
                                                                                                                            </div>
                                                                                                                            </div>
                                                                                                                            </div>
                                                                                                                            <div<?php echo sathi_reg_field_wrap_attrs('relative_details'); ?>
                                                                                                                                class="reg-subcard"
                                                                                                                                style="margin-top:20px;">
                                                                                                                                <h3><i
                                                                                                                                        class="fa-solid fa-users-rectangle"></i>
                                                                                                                                    Relative
                                                                                                                                    details
                                                                                                                                </h3>
                                                                                                                                <div
                                                                                                                                    class="reg-float">
                                                                                                                                    <textarea
                                                                                                                                        id="relative_details"
                                                                                                                                        name="relative_details"
                                                                                                                                        placeholder=" "
                                                                                                                                        <?php echo sathi_reg_field_required_attr('relative_details'); ?>
                                                                                                                                        rows="3"></textarea>
                                                                                                                                    <label
                                                                                                                                        for="relative_details">Relative
                                                                                                                                        Information
                                                                                                                                        (Optional)</label>
                                                                                                                                </div>
                                                                                                                                </div>
                                                                                                                                <div<?php echo sathi_reg_field_wrap_attrs('siblings'); ?>
                                                                                                                                    class="reg-subcard"
                                                                                                                                    style="margin-top:20px;">
                                                                                                                                    <h3><i
                                                                                                                                            class="fa-solid fa-people-roof"></i>
                                                                                                                                        Siblings
                                                                                                                                    </h3>
                                                                                                                                    <p
                                                                                                                                        style="font-size:12px;color:#666;margin-bottom:14px;">
                                                                                                                                        Married
                                                                                                                                        +
                                                                                                                                        unmarried
                                                                                                                                        must
                                                                                                                                        equal
                                                                                                                                        total
                                                                                                                                        for
                                                                                                                                        brothers
                                                                                                                                        and
                                                                                                                                        sisters.
                                                                                                                                    </p>
                                                                                                                                    <p
                                                                                                                                        style="font-size:13px;font-weight:600;margin-bottom:8px;">
                                                                                                                                        Brothers
                                                                                                                                    </p>
                                                                                                                                    <div
                                                                                                                                        class="reg-sibling-grid">
                                                                                                                                        <div
                                                                                                                                            class="reg-float">
                                                                                                                                            <input
                                                                                                                                                type="number"
                                                                                                                                                id="bro_total"
                                                                                                                                                name="bro_total"
                                                                                                                                                placeholder=" "
                                                                                                                                                min="0"
                                                                                                                                                value="0"
                                                                                                                                                <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                                                                                                                            <label
                                                                                                                                                for="bro_total">Total</label>
                                                                                                                                        </div>
                                                                                                                                        <div
                                                                                                                                            class="reg-float">
                                                                                                                                            <input
                                                                                                                                                type="number"
                                                                                                                                                id="bro_married"
                                                                                                                                                name="bro_married"
                                                                                                                                                placeholder=" "
                                                                                                                                                min="0"
                                                                                                                                                value="0"
                                                                                                                                                <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                                                                                                                            <label
                                                                                                                                                for="bro_married">Married</label>
                                                                                                                                        </div>
                                                                                                                                        <div
                                                                                                                                            class="reg-float">
                                                                                                                                            <input
                                                                                                                                                type="number"
                                                                                                                                                id="bro_unmarried"
                                                                                                                                                name="bro_unmarried"
                                                                                                                                                placeholder=" "
                                                                                                                                                min="0"
                                                                                                                                                value="0"
                                                                                                                                                <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                                                                                                                            <label
                                                                                                                                                for="bro_unmarried">Unmarried</label>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <span
                                                                                                                                        id="broErr"
                                                                                                                                        class="reg-error-msg sib-err">Married
                                                                                                                                        +
                                                                                                                                        unmarried
                                                                                                                                        must
                                                                                                                                        equal
                                                                                                                                        total
                                                                                                                                        (brothers).</span>
                                                                                                                                    <p
                                                                                                                                        style="font-size:13px;font-weight:600;margin:18px 0 8px;">
                                                                                                                                        Sisters
                                                                                                                                    </p>
                                                                                                                                    <div
                                                                                                                                        class="reg-sibling-grid">
                                                                                                                                        <div
                                                                                                                                            class="reg-float">
                                                                                                                                            <input
                                                                                                                                                type="number"
                                                                                                                                                id="sis_total"
                                                                                                                                                name="sis_total"
                                                                                                                                                placeholder=" "
                                                                                                                                                min="0"
                                                                                                                                                value="0"
                                                                                                                                                <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                                                                                                                            <label
                                                                                                                                                for="sis_total">Total</label>
                                                                                                                                        </div>
                                                                                                                                        <div
                                                                                                                                            class="reg-float">
                                                                                                                                            <input
                                                                                                                                                type="number"
                                                                                                                                                id="sis_married"
                                                                                                                                                name="sis_married"
                                                                                                                                                placeholder=" "
                                                                                                                                                min="0"
                                                                                                                                                value="0"
                                                                                                                                                <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                                                                                                                            <label
                                                                                                                                                for="sis_married">Married</label>
                                                                                                                                        </div>
                                                                                                                                        <div
                                                                                                                                            class="reg-float">
                                                                                                                                            <input
                                                                                                                                                type="number"
                                                                                                                                                id="sis_unmarried"
                                                                                                                                                name="sis_unmarried"
                                                                                                                                                placeholder=" "
                                                                                                                                                min="0"
                                                                                                                                                value="0"
                                                                                                                                                <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                                                                                                                            <label
                                                                                                                                                for="sis_unmarried">Unmarried</label>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <span
                                                                                                                                        id="sisErr"
                                                                                                                                        class="reg-error-msg sib-err">Married
                                                                                                                                        +
                                                                                                                                        unmarried
                                                                                                                                        must
                                                                                                                                        equal
                                                                                                                                        total
                                                                                                                                        (sisters).</span>
                                                                                                                                    </div>
                                                                                                                                    </div>

                                                                                                                                    <!-- STEP 5 ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Â Photo -->
                                                                                                                                    <div class="reg-panel"
                                                                                                                                        data-panel="4">
                                                                                                                                        <h2
                                                                                                                                            class="reg-section-title">
                                                                                                                                            Photo
                                                                                                                                            &amp;
                                                                                                                                            verification
                                                                                                                                        </h2>
                                                                                                                                        <div<?php echo sathi_reg_field_wrap_attrs('photo'); ?>>
                                                                                                                                            <label
                                                                                                                                                class="reg-upload reg-upload--photo"
                                                                                                                                                id="photoZone">
                                                                                                                                                <input
                                                                                                                                                    type="file"
                                                                                                                                                    id="photo"
                                                                                                                                                    name="photo"
                                                                                                                                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                                                                                                                                    <?php echo sathi_reg_field_required_attr('photo'); ?>
                                                                                                                                                    aria-label="Upload profile photo">
                                                                                                                                                <span
                                                                                                                                                    class="reg-upload-body">
                                                                                                                                                    <span
                                                                                                                                                        class="reg-upload-icon"
                                                                                                                                                        aria-hidden="true"><i
                                                                                                                                                            class="fa-solid fa-camera"></i></span>
                                                                                                                                                    <span
                                                                                                                                                        class="reg-upload-title">Upload
                                                                                                                                                        profile
                                                                                                                                                        photograph</span>
                                                                                                                                                    <span
                                                                                                                                                        class="reg-upload-hint">JPG
                                                                                                                                                        or
                                                                                                                                                        PNG
                                                                                                                                                        Ãƒâ€šÃ‚Â·
                                                                                                                                                        Max
                                                                                                                                                        5
                                                                                                                                                        MB
                                                                                                                                                        Ãƒâ€šÃ‚Â·
                                                                                                                                                        Clear
                                                                                                                                                        face
                                                                                                                                                        visible</span>
                                                                                                                                                    <span
                                                                                                                                                        class="reg-progress"
                                                                                                                                                        id="photoProgress"><span
                                                                                                                                                            class="reg-progress-bar"
                                                                                                                                                            id="photoProgressBar"></span></span>
                                                                                                                                                    <img src=""
                                                                                                                                                        alt=""
                                                                                                                                                        class="reg-preview"
                                                                                                                                                        id="photoPreview"
                                                                                                                                                        width="200"
                                                                                                                                                        height="200">
                                                                                                                                                </span>
                                                                                                                                            </label>
                                                                                                                                            <div
                                                                                                                                                class="reg-guidelines">
                                                                                                                                                <h4>Photo
                                                                                                                                                    guidelines
                                                                                                                                                </h4>
                                                                                                                                                <ul>
                                                                                                                                                    <li
                                                                                                                                                        class="ok">
                                                                                                                                                        Passport-style
                                                                                                                                                        preferred
                                                                                                                                                        Ãƒâ€šÃ‚Â·
                                                                                                                                                        Good
                                                                                                                                                        lighting
                                                                                                                                                    </li>
                                                                                                                                                    <li
                                                                                                                                                        class="ok">
                                                                                                                                                        Clear
                                                                                                                                                        face
                                                                                                                                                        visible
                                                                                                                                                    </li>
                                                                                                                                                    <li
                                                                                                                                                        class="bad">
                                                                                                                                                        No
                                                                                                                                                        selfies
                                                                                                                                                        Ãƒâ€šÃ‚Â·
                                                                                                                                                        No
                                                                                                                                                        group
                                                                                                                                                        photos
                                                                                                                                                        Ãƒâ€šÃ‚Â·
                                                                                                                                                        No
                                                                                                                                                        heavy
                                                                                                                                                        filters
                                                                                                                                                    </li>
                                                                                                                                                </ul>
                                                                                                                                            </div>
                                                                                                                                            <p class="reg-trust-strip"
                                                                                                                                                style="justify-content:flex-start;margin-top:16px;">
                                                                                                                                                <span><i
                                                                                                                                                        class="fa-solid fa-lock"></i>
                                                                                                                                                    Secure
                                                                                                                                                    upload</span>
                                                                                                                                                <span><i
                                                                                                                                                        class="fa-solid fa-user-check"></i>
                                                                                                                                                    Admin
                                                                                                                                                    review
                                                                                                                                                    before
                                                                                                                                                    profile
                                                                                                                                                    is
                                                                                                                                                    live</span>
                                                                                                                                            </p>
                                                                                                                                    </div>
                                                                                                                                    </div>

                                                                                                                                    <!-- STEP 6 – Payment (after upload) -->
                                                                                                                                    <?php if ($payment_enabled): ?>
                                                                                                                                        <div class="reg-panel"
                                                                                                                                            data-panel="5">
                                                                                                                                            <h2
                                                                                                                                                class="reg-section-title">
                                                                                                                                                Membership
                                                                                                                                                payment
                                                                                                                                            </h2>
                                                                                                                                            <p
                                                                                                                                                class="reg-payment-intro">
                                                                                                                                                Activate
                                                                                                                                                your
                                                                                                                                                profile
                                                                                                                                                listing
                                                                                                                                                with
                                                                                                                                                the
                                                                                                                                                bureau
                                                                                                                                                registration
                                                                                                                                                fee.
                                                                                                                                                Payment
                                                                                                                                                gateway
                                                                                                                                                integration
                                                                                                                                                can
                                                                                                                                                be
                                                                                                                                                connected
                                                                                                                                                later
                                                                                                                                                –
                                                                                                                                                select
                                                                                                                                                a
                                                                                                                                                method
                                                                                                                                                below
                                                                                                                                                to
                                                                                                                                                continue.
                                                                                                                                            </p>

                                                                                                                                            <div
                                                                                                                                                class="reg-payment-card">
                                                                                                                                                <div
                                                                                                                                                    class="reg-payment-card-head">
                                                                                                                                                    <div>
                                                                                                                                                        <span
                                                                                                                                                            class="reg-payment-badge">Registration</span>
                                                                                                                                                        <h3
                                                                                                                                                            class="reg-payment-plan-name">
                                                                                                                                                            Standard
                                                                                                                                                            ·
                                                                                                                                                            180
                                                                                                                                                            days
                                                                                                                                                        </h3>
                                                                                                                                                        <p
                                                                                                                                                            class="reg-payment-plan-meta">
                                                                                                                                                            Profile
                                                                                                                                                            visibility
                                                                                                                                                            ·
                                                                                                                                                            Basic
                                                                                                                                                            match
                                                                                                                                                            suggestions
                                                                                                                                                        </p>
                                                                                                                                                    </div>
                                                                                                                                                    <p
                                                                                                                                                        class="reg-payment-amount">
                                                                                                                                                        <span
                                                                                                                                                            class="reg-payment-currency">₹</span>999
                                                                                                                                                    </p>
                                                                                                                                                </div>
                                                                                                                                                <ul
                                                                                                                                                    class="reg-payment-features">
                                                                                                                                                    <li><i class="fa-solid fa-check"
                                                                                                                                                            aria-hidden="true"></i>
                                                                                                                                                        Profile
                                                                                                                                                        listed
                                                                                                                                                        after
                                                                                                                                                        admin
                                                                                                                                                        verification
                                                                                                                                                    </li>
                                                                                                                                                    <li><i class="fa-solid fa-check"
                                                                                                                                                            aria-hidden="true"></i>
                                                                                                                                                        Secure
                                                                                                                                                        document
                                                                                                                                                        &amp;
                                                                                                                                                        photo
                                                                                                                                                        review
                                                                                                                                                    </li>
                                                                                                                                                    <li><i class="fa-solid fa-check"
                                                                                                                                                            aria-hidden="true"></i>
                                                                                                                                                        Upgrade
                                                                                                                                                        anytime
                                                                                                                                                        to
                                                                                                                                                        Premium
                                                                                                                                                    </li>
                                                                                                                                                </ul>
                                                                                                                                            </div>

                                                                                                                                            <div<?php echo sathi_reg_field_wrap_attrs('pay_method'); ?>>
                                                                                                                                                <fieldset
                                                                                                                                                    class="reg-payment-fieldset">
                                                                                                                                                    <legend
                                                                                                                                                        class="reg-payment-legend">
                                                                                                                                                        Choose
                                                                                                                                                        payment
                                                                                                                                                        method
                                                                                                                                                    </legend>
                                                                                                                                                    <label
                                                                                                                                                        class="reg-pay-option">
                                                                                                                                                        <input
                                                                                                                                                            type="radio"
                                                                                                                                                            name="pay_method"
                                                                                                                                                            value="razorpay"
                                                                                                                                                            checked>
                                                                                                                                                        <span
                                                                                                                                                            class="reg-pay-option-body">
                                                                                                                                                            <span
                                                                                                                                                                class="reg-pay-title"><i
                                                                                                                                                                    class="fa-solid fa-bolt"
                                                                                                                                                                    aria-hidden="true"></i>
                                                                                                                                                                Razorpay</span>
                                                                                                                                                            <span
                                                                                                                                                                class="reg-pay-sub">Cards,
                                                                                                                                                                UPI,
                                                                                                                                                                netbanking</span>
                                                                                                                                                        </span>
                                                                                                                                                    </label>
                                                                                                                                                </fieldset>
                                                                                                                                        </div>
                                                                                                                                        </div>
                                                                                                                                    <?php endif; ?>

                                                                                                                                    <div
                                                                                                                                        class="reg-nav">
                                                                                                                                        <button
                                                                                                                                            type="button"
                                                                                                                                            class="reg-btn reg-btn--prev"
                                                                                                                                            id="btnPrev">Back</button>
                                                                                                                                        <button
                                                                                                                                            type="button"
                                                                                                                                            class="reg-btn reg-btn--next"
                                                                                                                                            id="btnNext">Continue</button>
                                                                                                                                        <button
                                                                                                                                            type="submit"
                                                                                                                                            class="reg-btn reg-btn--primary"
                                                                                                                                            id="btnSubmit"><?php echo $payment_enabled ? 'Pay & submit registration' : 'Complete Registration'; ?></button>
                                                                                                                                    </div>
                                                                                                                                    </form>
                                                                                                                                    </div>
                                                                                                                                    </div>
                                                                                                                                    </div>
                                                                                                                                    </div>
</main>

<script>
    (function () {
        const form = document.getElementById('regWizard');
        const panels = document.querySelectorAll('.reg-panel');
        const steps = document.querySelectorAll('.reg-step-item');
        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');
        const paymentEnabled = <?php echo $payment_enabled ? 'true' : 'false'; ?>;
        let step = 0;

        function showStep(n) {
            panels.forEach((p, i) => p.classList.toggle('active', i === n));
            steps.forEach((s, i) => s.classList.toggle('active', i === n));
            steps.forEach((s, i) => s.classList.toggle('completed', i < n));
            btnPrev.style.display = n === 0 ? 'none' : 'inline-block';
            btnNext.style.display = n === panels.length - 1 ? 'none' : 'inline-block';
            btnSubmit.style.display = n === panels.length - 1 ? 'inline-block' : 'none';
            step = n;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            saveDraft();
        }

        function validateStep(n) {
            const panel = panels[n];
            const required = panel.querySelectorAll('[required]');
            let valid = true;
            required.forEach(el => {
                if (el.offsetParent === null) return; // skip hidden
                if (!el.value || (el.type === 'checkbox' && !el.checked)) {
                    el.closest('.reg-float')?.classList.add('invalid');
                    el.closest('.reg-upload')?.classList.add('invalid');
                    valid = false;
                } else {
                    el.closest('.reg-float')?.classList.remove('invalid');
                    el.closest('.reg-upload')?.classList.remove('invalid');
                }
            });

            if (n === 3) { // Family step validation
                if (!validateSiblings()) valid = false;
            }

            return valid;
        }

        function validateSiblings() {
            const bt = parseInt(document.getElementById('bro_total').value) || 0;
            const bm = parseInt(document.getElementById('bro_married').value) || 0;
            const bu = parseInt(document.getElementById('bro_unmarried').value) || 0;
            const st = parseInt(document.getElementById('sis_total').value) || 0;
            const sm = parseInt(document.getElementById('sis_married').value) || 0;
            const su = parseInt(document.getElementById('sis_unmarried').value) || 0;

            let ok = true;
            if (bt !== (bm + bu)) {
                document.getElementById('broErr').classList.add('visible');
                ok = false;
            } else {
                document.getElementById('broErr').classList.remove('visible');
            }
            if (st !== (sm + su)) {
                document.getElementById('sisErr').classList.add('visible');
                ok = false;
            } else {
                document.getElementById('sisErr').classList.remove('visible');
            }
            return ok;
        }

        btnNext.addEventListener('click', () => {
            if (validateStep(step)) showStep(step + 1);
        });
        btnPrev.addEventListener('click', () => showStep(step - 1));

        // Stepper click logic (allow going back)
        document.querySelectorAll('.reg-step-item').forEach(item => {
            item.addEventListener('click', () => {
                const targetStep = parseInt(item.getAttribute('data-step'));
                if (targetStep < step) {
                    showStep(targetStep);
                }
            });
        });

        // Geo Cascade
        const geoData = <?php echo json_encode($masters['geo']); ?>;
        document.querySelectorAll('[data-geo-role="country"]').forEach(sel => {
            sel.addEventListener('change', function () {
                const prefix = this.getAttribute('data-geo-prefix');
                const stateSel = document.getElementById(prefix + 'state');
                const citySel = document.getElementById(prefix + 'city');
                if (!stateSel) return;
                stateSel.innerHTML = '<option value="" disabled selected>Select State</option>';
                if (citySel) citySel.innerHTML = '<option value="" disabled selected>Select City</option>';

                const states = geoData.states[this.value] || [];
                states.forEach(s => {
                    stateSel.innerHTML += `<option value="${s.value}">${s.label}</option>`;
                });
                stateSel.innerHTML += '<option value="other">Other (Custom)</option>';
                stateSel.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });

        document.querySelectorAll('[data-geo-role="state"]').forEach(sel => {
            sel.addEventListener('change', function () {
                const prefix = this.getAttribute('data-geo-prefix');
                const citySel = document.getElementById(prefix + 'city');
                if (!citySel) return;
                citySel.innerHTML = '<option value="" disabled selected>Select City</option>';
                const cities = geoData.cities[this.value] || [];
                cities.forEach(c => {
                    citySel.innerHTML += `<option value="${c.value}">${c.label}</option>`;
                });
                citySel.innerHTML += '<option value="other">Other (Custom)</option>';
                citySel.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });

        // Custom Dropdown Logic
        function handleCustomDropdown(sel) {
            const wrap = sel.closest('.reg-float-select');
            if (!wrap) return;
            let customInput = wrap.querySelector('.reg-custom-input');
            if (sel.value === 'other') {
                if (!customInput) {
                    customInput = document.createElement('input');
                    customInput.type = 'text';
                    customInput.className = 'reg-custom-input';
                    customInput.placeholder = 'Please specify...';
                    customInput.style.marginTop = '10px';
                    customInput.name = sel.name + '_custom';
                    wrap.appendChild(customInput);
                    customInput.focus();
                }
                customInput.style.display = 'block';
                customInput.required = true;
            } else {
                if (customInput) {
                    customInput.style.display = 'none';
                    customInput.required = false;
                }
            }
        }

        // Initial field setup for custom inputs
        document.querySelectorAll('select').forEach(sel => {
            // Add "Other" to all selects if not present
            if (!sel.querySelector('option[value="other"]')) {
                sel.innerHTML += '<option value="other">Other (Custom)</option>';
            }

            // Create custom input upfront
            const wrap = sel.closest('.reg-float-select');
            if (wrap && !wrap.querySelector('.reg-custom-input')) {
                const customInput = document.createElement('input');
                customInput.type = 'text';
                customInput.className = 'reg-custom-input';
                customInput.placeholder = 'Please specify...';
                customInput.name = sel.name + '_custom';
                wrap.appendChild(customInput);
            }

            sel.addEventListener('change', () => handleCustomDropdown(sel));
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!validateStep(step)) return;
            const pw = document.getElementById('password');
            const pwc = document.getElementById('password_confirm');
            if (pw && pwc && pw.value !== pwc.value) {
                alert('Passwords do not match.');
                return;
            }

            if (!paymentEnabled) {
                submitRegistration();
                return;
            }

            const options = {
                "key": "rzp_test_S7dlJIqMvrpcaj",
                "amount": 99900,
                "currency": "INR",
                "name": "ShadikiBaat",
                "description": "Registration Fee",
                "handler": function (response) {
                    submitRegistration(response.razorpay_payment_id);
                },
                "prefill": {
                    "name": document.getElementById('full_name')?.value || '',
                    "email": document.getElementById('email')?.value || '',
                    "contact": document.getElementById('mobile')?.value || ''
                },
                "theme": { "color": "#e91e63" }
            };
            const rzp = new Razorpay(options);
            rzp.open();
        });

        function submitRegistration(paymentId = '') {
            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Processing...';
            const fd = new FormData(form);
            if (paymentId) fd.append('razorpay_payment_id', paymentId);

            fetch('api/complete-registration.php', {
                method: 'POST',
                credentials: 'same-origin',
                body: fd
            })
                .then(r => r.json())
                .then(data => {
                    if (data.ok) {
                        localStorage.removeItem('sathi_reg_draft');
                        window.location.href = 'index.php';
                    } else {
                        alert(data.error || 'Registration failed');
                        btnSubmit.disabled = false;
                        btnSubmit.textContent = paymentEnabled ? 'Pay & submit registration' : 'Complete Registration';
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Network error. Please try again.');
                    btnSubmit.disabled = false;
                    btnSubmit.textContent = paymentEnabled ? 'Pay & submit registration' : 'Complete Registration';
                });
        }

        // Persistence logic
        let draftTimeout;
        function saveDraft() {
            clearTimeout(draftTimeout);
            draftTimeout = setTimeout(() => {
                const fd = new FormData(form);
                const data = {};
                fd.forEach((value, key) => {
                    if (key !== 'password' && key !== 'password_confirm' && !(value instanceof File)) {
                        data[key] = value;
                    }
                });
                data['_current_step'] = step;
                localStorage.setItem('sathi_reg_draft', JSON.stringify(data));
            }, 500);
        }

        async function loadDraft() {
            const raw = localStorage.getItem('sathi_reg_draft');
            if (!raw) {
                showStep(0);
                return;
            }
            try {
                const data = JSON.parse(raw);

                // Step 1: Set basic fields and trigger changes to populate dynamic selects
                const fields = Object.keys(data);

                // We need to set them in an order that respects dependencies
                // Or just do multiple passes.
                for (let pass = 0; pass < 3; pass++) {
                    for (const key of fields) {
                        const el = form.elements[key];
                        if (!el) continue;

                        if (el.type === 'checkbox' || el.type === 'radio') {
                            if (el.length > 1) {
                                for (let i = 0; i < el.length; i++) {
                                    if (el[i].value === data[key]) el[i].checked = true;
                                }
                            } else {
                                el.checked = !!data[key];
                            }
                        } else {
                            el.value = data[key];
                        }

                        el.dispatchEvent(new Event('input', { bubbles: true }));
                        el.dispatchEvent(new Event('change', { bubbles: true }));

                        if (el.tagName === 'SELECT') handleCustomDropdown(el);
                    }
                    await new Promise(r => setTimeout(r, 100)); // Wait for any cascades
                }

                if (data['_current_step'] !== undefined) {
                    showStep(parseInt(data['_current_step']));
                } else {
                    showStep(0);
                }
            } catch (e) {
                console.error('Draft load error', e);
                showStep(0);
            }
        }

        form.addEventListener('input', saveDraft);
        form.addEventListener('change', saveDraft);
        window.addEventListener('load', loadDraft);

        // Initial field setup for custom inputs
        document.querySelectorAll('select').forEach(handleCustomDropdown);

    })();

    // File input labels
    ['kundli_image', 'horoscope', 'photo'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('change', function () {
            const sp = document.getElementById(id.replace('_image', '') + 'Name');
            if (sp && this.files[0]) sp.textContent = this.files[0].name;
        });
    });

    // Sibling listeners
    ['bro_total', 'bro_married', 'bro_unmarried', 'sis_total', 'sis_married', 'sis_unmarried'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', () => {
            const bt = parseInt(document.getElementById('bro_total').value) || 0;
            const bm = parseInt(document.getElementById('bro_married').value) || 0;
            const bu = parseInt(document.getElementById('bro_unmarried').value) || 0;
            if (bt === (bm + bu)) document.getElementById('broErr').classList.remove('visible');
            const st = parseInt(document.getElementById('sis_total').value) || 0;
            const sm = parseInt(document.getElementById('sis_married').value) || 0;
            const su = parseInt(document.getElementById('sis_unmarried').value) || 0;
            if (st === (sm + su)) document.getElementById('sisErr').classList.remove('visible');
        });
    });

    // Digamber Jain validation
    const digamberSelect = document.getElementById('digamber');
    if (digamberSelect) {
        digamberSelect.addEventListener('change', function () {
            if (this.value === 'no') {
                Swal.fire({
                    icon: 'error',
                    title: 'Access Denied',
                    text: 'This website is only for Digambar Jain.',
                    confirmButtonColor: '#f45c93'
                }).then(() => {
                    this.value = 'yes'; // Reset to Yes
                    // Update custom dropdown span text if it exists
                    const wrapper = this.closest('.reg-float-select');
                    if (wrapper) {
                        const span = wrapper.querySelector('.select-selected');
                        if (span) span.textContent = 'Yes';
                    }
                });
            }
        });
    }
</script>

<?php include 'footer.php'; ?>
</body>

</html>