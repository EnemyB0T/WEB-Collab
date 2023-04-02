<?php
session_start();
include('config.php');

if(isset($_SESSION['userID'])) {
  // If the user is logged in, show the note form
  echo '<h1>Add Note</h1>';

  if(isset($_POST['submit'])) {
    // If the form is submitted, insert the note into the database
    $title = $_POST['title'];
    $content = $_POST['content'];
    $userID = $_SESSION['userID'];
    $createdAt = date('Y-m-d H:i:s');

    $sql = "INSERT INTO note (title, content, userID, createdAt) VALUES ('$title', '$content', '$userID', '$createdAt')";
    $result = mysqli_query($conn, $sql);

    if($result) {
      echo '<p>Note added successfully!</p>';
    } else {
      echo '<p>Error adding note: ' . mysqli_error($conn) . '</p>';
    }
  }

  echo '<form method="post">';
  echo '<label>Title:</label>';
  echo '<input type="text" name="title"><br>';
  echo '<label>Content:</label>';
  echo '<textarea name="content"></textarea><br>';
  echo '<input type="submit" name="submit" value="Add Note">';
  echo '</form>';

  
  // retrieve the note from the database
$sql = "SELECT * FROM note WHERE userID='$userID'";
$result = mysqli_query($conn, $sql);
$notes = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $notes[] = $row;
    }
} else {
    $notes = null;
}



} else {
  // If the user is not logged in, redirect them to the login page
  echo 'User is not logged in';
  sleep(10);
  header('Location: index.php');
  exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Create New Note</title>
</head>
<body>
	<!-- A button that logs out the user -->
	<button onclick="logout()">Logout</button>

	<!-- A script that redirects the user to the logout page when the button is clicked -->
	<script>
		function logout() {
			window.location.href = "logout.php";
		}
	</script>
</body>
</html>