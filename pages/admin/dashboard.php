<?php
include('../../includes/db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are set in the POST request
    if (isset($_POST['day'], $_POST['time_start'], $_POST['time_end'], $_POST['subject_name'], $_POST['teacher_name'])) {
        $day = $_POST['day'];
        $time_start = $_POST['time_start'];
        $time_end = $_POST['time_end'];
        $subject_name = $_POST['subject_name'];
        $teacher_name = $_POST['teacher_name'];

        // Insert the new class routine into the database
        $insert_query = "INSERT INTO class_routine (day, time_start, time_end, subject_name, teacher_name, created_at) 
                         VALUES ('$day', '$time_start', '$time_end', '$subject_name', '$teacher_name', NOW())";

        if ($conn->query($insert_query) === TRUE) {
            echo "<script>alert('Class routine added successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill all required fields.');</script>";
    }
}

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

                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border">Day</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border">Start-End Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border">Teacher</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Access the new columns time_start and time_end
                                    $time_start = $row['time_start'];
                                    $time_end = $row['time_end'];
                                    $id = $row['id']; // Assuming 'id' is the unique identifier for the routine

                                    // Convert 24-hour format to 12-hour format with AM/PM
                                    $time_start_12hr = date("g:i A", strtotime($time_start));  // 12-hour format
                                    $time_end_12hr = date("g:i A", strtotime($time_end));  // 12-hour format

                                    echo "<tr class='bg-white border-b hover:bg-gray-50'>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-700 border'>" . htmlspecialchars($row['day'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-700 border'>" . htmlspecialchars($time_start_12hr, ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars($time_end_12hr, ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-700 border'>" . htmlspecialchars($row['subject_name'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-700 border'>" . htmlspecialchars($row['teacher_name'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-700 border'>";
                                    // Edit and Delete buttons
                                    echo "<a href='edit_routine.php?id=$id' class='text-blue-500 hover:text-blue-700'>Edit</a> | ";
                                    echo "<a href='delete_routine.php?id=$id' class='text-red-500 hover:text-red-700' onclick='return confirm(\"Are you sure you want to delete this routine?\")'>Delete</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr>";
                                echo "<td colspan='5' class='px-6 py-4 text-center text-gray-500'>No class routine available.</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


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

            <form method="POST" class="bg-white shadow-md rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="day" class="block text-sm font-medium text-gray-700">Day</label>
                        <select name="day" id="day" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="" disabled selected>Select a day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>
                    </div>
                    <div>
                        <label for="time_start" class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="time" id="time_start" name="time_start" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="time_end" class="block text-sm font-medium text-gray-700">End Time</label>
                        <input type="time" id="time_end" name="time_end" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="subject_name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                        <input type="text" id="subject_name" name="subject_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="teacher_name" class="block text-sm font-medium text-gray-700">Teacher Name</label>
                        <input type="text" id="teacher_name" name="teacher_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add Routine</button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>