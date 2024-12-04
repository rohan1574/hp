<?php
include('../../includes/db.php');

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the routine details from the database
    $query = "SELECT * FROM class_routine WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Routine not found.";
        exit();
    }
} else {
    echo "No ID provided.";
    exit();
}

// Handle form submission to update the routine
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get updated values from the form
    $day = $_POST['day'];
    $time_start = $_POST['time_start'];
    $time_end = $_POST['time_end'];
    $subject_name = $_POST['subject_name'];
    $teacher_name = $_POST['teacher_name'];

    // Update the class routine in the database
    $update_query = "UPDATE class_routine SET day = ?, time_start = ?, time_end = ?, subject_name = ?, teacher_name = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssi", $day, $time_start, $time_end, $subject_name, $teacher_name, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Class routine updated successfully!'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Class Routine</title>
</head>

<body class="bg-gray-100 font-sans">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
        <h2 class="text-2xl font-bold mb-6">Edit Class Routine</h2>
        <form method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="day" class="block text-sm font-medium text-gray-700">Day</label>
                    <select name="day" id="day" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="" disabled>Select a day</option>
                        <option value="Monday" <?php echo ($row['day'] === 'Monday') ? 'selected' : ''; ?>>Monday</option>
                        <option value="Tuesday" <?php echo ($row['day'] === 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
                        <option value="Wednesday" <?php echo ($row['day'] === 'Wednesday') ? 'selected' : ''; ?>>Wednesday</option>
                        <option value="Thursday" <?php echo ($row['day'] === 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
                        <option value="Friday" <?php echo ($row['day'] === 'Friday') ? 'selected' : ''; ?>>Friday</option>
                    </select>
                </div>
                <div>
                    <label for="time_start" class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" id="time_start" name="time_start" value="<?php echo $row['time_start']; ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="time_end" class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" id="time_end" name="time_end" value="<?php echo $row['time_end']; ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="subject_name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                    <input type="text" id="subject_name" name="subject_name" value="<?php echo $row['subject_name']; ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="teacher_name" class="block text-sm font-medium text-gray-700">Teacher Name</label>
                    <input type="text" id="teacher_name" name="teacher_name" value="<?php echo $row['teacher_name']; ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Update Routine</button>
            </div>
        </form>
    </div>
</body>

</html>
