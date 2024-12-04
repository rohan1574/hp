<?php
include('../../includes/db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data
    $bangla_time = $_POST['bangla_time'];
    $english_time = $_POST['english_time'];
    $math_time = $_POST['math_time'];
    $higher_math_time = $_POST['higher_math_time'];
    $biology_time = $_POST['biology_time'];

    $teacher_bangla = $_POST['teacher_bangla'];
    $teacher_english = $_POST['teacher_english'];
    $teacher_math = $_POST['teacher_math'];
    $teacher_higher_math = $_POST['teacher_higher_math'];
    $teacher_biology = $_POST['teacher_biology'];

    // Insert data into the database
    $query = "INSERT INTO class_routine (bangla_time, english_time, math_time, higher_math_time, biology_time, 
            teacher_bangla, teacher_english, teacher_math, teacher_higher_math, teacher_biology) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss", $bangla_time, $english_time, $math_time, $higher_math_time, $biology_time,
                                      $teacher_bangla, $teacher_english, $teacher_math, $teacher_higher_math, $teacher_biology);

    if ($stmt->execute()) {
        // Display success message
        $message = "Routine saved successfully!";
    } else {
        // Display error message
        $message = "Error saving routine!";
    }

    $stmt->close();
}

// Fetch routine data for display (optional)
$query = "SELECT * FROM class_routine ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleModal() {
            const modal = document.getElementById('routine-modal');
            modal.classList.toggle('hidden');
        }
    </script>
    <script>
        // JavaScript function to toggle sub-menu visibility
        function toggleSubMenu(id) {
            const submenu = document.getElementById(id);
            submenu.classList.toggle('hidden');
        }
    </script>
    <title>Admin Dashboard</title>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Sidebar -->
    <div class="flex h-screen">
        <aside class="bg-blue-900 text-white w-64 space-y-6 py-7 px-2">
            <div class="text-center text-2xl font-bold">Admin Dashboard</div>
            <nav class="space-y-4">
                <!-- Menu items -->
                <a href="dashboard.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Dashboard</a>
                 <!-- Events Menu -->
                 <div>
                    <button onclick="toggleSubMenu('events-menu')" class="block py-2.5 px-4 rounded transition hover:bg-blue-800 w-full text-left">
                        Events
                    </button>
                    <div id="events-menu" class="hidden pl-4">
                        <a href="add_event.php" class="block py-2 px-4 rounded transition hover:bg-blue-700">Add New</a>
                        <a href="list_events.php" class="block py-2 px-4 rounded transition hover:bg-blue-700">List</a>
                    </div>
                </div>
                
                <!-- Users Menu -->
                <div>
                    <button onclick="toggleSubMenu('users-menu')" class="block py-2.5 px-4 rounded transition hover:bg-blue-800 w-full text-left">
                        Users
                    </button>
                    <div id="users-menu" class="hidden pl-4">
                        <a href="add_user.php" class="block py-2 px-4 rounded transition hover:bg-blue-700">Add New</a>
                        <a href="list_users.php" class="block py-2 px-4 rounded transition hover:bg-blue-700">List</a>
                    </div>
                </div>
                <a href="javascript:void(0)" onclick="toggleModal()" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Class Routine</a>
                <a href="attendance.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Attendance</a>
                <a href="logout.php" class="block py-2.5 px-4 rounded transition hover:bg-red-800">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Welcome, Admin</h1>
                <div class="text-sm text-gray-600">Today is <?php echo date("l, F j, Y"); ?></div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 p-6">
                <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
                <p class="text-gray-700">Welcome to the admin dashboard. Use the sidebar to navigate through the application.</p>

                <!-- Display success or error message -->
                <?php if (isset($message)) : ?>
                    <p class="text-green-500"><?php echo $message; ?></p>
                <?php endif; ?>

                <!-- Display Class Routine Data -->
                <h3 class="text-xl font-semibold mt-8">Class Routine</h3>
                <table class="w-full border-collapse mt-4">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 border border-gray-300">Bangla Time</th>
                            <th class="p-2 border border-gray-300">English Time</th>
                            <th class="p-2 border border-gray-300">Math Time</th>
                            <th class="p-2 border border-gray-300">Higher Math Time</th>
                            <th class="p-2 border border-gray-300">Biology Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr class="hover:bg-gray-100">
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['bangla_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['english_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['math_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['higher_math_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($row['biology_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <!-- Modal for Class Routine Form -->
    <div id="routine-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Class Routine</h3>
                <button onclick="toggleModal()" class="text-xl text-gray-500">&times;</button>
            </div>
            
            <form action="" method="POST">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- Time and Teacher Inputs -->
                    <div>
                        <label for="bangla_time" class="block text-sm font-medium text-gray-700">Bangla Time</label>
                        <input type="text" id="bangla_time" name="bangla_time" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="english_time" class="block text-sm font-medium text-gray-700">English Time</label>
                        <input type="text" id="english_time" name="english_time" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="math_time" class="block text-sm font-medium text-gray-700">Math Time</label>
                        <input type="text" id="math_time" name="math_time" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="higher_math_time" class="block text-sm font-medium text-gray-700">Higher Math Time</label>
                        <input type="text" id="higher_math_time" name="higher_math_time" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="biology_time" class="block text-sm font-medium text-gray-700">Biology Time</label>
                        <input type="text" id="biology_time" name="biology_time" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- Teacher Inputs -->
                    <div>
                        <label for="teacher_bangla" class="block text-sm font-medium text-gray-700">Teacher for Bangla</label>
                        <input type="text" id="teacher_bangla" name="teacher_bangla" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="teacher_english" class="block text-sm font-medium text-gray-700">Teacher for English</label>
                        <input type="text" id="teacher_english" name="teacher_english" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="teacher_math" class="block text-sm font-medium text-gray-700">Teacher for Math</label>
                        <input type="text" id="teacher_math" name="teacher_math" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="teacher_higher_math" class="block text-sm font-medium text-gray-700">Teacher for Higher Math</label>
                        <input type="text" id="teacher_higher_math" name="teacher_higher_math" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label for="teacher_biology" class="block text-sm font-medium text-gray-700">Teacher for Biology</label>
                        <input type="text" id="teacher_biology" name="teacher_biology" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg">Save Routine</button>
            </form>
        </div>
    </div>
</body>
</html>
