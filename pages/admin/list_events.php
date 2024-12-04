<?php
// Include DB connection
include '../../includes/db.php';
include '../../includes/auth.php';  // Optional: To check if the admin is logged in

// Start the session to access session variables, but only if a session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch all events from the database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

// Get the logged-in user's email from session, or show 'Guest' if not logged in
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>List of Events</title>
    <script>
        // JavaScript function to toggle the visibility of the input field
        function showInput(eventId) {
            const inputField = document.getElementById('input-' + eventId);
            inputField.classList.toggle('hidden');
        }

        function showRegistrars(eventId) {
            const registrarsList = document.getElementById('registrars-' + eventId);
            registrarsList.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Sidebar -->
    <div class="flex h-screen">

        <aside class="bg-blue-900 text-white w-64 space-y-6 py-7 px-2">
            <div class="text-center text-2xl font-bold">Admin Dashboard</div>
            <nav class="space-y-4">
                <a href="dashboard.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Dashboard</a>
                <a href="list_events.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">List Events</a>
                <a href="add_event.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Add Event</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Event List</h1>
            </header>

            <main class="flex-1 p-6">
                <!-- Event List Table -->
                <table class="min-w-full bg-white shadow-md rounded-md">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2">Event Name</th>
                            <th class="px-4 py-2">Event Date</th>
                            <th class="px-4 py-2">Venue</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($event = $result->fetch_assoc()): ?>
                                <?php
                                    // Get the number of users registered for the event
                                    $eventId = $event['id'];
                                    $countSql = "SELECT COUNT(*) AS total FROM registrations WHERE event_id = $eventId";
                                    $countResult = $conn->query($countSql);
                                    $count = $countResult->fetch_assoc()['total'];

                                    // Get the emails of users registered for this event
                                    $registrarSql = "SELECT user_email FROM registrations WHERE event_id = $eventId";
                                    $registrarResult = $conn->query($registrarSql);
                                    $registrars = [];
                                    while ($registrar = $registrarResult->fetch_assoc()) {
                                        $registrars[] = $registrar['user_email'];
                                    }
                                ?>
                                <tr>
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($event['name']); ?></td>
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($event['date']); ?></td>
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($event['venue']); ?></td>
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($event['description']); ?></td>
                                    <td class="px-4 py-2">
                                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="text-blue-500">Edit</a> |
                                        <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="text-red-500">Delete</a> |
                                        <a href="javascript:void(0);" onclick="showRegistrars(<?php echo $event['id']; ?>)" class="text-blue-500">
                                            Show Registrars (<?php echo $count; ?>)
                                        </a>

                                        <!-- Hidden list of registrars -->
                                        <div id="registrars-<?php echo $event['id']; ?>" class="hidden mt-2">
                                            <ul>
                                                <?php foreach ($registrars as $registrar): ?>
                                                    <li><?php echo htmlspecialchars($registrar); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center">No events found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

</body>
</html>
