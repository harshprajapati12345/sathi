<?php
declare(strict_types=1);

return [
    'members-all' => [
        'type' => 'table',
        'description' => 'View and manage every registered member with filters and quick actions.',
        'columns' => ['ID', 'Name', 'Gender', 'Age', 'City', 'Religion', 'Plan', 'Status', 'Action'],
        'rows' => [
            ['1', 'Aarti Singh', 'Female', '29', 'Mumbai', 'Hindu', 'Gold', 'Active', 'View | Edit | Delete'],
            ['2', 'Rahul Verma', 'Male', '34', 'Delhi', 'Hindu', 'Standard', 'Blocked', 'View | Edit | Delete'],
            ['3', 'Sneha Patel', 'Female', '27', 'Ahmedabad', 'Jain', 'Premium', 'Active', 'View | Edit | Delete'],
            ['4', 'Ankit Sharma', 'Male', '31', 'Pune', 'Sikh', 'Gold', 'Pending', 'View | Edit | Delete'],
        ],
    ],
    'members-approval' => [
        'type' => 'approval',
        'description' => 'Approve or reject newly registered members before they can access the user index page.',
        'columns' => ['Email', 'Name', 'Status', 'Registered At', 'Action'],
        'handler' => 'members_approval',
    ],
    'members-approved-paid' => [
        'type' => 'table',
        'description' => 'Require a detailed look at members with approved profiles and active paid subscriptions.',
        'columns' => ['Name', 'Plan Name', 'Payment Date', 'Expiry Date', 'Status'],
        'rows' => [
            ['Priya Sharma', 'Gold', '2026-04-12', '2027-04-11', 'Paid'],
            ['Sahil Kapoor', 'Premium', '2026-04-22', '2027-04-21', 'Paid'],
            ['Meera Nair', 'Standard', '2026-05-01', '2027-04-30', 'Paid'],
        ],
    ],
    'members-renew' => [
        'type' => 'table',
        'description' => 'Renew expiring memberships from a single screen.',
        'columns' => ['Member Name', 'Current Plan', 'Expiry', 'Action'],
        'rows' => [
            ['Divya Joshi', 'Gold', '2026-05-18', 'Renew'],
            ['Aman Malhotra', 'Standard', '2026-05-24', 'Renew'],
            ['Richa Sen', 'Premium', '2026-05-29', 'Renew'],
        ],
    ],
    'members-featured' => [
        'type' => 'table',
        'description' => 'Track featured profile status for premium visibility campaigns.',
        'columns' => ['Name', 'Featured Status', 'Start Date', 'End Date'],
        'rows' => [
            ['Neha Jain', 'Yes', '2026-04-01', '2026-06-30'],
            ['Vikram Singh', 'No', '—', '—'],
            ['Anjali Rao', 'Yes', '2026-05-05', '2026-08-04'],
        ],
    ],
    'members-deactivation' => [
        'type' => 'approval',
        'description' => 'Approve or reject requested profile deactivations with a single action panel.',
        'columns' => ['User Name', 'Reason', 'Date', 'Action'],
        'rows' => [
            ['Pooja Mehta', 'Privacy concerns', '2026-05-10', 'Approve | Reject'],
            ['Rohan Desai', 'Profile duplicate', '2026-05-09', 'Approve | Reject'],
            ['Trisha Gupta', 'Not satisfied with matches', '2026-05-08', 'Approve | Reject'],
        ],
    ],
    'plans-add' => [
        'type' => 'form',
        'description' => 'Create a new membership package and define pricing, duration, and benefits.',
        'fields' => [
            ['label' => 'Plan Name', 'name' => 'plan_name', 'type' => 'text', 'placeholder' => 'e.g. Premium'],
            ['label' => 'Price', 'name' => 'price', 'type' => 'number', 'placeholder' => '1999'],
            ['label' => 'Duration (days)', 'name' => 'duration', 'type' => 'number', 'placeholder' => '365'],
            ['label' => 'Features', 'name' => 'features', 'type' => 'textarea', 'placeholder' => 'Enter plan features, separated by commas'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
    ],
    'plans-all' => [
        'type' => 'table',
        'description' => 'Review all active and inactive membership plans.',
        'columns' => ['Plan Name', 'Price', 'Duration', 'Active Status', 'Action'],
        'rows' => [
            ['Standard', '₹999', '180', 'Active', 'Edit | Delete'],
            ['Gold', '₹1999', '365', 'Active', 'Edit | Delete'],
            ['Premium', '₹2999', '365', 'Inactive', 'Edit | Delete'],
        ],
    ],
    'master-religion' => [
        'handler' => 'master_data',
        'description' => 'Manage master list values for religion metadata.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. Hindu'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'Hindu', 'Active', 'Edit | Delete'], ['2', 'Muslim', 'Active', 'Edit | Delete'], ['3', 'Sikh', 'Active', 'Edit | Delete']],
    ],
    'master-caste' => [
        'handler' => 'master_data',
        'description' => 'Master data management for caste categories.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. Brahmin'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'Brahmin', 'Active', 'Edit | Delete'], ['2', 'Kshatriya', 'Active', 'Edit | Delete'], ['3', 'Vaishya', 'Inactive', 'Edit | Delete']],
    ],
    'master-subcaste' => [
        'handler' => 'master_data',
        'description' => 'Manage sub-caste lookup tables for member profiles.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. Aggarwal'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'Aggarwal', 'Active', 'Edit | Delete'], ['2', 'Jain', 'Active', 'Edit | Delete'], ['3', 'Reddy', 'Active', 'Edit | Delete']],
    ],
    'master-gotra' => [
        'handler' => 'master_data',
        'description' => 'Edit gotra entries used in search and profile data.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. Bhardwaj'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'Bhardwaj', 'Active', 'Edit | Delete'], ['2', 'Jaiswal', 'Active', 'Edit | Delete']],
    ],
    'master-country' => [
        'handler' => 'master_data',
        'description' => 'Country master records for member geographic data.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. India'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'India', 'Active', 'Edit | Delete'], ['2', 'United States', 'Active', 'Edit | Delete']],
    ],
    'master-state' => [
        'handler' => 'master_data',
        'description' => 'State-level master data for profile filters.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. Maharashtra'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'Maharashtra', 'Active', 'Edit | Delete'], ['2', 'Karnataka', 'Active', 'Edit | Delete']],
    ],
    'master-city' => [
        'handler' => 'master_data',
        'description' => 'City master listings to keep location data consistent.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. Mumbai'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'Mumbai', 'Active', 'Edit | Delete'], ['2', 'Bangalore', 'Active', 'Edit | Delete']],
    ],
    'master-occupation' => [
        'handler' => 'master_data',
        'description' => 'Occupation master data used for profile details.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. Software Engineer'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'Software Engineer', 'Active', 'Edit | Delete'], ['2', 'Doctor', 'Active', 'Edit | Delete']],
    ],
    'master-education' => [
        'handler' => 'master_data',
        'description' => 'Education master values for profile filters.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. B.Tech'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'B.Tech', 'Active', 'Edit | Delete'], ['2', 'MBA', 'Active', 'Edit | Delete']],
    ],
    'master-mother-tongue' => [
        'handler' => 'master_data',
        'description' => 'Mother tongue master data for members.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. Hindi'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'Hindi', 'Active', 'Edit | Delete'], ['2', 'Tamil', 'Active', 'Edit | Delete']],
    ],
    'master-star' => [
        'handler' => 'master_data',
        'description' => 'Star (Nakshatra) master data.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. Ashwini'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'Ashwini', 'Active', 'Edit | Delete'], ['2', 'Bharani', 'Active', 'Edit | Delete']],
    ],
    'master-rasi' => [
        'handler' => 'master_data',
        'description' => 'Rasi / moon sign master entries.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. Aries'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'Aries', 'Active', 'Edit | Delete'], ['2', 'Taurus', 'Active', 'Edit | Delete']],
    ],
    'master-income' => [
        'handler' => 'master_data',
        'description' => 'Annual income categories for member filters.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. ₹2 Lakh - ₹5 Lakh'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', '₹2 Lakh - ₹5 Lakh', 'Active', 'Edit | Delete'], ['2', '₹5 Lakh - ₹10 Lakh', 'Active', 'Edit | Delete']],
    ],
    'master-dosh' => [
        'handler' => 'master_data',
        'description' => 'Dosh compatibility settings for matchmaking.',
        'columns' => ['ID', 'Name', 'Status', 'Action'],
        'fields' => [
            ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'placeholder' => 'e.g. No Dosh'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
        'rows' => [['1', 'No Dosh', 'Active', 'Edit | Delete'], ['2', 'Vata Dosh', 'Active', 'Edit | Delete']],
    ],
    'match-suggestions' => [
        'type' => 'table',
        'description' => 'Suggested matches based on member preferences and compatibility.',
        'columns' => ['User 1', 'User 2', 'Match %'],
        'rows' => [['Priya Sharma', 'Aditya Rao', '88%'], ['Megha Shah', 'Rohan Nair', '76%'], ['Sana Khan', 'Vivek Patel', '82%']],
    ],
    'match-compatibility' => [
        'type' => 'settings',
        'description' => 'Control matchmaking rules for age difference, religion, and location priority.',
        'fields' => [
            ['label' => 'Age Difference Range', 'name' => 'age_difference', 'type' => 'text', 'placeholder' => 'e.g. 0-8 years'],
            ['label' => 'Religion Match Rule', 'name' => 'religion_rule', 'type' => 'select', 'options' => ['Strict', 'Relaxed', 'Any']],
            ['label' => 'Location Priority', 'name' => 'location_priority', 'type' => 'select', 'options' => ['City', 'State', 'Country', 'Any']],
        ],
    ],
    'payments-history' => [
        'type' => 'table',
        'description' => 'Track every payment transaction in a searchable ledger.',
        'columns' => ['User', 'Amount', 'Payment Method', 'Transaction ID', 'Status', 'Date'],
        'rows' => [
            ['Aarti Singh', '₹1,999', 'Razorpay', 'TXN12345', 'Completed', '2026-05-02'],
            ['Rahul Verma', '₹999', 'UPI', 'TXN12346', 'Pending', '2026-05-04'],
        ],
    ],
    'payments-manual' => [
        'type' => 'form',
        'description' => 'Approve manual payment requests with an uploaded screenshot reference.',
        'fields' => [
            ['label' => 'User', 'name' => 'user', 'type' => 'text', 'placeholder' => 'Member name'],
            ['label' => 'Amount', 'name' => 'amount', 'type' => 'number', 'placeholder' => 'e.g. 1999'],
            ['label' => 'Screenshot Upload', 'name' => 'screenshot', 'type' => 'file'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Approve', 'Reject']],
        ],
    ],
    'payments-methods' => [
        'type' => 'table',
        'description' => 'Configure payment gateway methods and API credentials.',
        'columns' => ['Method Name', 'API Key', 'Status', 'Action'],
        'rows' => [
            ['UPI', 'upi_key_placeholder', 'Active', 'Edit | Disable'],
            ['Razorpay', 'razorpay_key_placeholder', 'Active', 'Edit | Disable'],
            ['Stripe', 'stripe_key_placeholder', 'Inactive', 'Edit | Enable'],
        ],
    ],
    'approval-horoscope' => [
        'type' => 'approval',
        'description' => 'Approve horoscope PDF uploads before they go live.',
        'columns' => ['User Name', 'Document', 'Action'],
        'rows' => [['Neha Jain', 'horoscope.pdf', 'Approve | Reject'], ['Aman Malhotra', 'horoscope.pdf', 'Approve | Reject']],
    ],
    'approval-document' => [
        'type' => 'approval',
        'description' => 'Review ID proof documents and accept or reject requests.',
        'columns' => ['User Name', 'Document', 'Action'],
        'rows' => [['Priya Sharma', 'ID Proof', 'Approve | Reject'], ['Rohan Desai', 'Address Proof', 'Approve | Reject']],
    ],
    'approval-photo' => [
        'type' => 'approval',
        'description' => 'Approve or reject profile picture requests with preview support.',
        'columns' => ['User Name', 'Image Preview', 'Action'],
        'rows' => [['Aarti Singh', 'Photo', 'Approve | Reject'], ['Vikram Singh', 'Photo', 'Approve | Reject']],
    ],
    'approval-gallery' => [
        'type' => 'approval',
        'description' => 'Review gallery uploads and approve sets of multiple images.',
        'columns' => ['User Name', 'Gallery Preview', 'Action'],
        'rows' => [['Sneha Patel', '3 images', 'Approve | Reject'], ['Anjali Rao', '5 images', 'Approve | Reject']],
    ],
    'approval-about' => [
        'type' => 'approval',
        'description' => 'Approve or reject profile About Me bios.',
        'columns' => ['User Name', 'Text Content', 'Action'],
        'rows' => [['Ritu Singh', 'About text', 'Approve | Reject'], ['Karan Mehta', 'About text', 'Approve | Reject']],
    ],
    'approval-partner' => [
        'type' => 'approval',
        'description' => 'Approve partner expectation descriptions before publishing.',
        'columns' => ['User Name', 'Text Content', 'Action'],
        'rows' => [['Megha Shah', 'Partner preferences', 'Approve | Reject'], ['Sahil Sharma', 'Partner preferences', 'Approve | Reject']],
    ],
    'stories-all' => [
        'type' => 'table',
        'description' => 'List all published success stories and manage their visibility.',
        'columns' => ['Couple Name', 'Image', 'Story', 'Status', 'Action'],
        'rows' => [['Aarti & Rohit', 'Photo', 'Their story...', 'Published', 'Edit | Delete'], ['Priya & Amit', 'Photo', 'Their story...', 'Draft', 'Edit | Delete']],
    ],
    'stories-add' => [
        'type' => 'form',
        'description' => 'Add a new success story with couple details and image upload.',
        'fields' => [
            ['label' => 'Groom Name', 'name' => 'groom_name', 'type' => 'text', 'placeholder' => 'Groom name'],
            ['label' => 'Bride Name', 'name' => 'bride_name', 'type' => 'text', 'placeholder' => 'Bride name'],
            ['label' => 'Story', 'name' => 'story', 'type' => 'textarea', 'placeholder' => 'Enter the couple story'],
            ['label' => 'Upload Image', 'name' => 'image', 'type' => 'file'],
        ],
    ],
    'stories-approval' => [
        'type' => 'approval',
        'description' => 'Approve pending success stories before they become visible.',
        'columns' => ['Couple Name', 'Story Preview', 'Action'],
        'rows' => [['Ria & Kunal', 'Pending review', 'Approve | Reject'], ['Swati & Abhay', 'Pending review', 'Approve | Reject']],
    ],
    'activity-interest' => [
        'type' => 'table',
        'description' => 'Monitor expressed interests between members.',
        'columns' => ['From User', 'To User', 'Date'],
        'rows' => [['Priya Sharma', 'Aman Malhotra', '2026-05-07'], ['Neha Jain', 'Vikram Singh', '2026-05-08']],
    ],
    'activity-messages' => [
        'type' => 'table',
        'description' => 'View expressive member messages in one place.',
        'columns' => ['From User', 'To User', 'Date'],
        'rows' => [['Meera Patel', 'Rohan Desai', '2026-05-05'], ['Anjali Rao', 'Sahil Kapoor', '2026-05-06']],
    ],
    'activity-viewed' => [
        'type' => 'table',
        'description' => 'Track profile views and interest signals.',
        'columns' => ['From User', 'To User', 'Date'],
        'rows' => [['Aarti Singh', 'Rahul Verma', '2026-05-02'], ['Divya Joshi', 'Vikram Singh', '2026-05-03']],
    ],
    'activity-ignored' => [
        'type' => 'table',
        'description' => 'Review ignored connections to improve matchmaking quality.',
        'columns' => ['From User', 'To User', 'Date'],
        'rows' => [['Sana Khan', 'Aditya Rao', '2026-05-01'], ['Nikhil Sharma', 'Pooja Mehta', '2026-05-02']],
    ],
    'activity-shortlisted' => [
        'type' => 'table',
        'description' => 'List shortlisted members for quick reference.',
        'columns' => ['From User', 'To User', 'Date'],
        'rows' => [['Priya Sharma', 'Vivek Patel', '2026-05-03'], ['Megha Shah', 'Aman Malhotra', '2026-05-04']],
    ],
    'activity-blocked' => [
        'type' => 'table',
        'description' => 'Manage blocked member connections and audit actions.',
        'columns' => ['From User', 'To User', 'Date'],
        'rows' => [['Rohan Desai', 'Sonal Kapoor', '2026-05-03'], ['Karan Mehta', 'Neha Jain', '2026-05-04']],
    ],
    'cms-pages' => [
        'type' => 'table',
        'description' => 'Manage CMS pages and status in one place.',
        'columns' => ['Page Title', 'Slug', 'Status', 'Action'],
        'rows' => [['About Us', 'about-us', 'Published', 'Edit'], ['Privacy Policy', 'privacy-policy', 'Published', 'Edit']],
    ],
    'cms-email' => [
        'type' => 'form',
        'description' => 'Send announcement emails directly to members.',
        'fields' => [
            ['label' => 'Subject', 'name' => 'subject', 'type' => 'text', 'placeholder' => 'Email subject'],
            ['label' => 'Message', 'name' => 'message', 'type' => 'textarea', 'placeholder' => 'Write your message here'],
        ],
    ],
    'ads-all' => [
        'type' => 'table',
        'description' => 'Manage website advertisements and placements.',
        'columns' => ['Title', 'Image', 'Position', 'Status', 'Action'],
        'rows' => [['Top Banner', 'Banner', 'Homepage', 'Active', 'Edit | Delete'], ['Sidebar', 'Banner', 'Sidebar', 'Active', 'Edit | Delete']],
    ],
    'ads-add' => [
        'type' => 'form',
        'description' => 'Create a new advertisement with banner, link, and schedule.',
        'fields' => [
            ['label' => 'Title', 'name' => 'title', 'type' => 'text', 'placeholder' => 'Ad title'],
            ['label' => 'Upload Banner', 'name' => 'banner', 'type' => 'file'],
            ['label' => 'Link', 'name' => 'link', 'type' => 'text', 'placeholder' => 'https://'],
            ['label' => 'Start Date', 'name' => 'start_date', 'type' => 'date'],
            ['label' => 'End Date', 'name' => 'end_date', 'type' => 'date'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
        ],
    ],
    'locale-currency' => [
        'type' => 'table',
        'description' => 'Manage available currency codes and symbols.',
        'columns' => ['Currency Name', 'Symbol', 'Code', 'Action'],
        'rows' => [['Indian Rupee', '₹', 'INR', 'Edit | Delete'], ['US Dollar', '$', 'USD', 'Edit | Delete']],
    ],
    'locale-manual-payment' => [
        'type' => 'form',
        'description' => 'Update manual payment instructions and bank details.',
        'fields' => [
            ['label' => 'Instructions', 'name' => 'instructions', 'type' => 'textarea', 'placeholder' => 'Payment instructions'],
            ['label' => 'Bank Details', 'name' => 'bank_details', 'type' => 'textarea', 'placeholder' => 'Account name, number, IFSC'],
            ['label' => 'QR Code', 'name' => 'qr_code', 'type' => 'file'],
        ],
    ],
    'site-theme' => [
        'type' => 'settings',
        'description' => 'Choose the primary and secondary colors for the website theme.',
        'fields' => [
            ['label' => 'Primary Color', 'name' => 'primary_color', 'type' => 'text', 'placeholder' => '#e94e77'],
            ['label' => 'Secondary Color', 'name' => 'secondary_color', 'type' => 'text', 'placeholder' => '#fca5a5'],
        ],
    ],
    'site-logo' => [
        'type' => 'form',
        'description' => 'Upload the site logo and favicon for branding.',
        'fields' => [
            ['label' => 'Upload Logo', 'name' => 'logo', 'type' => 'file'],
            ['label' => 'Upload Favicon', 'name' => 'favicon', 'type' => 'file'],
        ],
    ],
    'site-homepage' => [
        'type' => 'form',
        'description' => 'Configure homepage hero text and banner visuals.',
        'fields' => [
            ['label' => 'Hero Title', 'name' => 'hero_title', 'type' => 'text', 'placeholder' => 'Your perfect life partner is waiting'],
            ['label' => 'Subtitle', 'name' => 'subtitle', 'type' => 'text', 'placeholder' => 'Find meaningful connections'],
            ['label' => 'Banner Image', 'name' => 'banner_image', 'type' => 'file'],
        ],
    ],
    'site-social' => [
        'type' => 'form',
        'description' => 'Update social media links for the website footer and contact pages.',
        'fields' => [
            ['label' => 'Facebook', 'name' => 'facebook', 'type' => 'text', 'placeholder' => 'https://facebook.com/...'],
            ['label' => 'Instagram', 'name' => 'instagram', 'type' => 'text', 'placeholder' => 'https://instagram.com/...'],
            ['label' => 'WhatsApp', 'name' => 'whatsapp', 'type' => 'text', 'placeholder' => '+91...'],
        ],
    ],
    'settings-whatsapp' => [
        'type' => 'settings',
        'description' => 'Enable WhatsApp button support and configure the target number.',
        'fields' => [
            ['label' => 'WhatsApp Number', 'name' => 'whatsapp_number', 'type' => 'text', 'placeholder' => '+91...'],
            ['label' => 'Enable Button', 'name' => 'enable_button', 'type' => 'select', 'options' => ['Yes', 'No']],
        ],
    ],
    'settings-basic' => [
        'type' => 'form',
        'description' => 'Basic site settings such as name, email, and contact phone.',
        'fields' => [
            ['label' => 'Site Name', 'name' => 'site_name', 'type' => 'text', 'placeholder' => 'Shadikibaat'],
            ['label' => 'Email', 'name' => 'email', 'type' => 'text', 'placeholder' => 'admin@example.com'],
            ['label' => 'Phone', 'name' => 'phone', 'type' => 'text', 'placeholder' => '+91 98765 43210'],
        ],
    ],
    'settings-seo' => [
        'type' => 'form',
        'description' => 'SEO metadata for search engines and page previews.',
        'fields' => [
            ['label' => 'Meta Title', 'name' => 'meta_title', 'type' => 'text', 'placeholder' => 'Shadikibaat Matrimonial'],
            ['label' => 'Meta Description', 'name' => 'meta_description', 'type' => 'textarea', 'placeholder' => 'Best matchmaking platform...'],
            ['label' => 'Keywords', 'name' => 'keywords', 'type' => 'text', 'placeholder' => 'matrimonial, marriage, profiles'],
        ],
    ],
    'settings-smtp' => [
        'type' => 'form',
        'description' => 'SMTP credentials so the site can send notification emails.',
        'fields' => [
            ['label' => 'Host', 'name' => 'smtp_host', 'type' => 'text', 'placeholder' => 'smtp.example.com'],
            ['label' => 'Port', 'name' => 'smtp_port', 'type' => 'number', 'placeholder' => '587'],
            ['label' => 'Email', 'name' => 'smtp_email', 'type' => 'text', 'placeholder' => 'noreply@example.com'],
            ['label' => 'Password', 'name' => 'smtp_password', 'type' => 'password', 'placeholder' => '••••••••'],
        ],
    ],
    'settings-fields' => [
        'type' => 'table',
        'description' => 'Enable or disable member profile fields globally.',
        'columns' => ['Field', 'Enabled', 'Action'],
        'rows' => [['Religion', 'Yes', 'Toggle'], ['City', 'Yes', 'Toggle'], ['About Me', 'No', 'Toggle']],
    ],
    'settings-menu' => [
        'type' => 'table',
        'description' => 'Toggle menu items and admin navigation visibility.',
        'columns' => ['Menu Item', 'Visible', 'Action'],
        'rows' => [['Members', 'Yes', 'Toggle'], ['Payments', 'Yes', 'Toggle'], ['Advertisement', 'No', 'Toggle']],
    ],
    'settings-sms' => [
        'type' => 'form',
        'description' => 'SMS gateway settings for OTP and notifications.',
        'fields' => [
            ['label' => 'SMS API Key', 'name' => 'sms_api_key', 'type' => 'text', 'placeholder' => 'sms_api_key'],
            ['label' => 'Sender ID', 'name' => 'sms_sender_id', 'type' => 'text', 'placeholder' => 'SATHIIN'],
        ],
    ],
    'data-contact' => [
        'type' => 'table',
        'description' => 'Review contact form submissions from visitors.',
        'columns' => ['Name', 'Email', 'Message'],
        'rows' => [['Sakshi Patel', 'sakshi@example.com', 'I have a question about membership.'], ['Vijay Kumar', 'vijay@example.com', 'How do I contact support?']],
    ],
    'data-export' => [
        'type' => 'action',
        'description' => 'Export users and member data to CSV or Excel files.',
        'buttons' => [['label' => 'Export Users', 'type' => 'primary'], ['label' => 'Export Memberships', 'type' => 'secondary']],
    ],
    'data-backup' => [
        'type' => 'action',
        'description' => 'Create a database backup snapshot for recovery and auditing.',
        'buttons' => [['label' => 'Backup Database', 'type' => 'primary']],
    ],
    'account-password' => [
        'type' => 'form',
        'description' => 'Change the admin password to keep the account secure.',
        'fields' => [
            ['label' => 'Old Password', 'name' => 'old_password', 'type' => 'password'],
            ['label' => 'New Password', 'name' => 'new_password', 'type' => 'password'],
            ['label' => 'Confirm Password', 'name' => 'confirm_password', 'type' => 'password'],
        ],
    ],
];
