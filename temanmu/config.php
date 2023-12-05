<?php 

$server = "db";
$user = "root";
$pass = "mypass";
$database = "temanmu";
 
$conn = mysqli_connect($server, $user, $pass, $database);
 
if (!$conn) {
    throw new Exception("Failed to connect to database: " . mysqli_connect_error());
}

// The echo statement is removed to prevent output before session_start() in the main script

?>