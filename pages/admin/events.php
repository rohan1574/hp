<?php
include '../../includes/db.php';
include '../../includes/auth.php';
redirectToLogin();

$sql = "SELECT * FROM events";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo $row['name'] . " - " . $row['date'] . " - " . $row['venue'];
    echo "<a href='edit_event.php?id=" . $row['id'] . "'>Edit</a>";
    echo "<a href='delete_event.php?id=" . $row['id'] . "'>Delete</a><br>";
}
?>
