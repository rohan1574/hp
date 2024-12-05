<?php
include('../../includes/db.php');  // Adjust the path to your db.php file
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && hash('sha256', $password) === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid login credentials.";
        }
    } else {
        $error = "Please fill in both username and password.";
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
    <style>
        body {
            background-image: url('https://img.freepik.com/premium-photo/wideangle-photography-view-university-main-building-large-building-with-green-lawn-grass-field_551880-7790.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Animation for moving colors */
        @keyframes color-animation {
            0% {
                border-color: rgb(255, 0, 0);
                background-color: rgba(255, 0, 0, 0.1);
            }

            33% {
                border-color: rgb(0, 255, 0);
                background-color: rgba(0, 255, 0, 0.1);
            }

            66% {
                border-color: rgb(0, 0, 255);
                background-color: rgba(0, 0, 255, 0.1);
            }

            100% {
                border-color: rgb(255, 0, 0);
                background-color: rgba(255, 0, 0, 0.1);
            }
        }

        /* Applying animations */
        .animated-border {
            border-width: 6px;
            animation: color-animation 2s linear infinite;
        }

        .animated-input:hover {
            animation: color-animation 2s linear infinite;
        }

        /* RGB Colors for text */
        .text-admin {
            color: rgb(255, 0, 0);
            /* Red */
        }

        .text-username {
            color: rgb(0, 255, 0);
            /* Green */
        }

        .text-password {
            color: rgb(0, 0, 255);
            /* Blue */
        }

        .text-login {
            color: rgb(255, 165, 0);
            /* Orange */
        }
    </style>
</head>

<body class="bg-gray-50 font-sans min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full bg-opacity-90">
        <h2 class="text-2xl font-bold text-admin text-center mb-6">Admin Login</h2>
        <form method="POST" action="" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-username mb-1">Username</label>
                <input
                    type="text"
                    name="username"
                    class="w-full border rounded p-3  focus:outline-none animated-border animated-input"
                    placeholder="Enter your username"
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium text-password mb-1">Password</label>
                <input
                    type="password"
                    name="password"
                    class="w-full border rounded p-3 focus:outline-none animated-border animated-input"
                    placeholder="Enter your password"
                    required>
            </div>
            <div>
            <label class="block text-sm font-medium text-login mb-1">Login</label>
                <button
                    type="submit"
                    class="w-full border text-red-500 text-xl rounded p-3 focus:outline-none animated-border animated-input">
                    Login
                </button>
            </div>
            <?php if ($error): ?>
                <p class="text-red-500 text-sm mt-4 text-center"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
        <p class="mt-6 text-gray-500 text-sm text-center">© 2024 Your Company. All rights reserved.</p>
    </div>
</body>

</html>