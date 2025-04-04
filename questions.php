<?php

session_start();

if (!isset($_SESSION["moderator_name"]) || $_SESSION["moderator_logged_in"] !== true) {
  header("Location:moderator.php");
  exit(); 
}

?>

<body class="body-questions" style="background: url(&quot;assets/img/Frame%2016%20(2).svg&quot;) center / auto repeat;">

<?php require "./nav-bar-mod.php"; ?>

  <!-- <nav id="top" class="d-block sticky-top"> -->
  <div class="refresh">
    <a class="btn btn-primary btn-lg fw-bolder check-out-btn fade-in" role="button" id="refresh" href="questions.php">Refresh</a>
  </div>
  <div class="query-container"></div>
  <div class="footer">
    <button class="btn btn-primary btn-lg fw-bolder check-out-btn" id="LoadMore">Load more</button>
    <a class="btn btn-primary btn-lg fw-bolder check-out-btn fade-in" role="button" id="oldLink" href="#refresh" style="/*display: none;*/">to top of page</a>
  </div>
  <div class="clear">
    <a class="btn btn-danger btn-lg fw-bolder check-out-btn fade-in" role="button" id="clear-questions" href="#">
      <i class="fa fa-trash"></i>
      clear</a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/bs-init.js"></script>
  <script src="assets/js/scripts.js"></script>
</body>

</html>

