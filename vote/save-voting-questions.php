<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // For development only

// Initialize response
$response = ["success" => false, "error" => ""];

try {
    // Verify request method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method");
    }

    // Get and validate input
    $input = json_decode(file_get_contents("php://input"), true);
    if ($input === null) {
        throw new Exception("Invalid JSON input");
    }
    
    if (!isset($input["questions"]) || !is_array($input["questions"])) {
        throw new Exception("No questions provided");
    }

    // Database connection
    require __DIR__ . "/../connection.php";
    
    if ($connection->connect_error) {
        throw new Exception("Database connection failed: " . $connection->connect_error);
    }

    // Begin transaction
    $connection->begin_transaction();

    foreach ($input["questions"] as $question) {
        // Validate question
        if (empty($question["question_text"])) {
            throw new Exception("Question text cannot be empty");
        }
        
        if (!in_array($question["question_type"], ["Open", "Single", "Multiple"])) {
            throw new Exception("Invalid question type");
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
        if (($question["question_type"] === "Single" || $question["question_type"] === "Multiple") && !empty($question["options"])) {
            foreach ($question["options"] as $option) {
                $option = trim($option);
                if (empty($option)) continue;
                
                $stmtOption = $connection->prepare("INSERT INTO votingOptions (query_id, option_text) VALUES (?, ?)");
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
    if (isset($connection) && $connection instanceof mysqli && $connection->thread_id) {
        $connection->rollback();
    }
    $response["error"] = $e->getMessage();
} finally {
    // Close connection
    if (isset($connection) && $connection instanceof mysqli && $connection->thread_id) {
        $connection->close();
    }
}

// Send JSON response
echo json_encode($response);
exit;
