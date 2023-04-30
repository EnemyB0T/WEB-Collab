<?php
    // include the config file
    include('config.php');

    session_start();

    if (!isset($_SESSION['userID'])) {
        header("Location: ../loginCode.php");
    }
    $userID = $_SESSION['userID'];
    $noteID = $_GET['noteID'];
    $sql = "SELECT title, content FROM note WHERE noteID=$noteID AND userID=$userID";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $content = $row['content'];
    } else {
        echo '<p>You do not have permission to retrieve this note.</p>';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = array();
        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        } else {
            $title = $_POST['title'];
        }
        if (empty($_POST['content'])) {
            $errors[] = 'Content is required';
        } else {
            $content = $_POST['content'];
        }
        if (count($errors) == 0) {
            $sql = "UPDATE note SET title='$title', content='$content' WHERE noteID=$noteID";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // redirect to notes page
                header('Location: noteAddis.php');
                exit();
            } else {
                echo 'Error updating note: ' . mysqli_error($conn);
            }
        } else {
            // there are errors, display them to the user
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
        }
    }

?>

<form method="post">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="<?php echo $title; ?>">
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" id="content" class="form-control"><?php echo $content; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update Note</button>
</form>