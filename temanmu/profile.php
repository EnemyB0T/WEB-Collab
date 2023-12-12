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
    <!-- <?php echo $userRank ?> -->
    <h1>User Profile</h1>
    <p>Username: <?php echo htmlspecialchars($data['userName']); ?></p>
    <p>Total Points: <?php echo htmlspecialchars($userData['totalNilai']); ?></p>
    <p>Rank: <?php echo htmlspecialchars($userRank); ?></p>
    <!-- Add more user details here -->
    <button onclick="history.back()">Back</button>
</body>
</html>
