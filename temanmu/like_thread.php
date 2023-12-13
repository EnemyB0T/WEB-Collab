<?php
ob_start(); // Start buffering output to prevent headers already sent issues
include 'config.php';
include 'utils.php';

session_start();

if (isset($_SESSION['userID']) && isset($_POST['kontenID'])) {
    $userID = $_SESSION['userID'];
    $kontenID = $_POST['kontenID'];
    $replyID = $_POST['replyID'] ?? null; // replyID from the POST data, can be null

    // echo '<script>alert("' . $replyID . '")</script>';

    $username = getUsernameFromUserID($userID, $conn);
    // echo $username;

    // Debugging: Check if kontenID exists in the konten table
$checkKontenIDStmt = $conn->prepare("SELECT kontenID FROM konten WHERE kontenID = ?");
$checkKontenIDStmt->bind_param("i", $kontenID);
$checkKontenIDStmt->execute();
$checkKontenIDResult = $checkKontenIDStmt->get_result();

if($checkKontenIDResult->num_rows == 0) {
    exit('Error: kontenID does not exist in the konten table.');
}

    

    // Check if the user has already liked this content or reply
    $likeCheckStmt = $conn->prepare("SELECT poin FROM likedReply WHERE kontenID = ? AND userID = ? AND (? IS NULL OR replyID = ?)");
    $likeCheckStmt->bind_param("iiii", $kontenID, $userID, $replyID, $replyID);
    $likeCheckStmt->execute();
    $likeResult = $likeCheckStmt->get_result();
    
    if ($like = $likeResult->fetch_assoc()) {
        // Toggle the like if it exists (like/un-like)
        $newPoinValue = ($like['poin'] == 1) ? 0 : 1;
        echo '<p> new poin value = ' . $newPoinValue . '</p>';
        // $updateStmt = $conn->prepare("UPDATE likedReply SET poin = ? WHERE kontenID = ? AND userID = ? AND (? IS NULL OR replyID = ?)");
        // $updateStmt->bind_param("iiiii", $newPoinValue, $kontenID, $userID, $replyID, $replyID);
        // $updateStmt->execute();
        // // Check if there was an error in the execution
        // if ($updateStmt->error) {
        //     echo '<p>Error in update statement: ' . $updateStmt->error . '</p>';
        // } else {
        //     echo '<p>Update executed successfully.</p>';
        //     }
    
        // Determine the like action: true for liking, false for un-liking
        $isLikingAction = ($newPoinValue == 1);
        echo '<p> is liking action = ' . $isLikingAction . '</p>';

        // Adjust user points for like/un-like
        handleLikeAction($userID, $isLikingAction, $kontenID, $replyID, $conn);
    } else {
        // Insert a new like if it doesn't exist
        // $insertStmt = $conn->prepare("INSERT INTO likedReply (kontenID, replyID, userID, username, poin, dateCreated) VALUES (?, ?, ?, ?, 1, NOW())");

        // $replyIDParam = $replyID === null ? null : $replyID;
        // // Check if $replyID is null and bind parameters accordingly
        
        // $insertStmt->bind_param("iiis", $kontenID, $replyIDParam, $userID, $username);


        // $insertStmt->execute();
    
        // Deduct 1 point from the user for liking, if they have enough points
        $likeActionResult = handleLikeAction($userID, true, $kontenID, $replyID, $conn);
        if ($likeActionResult !== "Action processed successfully.") {
            echo $likeActionResult; // Display the error message
        } else {
            // Add 1 point to the thread/reply creator
            $creatorUserID = getCreatorUserID($kontenID, $replyID, $conn); // Function to get the creator's userID
            if ($creatorUserID && $creatorUserID != $userID) { // Ensure the creator is not the same as the liker
                adjustUserPoints($creatorUserID, $conn);
            }
        }
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

    $topicIdOrName = $_POST['topicIdOrName'] ?? 'DefaultTopicName'; // Use a default value for debugging

    // Debugging: Display the retrieved topic name
    echo '<p>Topic Name: ' . htmlspecialchars($topicIdOrName) . '</p>';

    // Determine the redirection URL
    $redirectPage = $_POST['redirect'] ?? 'thread'; // Default to 'thread' if not provided

    echo '<p>Redirect to specific thread ' . htmlspecialchars($redirectPage) . '</p>';

    // Debugging: Display the retrieved redirecting page
    echo '<p>Redirect Page: ' . htmlspecialchars($redirectPage) . '</p>';

    $redirectUrl = $redirectPage === 'thread_specific' ? 
        "thread_specific.php?id=" . urlencode($kontenID) :
        "thread.php?topic=" . urlencode($topicIdOrName); // Ensure $topicIdOrName is defined and holds the topic ID or name


    // Debugging: Display redirect URL
    // echo '<p>Redirect Page: ' . htmlspecialchars($redirectUrl) . '</p>';

    // Automatic redirect. Comment to debug
    header("Location: " . $redirectUrl);

    // Instead of redirecting immediately, present a button to the user. Comment if automatic redirect is activated
    // echo '<p>Click the button to go back.</p>';
    // echo '<button onclick="window.location.href=\'' . $redirectUrl . '\'">Go Back</button>';

    // Don't forget to call exit to prevent further code execution if necessary
    exit();
}
ob_end_flush(); // End buffering and output everything
?>
