<?php 
 
session_start();
session_destroy();
 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Logged Out</title>
</head>
<body>
	<h1>You have been logged out</h1>
	<p>Thank you for using our application. You are now logged out.</p>

    <?php 
	// Redirect to index.php after 1 seconds
	header("refresh:1;url=loginCode.php");
	?>
</body>
</html>