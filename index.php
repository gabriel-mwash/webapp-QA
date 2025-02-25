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

<body style="background: url(&quot;assets/img/Frame%2016%20(2).svg&quot;) center / auto repeat, #ffffff;">
    <div>
        <h1 class="text-center">Q and A Session</h1>
    </div>
    <form class="pulse animated question-form" action="submit_question.php" method="POST" >
        <div class="text-center">
          <img width="100" height="100" src="assets/img/AYLF-LOGO-NB-02.webp">
        </div>
        <div>
          <textarea class="form-control question-area" name="question" required placeholder="type question here" ></textarea>
        </div>
        <label class="form-label row-cols-sm-6">* Not mandatory</label>
        <div class="text-center name-group">
          <input class="form-control name-campus-fields pe-0" name="name" type="text" placeholder="name">
          <input class="form-control name-campus-fields pe-0" name="institute" type="text" placeholder="Institute">
        </div>
        <div class="question-btns">
          <a class="btn btn-primary btn-lg active fw-bolder mod-login-btn" role="button"
            data-bss-hover-animate="tada"  data-bs-target="moderator.php" 
            href="moderator.php" style="background: #94d82d;color: rgb(3,1,1);">moderator login</a>
          <a class="btn btn-primary btn-lg active fw-bolder submit-btn" role="button" 
            data-bss-hover-animate="tada" type="submit"
          onclick="document.querySelector('.question-form').submit(); return false;"
            style="background: #94d82d;color: rgb(0,0,0);">submit
            
          </a>
            
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

<html>
