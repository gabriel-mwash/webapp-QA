<?php 

$servername = "localhost";
$username = "gabu";
$password = "gabu_123";
$database = "webappdb";


// create connection
$connection = new mysqli(
  $servername, $username, $password, $database
);

// check connection 
if ($connection->connect_error) {
  die("connection failed: " . $connection->connect_error);
}

// echo "connection successfully";

?>
