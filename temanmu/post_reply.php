<?php
include 'config.php';
include 'utils.php';

session_start();

// Check if we have the userID in the session
if (!isset($_SESSION['userID'])) {
    die('You must be logged in to post a reply.');
}

$userID = $_SESSION['userID'];
$username = getUsernameFromUserID($userID, $conn); // Fetch the username

if ($username === null) {
    die('Username cannot be found.');
}

if (isset($_POST['submit-reply'])) {
    $isi = $_POST['isi'];
    $kontenID = $_POST['kontenID'];
    

    // Fetch the username from the database based on userID
    $username = getUsernameFromUserID($userID, $conn);

    // Insert the reply into the database
    $stmt = $conn->prepare("INSERT INTO reply (isi, username, userID, kontenID, dateCreated) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssii", $isi, $username, $userID, $kontenID);
    $stmt->execute();

    if ($stmt->error) {
        // Handle error here
        echo "Error: " . $stmt->error;
    } else {
        // Redirect back to the thread_specific.php or display a success message
        header("Location: thread_specific.php?id=" . urlencode($kontenID));
        exit();
    }
}

?>
