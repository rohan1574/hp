<?php
// Include DB connection
include '../../includes/db.php';
include '../../includes/auth.php';  // Optional: To check if the admin is logged in

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $description = $_POST['description'];

    // Prepare the SQL query to insert event data
    $sql = "INSERT INTO events (name, date, venue, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $date, $venue, $description);

    // Execute the query
    if ($stmt->execute()) {
        // Event added successfully
        header("Location: list_events.php");  // Redirect to the list of events
        exit;
    } else {
        // Error handling
        $error = "Error adding event. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add Event</title>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
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
        <div class="flex-1 p-6">
            <div class="container mx-auto p-6 bg-white shadow-md rounded-md">
                <h2 class="text-2xl font-bold mb-4">Add New Event</h2>
                <?php if (isset($error)): ?>
                    <p class="text-red-500"><?php echo $error; ?></p>
                <?php endif; ?>
                <form action="add_event.php" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Event Name</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Event Date</label>
                        <input type="date" name="date" required class="w-full border border-gray-300 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Venue</label>
                        <input type="text" name="venue" required class="w-full border border-gray-300 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Event Description</label>
                        <textarea name="description" required class="w-full border border-gray-300 p-2 rounded"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Event</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>