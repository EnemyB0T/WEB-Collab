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
        

        // Fetch the count of active likes for each thread
        $likeCountStmt = $conn->prepare("SELECT SUM(poin) as likeCount FROM likedReply WHERE kontenID = ? AND replyID IS NULL");
        $likeCountStmt->bind_param("i", $thread['kontenID']);
        $likeCountStmt->execute();
        $likeCountResult = $likeCountStmt->get_result();
        $likeCountRow = $likeCountResult->fetch_assoc();
        $likeCount = $likeCountRow['likeCount'] ?: 0;  // Use the null coalescing operator to default to 0 if null


        // Like Button
        echo '<form action="like_thread.php" method="POST">';
        echo '<input type="hidden" name="kontenID" value="' . $thread['kontenID'] . '">'; // Corrected to use $thread['kontenID']
        echo '<input type="hidden" name="replyID" value="' . $reply['replyID'] . '">'; // send replyID to like
        echo '<input type="hidden" name="topicIdOrName" value="' . $selectedTopic . '">';
        if ($thread['userID'] !== $_SESSION['userID']) {
            echo '<input type="hidden" name="redirect" value="thread">'; // Redirect back to thread.php
            echo '<button type="submit" name="like">Like</button>';
        } elseif ($thread['status'] === 'OPEN') {
            echo "<button class='solved-btn'>Mark as Solved</button>";
        }
        echo '</form>';
        
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
