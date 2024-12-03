<?php
include('../../includes/db.php');

// Fetch attendance records from the database
$query = "SELECT * FROM attendance ORDER BY date DESC"; // Use 'date' instead of 'created_at'
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Dashboard</title>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Sidebar (Same as before) -->

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">Welcome, Admin</h1>
        </header>

        <main class="flex-1 p-6">
            <h2 class="text-2xl font-bold mb-4">Attendance List</h2>

            <!-- Attendance Table -->
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border border-gray-300">First Name</th>
                        <th class="p-2 border border-gray-300">Last Name</th>
                        <th class="p-2 border border-gray-300">Gender</th>
                        <th class="p-2 border border-gray-300">Contact No</th>
                        <th class="p-2 border border-gray-300">Email</th>
                        <th class="p-2 border border-gray-300">Attendance Status</th>
                        <th class="p-2 border border-gray-300">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['first_name']); ?></td>
                            <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['last_name']); ?></td>
                            <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['contact_no']); ?></td>
                            <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['attendance_status']); ?></td>
                            <td class="p-2 border border-gray-300"><?php echo date("F j, Y, g:i a", strtotime($row['date'])); ?></td> <!-- Use 'date' here -->
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>

</body>
</html>

<?php
$conn->close();
?>
