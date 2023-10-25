<?php 
 
include 'config.php';
 
error_reporting(0);
 
session_start();
 
if (!isset($_SESSION['userID'])) {
    header("Location: loginCode.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homepageLogged.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
</head>
<body>
    
    <header>
        <h2 class="logo"><a href="homepageLogged.php">Quill</a></h2>
        <nav class="navbar">
            <button class="btnNotes"><a href="noteAddis.php">Notes</a></button>
        </nav>
        <img class="userpic" src="profile-images/userpic.png" onclick="toggleMenu()">

        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <div class="user-info">
                    <img src="profile-images/userpic.png">
                    <h2>Username</h2>
                </div>
                <hr>

                <a href="editprofile.html" class="sub-menu-link">
                    <img src="profile-images/profile.png">
                    <h3>Edit Profile</h3>
                    <span>></span>
                </a>
                <a href="#" class="sub-menu-link">
                    <img src="profile-images/setting.png">
                    <h3>Settings & Privacy</h3>
                    <span>></span>
                </a>
                <a href="#" class="sub-menu-link">
                    <img src="profile-images/help.png">
                    <h3>Help & Support</h3>
                    <span>></span>
                </a>
                <a href="#" class="sub-menu-link">
                    <img src="profile-images/logout.png">
                    <h3>Logout</h3>
                    <span>></span>
                </a>
            </div>
        </div>
    </header>

    <img class="bg1" src="background/BG1.png" /> 
    <img class="bg2" src="background/BG2.png" />
    <img class="bg3" src="background/BG3.png" />
    

    <div>
        <h1>Quill is a note-taking and organization tool.</h1>
        <p>Category Sorting</p>
        <b>Notes will be able to be organized in an icon-style folder system with sorting according to time, alphabetical, and size</b>
    </div>
    <div>
        <p class="p1">Drag'n Drop</p>
        <b class="b1">Using a drag and drop interface, we make note-taking convenient to organize.</b>
    </div>
    <div>
        <p class="p2">Unique UI</p>
        <b class="b2">We hope to inspire users with our specialized and stylized designs.</b>
    </div>


    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu(){
            subMenu.classList.toggle("open-menu");
        }
    </script>
</body>

<footer>
    <div class="footer-container">
        <div class="socialIcons">
            <a href=""><i class="fa-brands fa-facebook"></i></a>
            <a href=""><i class="fa-brands fa-instagram"></i></a>
            <a href=""><i class="fa-brands fa-twitter"></i></a>
            <a href=""><i class="fa-brands fa-discord"></i></a>
        </div>
        <div class="footer-nav">
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">About Us</a></li>
                <li><a href="">Terms</a></li>
                <li><a href="">FAQ</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <a>Quill &copy;2023</a>
    </div>
</footer>
</html>