<?php 
 
include 'config.php';
 
error_reporting(0);
 
session_start();
 
if (isset($_SESSION['userID'])) {
    header("Location: berhasil_login.php");
}
 
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
 
    $sql = "SELECT * FROM useraccount WHERE emailAddress='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['userID'] = $row['userID'];
        header("Location: berhasil_login.php");
    } else {
        echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
    }
}
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Login Page.css">
    <title>Login page in HTML</title>
</head>
<body>
    <h1>Quill</h1>
    <form action="" method="POST" class="login-email">
        <!-- Headings for the form -->
        <div class="headingsContainer">
            <h3>Login</h3>
            <p>Silakan mengisi pada kolom dibawah ini!</p>
        </div>

        <!-- Main container for all inputs -->
        <div class="mainContainer">
            <!-- Email -->
            <label for="email">Your email:</label>
            <input type="text" placeholder="Enter email" name="email" value="<?php echo $email; ?>" required>

            <br><br>

            <!-- Password -->
            <label for="password">Your password:</label>
            <input type="password" placeholder="Enter password" name="password" value="<?php echo $_POST['password']; ?>" required>

            <!-- checklist -->
            <div class="subcontainer">
                <label>
                  <p><input type="checkbox" check="checked" name="syarat & ketentuan"> Tetap online selama 4 jam </p>
                </label>
                  <p><input type="checkbox" check="checked" name="syarat & ketentuan"> Anonymous mode </p>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn" name="submit">Login</button>
            <!-- Back button -->
            <button type="back">Back</button>
            <!-- Sign up link -->
            <p class="lupapass"><p align="center"> Forgot Password?</p>  <a href="#"><p align="center">click here!</p></a></p>

        </div>

    </form>
</body>
</html>
