<?php
// Include DB connection
include '../../includes/db.php';
include '../../includes/auth.php';  // Optional: To check if the admin is logged in

// Check if event ID is provided
if (!isset($_GET['id'])) {
    die("Event ID is required.");
}

$event_id = $_GET['id'];

// Fetch the existing event details
$sql = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    die("Event not found.");
}

// Check if form is submitted for updating event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $description = $_POST['description'];

    // Prepare the SQL query to update event data
    $sql = "UPDATE events SET name = ?, date = ?, venue = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $date, $venue, $description, $event_id);

    // Execute the query
    if ($stmt->execute()) {
        // Event updated successfully
        header("Location: list_events.php");  // Redirect to the list of events
        exit;
    } else {
        // Error handling
        $error = "Error updating event. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Event</title>
</head>
<body>
    <div class="container mx-auto p-6 bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-bold mb-4">Edit Event</h2>
        <?php if (isset($error)): ?>
            <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="edit_event.php?id=<?php echo $event_id; ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Event Name</label>
                <input type="text" name="name" value="<?php echo $event['name']; ?>" required class="w-full border border-gray-300 p-2 rounded">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Event Date</label>
                <input type="date" name="date" value="<?php echo $event['date']; ?>" required class="w-full border border-gray-300 p-2 rounded">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Venue</label>
                <input type="text" name="venue" value="<?php echo $event['venue']; ?>" required class="w-full border border-gray-300 p-2 rounded">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Event Description</label>
                <textarea name="description" required class="w-full border border-gray-300 p-2 rounded"><?php echo $event['description']; ?></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Event</button>
        </form>
    </div>
</body>
</html>
