<?php 
 
session_start();
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="telahLogout.css">
    <title>Login page in HTML</title>
</head>
<body>
    <h1 class="form-header">Quill</h1>
    <form action="">
        <!-- Headings for the form -->
        <div class="headingsContainer">
            <h3>Logout</h3>
            
        </div>

        <!-- Main container for all inputs -->
        <div class="mainContainer">
            <!-- TelahBerhasil -->
            <p>Logout Succesful</p>
            
        </div>

    </form>

    <?php 
	// Redirect to index.php after 1 seconds
	header("refresh:1;url=homepage.html");
	?>
</body>
</html>
