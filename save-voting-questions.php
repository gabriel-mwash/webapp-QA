<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set("display_errors", 1);

require "connection.php";


if ($connection->connect_error) {
  echo json_encode(["success" => false, "error" => "Database connection failed"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
var_dump($data);
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
?>

