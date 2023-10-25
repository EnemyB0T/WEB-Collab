<?php
    // include the config file
    include('../config.php');

    session_start();

    if (!isset($_SESSION['userID'])) {
        header("Location: ../loginCode.php");
    }

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SketchPad</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- STYLES -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Sen&display=swap" rel="stylesheet">

    <!-- JS -->
    <script
      src="https://code.jquery.com/jquery-3.4.1.js"
      integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
      crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
  <body>

    <!-- navbar -->
    <div id="navbar">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container-fluid">
              <a class="navbar-brand">Quill</a>
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

      

    <div class="sidebar">
      <table class="colors table">
        <tr>
          <td bgcolor="#ff5454">#ff5454</td>
          <td bgcolor="#f59b47">#f59b47</td>
          <td bgcolor="#f7e674">#f7e674</td>
          <td bgcolor="#bbff6e">#bbff6e</td>
          <td bgcolor="#75ff69">#75ff69</td>
          <td bgcolor="#82fff9">#82fff9</td>
          <td bgcolor="#85b6ff">#85b6ff</td>
          <td bgcolor="#b685ff">#b685ff</td>
          <td bgcolor="#ff8fd4">#ff8fd4</td>
          <td bgcolor="#ffffff">#ffffff</td>
        </tr>
        <tr>
          <td bgcolor="#db1a1a">#db1a1a</td>
          <td bgcolor="#ffa200">#ffa200</td>
          <td bgcolor="#ffe100">#ffe100</td>
          <td bgcolor="#83ed0c">#83ed0c</td>
          <td bgcolor="#1cdb0b">#1cdb0b</td>
          <td bgcolor="#00fffb">#00fffb</td>
          <td bgcolor="#0e69f0">#0e69f0</td>
          <td bgcolor="#7417ff">#7417ff</td>
          <td bgcolor="#e61595">#e61595</td>
          <td bgcolor="#919191">#919191</td>
        </tr>
        <tr>
          <td bgcolor="#7a0f0f">#7a0f0f</td>
          <td bgcolor="#ba5a00">#ba5a00</td>
          <td bgcolor="#b59d00">#b59d00</td>
          <td bgcolor="#64bd00">#64bd00</td>
          <td bgcolor="#0b8a00">#0b8a00</td>
          <td bgcolor="#009997">#009997</td>
          <td bgcolor="#003e99">#003e99</td>
          <td bgcolor="#470d9e">#470d9e</td>
          <td bgcolor="#8c0859">#8c0859</td>
          <td bgcolor="#000000">#000000</td>
        </tr>
      </table>
      <table class="utilities">
        <tr>
          <td class="sliderLabel">WIDTH</td>
          <td class="slider"><div id="slider-2"></div></td>
          <td class="currentColor">PEN COLOR</td>
          <td class="reset">RESET</td>
        </tr>
      </table>
    </div>

    <div>
      <canvas id="sketchpad"></canvas>
      <script src="draw.js"></script>
    </div>
    <a href="../noteAddis.php" class="btn btn-primary">Back</a>
    <form action="save_drawing.php">
      <input type="submit" value="save" id="saveBtn" onclick="saveDrawing()">
  </form>
  </body>
</html>
