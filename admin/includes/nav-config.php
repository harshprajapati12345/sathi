<?php
/**
 * Admin sidebar navigation — slug (col 2) must match $adminCurrent on each page.
 * Fourth column: direct href to static UI page.
 */
return [
    ['link', 'dashboard', 'Dashboard', 'fa-gauge-high', 'dashboard.php'],

    ['section', 'Members'],
    ['link', 'members-all', 'All Members', 'fa-users', 'members.php'],
    ['link', 'members-approval', 'Member Approvals', 'fa-user-clock', 'member-approvals.php'],
    ['link', 'members-approved', 'Approved Members', 'fa-circle-check', 'approved-members.php'],
    ['link', 'members-rejected', 'Rejected Members', 'fa-circle-xmark', 'rejected-members.php'],
    ['link', 'members-paid', 'Paid Members', 'fa-indian-rupee-sign', 'paid-members.php'],
    ['link', 'members-featured', 'Featured Members', 'fa-star', 'featured-members.php'],
    ['link', 'members-deactivation', 'Profile Deactivation Requests', 'fa-user-slash', 'profile-deactivation.php'],

    ['section', 'Membership Plans'],
    ['link', 'plans-add', 'Add Membership Plan', 'fa-plus-circle', 'add-membership-plan.php'],
    ['link', 'plans-all', 'All Membership Plans', 'fa-list-ul', 'membership-plans.php'],

    ['section', 'Registration Form Controls'],
    ['link', 'form-field-settings', 'Field Visibility', 'fa-sliders', 'form-field-settings.php'],
    ['link', 'master-mandir', 'Mandir Master', 'fa-vihara', 'master-mandir.php'],
    ['link', 'master-subcast', 'Subcast Master', 'fa-users', 'master-subcast.php'],
    ['link', 'master-gotra', 'Gotra Master', 'fa-om', 'master-gotra.php'],

    ['section', 'Payments'],
    ['link', 'payments-history', 'Payment History', 'fa-receipt', 'payments.php'],
    ['link', 'payments-manual', 'Manual Payments', 'fa-hand-holding-dollar', 'manual-payments.php'],
    ['link', 'payments-methods', 'Payment Methods', 'fa-credit-card', 'payment-methods.php'],

    ['section', 'CMS'],
    ['link', 'cms-home', 'CMS Overview', 'fa-layer-group', 'cms.php'],
    ['link', 'cms-blogs', 'Blogs', 'fa-newspaper', 'blogs.php'],
    ['link', 'cms-stories', 'Success Stories', 'fa-heart', 'success-stories.php'],
    ['link', 'cms-banner', 'Homepage Banner', 'fa-image', 'homepage-banner.php'],
    ['link', 'cms-ads', 'Advertisements', 'fa-ad', 'advertisements.php'],

    ['section', 'Reports'],
    ['link', 'reports', 'Reports', 'fa-chart-column', 'reports.php'],
    ['link', 'profession-stats', 'Profession Stats', 'fa-briefcase', 'profession-stats.php'],

    ['section', 'Settings'],
    ['link', 'settings', 'Settings', 'fa-gear', 'settings.php'],
];
