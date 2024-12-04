<?php
include('../../includes/db.php');

// Fetch all users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>List Users</title>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Sidebar -->
    <div class="flex h-screen">
        <aside class="bg-blue-900 text-white w-64 space-y-6 py-7 px-2">
            <div class="text-center text-2xl font-bold">Admin Dashboard</div>
            <nav class="space-y-4">
                <a href="dashboard.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Dashboard</a>
                <a href="add_user.php" class="block py-2.5 px-4 rounded transition hover:bg-blue-800">Add New User</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">List of Users</h1>
            </header>

            <main class="flex-1 p-6">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-2 px-4">First Name</th>
                            <th class="py-2 px-4">Last Name</th>
                            <th class="py-2 px-4">Email</th>
                            <th class="py-2 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($user = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td class='py-2 px-4 border-b'>" . $user['first_name'] . "</td>";
                                echo "<td class='py-2 px-4 border-b'>" . $user['last_name'] . "</td>";
                                echo "<td class='py-2 px-4 border-b'>" . $user['email'] . "</td>";
                                echo "<td class='py-2 px-4 border-b'>
                                        <a href='view_user.php?id=" . $user['id'] . "' class='text-blue-500'>View</a> | 
                                        <a href='edit_user.php?id=" . $user['id'] . "' class='text-blue-500'>Edit</a> | 
                                        <a href='delete_user.php?id=" . $user['id'] . "' class='text-red-500'>Delete</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center py-4'>No users found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>