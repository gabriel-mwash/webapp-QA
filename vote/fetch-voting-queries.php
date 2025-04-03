<?php
session_start();
require "../connection.php";

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch all questions from the votingQuery table
$sql = "SELECT * FROM votingQuery"; 
$result = $connection->query($sql);

$questions = [];

if ($result->num_rows > 0) {
  // Loop through each question
  while ($question = $result->fetch_assoc()) {
    // Prepare question data
    $question_data = [
      'id' => $question['query_id'],
      'text' => $question['query_text'],
      'type' => $question['query_type'],
      'options' => []
    ];
    $options_sql = "SELECT * FROM votingOptions WHERE query_id = " 
      . $question['query_id'];
    $options_result = $connection->query($options_sql);

    // Add options to the question data
    while ($option = $options_result->fetch_assoc()) {
      $question_data['options'][] = [
        'id' => $option['options_id'],
        'text' => $option['option_text']
      ];
    }

      // Add the question data to the questions array
      $questions[] = $question_data;
  }
} else {
    echo json_encode(['error' => 'No questions found']);
    exit;
}

// Close connection
$connection->close();

// Return the questions data as JSON
echo json_encode($questions);
?>

