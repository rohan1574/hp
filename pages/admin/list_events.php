<?php
// Include DB connection
include '../../includes/db.php';
include '../../includes/auth.php';  // Optional: To check if the admin is logged in

// Fetch all events
$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>List of Events</title>
</head>
<body>
    <div class="container mx-auto p-6 bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-bold mb-4">Event List</h2>
        <table class="min-w-full bg-white shadow-md rounded-md">
            <thead>
                <tr class="border-b">
                    <th class="px-4 py-2">Event Name</th>
                    <th class="px-4 py-2">Event Date</th>
                    <th class="px-4 py-2">Venue</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($event = $result->fetch_assoc()): ?>
                <tr>
                    <td class="px-4 py-2"><?php echo $event['name']; ?></td>
                    <td class="px-4 py-2"><?php echo $event['date']; ?></td>
                    <td class="px-4 py-2"><?php echo $event['venue']; ?></td>
                    <td class="px-4 py-2"><?php echo $event['description']; ?></td>
                    <td class="px-4 py-2">
                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="text-blue-500">Edit</a>
                        | 
                        <a href="view_event.php?id=<?php echo $event['id']; ?>" class="text-blue-500">View</a>
                        | 
                        <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="text-red-500">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
