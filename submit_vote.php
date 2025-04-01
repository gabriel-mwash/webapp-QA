<?php
session_start();
require 'connection.php'; // Ensure you have a DB connection file

// Check if the user has already voted
if (isset($_SESSION['voted']) && $_SESSION['voted'] === true) {
  echo json_encode(['error' => 'You have already voted.']);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(["error" => "Invalid request method."]);
  exit;
}

if(!isset($_POST["vote"]) || empty($_POST["vote"])) {
  echo json_encode(["eror" => "No votes submitted."]);
  exit;
}

$votes = $_POST["vote"];

try {
  foreach ($votes as $question_id => $response) {
    if (is_array($response)) {
      // Multiple choice: Insert each selected option
      foreach ($response as $option_id) {
        $stmt = $connection->prepare("INSERT INTO votes (query_id, option_id) VALUES (?, ?)");
        $stmt->execute([$question_id, $option_id]);
      }
    } 
    elseif (!empty($response)) {
      // Single choice or open-ended answer
      $stmt = $connection->prepare("INSERT INTO votes (query_id, option_text) VALUES (?, ?)");
      $stmt->execute([$question_id, $response]);
    }
  }
  $_SESSION['voted'] = true;
}
catch (Exception $e) {
  echo json_encode(["error" => "Database  error: " . $e->getMessage()]);
}

exit;
