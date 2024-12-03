<?php
session_start();
include '../../includes/db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Query to get student details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($student['first_name']); ?>!</h2>
    <p>Here are your details:</p>
    <ul>
        <li>Address: <?php echo htmlspecialchars($student['address']); ?></li>
        <li>Name: <?php echo htmlspecialchars($student['first_name']) . ' ' . htmlspecialchars($student['last_name']); ?></li>
        <li>Email: <?php echo htmlspecialchars($student['email']); ?></li>
        <li>Contact: <?php echo htmlspecialchars($student['contact_no']); ?></li>
    </ul>
    
    <a href="logout.php">Logout</a>
</body>
</html>
