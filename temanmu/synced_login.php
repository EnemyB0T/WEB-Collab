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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temanmu</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
</head>
<body>
<nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
          <i class="fa fa-bars"></i>
        </label>
        <label class="logo"><a href="homepage.html">Temanmu.com </a></label>
        <ul>
          <li><a href="homepage.html">Beranda</a></li>
          <li><a href="topik.html">Topik</a></li>
          <li><a href="chat.html">Curhatanmu</a></li>
          <li><a href="faq.html">Tentang kami</a></li>
          <li><a href="testimoni.html">Testimoni</a></li>
          <li><img class="userIcon" src="images/Group.png" alt="User" onclick="toggleMenu()">
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <h2>Guest</h2>
                    </div>
                    <hr>
                    <a href="synced_login.php" class="sub-menu-link">
                        <h3>Login</h3>
                        <span>></span>
                    </a>
                    <a href="register.html" class="sub-menu-link">
                        <h3>Register</h3>
                        <span>></span>
                    </a>
                </div>
            </div>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="slide">
          <div>
            <section class="section section1">
              <h1>Mulai ceritamu</h1>
              <p>dengan Temanmu, pendengarmu</p>
            </section>
          </div>
          <div>
            <section class="section section2">
                <h3>Masuk untuk mulai ceritamu</h3>
                <p>Belum punya akun? <a href="register.html">Daftar</a></p>
                <p>&nbsp;</p>
                <form action="synced_login.php" method="POST" class="login-email">
                  <h3>Email</h3>
                  <input type="text" placeholder="Enter email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>
                  <h3>Password</h3>
                  <input type="password" placeholder="Enter password" name="password" value="<?php echo $_POST['password']; ?>" required><br><br>
                  <div class="extra">
                    <p>Sambungkan akun ke <a href="#">Spotify</a></p>
                  </div>
                  <div class ="submit"><input class="btn" type="submit" value="Submit"></div>
                </form>
            </section>
          </div>
        </div>

        <footer>
            <div class="leftContent">
                <section class="sectionFooterLogo">
                    <h2><a href="homepage.html">Temanmu.com </a></h2>
                    <p>Temanmu, pendengarmu</p>
                    <p>&nbsp;</p>
                    <p>
                        <a href="#"><img class="footerIcon" src="images/Facebook.png" alt="Facebook"></a>
                        <a href="#"><img class="footerIcon" src="images/Twitter.png" alt="Twitter"></a>
                        <a href="#"><img class="footerIcon" src="images/Instagram.png" alt="Instagram"></a>
                    </p>
                </section>
            </div>
            <div class="centerContent">
                <h3>Sitemap</h3>
                <ul>
                  <li><a href="homepage.html">Beranda</a></li>
                  <li><a href="topik.html">Topik</a></li>
                  <li><a href="chat.html">Curhatanmu</a></li>
                  <li><a href="faq.html">Tentang</a></li>
                  <li><a href="testimoni.html">Testimoni</a></li>
                </ul>
            </div>
        </footer>
    </div>
  <script>
    let subMenu = document.getElementById("subMenu");

    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }
  </script>

</body>

</html>