<?php
session_start();
include('../../includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];  // Get student ID from session

// Handle attendance status toggle
if (isset($_GET['toggle_id'])) {
    $attendance_id = $_GET['toggle_id'];
    
    // Fetch current attendance status
    $query = "SELECT attendance_status FROM attendance WHERE id = ? AND student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $attendance_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $attendance = $result->fetch_assoc();
    
    // If attendance record exists, toggle the status
    if ($attendance) {
        $new_status = ($attendance['attendance_status'] == 'Present') ? 'Waiting' : 'Present';
        
        // Update the attendance status
        $update_query = "UPDATE attendance SET attendance_status = ? WHERE id = ? AND student_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sii", $new_status, $attendance_id, $student_id);
        
        if ($stmt->execute()) {
            // Redirect back to the dashboard after toggling
            header("Location: dashboard.php");
            exit();
        }
    }
}

// Fetch attendance records for this student
$attendance_query = "SELECT * FROM attendance WHERE student_id = ?";
$stmt = $conn->prepare($attendance_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$attendance_result = $stmt->get_result();

// Fetch student details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$student_result = $stmt->get_result();
$student = $student_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Student Dashboard</title>
    <script>
        // JavaScript function to toggle the form visibility
        function toggleForm() {
            const form = document.getElementById('attendance-form');
            form.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Sidebar -->
    <div class="flex h-screen">
        <aside class="bg-blue-900 text-white w-64 space-y-6 py-7 px-2">
            <div class="text-center text-2xl font-bold">Student Dashboard</div>
            <nav class="space-y-4">
                <a href="dashboard.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Dashboard</a>
                <a href="routine.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Class Routine</a>
                <a href="profile.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">View Profile</a>
                <a href="logout.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Welcome, <?php echo htmlspecialchars($student['first_name']); ?>!</h1>
            </header>

            <main class="flex-1 p-6">
                <p>Welcome to your student dashboard. You can manage your profile, check your attendance details, etc.</p>
                
                <!-- Button to show attendance form -->
                <button onclick="toggleForm()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    New Attendance
                </button>

                <!-- Attendance form that will toggle visibility -->
                <div id="attendance-form" class="hidden mt-4 bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-4">New Attendance</h2>
                    <form action="submit_attendance.php" method="POST">
                        <!-- First Name -->
                        <label for="first_name" class="block text-gray-700">First Name:</label>
                        <input type="text" id="first_name" name="first_name" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>

                        <!-- Last Name -->
                        <label for="last_name" class="block text-gray-700 mt-4">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>

                        <!-- Gender -->
                        <label for="gender" class="block text-gray-700 mt-4">Gender:</label>
                        <select id="gender" name="gender" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>

                        <!-- Contact No -->
                        <label for="contact_no" class="block text-gray-700 mt-4">Contact No:</label>
                        <input type="text" id="contact_no" name="contact_no" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>

                        <!-- Email -->
                        <label for="email" class="block text-gray-700 mt-4">Email:</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>

                        <!-- Address -->
                        <label for="address" class="block text-gray-700 mt-4">Address:</label>
                        <textarea id="address" name="address" class="mt-1 block w-full p-2 border border-gray-300 rounded" required></textarea>

                        <!-- Attendance Status -->
                        <label for="attendance_status" class="block text-gray-700 mt-4">Attendance Status:</label>
                        <select id="attendance_status" name="attendance_status" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                            <option value="Waiting" selected>Waiting</option>
                            <option value="Present">Present</option>
                        </select>

                        <!-- Submit Button -->
                        <button type="submit" class="mt-6 bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                            Submit
                        </button>
                    </form>
                </div>

                <!-- Display Attendance Table -->
                <h2 class="text-2xl font-bold mt-6 mb-4">Attendance Records</h2>
                <table class="min-w-full table-auto bg-white border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 border border-gray-300">First Name</th>
                            <th class="p-2 border border-gray-300">Last Name</th>
                            <th class="p-2 border border-gray-300">Gender</th>
                            <th class="p-2 border border-gray-300">Contact No</th>
                            <th class="p-2 border border-gray-300">Email</th>
                            <th class="p-2 border border-gray-300">Attendance Status</th>
                            <th class="p-2 border border-gray-300">Date</th>
                            <th class="p-2 border border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($attendance_result->num_rows > 0) {
                            while ($attendance = $attendance_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='p-2 border border-gray-300'>" . htmlspecialchars($attendance['first_name']) . "</td>";
                                echo "<td class='p-2 border border-gray-300'>" . htmlspecialchars($attendance['last_name']) . "</td>";
                                echo "<td class='p-2 border border-gray-300'>" . htmlspecialchars($attendance['gender']) . "</td>";
                                echo "<td class='p-2 border border-gray-300'>" . htmlspecialchars($attendance['contact_no']) . "</td>";
                                echo "<td class='p-2 border border-gray-300'>" . htmlspecialchars($attendance['email']) . "</td>";
                                echo "<td class='p-2 border border-gray-300'>" . htmlspecialchars($attendance['attendance_status']) . "</td>";
                                echo "<td class='p-2 border border-gray-300'>" . htmlspecialchars($attendance['date']) . "</td>";
                                echo "<td class='p-2 border border-gray-300'>
                                    <a href='edit_attendance.php?id=" . $attendance['id'] . "' class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600'>Edit</a>
                                    <a href='dashboard.php?toggle_id=" . $attendance['id'] . "' class='bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600'>Toggle Status</a>
                                    <a href='delete_attendance.php?id=" . $attendance['id'] . "' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600'>Delete</a>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='p-2 border border-gray-300 text-center'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</body>
</html>
