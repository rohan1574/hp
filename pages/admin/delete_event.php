<?php
// Include DB connection
include '../../includes/db.php';
include '../../includes/auth.php';  // Optional: To check if the admin is logged in

// Check if event ID is provided
if (!isset($_GET['id'])) {
    die("Event ID is required.");
}

$event_id = $_GET['id'];

// Prepare SQL query to delete the event
$sql = "DELETE FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);

// Execute the query
if ($stmt->execute()) {
    // Redirect to event list
    header("Location: list_events.php");
    exit;
} else {
    die("Error deleting event.");
}
?>
