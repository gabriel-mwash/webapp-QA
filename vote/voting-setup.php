<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voting Setup</title>
  <link rel="stylesheet" href="assets/css/voting-setup.css">
<body id="body">
<?php require "../nav-bar-mod.php"; ?>
  <div class=" setup-container">
    <h2 class="text-center">Voting Setup</h2>
    <div id="questions-container"></div>
    <button id="add-question" class="btn btn-primary w-100 mb-3">+ Add Question</button>
  </div>

  <div class="preview-container">
    <h5>Poll Preview:</h5>
    <div id="preview-section">
      <div id="preview-questions"></div>
    </div>
    <div class="button-group mt-3">
      <button id="launch-vote" class="btn btn-primary w-100 mb-3 btn-success">🚀 Launch Vote</button>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="./assets/js/script-setup-vote.js"></script>
</body>
</html>

