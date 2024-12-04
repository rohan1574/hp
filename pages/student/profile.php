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
    <script src="https://cdn.tailwindcss.com"></script>
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

        <!-- Main Content Area -->
        <div class="flex-1 p-6">
            <!-- Profile Content -->
            <h2 class="text-2xl font-bold mb-6">Welcome, <?php echo htmlspecialchars($student['first_name']); ?>!</h2>

            <!-- Profile Table -->
            <div class="overflow-x-auto bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4">Your Profile Details</h3>
                <table class="min-w-full table-auto">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium">Field</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-50">
                        <tr class="border-b">
                            <td class="px-6 py-4 text-sm font-medium text-gray-700">Name</td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo htmlspecialchars($student['first_name']) . ' ' . htmlspecialchars($student['last_name']); ?></td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-6 py-4 text-sm font-medium text-gray-700">Address</td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo htmlspecialchars($student['address']); ?></td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-6 py-4 text-sm font-medium text-gray-700">Email</td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo htmlspecialchars($student['email']); ?></td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-6 py-4 text-sm font-medium text-gray-700">Contact</td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo htmlspecialchars($student['contact_no']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <a href="logout.php" class="text-red-600 hover:text-red-800">Logout</a>
            </div>
        </div>
    </div>
</body>

</html>
