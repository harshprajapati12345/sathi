<?php
$files = [
    'header.php', 'index.php', 'login.php', 'about.php', 'success-stories.php', 
    'membership.php', 'pending.php', 'reject.php', 'helpers/auth_helper.php'
];
foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if ($file === 'helpers/auth_helper.php') {
            // Keep register.php in $public array, just add eligibility.php
            $content = str_replace("'register.php',", "'register.php', 'eligibility.php',", $content);
            $content = str_replace("header('Location: register.php');", "header('Location: login.php');", $content);
            $content = str_replace('header("Location: register.php");', 'header("Location: login.php");', $content);
        } else if (in_array($file, ['reject.php', 'pending.php'])) {
            $content = str_replace("header('Location: register.php');", "header('Location: eligibility.php');", $content);
            $content = str_replace('href="register.php"', 'href="eligibility.php"', $content);
        } else {
            $content = str_replace("location.href='register.php'", "location.href='eligibility.php'", $content);
            $content = str_replace('href="register.php"', 'href="eligibility.php"', $content);
        }
        
        file_put_contents($file, $content);
        echo "Updated $file\n";
    }
}
