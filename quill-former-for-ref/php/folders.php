<?php
require_once 'config.php';

$folders = getFolders();
echo json_encode($folders);
?>
