<?php


// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");
include("connection.php");

$batch = isset($_GET["batch"]) ? intval($_GET["batch"]) : 0;
$offset = $batch * 7;

$sql = "SELECT question, name, institute FROM questions ORDER BY question_id ASC LIMIT 7 OFFSET $offset";

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











/*
while (true) {
  $batch = 7;
  $sql = "SELECT question, name, institute FROM questions WHERE question_id <= ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("i", $batch);
  $stmt->execute();
  $result = $stmt->get_result();
  $questions = $result->num_rows;

  if (($questions <= $batch ) && ($questions !== 0)) {
    while ($row = $result->fetch_assoc()) {
      echo $row["question"] . "|" . $row["name"] . "|" . $row["institute"]. "<br>";
    }
    break;
  }
  else {
    echo "no questions yet";
  }

  if ($questions > $batch) {
    $batch += $
  }
}
  
 */ 





/*
if ($result->num_rows > 0) {
  // echo "there is data, number of questions " . $result->num_rows;
  while ($row = $result->fetch_assoc()) {
    echo $row["question"] . "|" . $row["name"] . "|" . $row["institute"] . "<br>";
  }
}
else {
  echo "no questions posted yet !";
}

 */


/*
while($row = $result->fetch_assoc()) {
  echo $row["question"] . "|" . $row["name"] . "|" . $row["institute"] . "<br>";
}
 */



/*
if($stmt->execute()) {
  echo "check ok";
}
else {
  echo "error in exe statement" . $stmt->error;
}
 */


  

?>
