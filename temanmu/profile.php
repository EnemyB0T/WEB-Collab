<?php
include 'config.php';
include 'utils.php';

session_start();

// Ensure the user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];
adjustUserPoints($userID, $conn);
$userData = getUserData($userID, $conn); // Implement getUserData to fetch user data from the database
// echo $userData;
$userRank = getUserRank($userID, $conn);


$sql = $conn->prepare("SELECT userName FROM user WHERE userID = ?");
$sql->bind_param("i", $_SESSION['userID']);
$sql->execute();
$result = $sql->get_result();
$data = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content here -->
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

    <!-- <?php echo $userRank ?> -->
    <h1>User Profile</h1>
    <p>Username: <?php echo htmlspecialchars($data['userName']); ?></p>
    <p>Total Points: <?php echo htmlspecialchars($userData['totalNilai']); ?></p>
    <p>Rank: <?php echo htmlspecialchars($userRank); ?></p>
    <!-- Add more user details here -->
    <button onclick="history.back()">Back</button>
</body>
</html>
