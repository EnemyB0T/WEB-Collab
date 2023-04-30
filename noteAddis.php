<?php
session_start();
include('config.php');

if(isset($_SESSION['userID'])) {
  // If the user is logged in, show the note form
  // retrieve the note from the database
    $userID = $_SESSION['userID'];
    $sql = "SELECT * FROM note WHERE userID=$userID";
    $result = mysqli_query($conn, $sql);
    $notes = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $notes[] = $row;
        }
    } else { 
        $notes = null;
    }
} else {
  // If the user is not logged in, redirect them to the login page
  echo 'User is not logged in';
  sleep(2);
  header('Location: loginCode.php');
  exit();
}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <title>Notes</title>
    <link rel="stylesheet" href="noteAddis.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

<header>
        <h2 class="logo"><a href="homepageLogged.php">Quill</a></h2>
        <nav class="navbar">
            <button class="btnNotes"><a href="noteAddis.php">Notes</a></button>
        </nav>
        <img class="userpic" src="profile-images/userpic.png" onclick="toggleMenu()">

        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <div class="user-info">
                    <img src="profile-images/userpic.png">
                    <h2>Username</h2>
                </div>
                <hr>

                <a href="editprofile.html" class="sub-menu-link">
                    <img src="profile-images/profile.png">
                    <h3>Edit Profile</h3>
                    <span>></span>
                </a>
                <a href="#" class="sub-menu-link">
                    <img src="profile-images/setting.png">
                    <h3>Settings & Privacy</h3>
                    <span>></span>
                </a>
                <a href="#" class="sub-menu-link">
                    <img src="profile-images/help.png">
                    <h3>Help & Support</h3>
                    <span>></span>
                </a>
                <a href="#" class="sub-menu-link">
                    <img src="profile-images/logout.png">
                    <h3>Logout</h3>
                    <span>></span>
                </a>
            </div>
        </div>
    </header>

    <!-- This is a comment by Jesus -->


    <div class="container">
        <!-- main-container -->
        <div class="container my-3">
            <h1>
                
            </h1>
            <div class="card">
                <div class="card-body">
                    <form method="post" action="addnote.php">
                        <h5 class="card-title">Add title</h5>

                        <div class="form-group my-3">
                            <input type="text" class="form-control" id="addTitle" placeholder="Enter your title" name="title">
                        </div>

                        <h5 class="card-title">Add a note</h5>
                        <div class="form-group">
                            <textarea class="form-control" id="addTxt" rows="3" placeholder="Enter your Note" name="content"></textarea>
                        </div>
                        <button class="btn btn-success my-3" id="addBtn" name="submit">Add Note</button>
                    </form> 
                </div>
            </div>
            <hr>
            <h1>Your Notes</h1>
            <hr>
            <div id="notes" class="row container-fluid"> </div>
        </div>

    </div>

    <!-- Display notes -->
<div class="card-container">
    <?php
        if ($notes) {
            foreach ($notes as $note) {
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $note['title'] . '</h5>';
                echo '<p class="card-text">' . nl2br($note['content']) . '</p>';
                echo '<p class="card-text"><small class="text-muted">Created On ' .
                 date('M j, Y', strtotime($note['createdAt'])) . '</small></p>';
                echo '<a href="delete_note.php?noteID=' . $note['noteID'] . '" class="btn btn-danger">Delete</a>';
                echo '<a href="edit_note.php?noteID=' . $note['noteID'] . '"class="btn btn-primary">Edit</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>You have no notes yet.</p>';
        }
    ?>
</div>



    <?php
    $sql = "SELECT * FROM drawings WHERE userID = $userID";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<img src="data:image/png;base64,' . base64_encode($row['image_data']) . '" alt="Drawing"/>';
        }
    } else {
        echo "No drawings found.";
    }
    mysqli_close($conn);
    ?>
    

    <button onclick="logout()">Logout</button>

	<!-- A script that redirects the user to the logout page when the button is clicked -->
	<script>
		function logout() {
			window.location.href = "telahLogout.php";
		}
	</script>
    <!-- <a href="draw_page/index-2.php" class="btn btn-primary">Drawing</a> -->

</body>

</html>