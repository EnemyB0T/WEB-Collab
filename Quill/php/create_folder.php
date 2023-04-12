<?php
require_once 'config.php';

if(isset($_POST['name'])){
    $name = $_POST['name'];
    $sql = "INSERT INTO folders (name) VALUES ('$name')";
    $result = $mysqli->query($sql);

    if($result){
        echo "Folder created successfully.";
    }else{
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}
?>
