<?php

include "connection.php";

$question = trim($_POST["question"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = !empty(trim($_POST["name"])) ? trim($_POST["name"]) : "Anonymous";
  $institute = !empty(trim($_POST["institute"])) ? trim($_POST["institute"]) : "Anonymous";
  
  $sql = "INSERT INTO questions (question, name, institute) VALUES (?, ?, ?)";
  
  if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("sss", $question, $name, $institute);
    if ($stmt->execute()) {
      header("Location:continue.php");
      exit();
    }
    else {
      echo "Error: " . $stmt->error;
    }
    $stmt->close();
  }
  else {
    echo "error preparing staement: " . $connection->error;
  }
}

$connection->close();


?>
