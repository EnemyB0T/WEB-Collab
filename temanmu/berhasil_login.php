<?php
// Start session
session_start();

// Check if the user is logged in
if (isset($_SESSION['userID'])) {
    $loggedIn = true;
    $userEmail = $_SESSION['userEmail'];
} else {
    $loggedIn = false;
}

// Logout logic
if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the login page
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Login Example</title>
</head>
<body>

<?php if ($loggedIn): ?>
    <p>Welcome, <?php echo $userEmail; ?>!</p>
    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>
<?php else: ?>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" name="login">Login</button>
    </form>
<?php endif; ?>

</body>
</html>
