<?php

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
</head>

<body class="body-questions" style="background: url(&quot;assets/img/Frame%2016%20(2).svg&quot;) center / auto repeat;">
  <nav id="top" class="d-block sticky-top">
    <img src="assets/img/AYLF-LOGO-NB-02.webp" style="height: 100px;width: 100px;">
  </nav>
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

