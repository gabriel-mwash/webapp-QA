<?php
header("Content-Type: application/json");

require "../connection.php";

// Initialize response array
$response = ["success" => false, "error" => ""];

try {
    // Verify connection
    if ($connection->connect_error) {
        throw new Exception("Database connection failed");
    }

    // Get and validate input
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input || !isset($input["questions"])) {
        throw new Exception("Invalid data received");
    }

    // Begin transaction
    $connection->begin_transaction();

    foreach ($input["questions"] as $question) {
        // Validate question data
        if (empty($question["question_text"])) {
            throw new Exception("Question text cannot be empty");
        }

        // Insert question
        $stmt = $connection->prepare("INSERT INTO votingQuery (query_text, query_type) VALUES (?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $connection->error);
        }
        
        $stmt->bind_param("ss", $question["question_text"], $question["question_type"]);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        $queryId = $connection->insert_id;

        // Insert options if needed
        if ($question["question_type"] !== "Open" && !empty($question["options"])) {
            foreach ($question["options"] as $option) {
                if (empty(trim($option))) continue;
                
                $stmtOption = $connection->prepare(
                    "INSERT INTO votingOptions (query_id, option_text) VALUES (?, ?)"
                );
                if (!$stmtOption) {
                    throw new Exception("Prepare failed: " . $connection->error);
                }
                
                $stmtOption->bind_param("is", $queryId, $option);
                if (!$stmtOption->execute()) {
                    throw new Exception("Execute failed: " . $stmtOption->error);
                }
            }
        }
    }

    // Commit transaction
    $connection->commit();
    $response["success"] = true;

} catch (Exception $e) {
    // Rollback on error
    if (isset($connection) && method_exists($connection, "rollback")) {
        $connection->rollback();
    }
    $response["error"] = $e->getMessage();
} finally {
    // Close connection
    if (isset($connection)) {
        $connection->close();
    }
}

// Send JSON response
echo json_encode($response);
exit;
/*
header("Content-Type: application/json");

require "../connection.php";


if ($connection->connect_error) {
  echo json_encode(["success" => false, "error" => "Database connection failed"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data["questions"])) {
  echo json_encode(["success" => false, "error" => "Invalid data"]);
  exit;
}

foreach ($data["questions"] as $question) {
  $stmt = $connection->prepare("INSERT INTO votingQuery (query_text, query_type) VALUES (?, ?)");
  $stmt->bind_param("ss", $question["question_text"], $question["question_type"]);
  $stmt->execute();
  $queryId = $stmt->insert_id;
  
  if ($question["question_type"] !== "Open") {
    foreach ($question["options"] as $option) {
      $stmtOption = $connection->prepare
        ("INSERT INTO votingOptions (query_id, option_text) VALUES (?, ?)");
      $stmtOption->bind_param("is", $queryId, $option);
      $stmtOption->execute();
    }
  }
}

echo json_encode(["success" => true]);
$connection->close();
*/
?>

