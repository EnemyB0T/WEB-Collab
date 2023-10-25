<?php 
 
$server = "localhost";
$user = "testAdmin";
$pass = "IDontKnow";
$database = "notetakingapp";
 
$conn = mysqli_connect($server, $user, $pass, $database);
 
if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}
 
?>