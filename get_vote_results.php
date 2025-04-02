<?php
require 'connection.php';

header('Content-Type: application/json');

$query = "
  SELECT 
    q.query_id,
    q.query_text AS question_text, 
    q.query_type,  -- Include query_type here
    o.options_id,
    o.option_text AS option_text, 
    v.response_text,
    COUNT(v.vote_id) AS vote_count
  FROM 
    votingQuery q
  LEFT JOIN 
    votingOptions o ON q.query_id = o.query_id
  LEFT JOIN 
    votes v ON o.options_id = v.options_id OR (q.query_type = 'open' AND v.query_id = q.query_id)
  GROUP BY 
    q.query_id, o.options_id, v.response_text
  ORDER BY 
    q.query_id, o.options_id;
";

$result = $connection->query($query);

if (!$result) {
    echo json_encode(["error" => "Database error: " . $connection->error]);
    exit;
}

$votes = [];

while ($row = $result->fetch_assoc()) {
    $question_id = $row['query_id'];

    // Initialize the question entry
    if (!isset($votes[$question_id])) {
        $votes[$question_id] = [
            "query_id" => $question_id,
            "question" => $row['question_text'],
            "query_type" => $row['query_type'],  // Store query_type here
            "responses" => [
                "options" => [],
                "open_responses" => []
            ]
        ];
    }

    if ($row['options_id'] !== null) {
        // Multiple or Single Choice Vote → Store with count
        $votes[$question_id]["responses"]["options"][] = [
            "option_id" => $row['options_id'],
            "option_text" => $row['option_text'],
            "vote_count" => (int)$row['vote_count']
        ];
    } elseif (!empty($row['response_text'])) {
        // Open-ended text response → Just store text (no vote count)
        $votes[$question_id]["responses"]["open_responses"][] = $row['response_text'];
    }
}

// Encode response as JSON
echo json_encode(array_values($votes), JSON_PRETTY_PRINT);
?>

