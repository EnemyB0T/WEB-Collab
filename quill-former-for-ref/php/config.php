<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'quillapp';
$dbName = 'quill_db';
define('DB_CHARSET', 'utf8');

// Connect with the database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection status
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
