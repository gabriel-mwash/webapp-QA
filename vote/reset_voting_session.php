<?php
header("Content-Type: application/json");
if (ob_get_level()) ob_end_clean();

$response = ["success" => false];

// Admin verification
session_start();
$resetTime = time();
file_put_contents(__DIR__ . "/system_reset_time.txt", $resetTime);

$_SESSION["system_reset_time"] = $resetTime;

if (!isset($_SESSION['moderator_logged_in']) || !$_SESSION['moderator_logged_in']) {
    $response["error"] = "Admin access required";
    echo json_encode($response);
    exit;
}

require "../connection.php";

try {
    $connection->query("SET FOREIGN_KEY_CHECKS = 0");
    
    // Clear tables in perfect order for your schema
    $connection->query("TRUNCATE TABLE votes");          // Must go first (references others)
    $connection->query("TRUNCATE TABLE votingOptions");  // Goes next (references votingQuery)
    $connection->query("TRUNCATE TABLE votingQuery");    // Finally clear the main table
    
    // Re-enable foreign key checks
    $connection->query("SET FOREIGN_KEY_CHECKS = 1");
    
    $_SESSION['voted'] = false;
    
    $connection->query("ALTER TABLE votingQuery AUTO_INCREMENT = 1");
    $connection->query("ALTER TABLE votingOptions AUTO_INCREMENT = 1");
    $connection->query("ALTER TABLE votes AUTO_INCREMENT = 1");
    
    $response["success"] = true;
    $response["message"] = "Voting data completely reset";
    
} catch (Exception $e) {
    // Ensure foreign key checks are re-enabled on error
    $connection->query("SET FOREIGN_KEY_CHECKS = 1");
    $response["error"] = "Reset failed: " . $e->getMessage();
    error_log("Reset Error: " . $e->getMessage());
}

echo json_encode($response);
exit;
