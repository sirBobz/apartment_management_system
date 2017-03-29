<?php

define('CURRENCY', '$');
define('WEB_URL', 'http://localhost/ams/');
define('ROOT_PATH', '/var/www/html/ams/');

$servername = "127.0.0.1";
$username = "root";
$password = "ub435!";
$dbname = "ams_Db";
   // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>