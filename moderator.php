<?php 

session_start();

$error_message = "";

if(isset($_SESSION["error"])) {
  $error_message = $_SESSION["error"];
  unset($_SESSION["error"]);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="background: url(&quot;assets/img/Frame%2016%20(2).svg&quot;) center / auto repeat;">
<?php if (!empty($error_message)):?>
  <script> 
    alert("<?php echo $error_message ?>");
  </script>
<?php endif; ?>

  <h1 class="text-center">Q and A Session</h1>
  <form class="pulse animated moderator-form" action="mod_submit.php" method="post">
      <div class="text-center">
        <img width="100" height="100" src="assets/img/AYLF-LOGO-NB-02.webp">
      </div>
      <div class="text-center mod-name">
        <label class="form-label mod-label" >moderator</label>
        <input class="form-control name-campus-fields pe-0" 
          type="text" name="moderator_name">
      </div>
      <div class="cod-name">
        <label class="form-label cod-label" >code&nbsp;</label>
        <input class="form-control name-campus-fields pe-0 cod-input" 
          name="code" type="text" >
      </div>
      <a class="btn btn-lg active fw-bolder mod-login-btn" role="button" 
        onclick="document.querySelector('.moderator-form').submit(); return false;"
        data-bss-hover-animate="tada" style="background: #ffdf00;" 
        >login
      </a>
      <p style="font-family: 'Fugaz One', serif;color: #ffdf00;
        text-align: center;padding: 10px;margin-top: 3rem;"
        >Nurturing A New Breed Of Leaders in Africa
      </p>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/bs-init.js"></script>
</body>
</html>
