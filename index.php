<!DOCTYPE html>
<html data-bs-theme="light" lang="en">


<body style="background: url(&quot;assets/img/Frame%2016%20(2).svg&quot;) center / auto repeat, #ffffff;">

<?php require "./nav-bar.php"; ?>
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
            data-bss-hover-animate="pulse"  data-bs-target="moderator.php" 
            href="moderator.php" style="background: #94d82d;color: rgb(3,1,1);">moderator login</a>
          <a class="btn btn-primary btn-lg active fw-bolder submit-btn" role="button" 
            data-bss-hover-animate="pulse" type="submit"
            style="background: #94d82d;color: rgb(0,0,0);">submit
          </a>
            
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script>
      document.querySelector(".submit-btn").addEventListener("click", function (e) {
        let message = document.querySelector(".question-area").value.trim();
        let minQuestLength = 20;
        if (message .length < minQuestLength) {
          alert("message too short or invalid message");
          e.preventDefault();
        }
        else {
          document.querySelector(".question-form").submit();
          document.querySelector(".question-area").value = "";
        }
      }
      );
    </script>
</body>

<html>
