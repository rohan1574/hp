<?php
include('../../includes/db.php');

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the class routine from the database
    $delete_query = "DELETE FROM class_routine WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Class routine deleted successfully!'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'dashboard.php';</script>";
    }
} else {
    echo "<script>alert('No ID provided.'); window.location.href = 'dashboard.php';</script>";
}
