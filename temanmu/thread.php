<?php
include 'config.php';

try {
    error_reporting(E_ALL);
    
    session_start();
    
    // Check if the 'topic' GET parameter is set
    if (isset($_GET['topic'])) {
        $selectedTopic = $_GET['topic'];
    } else {
        // Redirect to the topic selection page if no topic is provided
        header("Location: test_page_for_topics.php");
        exit();
    }

    // Fetch threads from the database that match the selected topic
    $stmt = $conn->prepare("SELECT * FROM konten WHERE topik = ? ORDER BY FIELD(status, 'OPEN', 'LOCKED'), dateCreated DESC");
    $stmt->bind_param("s", $selectedTopic);
    $stmt->execute();
    $result = $stmt->get_result();
    
} catch (Exception $e) {
    echo "<script>alert('" . $e->getMessage() . "')</script>";
}

// Fetch the count of likes for the thread
// $likeCountStmt = $conn->prepare("SELECT COUNT(*) as likeCount FROM reply WHERE kontenID = ?");
// $likeCountStmt->bind_param("i", $threadID);
// $likeCountStmt->execute();
// $likeCountResult = $likeCountStmt->get_result();
// $likeCountRow = $likeCountResult->fetch_assoc();
// $likeCount = $likeCountRow['likeCount'];


// Now proceed with the rest of the thread_specific.php code

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Threads - <?php echo htmlspecialchars($selectedTopic); ?></title>
    <!-- Include your CSS and JavaScript files here -->
</head>
<body>
    <!-- Button to Profile Page -->
    <a href="profile.php" class="button">View Profile</a>
    <h1>Forum Threads: <?php echo htmlspecialchars($selectedTopic); ?></h1>
    <!-- Button to create a new thread -->
    <!-- When clicked, JavaScript could show the thread creation form -->
    <button id="create-thread" onclick="document.getElementById('thread-creation-form').style.display='block'">Create Thread</button>

    <!-- List of threads -->
<div id="thread-list">
    <?php
    if ($result->num_rows > 0) {
        // Iterate over each thread and display it
        while ($thread = $result->fetch_assoc()) {
            echo "<div class='thread'>";
            echo "<p>" . nl2br(htmlspecialchars($thread['isi'])) . "</p>";

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
                echo '<input type="hidden" name="topicIdOrName" value="' . $selectedTopic . '">';
                if ($thread['userID'] !== $_SESSION['userID']) {
                    echo '<input type="hidden" name="redirect" value="thread_specific">'; // Redirect back to thread.php
                    echo '<button type="submit" name="like">Like</button>';
                } elseif ($thread['status'] === 'OPEN') {
                    echo "<button class='solved-btn'>Mark as Solved</button>";
                }
            echo '</form>';

            
            echo '<p>Likes: ' . $likeCount . '</p>';
            // echo "<button class='reply-btn'>Reply</button>";
            
            // Add a button to view replies for each thread
            echo "<a href='thread_specific.php?id=" . $thread['kontenID'] . "'>lihat balasan</a>";

            echo "</div>"; // Close the thread div
        }
    } else {
        echo "<p>No threads found for this topic.</p>";
    }
    ?>
</div>


    
    <button onclick="window.location.href='test_page_for_topics.php'">Back</button>
    <!-- Thread creation form (hidden by default) -->
    <div id="thread-creation-form" style="display: none;">
        <form action="create_thread.php" method="POST">
            <input type="hidden" name="topik" value="<?php echo htmlspecialchars($selectedTopic); ?>">
            <textarea name="isi" placeholder="Write your thread content here..." required></textarea>
            <button type="submit" name="submit">Create Thread</button>
        </form>
    </div>

    <script>
        // Add your JavaScript here if needed
    </script>
</body>
</html>
