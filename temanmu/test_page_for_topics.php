<?php
include 'config.php'; // Includes your database connection
include 'utils.php';

session_start();

if(!isset($_SESSION['userID']))
{
    header('Location: login.php');
}
try {
    
    // Fetch the topics from the database
    $query = "SELECT DISTINCT topik FROM konten ORDER BY topik ASC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
} catch (Exception $e) {
    // Handle any exceptions
    echo "<script>alert('" . $e->getMessage() . "')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Topic</title>
</head>
<body>
    <h1>Welcome <?php echo htmlspecialchars(getUsernameFromUserID($_SESSION['userID'], $conn));; ?>!</h1>   
    <h2>Select a Topic</h2>
    <form action="thread.php" method="GET">
        <label for="topic-select">Choose a topic:</label>
        <select name="topic" id="topic-select">
            <?php
            if ($result->num_rows > 0) {
                // Output each row as a dropdown option
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['topik']) . '">' . htmlspecialchars($row['topik']) . '</option>';
                }
            } else {
                echo '<option value="">No topics available</option>';
            }
            ?>
        </select>
        <input type="submit" value="Go">
    </form>
    <button onclick="window.location.href='logout.php'">Logout</button>
</body>
</html>
