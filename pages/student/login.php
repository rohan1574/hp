<?php
include('../../includes/db.php');

$error_message = ''; // Initialize the error message variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? ''; 
    $password = $_POST['password'] ?? '';

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        if (password_verify($password, $student['password'])) {
            session_start();
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_email'] = $student['email'];
            header("Location: dashboard.php");
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
    <title>Student Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/College_Full_view-1.jpg/1280px-College_Full_view-1.jpg');
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
    <h2 class="text-2xl font-bold text-admin text-center mb-6">Student Login</h2>

        <?php if (!empty($error_message)) { ?>
            <p class="text-red-500 text-center"><?php echo $error_message; ?></p>
        <?php } ?>

        <form method="POST" action="login.php" class="space-y-6">
            <div>
            <label for="email" class="block text-sm font-medium text-username mb-1">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="w-full border rounded p-3 focus:outline-none animated-border animated-input" 
                    placeholder="Enter your email" 
                    required>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-password mb-1">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
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
        </form>

        <p class="mt-6 text-gray-500 text-sm text-center">© 2024 Your University. All rights reserved.</p>
    </div>
</body>
</html>
