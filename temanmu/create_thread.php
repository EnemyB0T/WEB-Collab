<?php
include 'config.php';
include 'utils.php'; // Ensure this contains createThreadOrReply

session_start();

if (isset($_POST['submit'])) {
    $isi = $_POST['isi'];
    $topik = $_POST['topik'];
    $userID = $_SESSION['userID']; // Assuming the user ID is stored in the session
    $username = getUsernameFromUserID($userID, $conn); // Function to get the username based on userID

    // Using createThreadOrReply for point deduction
    $threadCreationResult = createThreadOrReply($userID, true, $conn);

    if ($threadCreationResult == "Thread created successfully, points deducted.") {
        // Proceed to insert the thread into the database
        $stmt = $conn->prepare("INSERT INTO konten (isi, topik, username, userID, dateCreated) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssi", $isi, $topik, $username, $userID);
        $stmt->execute();

        if ($stmt->error) {
            // Handle error here
            echo "Error: " . $stmt->error;
        } else {
            // Redirect back to thread.php or display a success message
            header("Location: thread.php?topic=" . urlencode($topik));
            exit();
        }
    } else {
        // Handle the case where thread creation is not successful
        echo $threadCreationResult;
    }
}
?>
