<?php
declare(strict_types=1);

/**
 * Single source for registration master lists + field visibility (static until DB).
 * Admin master pages should mirror these lists; later replace with DB reads.
 */
function sathi_registration_masters(): array
{
    return [
        'religion' => [
            ['value' => 'jain', 'label' => 'Jain'],
        ],
        'gotra' => [
            ['value' => 'kashyap', 'label' => 'Kashyap'],
            ['value' => 'bharadwaj', 'label' => 'Bharadwaj'],
            ['value' => 'vasishtha', 'label' => 'Vasishtha'],
            ['value' => 'agarwal', 'label' => 'Agarwal'],
            ['value' => 'goyal', 'label' => 'Goyal'],
            ['value' => 'bansal', 'label' => 'Bansal'],
            ['value' => 'singhal', 'label' => 'Singhal'],
            ['value' => 'mittal', 'label' => 'Mittal'],
            ['value' => 'other', 'label' => 'Other'],
            ['value' => 'prefer_not', 'label' => 'Prefer not to say'],
        ],
        'occupation' => [
            ['value' => 'doctor', 'label' => 'Doctor'],
            ['value' => 'engineer', 'label' => 'Engineer'],
            ['value' => 'ca', 'label' => 'CA'],
            ['value' => 'business', 'label' => 'Business'],
            ['value' => 'government', 'label' => 'Government job'],
            ['value' => 'service', 'label' => 'Private service'],
            ['value' => 'advocate', 'label' => 'Advocate'],
            ['value' => 'entrepreneur', 'label' => 'Entrepreneur'],
        ],
        'education' => [
            ['value' => 'btech', 'label' => 'B.Tech'],
            ['value' => 'mtech', 'label' => 'M.Tech'],
            ['value' => 'mba', 'label' => 'MBA'],
            ['value' => 'mbbs', 'label' => 'MBBS'],
            ['value' => 'bcom', 'label' => 'B.Com'],
            ['value' => 'mcom', 'label' => 'M.Com'],
            ['value' => 'ca', 'label' => 'CA'],
            ['value' => 'mca', 'label' => 'MCA'],
            ['value' => 'bba', 'label' => 'BBA'],
            ['value' => 'llb', 'label' => 'LLB'],
            ['value' => 'other', 'label' => 'Other'],
        ],
        'annual_income' => [
            ['value' => '0-2', 'label' => '0–2 Lakh'],
            ['value' => '2-5', 'label' => '2–5 Lakh'],
            ['value' => '5-10', 'label' => '5–10 Lakh'],
            ['value' => '10-20', 'label' => '10–20 Lakh'],
            ['value' => '20+', 'label' => '20+ Lakh'],
        ],
        'mother_tongue' => [
            ['value' => 'hindi', 'label' => 'Hindi'],
            ['value' => 'gujarati', 'label' => 'Gujarati'],
            ['value' => 'marwari', 'label' => 'Marwari'],
            ['value' => 'tamil', 'label' => 'Tamil'],
            ['value' => 'kannada', 'label' => 'Kannada'],
            ['value' => 'marathi', 'label' => 'Marathi'],
            ['value' => 'english', 'label' => 'English'],
            ['value' => 'other', 'label' => 'Other'],
        ],
        'marital_status' => [
            ['value' => 'never_married', 'label' => 'Never married'],
            ['value' => 'divorced', 'label' => 'Divorced'],
            ['value' => 'widowed', 'label' => 'Widowed'],
        ],
        'star' => [
            ['value' => 'ashwini', 'label' => 'Ashwini'],
            ['value' => 'bharani', 'label' => 'Bharani'],
            ['value' => 'krittika', 'label' => 'Krittika'],
            ['value' => 'rohini', 'label' => 'Rohini'],
            ['value' => 'mrigasira', 'label' => 'Mrigasira'],
            ['value' => 'other', 'label' => 'Other'],
        ],
        'rasi' => [
            ['value' => 'mesh', 'label' => 'Mesh (Aries)'],
            ['value' => 'vrishabh', 'label' => 'Vrishabh (Taurus)'],
            ['value' => 'mithun', 'label' => 'Mithun (Gemini)'],
            ['value' => 'karka', 'label' => 'Karka (Cancer)'],
            ['value' => 'simha', 'label' => 'Simha (Leo)'],
            ['value' => 'kanya', 'label' => 'Kanya (Virgo)'],
            ['value' => 'tula', 'label' => 'Tula (Libra)'],
            ['value' => 'vrishchik', 'label' => 'Vrishchik (Scorpio)'],
            ['value' => 'dhanu', 'label' => 'Dhanu (Sagittarius)'],
            ['value' => 'makar', 'label' => 'Makar (Capricorn)'],
            ['value' => 'kumbha', 'label' => 'Kumbha (Aquarius)'],
            ['value' => 'meena', 'label' => 'Meena (Pisces)'],
        ],
        'dosh' => [
            ['value' => 'none', 'label' => 'No Dosh'],
            ['value' => 'mangal', 'label' => 'Mangal Dosh'],
            ['value' => 'kalsarp', 'label' => 'Kal Sarp Dosh'],
            ['value' => 'other', 'label' => 'Other'],
            ['value' => 'dont_know', 'label' => 'Don\'t know'],
        ],
        'geo' => [
            'countries' => [
                ['value' => 'in', 'label' => 'India'],
                ['value' => 'us', 'label' => 'United States'],
                ['value' => 'ae', 'label' => 'United Arab Emirates'],
                ['value' => 'uk', 'label' => 'United Kingdom'],
                ['value' => 'ca', 'label' => 'Canada'],
                ['value' => 'au', 'label' => 'Australia'],
            ],
            'states' => [
                'in' => [
                    ['value' => 'up', 'label' => 'Uttar Pradesh'],
                    ['value' => 'mh', 'label' => 'Maharashtra'],
                    ['value' => 'rj', 'label' => 'Rajasthan'],
                    ['value' => 'mp', 'label' => 'Madhya Pradesh'],
                    ['value' => 'dl', 'label' => 'Delhi'],
                    ['value' => 'ka', 'label' => 'Karnataka'],
                    ['value' => 'wb', 'label' => 'West Bengal'],
                    ['value' => 'tn', 'label' => 'Tamil Nadu'],
                    ['value' => 'tg', 'label' => 'Telangana'],
                    ['value' => 'other', 'label' => 'Other / Outside India'],
                ],
            ],
            'cities' => [
                'gj' => [
                    ['value' => 'ahmedabad', 'label' => 'Ahmedabad'],
                    ['value' => 'surat', 'label' => 'Surat'],
                    ['value' => 'vadodara', 'label' => 'Vadodara'],
                    ['value' => 'rajkot', 'label' => 'Rajkot'],
                    ['value' => 'bhavnagar', 'label' => 'Bhavnagar'],
                    ['value' => 'jamnagar', 'label' => 'Jamnagar'],
                    ['value' => 'junagadh', 'label' => 'Junagadh'],
                    ['value' => 'gandhidham', 'label' => 'Gandhidham'],
                    ['value' => 'nadiad', 'label' => 'Nadiad'],
                    ['value' => 'gandhinagar', 'label' => 'Gandhinagar'],
                    ['value' => 'anand', 'label' => 'Anand'],
                    ['value' => 'morbi', 'label' => 'Morbi'],
                    ['value' => 'mehsana', 'label' => 'Mehsana'],
                    ['value' => 'surendranagar', 'label' => 'Surendranagar'],
                    ['value' => 'bharuch', 'label' => 'Bharuch'],
                    ['value' => 'vapi', 'label' => 'Vapi'],
                    ['value' => 'navsari', 'label' => 'Navsari'],
                    ['value' => 'veraval', 'label' => 'Veraval'],
                    ['value' => 'porbandar', 'label' => 'Porbandar'],
                    ['value' => 'godhra', 'label' => 'Godhra'],
                    ['value' => 'bhuj', 'label' => 'Bhuj'],
                    ['value' => 'ankleshwar', 'label' => 'Ankleshwar'],
                    ['value' => 'botad', 'label' => 'Botad'],
                    ['value' => 'palanpur', 'label' => 'Palanpur'],
                    ['value' => 'patan', 'label' => 'Patan'],
                    ['value' => 'dahod', 'label' => 'Dahod'],
                    ['value' => 'jetpur', 'label' => 'Jetpur'],
                    ['value' => 'valsad', 'label' => 'Valsad'],
                    ['value' => 'kalol', 'label' => 'Kalol'],
                    ['value' => 'gondal', 'label' => 'Gondal'],
                    ['value' => 'amreli', 'label' => 'Amreli'],
                    ['value' => 'other', 'label' => 'Other / Local City'],
                ],
                'mp' => [
                    ['value' => 'indore', 'label' => 'Indore'],
                    ['value' => 'bhopal', 'label' => 'Bhopal'],
                    ['value' => 'gwalior', 'label' => 'Gwalior'],
                    ['value' => 'jabalpur', 'label' => 'Jabalpur'],
                    ['value' => 'ujjain', 'label' => 'Ujjain'],
                    ['value' => 'rewa', 'label' => 'Rewa'],
                    ['value' => 'other', 'label' => 'Other (Custom)']
                ],
                'mh' => [
                    ['value' => 'mumbai', 'label' => 'Mumbai'],
                    ['value' => 'pune', 'label' => 'Pune'],
                    ['value' => 'nagpur', 'label' => 'Nagpur'],
                    ['value' => 'nashik', 'label' => 'Nashik'],
                    ['value' => 'aurangabad', 'label' => 'Aurangabad'],
                    ['value' => 'other', 'label' => 'Other (Custom)']
                ],
                'rj' => [
                    ['value' => 'jaipur', 'label' => 'Jaipur'],
                    ['value' => 'jodhpur', 'label' => 'Jodhpur'],
                    ['value' => 'udaipur', 'label' => 'Udaipur'],
                    ['value' => 'kota', 'label' => 'Kota'],
                    ['value' => 'ajmer', 'label' => 'Ajmer'],
                    ['value' => 'other', 'label' => 'Other (Custom)']
                ],
                'up' => [
                    ['value' => 'lucknow', 'label' => 'Lucknow'],
                    ['value' => 'kanpur', 'label' => 'Kanpur'],
                    ['value' => 'agra', 'label' => 'Agra'],
                    ['value' => 'varanasi', 'label' => 'Varanasi'],
                    ['value' => 'noida', 'label' => 'Noida'],
                    ['value' => 'ghaziabad', 'label' => 'Ghaziabad'],
                    ['value' => 'other', 'label' => 'Other (Custom)']
                ],
                'dl' => [
                    ['value' => 'delhi', 'label' => 'Delhi'],
                    ['value' => 'new_delhi', 'label' => 'New Delhi'],
                    ['value' => 'other', 'label' => 'Other (Custom)']
                ],
                'ka' => [
                    ['value' => 'bangalore', 'label' => 'Bengaluru'],
                    ['value' => 'mysore', 'label' => 'Mysuru'],
                    ['value' => 'other', 'label' => 'Other (Custom)']
                ],
                'wb' => [
                    ['value' => 'kolkata', 'label' => 'Kolkata'],
                    ['value' => 'other', 'label' => 'Other (Custom)']
                ],
                'tn' => [
                    ['value' => 'chennai', 'label' => 'Chennai'],
                    ['value' => 'other', 'label' => 'Other (Custom)']
                ],
                'tg' => [
                    ['value' => 'hyderabad', 'label' => 'Hyderabad'],
                    ['value' => 'other', 'label' => 'Other (Custom)']
                ],
            ],
        ],
    ];
}

/**
 * @return array<string, array{visible: bool, required: bool}>
 */
function sathi_registration_field_settings(): array
{
    static $cached = null;
    if ($cached !== null) {
        return $cached;
    }

    $defaults = [
        'email' => ['visible' => true, 'required' => true],
        'password' => ['visible' => true, 'required' => true],
        'password_confirm' => ['visible' => true, 'required' => true],
        'digamber_jain' => ['visible' => true, 'required' => true],
        'first_name' => ['visible' => true, 'required' => true],
        'last_name' => ['visible' => true, 'required' => true],
        'gender' => ['visible' => true, 'required' => true],
        'marital_status' => ['visible' => true, 'required' => true],
        'mother_tongue' => ['visible' => true, 'required' => true],
        'religion' => ['visible' => true, 'required' => true],
        'temple' => ['visible' => true, 'required' => true],
        'birth_date' => ['visible' => true, 'required' => true],
        'birth_time' => ['visible' => true, 'required' => true],
        'birth_country' => ['visible' => true, 'required' => true],
        'birth_state' => ['visible' => true, 'required' => true],
        'birth_city' => ['visible' => true, 'required' => true],
        'birth_place' => ['visible' => true, 'required' => true],
        'native_country' => ['visible' => true, 'required' => true],
        'native_state' => ['visible' => true, 'required' => true],
        'native_city' => ['visible' => true, 'required' => true],
        'native_place' => ['visible' => true, 'required' => true],
        'gotra' => ['visible' => true, 'required' => false],
        'star' => ['visible' => true, 'required' => false],
        'rasi' => ['visible' => true, 'required' => false],
        'dosh' => ['visible' => true, 'required' => false],
        'kundli_type' => ['visible' => true, 'required' => false],
        'kundli_image' => ['visible' => true, 'required' => false],
        'horoscope' => ['visible' => true, 'required' => true],
        'country_code' => ['visible' => true, 'required' => true],
        'mobile' => ['visible' => true, 'required' => true],
        'whatsapp_same' => ['visible' => true, 'required' => false],
        'wa_country_code' => ['visible' => true, 'required' => true],
        'whatsapp_number' => ['visible' => true, 'required' => true],
        'addr_perm' => ['visible' => true, 'required' => true],
        'same_as_perm' => ['visible' => true, 'required' => false],
        'addr_curr' => ['visible' => true, 'required' => true],
        'education' => ['visible' => true, 'required' => true],
        'hobbies' => ['visible' => true, 'required' => false],
        'occupation' => ['visible' => true, 'required' => true],
        'firm_name' => ['visible' => true, 'required' => true],
        'designation' => ['visible' => true, 'required' => true],
        'annual_income' => ['visible' => true, 'required' => true],
        'father_name' => ['visible' => true, 'required' => false],
        'father_mobile' => ['visible' => true, 'required' => false],
        'father_income' => ['visible' => true, 'required' => false],
        'father_occ' => ['visible' => true, 'required' => false],
        'mother_name' => ['visible' => true, 'required' => false],
        'mother_mobile' => ['visible' => true, 'required' => false],
        'mother_income' => ['visible' => true, 'required' => false],
        'mother_occ' => ['visible' => true, 'required' => false],
        'siblings' => ['visible' => true, 'required' => true],
        'bro_total' => ['visible' => true, 'required' => true],
        'bro_married' => ['visible' => true, 'required' => true],
        'bro_unmarried' => ['visible' => true, 'required' => true],
        'sis_total' => ['visible' => true, 'required' => true],
        'sis_married' => ['visible' => true, 'required' => true],
        'sis_unmarried' => ['visible' => true, 'required' => true],
        'relative_details' => ['visible' => true, 'required' => false],
        'height' => ['visible' => true, 'required' => true],
        'weight' => ['visible' => true, 'required' => true],
        'complexion' => ['visible' => true, 'required' => true],
        'blood_group' => ['visible' => true, 'required' => true],
        'profile_created_by' => ['visible' => true, 'required' => true],
        'photo' => ['visible' => true, 'required' => true],
        'pay_method' => ['visible' => true, 'required' => true],
        'razorpay_payment_id' => ['visible' => false, 'required' => false],
        'csrf_token' => ['visible' => false, 'required' => false],
    ];

    try {
        if (!function_exists('sathi_db')) {
            require_once dirname(__DIR__) . '/config/database.php';
        }
        $db = sathi_db();
        $res = $db->query("SELECT field_key, is_visible, is_required FROM registration_field_settings");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $defaults[$row['field_key']] = [
                    'visible' => (bool) $row['is_visible'],
                    'required' => (bool) $row['is_required']
                ];
            }
        }
    } catch (Throwable $e) {
        // Fallback to defaults
    }

    $cached = $defaults;
    return $cached;
}

/**
 * @return array{visible: bool, required: bool}
 */
function sathi_reg_field(string $key): array
{
    $all = sathi_registration_field_settings();
    return $all[$key] ?? ['visible' => true, 'required' => false];
}

function sathi_reg_field_wrap_attrs(string $key, string $extraClass = ''): string
{
    $f = sathi_reg_field($key);
    $class = 'reg-field-wrap';
    if ($extraClass !== '') {
        $class .= ' ' . $extraClass;
    }
    if (!$f['visible']) {
        $class .= ' reg-field-wrap--hidden';
    }
    return ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '" data-reg-field="' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '"';
}

function sathi_reg_field_required_attr(string $key): string
{
    $f = sathi_reg_field($key);
    return ($f['visible'] && $f['required']) ? ' required' : '';
}

/**
 * @param array<int, array{value: string, label: string}> $options
 */
function sathi_reg_render_select_options(array $options): void
{
    echo '<option value="" disabled selected></option>';
    foreach ($options as $opt) {
        $v = htmlspecialchars($opt['value'], ENT_QUOTES, 'UTF-8');
        $l = htmlspecialchars($opt['label'], ENT_QUOTES, 'UTF-8');
        echo '<option value="' . $v . '">' . $l . '</option>';
    }
}

/**
 * Labels for admin Field Visibility table (order matters).
 * Only include user-input fields here, skip system/logic fields.
 *
 * @return array<string, string>
 */
function sathi_registration_field_labels(): array
{
    return [
        'email' => 'Email',
        'password' => 'Account password',
        'digamber_jain' => 'Digamber Jain verification',
        'first_name' => 'First name',
        'last_name' => 'Last name',
        'gender' => 'Gender',
        'marital_status' => 'Marital status',
        'mother_tongue' => 'Mother tongue',
        'religion' => 'Religion',
        'temple' => 'Temple name',
        'birth_date' => 'Birth date',
        'birth_time' => 'Birth time',
        'birth_country' => 'Birth country',
        'birth_state' => 'Birth state',
        'birth_city' => 'Birth city',
        'birth_place' => 'Birth place (locality)',
        'native_country' => 'Native country',
        'native_state' => 'Native state',
        'native_city' => 'Native city',
        'native_place' => 'Native place (locality)',
        'gotra' => 'Gotra',
        'star' => 'Star (Nakshatra)',
        'rasi' => 'Rasi (Moonsign)',
        'dosh' => 'Dosh (Mangal etc.)',
        'kundli_type' => 'Kundli type',
        'kundli_image' => 'Kundli image upload',
        'horoscope' => 'Horoscope upload',
        'mobile' => 'Mobile number',
        'whatsapp_number' => 'WhatsApp number',
        'addr_perm' => 'Permanent address',
        'addr_curr' => 'Current address',
        'education' => 'Education',
        'hobbies' => 'Hobbies',
        'occupation' => 'Occupation',
        'firm_name' => 'Company / firm name',
        'designation' => 'Designation',
        'annual_income' => 'Annual income',
        'father_name' => 'Father — name',
        'father_mobile' => 'Father — mobile',
        'father_income' => 'Father — income',
        'father_occ' => 'Father — occupation',
        'mother_name' => 'Mother — name',
        'mother_mobile' => 'Mother — mobile',
        'mother_income' => 'Mother — income',
        'mother_occ' => 'Mother — occupation',
        'siblings' => 'Sibling details (Group)',
        'relative_details' => 'Relative details',
        'height' => 'Height',
        'weight' => 'Weight',
        'complexion' => 'Complexion',
        'blood_group' => 'Blood group',
        'profile_created_by' => 'Profile created by',
        'photo' => 'Photo upload',
        'pay_method' => 'Payment method',
    ];
}
