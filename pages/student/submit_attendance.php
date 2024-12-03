<?php
session_start();
include('../../includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

$student_id = $_SESSION['student_id'];  // Get student ID from session

// Retrieve form values
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$gender = $_POST['gender'];
$contact_no = $_POST['contact_no'];
$email = $_POST['email'];
$address = $_POST['address'];
$attendance_status = $_POST['attendance_status'];

// Check if the student_id exists in the `users` table
$query = "SELECT id FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If student exists, insert attendance record
    $insert_query = "INSERT INTO attendance (student_id, first_name, last_name, gender, contact_no, email, address, attendance_status) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("isssssss", $student_id, $first_name, $last_name, $gender, $contact_no, $email, $address, $attendance_status);

    if ($insert_stmt->execute()) {
        // Successfully inserted attendance
        echo "Attendance submitted successfully.";
    } else {
        echo "Error: " . $insert_stmt->error;
    }
} else {
    // If student does not exist in the `users` table
    echo "Error: Student ID not found in the database.";
}

$insert_stmt->close();
$conn->close();
?>