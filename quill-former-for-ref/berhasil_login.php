<?php

include 'config.php';

session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: loginCode.php");
}

$userID = $_SESSION['userID'];
$sql = "SELECT username FROM useraccount WHERE userID = $userID";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$username = $row['username'];

// Redirect to note.php after 1 seconds
header("Refresh: 1; url=homepageLogged.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="berhasilLogin.css">
    <title>Login page in HTML</title>
</head>
<body>
    <h1 class="form-header">Quill</h1>
    <form action="">
        <!-- Headings for the form -->
        <div class="headingsContainer">
            <h3>Login</h3>
            
        </div>

        <!-- Main container for all inputs -->
        <form action="" method="POST" class="login-email">
            <?php echo "<h1>Welcome, " . $username ."!". "</h1>"; ?>

            <div class="input-group">
            <a href="logout.php" class="btn">Logout</a>
            </div>
        </form>

    </form>
</body>
</html>
