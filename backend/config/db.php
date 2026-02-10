<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "crm_ticket";
$port = 3306;   // IMPORTANT

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("DB Connection Failed: " . mysqli_connect_error());
}
