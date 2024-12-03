<?php
include('../../includes/db.php');  // Adjust the path to your db.php file
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure form fields are set before accessing them
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];  // Use username instead of email
        $password = $_POST['password'];

        // Prepare the SQL query to check the user credentials
        $sql = "SELECT * FROM admins WHERE username = ?";  // Use 'username' column in the query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);  // Use $username for login
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // If user exists and password matches
        if ($user && hash('sha256', $password) === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];  // Store username in session
            header("Location: dashboard.php");  // Redirect to admin dashboard
            exit;
        } else {
            $error = "Invalid login credentials.";  // Show error message if credentials are incorrect
        }
    } else {
        $error = "Please fill in both username and password.";  // Handle case if username or password is missing
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6 bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-bold mb-4">Admin Login</h2>
        <form method="POST" action="" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" class="w-full border border-gray-300 p-2 rounded" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Login</button>
            <?php if ($error): ?>
                <p class="text-red-500"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
