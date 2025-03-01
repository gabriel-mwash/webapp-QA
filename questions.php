?php

session_start();

if (!isset($_SESSION["moderator_name"]) || $_SESSION["moderator_logged_in"] !== true) {
  header("Location:moderator.php");
  exit(); 
}

?>



<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Q_and_A_webApp</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fredoka+One&amp;display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fugaz+One&amp;display=swap">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/Dark-NavBar-Navigation-with-Button.css">
  <link rel="stylesheet" href="assets/css/Dark-NavBar-Navigation-with-Search.css">
  <link rel="stylesheet" href="assets/css/Dark-NavBar.css">
</head>

<body class="body-questions" style="background: url(&quot;assets/img/Frame%2016%20(2).svg&quot;) center / auto repeat;">
  <nav class="navbar navbar-expand-md sticky-top navigation-clean-button navbar-light" style="height:80px;background-color:#37434d;color:#ffffff;">
      <div class="container-fluid">
        <img src="assets/img/AYLF-LOGO-NB-02.webp" style="height: 75px; width:75px;">
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse" id="navcol-1">
              <ul class="navbar-nav ms-auto">
                  <li class="nav-item"><a class="nav-link active" style="color:#ffffff;" href="#"><i class="fa fa-home"></i>&nbsp;Home</a></li>
                  <li class="nav-item"><a class="nav-link" style="color:#ffffff;" href="#"><i class="fa fa-wpexplorer"></i>&nbsp;Explore</a></li>
                  <li class="nav-item"><a class="nav-link" style="color:#ffffff;" href="#"><i class="fa fa-star-o"></i>&nbsp;Features</a></li>
                  <li class="nav-item"><a class="nav-link" style="color:#ffffff;" href="#"><i class="fa fa-user-circle-o"></i>&nbsp;Portfolio</a></li>
                  <li class="nav-item"><a class="nav-link" style="color:#ffffff;" href="#"><i class="fa fa-sign-in"></i>&nbsp;Sign In</a></li>
              </ul>
          </div>
      </div>
  </nav>


  <!-- <nav id="top" class="d-block sticky-top"> -->
  <a id="refresh" href="questions.php">Refresh</a>
  <div class="query-container"></div>
  <div class="footer">
    <button id="LoadMore">Load more </button>
    <a id="oldLink" href="#refresh" style="/*display: none;*/">to top of page</a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/bs-init.js"></script>
  <script src="assets/js/scripts.js"></script>
</body>

</html>

