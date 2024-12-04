<?php
include('../../includes/db.php');

$error_message = ''; // Initialize the error message variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = isset($_POST['email']) ? $_POST['email'] : '';  // Use ternary operator to check if email is set
    $password = isset($_POST['password']) ? $_POST['password'] : '';  // Similarly for password

    // SQL query to check if student exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);  // 's' means the email is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        
        // Check if the password matches
        if (password_verify($password, $student['password'])) {
            session_start();
            $_SESSION['student_id'] = $student['id'];  // Store student id in session
            $_SESSION['student_email'] = $student['email'];  // Store student email in session
            header("Location: dashboard.php");  // Redirect to the student dashboard page
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "Student not found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Student Login</title>
</head>
<body class="bg-gray-100 font-sans">

    <div class="max-w-md mx-auto mt-12 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-center text-xl font-bold mb-6">Student Login</h2>

        <?php if (!empty($error_message)) { ?>
            <p class="text-red-500 text-center"><?php echo $error_message; ?></p>
        <?php } ?>

        <form method="POST" action="login.php">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md">Login</button>
        </form>
    </div>

</body>
</html>