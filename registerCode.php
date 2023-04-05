<?php 

include 'config.php';
 
error_reporting(0);
 
session_start();
 
if (isset($_SESSION['userID'])) {
    header("Location: loginCode.php");
}
 
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
 
    if ($password) {
        $sql = "SELECT * FROM useraccount WHERE emailAddress='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO useraccount (username, emailAddress, password)
                    VALUES ('$username', '$email', '$password')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Selamat, registrasi berhasil!')</script>";
                $username = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            } else {
                echo "<script>alert('Woops! Terjadi kesalahan.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Sudah Terdaftar.')</script>";
        }
         
    } else {
        echo "<script>alert('Password Tidak Sesuai')</script>";
    }
}
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Register Page.css">
    <title>Register page in HTML</title>
</head>
<body>
    <h1>Quill</h1>
    <form action="" method="POST" class="login-email">
        <!-- Headings for the form -->
        <div class="headingsContainer">
            <h3>Register</h3>
            <p>Silakan mengisi pada kolom dibawah ini!</p>
        </div>

        <!-- Main container for all inputs -->
        <div class="mainContainer">
            <!-- Username -->
            <label for="email">Your email:</label>
            <input type="text" placeholder="Enter email" name="email" value="<?php echo $emailAddress; ?>"  required>

            <br><br>

            <!-- Password -->
            <label for="password">Your password:</label>
            <input type="password" placeholder="Enter password" name="password" value="<?php echo $password; ?>" required>

            <br><br>

            <!-- Code confirm -->
            <label for="code">Your code:</label> 
            <input type="Code" placeholder="Enter code" name="Code confirm">

            <br><br>

            <!-- Name -->
            <label for="full name">Your full name:</label>
            <input type="text" placeholder="Enter full name" name="username" value="<?php echo $username; ?>" required>

            <!-- checklist -->
            <div class="subcontainer">
                <label>
                  <p><input type="checkbox" check="checked" name="syarat & ketentuan"> Setuju dengan syarat dan ketentuan berlaku </p>
                </label>
                  <p><input type="checkbox" check="checked" name="syarat & ketentuan"> Update dan promosi Quill akan di kirimkan lewat email </p>
            </div>

            <!-- Submit button -->
            <button  name="submit">Register</button>
            <!-- Back button -->
            <button type="back">Back</button>
            <!-- Sign up link -->
            <p class="lupapass"><p align="center"> Already got a member?</p>  <a href="loginCode.php"><p align="center">Log in here!</p></a></p>

        </div>

    </form>
</body>
</html>