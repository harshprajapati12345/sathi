<?php
$f = fopen('MALE.csv', 'r');
$headers = fgetcsv($f);
print_r($headers);
fclose($f);
?>
