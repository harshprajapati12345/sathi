<?php
require 'c:\xampp\htdocs\sathi\config\database.php';
$db = sathi_db();
$res = $db->query("SELECT first_name, candidate_current_address, birth_place, native FROM candidates WHERE first_name IN ('Smita', 'Kalp')");
while($r = $res->fetch_assoc()) {
    print_r($r);
}
