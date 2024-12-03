<?php
// Include database connection
include('../includes/db.php');

// Fetch all events from the database
$query = "SELECT * FROM events";  // Assuming your table is named 'events'
$result = mysqli_query($conn, $query);
?>

<table class="min-w-full bg-white border border-gray-300">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b">Event ID</th>
            <th class="py-2 px-4 border-b">Event Name</th>
            <th class="py-2 px-4 border-b">Event Date</th>
            <th class="py-2 px-4 border-b">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Display events
        if (mysqli_num_rows($result) > 0) {
            while ($event = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td class='py-2 px-4 border-b'>" . $event['event_id'] . "</td>";
                echo "<td class='py-2 px-4 border-b'>" . $event['event_name'] . "</td>";
                echo "<td class='py-2 px-4 border-b'>" . $event['event_date'] . "</td>";
                echo "<td class='py-2 px-4 border-b'>
                        <a href='view_event.php?id=" . $event['event_id'] . "' class='text-blue-500'>View</a> | 
                        <a href='edit_event.php?id=" . $event['event_id'] . "' class='text-blue-500'>Edit</a> | 
                        <a href='delete_event.php?id=" . $event['event_id'] . "' class='text-red-500'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center py-4'>No events found</td></tr>";
        }
        ?>
    </tbody>
</table>
