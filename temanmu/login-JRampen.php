<?php
include 'config.php';
try{
    ob_start();
    session_start();

    error_reporting(E_ALL);
    
    if (isset($_SESSION['userID'])) {
        // echo "<script>alert('test')</script>";
        header("Location: test_page_for_topics.php");
    }
    
    if (isset($_POST['submit'])) {
        $enteredEmail = $_POST['email'];
        $enteredPassword = $_POST['password'];

        $checkEmailQuery = "SELECT * FROM user WHERE userEmail=?";
        $checkEmailStmt = mysqli_prepare($conn, $checkEmailQuery);
        mysqli_stmt_bind_param($checkEmailStmt, "s", $enteredEmail);
        mysqli_stmt_execute($checkEmailStmt);
        $result = mysqli_stmt_get_result($checkEmailStmt);

        if (!$result) {
            die("Error checking email: " . mysqli_error($conn));
        }

        if ($result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            $hashedPasswordFromDatabase = $userData['userPassword'];

            // Use password_verify to check if entered password matches hashed password
            if (password_verify($enteredPassword, $hashedPasswordFromDatabase)) {
                // Store user data in session
                $_SESSION['userID'] = $userData['userID'];
                $_SESSION['userEmail'] = $userData['userEmail'];
                // echo "<script>alert('" . $_SESSION['userID'] . "');</script>";

                
                // echo "<script>alert('reached session point')</script>";
                // Redirect to the home page
                header("Location: test_page_for_topics.php");
                
                
            } else {
                echo "<script>alert('Incorrect password.')</script>";
            }
        } else {
            echo "<script>alert('User not found.')</script>";
        }
    }
    ob_flush();
}catch (Exception $e) {
    // Handle the exception, for example:
    echo "<script>alert('" . $e->getMessage() . "')</script>";
    // Optionally, exit the script or redirect to an error page
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_page.css">
    <!-- <link rel="stylesheet" href="homepage.css"> -->
    <title>Login page in HTML</title>
</head>
<body>
    <h1 class="form-header"><a href="homepage.html">Temanmu</a></h1>
    <form action="login.php" method="POST" class="login-email">
        <!-- Headings for the form -->
        <div class="headingsContainer">
            <h3>Login</h3>
            <p>Please fill the form below</p>
        </div>

        <!-- Main container for all inputs -->
        <div class="mainContainer">
            <!-- Email -->
            <label for="email">Your email:</label>
            <input type="text" placeholder="Enter email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>


            <br><br>

            <!-- Password -->
            <label for="password">Your password:</label>
            <input type="password" placeholder="Enter password" name="password" value="<?php echo $_POST['password']; ?>" required>

            

            <div class="submit-button">
                <!-- Submit button -->
                <button type="submit" class="btn" name="submit">Login</button>
            </div>
            <!-- Sign up link -->
            <p class="lupapass"><a href="#"><p align="center">Forgot password?</p></a></p>
            <p class="keregister"><a href="register.php"><p align="center">Don't have an account? Signup!</p></a></p>
        </div>

    </form>
</body>
</html>
