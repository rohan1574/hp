<?php
include('../../includes/db.php');

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch attendance records with pagination
$query = "SELECT * FROM attendance ORDER BY date DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Attendance Records</title>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="bg-blue-900 text-white w-64 py-7 px-6 space-y-8">
            <div class="text-center text-2xl font-bold">Admin Dashboard</div>
            <nav class="space-y-4">
                <a href="dashboard.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Dashboard</a>
                <a href="add_event.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Add Event</a>
                <a href="list_events.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Event List</a>
                <a href="attendance.php" class="block py-2.5 px-4 rounded transition bg-blue-800">Attendance Records</a>
                <a href="logout.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <header class="bg-white shadow-md p-4 flex justify-between items-center mb-4">
                <h1 class="text-xl font-bold">Attendance Records</h1>
            </header>

            <main class="p-6 bg-white shadow-md rounded-md">
                <h2 class="text-2xl font-bold mb-4">Attendance List</h2>
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
                            <tr class="hover:bg-gray-100">
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['contact_no'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['attendance_status'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-2 border border-gray-300"><?php echo date("F j, Y, g:i a", strtotime($row['date'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <nav class="mt-4">
                    <a href="?page=<?php echo max(1, $page - 1); ?>" class="px-4 py-2 bg-gray-300 rounded">Previous</a>
                    <a href="?page=<?php echo $page + 1; ?>" class="px-4 py-2 bg-gray-300 rounded">Next</a>
                </nav>
            </main>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>
