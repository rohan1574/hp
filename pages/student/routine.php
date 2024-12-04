<?php
include('../../includes/db.php');

// Fetch class routine data
$query = "SELECT * FROM class_routine ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Class Routine</title>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Sidebar (if needed, can be reused from admin) -->
    <div class="flex h-screen">
        <aside class="bg-blue-900 text-white w-64 space-y-6 py-7 px-2">
            <div class="text-center text-2xl font-bold">Student Dashboard</div>
            <nav class="space-y-4">
                <a href="dashboard.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Dashboard</a>
                <a href="attendance.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Attendance</a>
                <a href="logout.php" class="block py-2.5 px-4 rounded transition hover:bg-red-800">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Welcome, Student</h1>
                <div class="text-sm text-gray-600">Today is <?php echo date("l, F j, Y"); ?></div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 p-6">
                <h2 class="text-2xl font-bold mb-4">Class Routine</h2>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='bg-white shadow-md p-4 rounded-lg mb-4'>";
                        echo "<h3 class='text-lg font-semibold'>Routine for " . $row['created_at'] . "</h3>";
                        echo "<ul class='space-y-2'>";
                        echo "<li><strong>Bangla Time:</strong> " . $row['bangla_time'] . " | <strong>Teacher:</strong> " . $row['teacher_bangla'] . "</li>";
                        echo "<li><strong>English Time:</strong> " . $row['english_time'] . " | <strong>Teacher:</strong> " . $row['teacher_english'] . "</li>";
                        echo "<li><strong>Math Time:</strong> " . $row['math_time'] . " | <strong>Teacher:</strong> " . $row['teacher_math'] . "</li>";
                        echo "<li><strong>Higher Math Time:</strong> " . $row['higher_math_time'] . " | <strong>Teacher:</strong> " . $row['teacher_higher_math'] . "</li>";
                        echo "<li><strong>Biology Time:</strong> " . $row['biology_time'] . " | <strong>Teacher:</strong> " . $row['teacher_biology'] . "</li>";
                        echo "</ul>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='text-gray-600'>No class routine available.</p>";
                }
                ?>
            </main>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
