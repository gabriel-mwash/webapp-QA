<?php
session_start();
require '../connection.php';

header('Content-Type: application/json');

$userLastVoteTime = $_SESSION["last_vote_time"] ?? 0;
$globalResetTime = (int) @file_get_contents(__DIR__ . "/system_reset_time.txt");

if ($userLastVoteTime >= $globalResetTime) {
  echo json_encode(["error" => "You have already voted. "]);
  exit;
}

// Validate request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Invalid request method."]);
    exit;
}

if (!isset($_POST["vote"]) || empty($_POST["vote"])) {
    echo json_encode(["error" => "No votes submitted."]);
    exit;
}

$votes = $_POST["vote"];

try {
    // $connection->beginTransaction();
    
    foreach ($votes as $question_id => $response) {
        $question_id = (int)$question_id;
        
        // Multiple choice (checkboxes)
        if (is_array($response)) {
            foreach ($response as $option_id) {
                if (!empty($option_id)) {
                    $stmt = $connection->prepare("INSERT INTO votes (query_id, options_id, response_text) VALUES (?, ?, NULL)");
                    $stmt->execute([$question_id, (int)$option_id]);
                }
            }
        }
        // Open-ended text answer
        elseif (!is_numeric($response)) {
            $stmt = $connection->prepare("INSERT INTO votes (query_id, options_id, response_text) VALUES (?, NULL, ?)");
            $stmt->execute([$question_id, trim($response)]);
        }
        // Single choice (radio buttons)
        else {
            $stmt = $connection->prepare("INSERT INTO votes (query_id, options_id, response_text) VALUES (?, ?, NULL)");
            $stmt->execute([$question_id, (int)$response]);
        }
    }
    
    $connection->commit();
    $_SESSION['voted'] = true;
    $_SESSION["last_vote_time"] = time();
    echo json_encode(["success" => "Vote submitted successfully!"]);
    
} catch (Exception $e) {
    $connection->rollBack();
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}

exit;
