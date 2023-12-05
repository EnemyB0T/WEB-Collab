<?php
ob_start(); // Start buffering output to prevent headers already sent issues
include 'config.php';
include 'utils.php';

session_start();

if (isset($_SESSION['userID']) && isset($_POST['kontenID'])) {
    $userID = $_SESSION['userID'];
    $kontenID = $_POST['kontenID'];
    $replyID = $_POST['replyID'] ?? null; // replyID from the POST data, can be null
    $username = getUsernameFromUserID($userID, $conn);
    echo $username;

    

    // Check if the user has already liked this content or reply
    $likeCheckStmt = $conn->prepare("SELECT poin FROM likedReply WHERE kontenID = ? AND userID = ? AND (? IS NULL OR replyID = ?)");
    $likeCheckStmt->bind_param("iiii", $kontenID, $userID, $replyID, $replyID);
    $likeCheckStmt->execute();
    $likeResult = $likeCheckStmt->get_result();
    
    if ($like = $likeResult->fetch_assoc()) {
        // Toggle the like if it exists
        $updateStmt = $conn->prepare("UPDATE likedReply SET poin = poin ^ 1 WHERE kontenID = ? AND userID = ? AND (? IS NULL OR replyID = ?)");
        $updateStmt->bind_param("iiii", $kontenID, $userID, $replyID, $replyID);
        $updateStmt->execute();
    } else {
        // Insert a new like if it doesn't exist
        $insertStmt = $conn->prepare("INSERT INTO likedReply (kontenID, replyID, username, userID, poin, dateCreated) VALUES (?, ?, ?, ?, 1, NOW())");
        // If $replyID is null, you need to bind null explicitly
        $replyIDParam = $replyID === null ? null : $replyID;

        // Use a ternary operator to pass the correct variable
        $insertStmt->bind_param("iisi", $kontenID, $replyIDParam, $username, $userID);

        $insertStmt->execute();
    }

    // Check for errors
    if (isset($updateStmt) && $updateStmt->error) {
        echo "Error updating like record: " . $updateStmt->error;
    } elseif (isset($insertStmt) && $insertStmt->error) {
        echo "Error inserting like record: " . $insertStmt->error;
    } else {
        echo "Like action processed successfully";
    }

    // echo '<script>alert("reached this point");</script>';

    // Determine the redirection URL
    $redirectPage = $_POST['redirect'] ?? 'thread'; // Default to 'thread' if not provided
    $redirectUrl = $redirectPage === 'thread_specific' ? 
        "thread_specific.php?id=" . urlencode($kontenID) :
        "thread.php?id=" . urlencode($topicIdOrName); // Ensure $topicIdOrName is defined and holds the topic ID or name

    // Instead of redirecting immediately, present a button to the user
    echo '<p>Click the button to go back.</p>';
    echo '<button onclick="window.location.href=\'' . $redirectUrl . '\'">Go Back</button>';

    // Don't forget to call exit to prevent further code execution if necessary
    exit();
}
ob_end_flush(); // End buffering and output everything
?>
