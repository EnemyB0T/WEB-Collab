<?php
include 'config.php';

session_start();

$threadID = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch thread details
$stmt = $conn->prepare("SELECT * FROM konten WHERE kontenID = ?");
$stmt->bind_param("i", $threadID);
$stmt->execute();
$result = $stmt->get_result();
$thread = $result->fetch_assoc();

// Fetch replies for the thread (assuming you have a replies table)
$replyStmt = $conn->prepare("SELECT * FROM reply WHERE kontenID = ?"); // Adjust table and column names as needed
$replyStmt->bind_param("i", $threadID);
$replyStmt->execute();
$replies = $replyStmt->get_result();

// Fetch the count of likes for the thread
$likeCountStmt = $conn->prepare("SELECT COUNT(*) as likeCount FROM reply WHERE kontenID = ?");
$likeCountStmt->bind_param("i", $threadID);
$likeCountStmt->execute();
$likeCountResult = $likeCountStmt->get_result();
$likeCountRow = $likeCountResult->fetch_assoc();
$likeCount = $likeCountRow['likeCount'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content -->
</head>
<body>
    <h1><?php echo htmlspecialchars($thread['topik']); ?></h1>
    <p><?php echo htmlspecialchars($thread['isi']); ?></p>
    <p>Created by: <?php echo htmlspecialchars($thread['username']); ?></p>
    <!-- Display like button and number of likes here -->

    <h2>Replies</h2>
    <?php
    while ($reply = $replies->fetch_assoc()) {
        // Display each reply
        echo "<div class='reply'>";
        echo "<p>" . htmlspecialchars($reply['isi']) . "</p>"; // Adjust 'content' to your reply content column name
        echo "<p> By " . htmlspecialchars($reply['username']) . "</p>";
        echo "</div>";

        echo "<div class='thread'>";
        echo "<p>" . nl2br(htmlspecialchars($thread['isi'])) . "</p>";
        // Check if the logged-in user is the thread creator
        $isThreadCreator = ($_SESSION['userID'] ?? null) == $reply['userID'];
            // Like button and like count display
            echo '<form action="like_thread.php" method="POST">';
            echo '<input type="hidden" name="kontenID" value="' . $threadID . '">';
            // Disable the like button if the logged-in user is the thread creator
            $disabledAttribute = $isThreadCreator ? 'disabled' : '';
            echo '<input type="hidden" name="redirect" value="thread_specific">'; // Redirect back to thread_specific.php
            echo '<button type="submit" name="like" ' . $disabledAttribute . '>Like</button>';
            echo '</form>';
            echo '<p>Likes: ' . $likeCount . '</p>';
        
        echo "</div>"; // Close your thread div here

    }
    ?>

    <!-- Reply button -->
    <form action="post_reply.php" method="POST">
        <textarea name="isi" placeholder="Write your reply here..." required></textarea>
        <input type="hidden" name="kontenID" value="<?php echo $threadID; ?>">
        <button type="submit" name="submit-reply">Post Reply</button>
    </form>

    <!-- Back button -->
    <button onclick="location.href='thread.php?topic=<?php echo urlencode($thread['topik']); ?>'">Back</button>

</body>
</html>
