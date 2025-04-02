<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voting</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="/vote.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body id="body">
<?php require "./nav-bar-mod.php"?>
<form id="vote-form">
<div class="row">
  <div class="col-md-12 " id="questions-container"></div>
</div>
<div class="btn-sbm-vote">
  <button id="submit-vote" class="btn btn-primary"
    type="submit"
    style="background-color: #94d82d";
>Submit Vote</button>
</div>
</form>
  <script src="vote-script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

