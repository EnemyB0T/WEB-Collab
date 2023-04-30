<?php

include('../config.php');
 
error_reporting(0);
 
session_start();
 
if (!isset($_SESSION['userID'])) {
    header("Location: ../loginCode.php");
}

	// requires php5
	define('UPLOAD_DIR', 'images/');
  var_dump($_POST);
  $img = $_POST['dataURL'];
  var_dump($img);
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);
  $fileName = uniqid() . '.png';
  $file = UPLOAD_DIR . $fileName;

  if(!is_dir(UPLOAD_DIR)) {
      if (!mkdir(UPLOAD_DIR, 0777, true)) {
          die('Unable to create directory');
      }
  }

  if(!file_exists($file)){
      if (!touch($file)) {
          die('Unable to create file');
      }
  }

  $success = file_put_contents($file, $data);
  if($success === false) {
      die('Unable to save the file');
  }

  print $file;

  $userID = $_SESSION['userID'];
  $sql = "INSERT INTO drawings (image_data, userID) VALUES ('$data', '$userID')";
  $result = mysqli_query($conn, $sql);
  echo $result;
  if($result) {
    echo '<p>Drawing added successfully!</p>';
    //sleep(2);
    // header('Location: index-2.php');
      // exit();
  } else {
    echo '<p>Error adding note: ' . mysqli_error($conn) . '</p>';
  }


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Image and Variables</title>
  </head>
  <body>
    <?php
      // Display the saved image
      $filePath = $file;
      echo "<img src='$filePath' alt='Saved Image'>";

      // Display the contents of the variables
      echo "<p>img: $img</p>";
      echo "<p>data: $data</p>";
      echo "<p>fileName: $fileName</p>";
      echo "<p>file: $file</p>";
      echo "<p>success: $success</p>";
      echo "<p>userID: $userID</p>";
      echo "<p>sql: $sql</p>";
      echo "<p>result: $result</p>";
    ?>
    <p>Received data from draw.js:</p>
<ul>
  <li>imgBase64: <?php echo $_POST['imgBase64']; ?></li>
</ul>


    <button onclick="window.history.back()">Go Back</button>

  </body>
</html>







