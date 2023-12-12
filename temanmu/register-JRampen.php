<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
 
error_reporting(0);
 
session_start();
 
if (isset($_SESSION['userID'])) {
    echo $_SESSION['userID'];
    header("Location: berhasil_login.php");
}
 
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $rawPassword = $_POST['password']; // Don't hash it yet
    $date = date("Y-m-d");

    // Use password_hash() to securely hash the password
    $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

    if ($hashedPassword) {
        $checkEmailQuery = "SELECT * FROM user WHERE userEmail=?";
        $checkEmailStmt = mysqli_prepare($conn, $checkEmailQuery);
        mysqli_stmt_bind_param($checkEmailStmt, "s", $email);
        mysqli_stmt_execute($checkEmailStmt);
        $result = mysqli_stmt_get_result($checkEmailStmt);

        if (!$result) {
            die("Error checking email: " . mysqli_error($conn));
        }

        if ($result->num_rows > 0) {
            echo "<script>alert('Woops! Email Sudah Terdaftar.')</script>";
        } else {
            $insertQuery = "INSERT INTO user (userName, userEmail, userPassword, dateCreated)
                            VALUES (?, ?, ?, ?)";

            $insertStmt = mysqli_prepare($conn, $insertQuery);

            if (!$insertStmt) {
                die("Error preparing insert statement: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($insertStmt, "ssss", $username, $email, $hashedPassword, $date);
            mysqli_stmt_execute($insertStmt);

            if (!$insertStmt) {
                die("Error inserting user: " . mysqli_error($conn));
            }

            //nilai database
            $newUserID = $conn->insert_id; // Get the last inserted ID

            $insertPointsQuery = "INSERT INTO nilai (userID, nilaiUser, nilaiKonten, nilaiReply, nilaiLike, totalNilai) VALUES (?, 5, 0, 0, 0, 5)";

            $stmt = $conn->prepare($insertPointsQuery);
            $stmt->bind_param("i", $newUserID);
            $stmt->execute();

            if ($stmt->error) {
                echo "Error creating life points record: " . $stmt->error;
            }
            echo "<script>alert('Selamat, registrasi berhasil!')</script>";
            $username = "";
            $email = "";
            $rawPassword = ""; // Clear the raw password
            header("Location: login.php");
        }
    } else {
        echo "<script>alert('Masukkan Password')</script>";
    }
}


 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register_page.css">
    <title>Register page in HTML</title>
</head>
<body>
<h1 class="form-header">Temanmu</h1>
    <form action="" method="POST" class="login-email">
        <!-- Headings for the form -->
        <div class="headingsContainer">
            <h3>Register</h3>
            <p>Please fill the form to register</p>
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
            <!-- <div class="code-confirm">
                <label for="code">Your&nbspcode:</label> 
                <input type="Code" placeholder="Enter code" name="Code confirm">
                <button class="sbutton">Send Code</button>
            </div>
            <br><br> -->

            <!-- Name -->
            <label for="full name">Your username</label>
            <input type="text" placeholder="Enter full name" name="username" value="<?php echo $username; ?>" required>

            <!-- checklist -->
            <!-- <div class="subcontainer">
                <label>
                  <p><input type="checkbox" check="checked" name="syarat & ketentuan"> Agree with our <a href="#">Terms and Condition</a> </p>
                </label>
                  <p><input type="checkbox" check="checked" name="syarat & ketentuan"> Updates and promotion will be sent via email </p>
            </div> -->

            <div class="submit-button">
            <!-- Submit button -->
                <button  name="submit">Register</button>

            </div>
            <!-- Sign up link -->
            <p class="lupapass"><p align="center"> Already got a member?</p>  <a href="login.php"><p align="center">Log in here!</p></a></p>

        </div>

    </form>
</body>
</html>