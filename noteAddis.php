<?php
session_start();
include('config.php');

if(isset($_SESSION['userID'])) {
  // If the user is logged in, show the note form
  //echo '<h1>Add Note</h1>';

  
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

mysqli_close($conn);
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
    <link rel="stylesheet" href="index.css">
</head>

<body>

    <!-- navbar -->
    <div id="navbar">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand">Notes</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" id="searchTxt" type="search" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

    </div>

    <!-- This is a comment by Jesus -->


    <div class="container">
        <!-- main-container -->
        <div class="container my-3">
            <h1>
                <marquee>Welcome To My Notes Website</marquee>
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
<?php
    // display the notes
if ($notes) {
    foreach ($notes as $note) {
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $note['title'] . '</h5>';
        echo '<p class="card-text">' . nl2br($note['content']) . '</p>';
        echo '<a href="delete_note.php?noteID=' . $note['noteID'] . '" class="btn btn-danger">Delete</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>You have no notes yet.</p>';
}
?>


    

    <button onclick="logout()">Logout</button>

	<!-- A script that redirects the user to the logout page when the button is clicked -->
	<script>
		function logout() {
			window.location.href = "logout.php";
		}
	</script>
</body>

</html>