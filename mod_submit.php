<?php

session_start();

include("connection.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $moderator_name = trim($_POST["moderator_name"]);
  $code = trim($_POST["code"]);
  $moderator_name = $_POST["moderator_name"];


  $sql = "SELECT code FROM code where code_id=1";
  $stmt = $connection->prepare($sql);
  if ($stmt) {
    $stmt->execute();
    $stmt->bind_result($code_db);
    $stmt->fetch();
    $stmt->close();
  }
  else {
    echo "error preparing staement " . $connection->error;
  }

  if ($code == $code_db) {
    $sql = "INSERT INTO moderator (mod_name) VALUES (?)";
    if ($stmt = $connection->prepare($sql)) { 
      $stmt->bind_param("s", $moderator_name);
      if ($stmt->execute()) {
        $_SESSION["moderator_name"] = $moderator_name;
        echo $_SESSION["moderator_name"];
        $_SESSION["moderator_logged_in"] = true;
        header("Location:questions.php");
        exit();
      }
      else {
        echo "Error " . $stmt->error;
      }
      $stmt->close();
    }
    else {
      "error preparing statement: " . $connection->error;
    }
  }
  else {
    $_SESSION["error"] = "Invalid code. Please try again. ";
    header("Location:moderator.php");
    exit();
  }
}

$connection->close();

?>
