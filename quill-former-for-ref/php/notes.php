<?php
require_once 'config.php';

if(isset($_POST['sortBy'])){
    $sortBy = $_POST['sortBy'];
    $notes = getNotes($sortBy);
    echo $notes;
}
