<?php
session_start();
include('config.php');

if(isset($_SESSION['userID'])) {
  // If the user is logged in, show the note form
  echo '<h1>Add Note</h1>';

  if(isset($_POST['submit'])) {
    echo '<p>received data</p>';
    // If the form is submitted, insert the note into the database
    $title = $_POST['title'];
    echo '<p>got title</p>';
    $content = $_POST['content'];
    echo '<p>got content</p>';
    $userID = $_SESSION['userID'];
    echo '<p>got userID</p>';
    $createdAt = date('Y-m-d H:i:s');
    echo '<p>got created At</p>';

    $sql = "INSERT INTO note (title, content, userID, createdAt) VALUES ('$title', '$content', '$userID', '$createdAt')";
    $result = mysqli_query($conn, $sql);
    echo $result;

    if($result) {
      echo '<p>Note added successfully!</p>';
      header('Location: noteAddis.php');
        exit();
    } else {
      echo '<p>Error adding note: ' . mysqli_error($conn) . '</p>';
    }

  }

} else {
    // If the user is not logged in, redirect them to the login page
    echo 'User is not logged in';
    sleep(2);
    header('Location: loginCode.php');
    exit();
  }
?>