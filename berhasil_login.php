<?php

include 'config.php';

session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: index.php");
}

$userID = $_SESSION['userID'];
$sql = "SELECT username FROM useraccount WHERE userID = $userID";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$username = $row['username'];

// Redirect to note.php after 1 seconds
header("Refresh: 1; url=noteAddis.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Berhasil Login</title>
</head>
<body>
    <div class="container-logout">
        <form action="" method="POST" class="login-email">
            <?php echo "<h1>Selamat Datang, " . $username ."!". "</h1>"; ?>

            <div class="input-group">
            <a href="logout.php" class="btn">Logout</a>
            </div>
        </form>
    </div>
</body>
</html>