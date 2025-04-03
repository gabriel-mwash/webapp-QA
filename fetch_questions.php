<?php


// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");
include("connection.php");

$batch = isset($_GET["batch"]) ? intval($_GET["batch"]) : 0;
$offset = $batch * 7;

$sql = "SELECT question, name, institute FROM questions ORDER BY RAND() LIMIT 7 OFFSET $offset";

$result = $connection->query($sql);

$questions = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
  }
}

// print_r($questions);


echo json_encode($questions, JSON_PRETTY_PRINT);

$connection->close();
?>
