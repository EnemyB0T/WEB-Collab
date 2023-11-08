<?php 

$server = "db";
$user = "root";
$pass = "mypass";
$database = "temanmu";
 
$conn = mysqli_connect($server, $user, $pass, $database);
 
if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}
 
?>