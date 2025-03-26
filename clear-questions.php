<?php

session_start();

require "./connection.php";

 
if (!isset($_SESSION["moderator_name"]) || $_SESSION["moderator_logged_in"] !== true) {
  header("Location:moderator.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sql_delete = "DELETE FROM questions";

  if ($connection->query($sql_delete) === TRUE) {
    $sql_reset = "ALTER TABLE questions AUTO_INCREMENT = 1";
    if ($connection->query($sql_reset) === TRUE) {
      echo "all questions deleted, and ID reset to 1";
    }
  }
  else {
    echo "Error : ", $connection->error;
  }
}
  






?>
