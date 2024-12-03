<?php
session_start();
include('../../includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

$student_id = $_SESSION['student_id'];  // Get student ID from session

// Fetch attendance record to be edited
if (isset($_GET['id'])) {
    $attendance_id = $_GET['id'];
    $query = "SELECT * FROM attendance WHERE id = ? AND student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $attendance_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $attendance = $result->fetch_assoc();
    } else {
        echo "Attendance record not found.";
        exit();
    }
}

// Update attendance details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $contact_no = $_POST['contact_no'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $attendance_status = $_POST['attendance_status'];

    $update_query = "UPDATE attendance 
                     SET first_name = ?, last_name = ?, gender = ?, contact_no = ?, email = ?, address = ?, attendance_status = ? 
                     WHERE id = ? AND student_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssssi", $first_name, $last_name, $gender, $contact_no, $email, $address, $attendance_status, $attendance_id, $student_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php"); // Redirect to the dashboard after successful update
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Attendance</title>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Sidebar -->
    <div class="flex h-screen">
        <aside class="bg-blue-900 text-white w-64 space-y-6 py-7 px-2">
            <div class="text-center text-2xl font-bold">Student Dashboard</div>
            <nav class="space-y-4">
                <a href="dashboard.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Dashboard</a>
                <a href="profile.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">View Profile</a>
                <a href="logout.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Edit Attendance</h1>
            </header>

            <main class="flex-1 p-6">
                <h2 class="text-2xl font-bold mb-6">Edit Your Attendance Details</h2>
                <form action="edit_attendance.php?id=<?php echo $attendance['id']; ?>" method="POST">
                    <div class="space-y-4">
                        <input type="text" name="first_name" value="<?php echo htmlspecialchars($attendance['first_name']); ?>" class="w-full px-4 py-2 rounded border border-gray-300" placeholder="First Name" required>
                        <input type="text" name="last_name" value="<?php echo htmlspecialchars($attendance['last_name']); ?>" class="w-full px-4 py-2 rounded border border-gray-300" placeholder="Last Name" required>
                        <input type="text" name="gender" value="<?php echo htmlspecialchars($attendance['gender']); ?>" class="w-full px-4 py-2 rounded border border-gray-300" placeholder="Gender" required>
                        <input type="text" name="contact_no" value="<?php echo htmlspecialchars($attendance['contact_no']); ?>" class="w-full px-4 py-2 rounded border border-gray-300" placeholder="Contact Number" required>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($attendance['email']); ?>" class="w-full px-4 py-2 rounded border border-gray-300" placeholder="Email" required>
                        <textarea name="address" class="w-full px-4 py-2 rounded border border-gray-300" placeholder="Address" required><?php echo htmlspecialchars($attendance['address']); ?></textarea>
                        <select name="attendance_status" class="w-full px-4 py-2 rounded border border-gray-300" required>
                            <option value="Present" <?php echo ($attendance['attendance_status'] == 'Present') ? 'selected' : ''; ?>>Present</option>
                            <option value="Waiting" <?php echo ($attendance['attendance_status'] == 'Waiting') ? 'selected' : ''; ?>>Waiting</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-6">
                        Update Attendance
                    </button>
                </form>
            </main>
        </div>
    </div>

</body>
</html>

<?php $conn->close(); ?>
