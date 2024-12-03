<?php
session_start();
include('../../includes/db.php');

// Ensure the event ID and registrar ID are passed
if (!isset($_POST['event_id']) || !isset($_POST['registrar_id'])) {
    echo "Invalid request. Missing event or student ID.";
    exit();
}

$event_id = intval($_POST['event_id']);
$registrar_id = intval($_POST['registrar_id']);

// Update the event with the selected student as the registrar
$query = "UPDATE events SET registrar_id = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $registrar_id, $event_id);

if ($stmt->execute()) {
    header("Location: view_event.php?id=" . $event_id . "&success=Student assigned as registrar successfully.");
} else {
    header("Location: view_event.php?id=" . $event_id . "&error=Failed to assign student.");
}

$stmt->close();
$conn->close();
?>
