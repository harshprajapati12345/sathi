-- COMPLETE SEEDER FOR MALE CANDIDATES (All Records)
START TRANSACTION;

INSERT IGNORE INTO `users` (
    `profile_id`, `first_name`, `last_name`, `email`, `mobile`, `password_hash`,
    `gender`, `dob`, `religion_id`, `mother_tongue_id`, `marital_status_id`,
    `education_id`, `occupation_id`, `country_id`, `weight`, `permanent_address`,
    `current_address`, `hobbies`, `annual_income`, `widow_divorce`, `handicapped`,
    `languages_known`, `occupation_firm`, `occupation_designation`, `father_name`,
    `father_mobile_number`, `father_annual_income`, `father_occupation`, `mother_name`,
    `mother_mobile_number`, `mother_annual_income`, `mother_occupation`, `brothers`,
    `brothers_married_count`, `brothers_unmarried_count`, `sisters`, `sisters_married_count`,
    `sisters_unmarried_count`, `candidate_photo`, `payment_qr_code`, `payment_screenshot`,
    `status`, `membership_status`, `email_verified`, `mobile_verified`, `created_at`, `updated_at`
) VALUES

-- Record 1
(
    'PROF000001', 'Sachin', 'Bhavarlal Jain', 'kalpanaviral222@gmail.com', '9376121836',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1993-07-08', 2, 2, 1, 11, 4, 1, 65,
    '2,Avadhpuri society,near Tripada society ,Gor no kuvo,Maninagar -East, Ahmedabad',
    NULL,
    'Music,Traveling,Gym, Cricket',
    1500000.00, 'Not Applicable', 'No',
    'Gujarati, Hindi, Marwadi',
    'Simandhar Provision Store ,Shridhar complex,opp sevendays school,Haripura,Maninagar East',
    'Owner',
    'Bhavarlal Jalamchand Jain', '9099502754', 1500000.00, 'Business',
    'Shashiben Bhavarlal Jain', '9825676814', NULL, 'House Wife',
    0, 0, 0, 2, 2, 0,
    'https://drive.google.com/open?id=1zIbG33ZEmNtGF9_HNhe9YNIJ9h0N7pON',
    'Upi',
    'https://drive.google.com/open?id=15vtg8oT8hP6GxSc2nouW-HCSs3QKrLCi',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 2
(
    'PROF000002', 'AAKASH', 'JAIN', 'grivafin@gmail.com', '9737067941',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1996-01-01', 2, 2, 1, 11, 4, 1, 78,
    'B 302 TULSI STATUS NEW TRAGAD NR VAISNODEVI CIRCLE AHMEDABAD-382470',
    'B 302 TULSI STATUS NEW TRAGAD NR VAISNODEVI CIRCLE AHMEDABAD-382470',
    'TRAVELLING',
    150000.00, 'Not Applicable', 'No',
    'Gujarati, Hindi, English',
    'GRIVA INSURANCE SOLUTION',
    'OWNER',
    'VINODKUMAR G JAIN', '8000120070', 75000.00, 'Retired',
    'KIRANBEN V JAIN', '6352915576', 0.00, 'House Wife',
    1, 1, 0, 2, 2, 0,
    'https://drive.google.com/open?id=1mrLVCraGDGB3kWlQ3mFSx994Sn3zfEsO',
    NULL,
    'https://drive.google.com/open?id=1N2pF0BV2zJQ1Pnejxq-YQDt2qxlTFXpx',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 3
(
    'PROF000003', 'Aayush', 'Kalpeshbhai Shah', 'ayushshah2182000@gmail.com', '9429009266',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '2000-08-21', 2, 2, 1, 1, 6, 1, 76,
    '12,Punit Nagar part-3, Near Mahesh complex, Waghodia Road Vadodara-390019',
    NULL,
    'Traveling',
    550000.00, 'Not Applicable', 'No',
    'Gujarati, Hindi, English',
    'Tuvoc Technology PVT LTD',
    'Software Engineer',
    'Kalpeshbhai Ratilal Shah', '8140349056', NULL, 'Job',
    'Hetalben Kalpeshbhai Shah', '9428766225', NULL, 'House Wife',
    0, 0, 0, 1, 1, NULL,
    'https://drive.google.com/open?id=1Fwuvhy2JpwNVFb19_KodxMS-ujkqh4nE',
    'ayushshah2182000@okaxis',
    'https://drive.google.com/open?id=1E3B6HV1X0MKasjJ5ia-43HNBZ0ujY-6t',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 4
(
    'PROF000004', 'Abhilash', 'Dosi', 'apunramjane@gmail.com', '7737000449',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1992-08-29', 2, 2, 2, 1, 4, 1, 78,
    'Jigar Stationary, Dahod Road , Gangartalai Banswara Rajasthan (327601)',
    'Jigar Stationary, Dahod Road , Gangartalai Banswara Rajasthan (327601)',
    'Music, Travel, Bike Riding, Movies',
    450000.00, 'Divorce', 'No',
    'Gujarati, Hindi, English',
    'MNC Process BDO & Computer Science',
    'Jr Officer',
    'Bhupendra Dosi', '9001242576', 1200000.00, 'Job',
    'Sharmista Dosi', '9799808286', 0.00, 'House Wife',
    1, 1, 0, 0, 0, 0,
    'https://drive.google.com/open?id=1oFxiccFIEQsZSScPHg45RHybU_owvrLn',
    'Payment Done',
    'https://drive.google.com/open?id=1DCfP8oM_ReelPWCx-EoRH67uBDi7jD-W',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 5
(
    'PROF000005', 'Abhinav', 'jain', 'rajulsomia@gmail.com', '9414918583',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1999-12-20', 2, 1, 1, 1, 6, 1, 67,
    '2 aadarsh nagar opp veshali appartment Hiran magri sector 4 Udaipur Rajasthan',
    'Udaipur rajsthan',
    'Traveling, Reading',
    1500000.00, 'Not Applicable', 'No',
    'Hindi, English',
    'Dealshare',
    'Software engineer',
    'Rishabh kumar jain', '9414918583', 3000000.00, 'Job',
    'Rekha jain', '9414918583', 1800000.00, 'Job',
    1, 1, 0, 0, 0, 0,
    'https://drive.google.com/open?id=180evmjJMXDeLoM8Ny2XvNL4eVgpVUrYi',
    '4270000000',
    'https://drive.google.com/open?id=1HYA498tMkC57R9xB1frrDYuwQydOmMyc',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 6
(
    'PROF000006', 'Abhinesh', 'Sabariya', 'abhinesh.sabariya@gmail.com', '9887999181',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1990-07-26', 2, 1, 1, 1, 6, 1, 60,
    'Lohar Gali, Behind Chatiyalia Temple, Pratapgarh(Raj)-312605',
    'C10, Kankavati Flats, Near Gaurang Society, Vasna, Ahmedabad-380007',
    'Like to play cricket, Badminton, Chess, Listen to music',
    1000000.00, 'Not Applicable', 'No',
    'Hindi, English',
    'Smartmeters Technology Pvt. Ltd.',
    'Asst. Manager Quality',
    'Sunil Kumar Sabariya', '9784243392', NULL, 'Business',
    'Savita Sabariya', '9694703486', NULL, 'House Wife',
    1, 1, NULL, 0, NULL, NULL,
    'https://drive.google.com/open?id=1Sw-kUagitTjPT0n_Ih-AuKppid5IsNld',
    NULL,
    'https://drive.google.com/open?id=13WhbgIzIfrssVcnCUFkameu5tx_U1SDd',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 7
(
    'PROF000007', 'Abhishek', 'Bharatkumar Bhavot', 'shrutibhavot321@gmail.com', '8128356576',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '2001-11-01', 2, 2, 1, 5, 6, 1, 65,
    'A 502 Dev Ashish 2, Nr. Sarvopari flora, Naroda, Ahmedabad 382330',
    NULL,
    'Watching movies, Travelling',
    NULL, 'Not Applicable', 'No',
    'Gujarati, Hindi, English, Mewadi',
    'Hitech Engineering pvt. ltd.',
    'Senior Accountant',
    'Bhvot Bharatkumar Babulal', '9510044358', NULL, 'Business',
    'Bhavot Suman Bharatkumar', '9377168363', NULL, 'House Wife',
    0, 0, 0, 1, 1, 0,
    'https://drive.google.com/open?id=1e7nZjbWqVQ6SFttFqMUqm4iy6_y82BK-',
    'Paid by Shruti Bhavot on 9-28',
    'https://drive.google.com/open?id=1zgm8ZLMAJfx6f3lfeFsTOnvMrSL3pttJ',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 8
(
    'PROF000008', 'Adit', 'Vijayakumar Shah', 'shahadit03@gmail.com', '8980574795',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1997-08-23', 2, 2, 1, 7, 6, 1, 75,
    '704 Rushabh Enclave Mahalakshmi Paach Rasta Paldi Ahmedabad',
    NULL,
    'Singing, Travelling',
    2200000.00, 'Not Applicable', NULL,
    'Gujarati, Hindi, English',
    NULL,
    NULL,
    'Vijayakumar K shah', '9879057653', NULL, 'Business',
    'Rakshita Shah', '8306245355', NULL, 'House Wife',
    0, 0, 0, 1, NULL, 1,
    'https://drive.google.com/open?id=1e9m6crZCZm8iKzY8xu0x35LnGE5S8EQY',
    NULL,
    'https://drive.google.com/open?id=1c2nZqrTOgkkf17gAHa-zJWdJFgaotm2l',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 9
(
    'PROF000009', 'ADITYA VARDHAN', 'GANDHI', 'dileepgandhi011@gmail.com', '7424809412',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1994-05-19', 2, 2, 1, 5, 4, 1, 65,
    'V.P.O NAUGAMA, BAGIDORA, BANSWARA RAJASTHAN 327603',
    'D-22 TARUN-NAGAR-3 SOCEITY NEAR JAIN DERASAR SUBASH CHOWK GURUKUL AHMEDABAD GUJARAT 320062',
    'WRITING BOOKS',
    800000.00, 'Not Applicable', 'No',
    'Gujarati, Hindi, English',
    'FLASH MEDIA BRANDING AHEMDABAD',
    'OWNER OF BUSINESS',
    'DILEEP KUMAR GANDHI', '9829059474', 1600000.00, 'Business',
    'SUSHMA GANDHI', '982959474', 0.00, 'House Wife',
    0, 0, 0, 1, NULL, NULL,
    'https://drive.google.com/open?id=1mv1tTnqYcXXb3J500DANqFzpTzWe6ykC',
    'GPAY',
    'https://drive.google.com/open?id=1K-DBWXLpkGh7M6W_wQTfXchlyVQojk7j',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 10
(
    'PROF000010', 'Ajay', 'Bhorawat', 'ajaybhorawat20@gmail.com', '8767970820',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1989-07-20', 2, 3, 1, 3, 6, 1, 75,
    'Flat no.12, 4 Floor, 2A New Building, Jitekarwadi, 88A Thakurdwar, Dr.Baba saheb Jaykar marg, Charni road East, Mumbai 4',
    'Manyata Tech park, Hebbal, Bangalore',
    'Travelling, watching movie and series, music and reading books',
    3250000.00, 'Not Applicable', 'No',
    'Gujarati, Hindi, English, MARWADI, Marathi',
    'Commonwealth Bank of Australia',
    'Associate Manager',
    'Prabhulal Bhorawat', '9322888224', NULL, 'Business',
    'Indira Bhorawat', '9322888224', NULL, 'House Wife',
    1, 1, 0, 2, 2, 0,
    'https://drive.google.com/open?id=1XH_yneeU3wORCilK7BRjYzHAUojIXt2L',
    'Paid',
    'https://drive.google.com/open?id=1noCvsriS28ljIIdtcNpL7UQeD6mUYyX_',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 11
(
    'PROF000011', 'AKASH', 'KETANBHAI SHAH', 'akash.shah2510@gmail.com', '9723406633',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1991-10-25', 2, 2, 1, 1, 6, 1, 76,
    '8, PADMAVATI SOCIETY, RAMAKAKA ROAD, CHHANI, VADODARA',
    NULL,
    'TRAVELLING, FOOD, CRICKET',
    1200000.00, 'Not Applicable', 'No',
    'Gujarati, Hindi, English',
    'STELLAR FORMULATIONS INDUSTRIES PVT. LTD',
    'MANAGER',
    'Late KETANBHAI HASMUKHLAL SHAH', '-', NULL, 'PASSED AWAY',
    'NAYNABEN KETANBHAI SHAH', '9601282080', 50000.00, 'House Wife',
    0, 0, 0, 1, 1, 0,
    'https://drive.google.com/open?id=17j2QdteHgSdr1sz6tTxtlt0Htst9VhRm',
    'Paid 1000Rs., - 423149279141',
    'https://drive.google.com/open?id=1gx2rx4QZrxWVPXm2u_NYZnjhzxQsEop9',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 12
(
    'PROF000012', 'Akhilesh', 'Jain', 'write2akhileshjain@gmail.com', '9460318182',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1984-12-24', 2, 1, 2, 1, 5, 1, 119,
    '583 Hiran Magri Sector 4 Udaipur Rajasthan',
    NULL,
    'NA',
    NULL, 'Divorce', 'No',
    'Hindi, English',
    'Judiciary',
    'Senior Assistant',
    'Sh Rajendra Kumar Jain', '9829153802', NULL, 'Retired Govt Employee',
    'Manjula Jain', NULL, NULL, 'Retired Govt Teacher',
    0, 0, 0, 1, 1, 0,
    'https://drive.google.com/open?id=1aoEoyV2GbPTir0-fTKAydQUpjUHOFoUi',
    NULL,
    'https://drive.google.com/open?id=1XVVvUpysR4JQkC26aFWddiA3-lcDhQrx',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 13
(
    'PROF000013', 'AKSHATKUMAR JASHAVANTLAL', 'SHAH', 'akshat.shah306@gmail.com', '8401358121',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1997-06-30', 2, 2, 1, 1, 6, 1, 67,
    'F-11 Sanskrut Apartment behind alkapuri society ghatlodiya ahmedabad',
    NULL,
    'Playing chess, watching cricket, Travelin',
    840000.00, 'Not Applicable', NULL,
    'Gujarati, Hindi, English',
    'Moon technolabs',
    'Software QA Engineer',
    'JASHAVANTLAL SHAH', '8238622413', 600000.00, 'Retired',
    'Jayaben Shah', NULL, NULL, 'House Wife',
    0, 0, 0, 2, 2, NULL,
    'https://drive.google.com/open?id=1_e1xsmhaQpZcPkJGfj8xD_WEKTwUcnKB',
    NULL,
    'https://drive.google.com/open?id=1_ivhbzZsG1SKy9ngmPFd2JSh4kDUJ2bA',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 14
(
    'PROF000014', 'Akshay', 'Jain', 'akshayja3@gmail.com', '9636450224',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1988-01-03', 2, 2, 1, 3, 6, 1, 60,
    'Flat no 4, Altitude Apartment, New Navratan Complex, Udaipur',
    'Flat no. 304, Janadhar Mangala Society, GIFT City, Gandhinagar-Gujarat',
    'listening music, gardening',
    1000000.00, 'Not Applicable', 'No',
    'Gujarati, Hindi, English',
    NULL,
    NULL,
    'Gopendra Jain', '9829489820', NULL, 'Job',
    'Indra Jain', NULL, NULL, 'House Wife',
    0, 0, 0, 2, 2, NULL,
    'https://drive.google.com/open?id=11Aa7RCbiVW9Uvl5GJk39uVKXHEsQbyw8',
    NULL,
    'https://drive.google.com/open?id=1XbRu0lvpCKOBh1ZwC8ty2N_9VGcioaRY',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 15
(
    'PROF000015', 'Alekh', 'Manojbhai Shah', 'mrshah1464@gmail.com', '9327028355',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1995-09-13', 2, 2, 1, 2, 5, 1, 75,
    '46 Gokulpark Soc, Maninagar East, Ahmedabad 08',
    NULL,
    'Reading, Travelling, Binge watching, Cricket, Cooking',
    1000000.00, 'Not Applicable', 'No',
    'Gujarati, Hindi, English',
    'Gujarat Information Department',
    'Media Expert',
    'Manojbhai Ratilal Shah', '9327028355', NULL, 'Consultancy',
    'Nitaben Manojbhai Shah', NULL, NULL, 'House Wife',
    0, 0, 0, 1, 1, NULL,
    'https://drive.google.com/open?id=1717uwDzPaGGs7iSnc855w7yFv5HXxYB6',
    'UPI',
    'https://drive.google.com/open?id=1V82FvJG_nl14Do8FRX84_iHMozps4Th_',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 16
(
    'PROF000016', 'Aman', 'Jain', 'jain591225@gmail.com', '8000763766',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1993-03-10', 2, 1, 1, 1, 6, 2, 65,
    'Lahabit, Thaltej, Ahmedabad',
    'yes',
    'Adventure traveling, Hiking, Skydiving, Kayaking & Surfing',
    4000000.00, 'Not Applicable', 'No',
    'Hindi, English',
    'Strategy &, PWC CONSULTANCY, NEW YORK CITY',
    'Sr. Consultant',
    'Pradeep Kumar Jain', '8000763766', 2000000.00, 'Job',
    'Sunita Jain', '8000763766', 500000.00, NULL,
    1, 1, 0, 0, 0, 0,
    'https://drive.google.com/open?id=1JGDATuQ-o1mDHB2hXMqJKVwvL_--h2-X',
    NULL,
    'https://drive.google.com/open?id=162iMKFuhNgy8JkjsEfhPQQE5AK4c16zW',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 17
(
    'PROF000017', 'Aman', 'Junwa', 'amanjunwa1995@gmail.com', '9177740000',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1995-05-17', 2, 2, 1, 1, 6, 1, 65,
    'Shantiniketan, Gali No.3, Aadinath Nagar, Bahubali colony, Banswara(327001)',
    '101 Alfa Society, Near HDFC Bank, link Road, Bharuch(392001)',
    'Swimming, Playing Badminton and watching Documentaries',
    1200000.00, 'Not Applicable', 'No',
    'Gujarati, Hindi, English, Marathi',
    'BASF India Limited',
    'Senior Executive',
    'Rajiv Junwa', '9173000000', 1100000.00, 'Job',
    'Sunita Junwa', '9194150000', 0.00, 'House Wife',
    0, 0, 0, 1, 0, 1,
    'https://drive.google.com/open?id=1uGOu1jkENLx_jKIVXlS-SvjOElPN8C8w',
    'Paid with Google Pay',
    'https://drive.google.com/open?id=1PyiYZvG-QJKPLRtR5YyEaYbCXYKbBLo-',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 18
(
    'PROF000018', 'Anish', 'Jain', 'anishjain.2210@gmail.com', '9913183365',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1998-10-22', 2, 2, 1, 1, 6, 1, 65,
    '501, Richmond Grand, Nr. Torrent Power Substation, Makarba Road, Prahlad Nagar Extension, Ahmedabad',
    NULL,
    'Swimming, Travelling, Connecting',
    2000000.00, 'Not Applicable', 'No',
    'Gujarati, Hindi, English',
    'Crest Data',
    'Technical Lead, Engineering',
    'Sunil Jain', '9726909343', 1500000.00, 'Job',
    'Vandana Jain', '9913183363', NULL, 'House Wife',
    0, 0, 0, 0, NULL, NULL,
    'https://drive.google.com/open?id=1SxK8RkulKbkl8J-L5WDgQdMs-WrSz_Rv',
    '4250000000',
    'https://drive.google.com/open?id=1ufnUYzhe5aW2Zo0ybrsEgNnM-9iRt4k2',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 19
(
    'PROF000019', 'Ankit', 'gandhi', 'vaibhavjain21071987@gmail.com', '9414977004',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1988-01-01', 2, 1, 1, 6, 4, 1, 52,
    'C/O PARASNATH BOOK SELLER, Old Bus Stand, Kherwara, Dist- Udaipur, Rajasthan',
    'Shiv Ganga Residency, Math Road, Savina, Udaipur, Rajasthan',
    'Reading',
    3600000.00, 'Not Applicable', 'No',
    'Hindi, English',
    'PARASNATH BOOK SELLERS',
    'Owner',
    'Nirmal Kumar Gandhi', '9414977004', 1200000.00, 'Business',
    'Kailash Gandhi', '8003780089', NULL, 'House Wife',
    0, 0, 0, 2, 2, 0,
    'https://drive.google.com/open?id=1Y5J378Xlmbhj7E4FS01zmVx20tdJp5Xx',
    'upi',
    'https://drive.google.com/open?id=14GXNJmXRvllA7pFQwVqSVZPbM8thOVjT',
    'approved', 'free', 1, 1, NOW(), NOW()
),

-- Record 20
(
    'PROF000020', 'Ankit', 'jain', 'rajeevjainmini143@gmail.com', '9977933536',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'male', '1988-09-09', 2, 1, 1, 1, 4, 1, 70,
    'Near police thana chandera, tikamgarh, m.p.',
    NULL,
    'Business',
    500000.00, 'Not Applicable', 'No',
    'Hindi',
    'Businessman',
    'General store',
    'Swargiye rajkumar jain', 'Not applicable', NULL, 'No more',
    'Mrs. Sushila jain', '9977932804', NULL, 'House Wife',
    2, 2, 0, 1, 1, 0,
    'https://drive.google.com/open?id=1mL5rTGpUYqaURbTf0p3lVqkPd7PqUOrX',
    'Paid 1000',
    'https://drive.google.com/open?id=1-RbppkBWETGv5_KSK02-GFL8gpSuNgQK',
    'approved', 'free', 1, 1, NOW(), NOW()
);

COMMIT;
