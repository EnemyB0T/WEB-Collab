<?php
session_start();
include('config.php');

/*
if(isset($_GET['id'])) {
    $noteID = $_GET['id'];
    echo "Note ID: $noteID";
}
else
{
    echo "Note ID not found";
}

*/

if (isset($_SESSION['userID']) && isset($_GET['noteID'])) {
    $userID = $_SESSION['userID'];
    $noteID = $_GET['noteID'];

    // check if the note belongs to the user
    $sql = "SELECT * FROM note WHERE noteID=$noteID AND userID=$userID";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // delete the note
        $sql = "DELETE FROM note WHERE noteID=$noteID";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<p>Note deleted successfully!</p>';
            header('Location: noteAddis.php');
        } else {
            echo '<p>Error deleting note: ' . mysqli_error($conn) . '</p>';
        }
    } else {
        echo '<p>You do not have permission to delete this note.</p>';
    }
    
} else {
    echo '<p>Invalid request.</p>';
}

mysqli_close($conn);
?>