<?php
// Include DB connection
include '../../includes/db.php';
session_start(); // Start session for user data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Event Attendees</title>
    <script>
        // Function to toggle the visibility of the form
        function toggleForm() {
            const form = document.getElementById('addForm');
            form.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6 bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-bold mb-4">Event Attendees</h2>

        <!-- Add New Button -->
        <button 
            onclick="toggleForm()" 
            class="bg-blue-600 text-white px-4 py-2 rounded-md mb-4">
            Add New
        </button>

        <!-- Add New Form (hidden by default) -->
        <form 
            id="addForm" 
            method="POST" 
            action="save_attendee.php" 
            class="hidden bg-gray-50 p-4 rounded-md shadow-md">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <!-- Event -->
                <div>
                    <label for="event" class="block text-sm font-medium text-gray-700">Event</label>
                    <input 
                        type="text" 
                        id="event" 
                        name="event" 
                        class="w-full px-4 py-2 border rounded-md" 
                        required>
                </div>
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input 
                        type="text" 
                        id="first_name" 
                        name="first_name" 
                        class="w-full px-4 py-2 border rounded-md" 
                        required>
                </div>
                <!-- Middle Name -->
                <div>
                    <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                    <input 
                        type="text" 
                        id="middle_name" 
                        name="middle_name" 
                        class="w-full px-4 py-2 border rounded-md">
                </div>
                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input 
                        type="text" 
                        id="last_name" 
                        name="last_name" 
                        class="w-full px-4 py-2 border rounded-md" 
                        required>
                </div>
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full px-4 py-2 border rounded-md" 
                        required>
                </div>
                <!-- Contact -->
                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                    <input 
                        type="text" 
                        id="contact" 
                        name="contact" 
                        class="w-full px-4 py-2 border rounded-md" 
                        required>
                </div>
                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea 
                        id="address" 
                        name="address" 
                        class="w-full px-4 py-2 border rounded-md" 
                        required></textarea>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4">
                <button 
                    type="button" 
                    onclick="toggleForm()" 
                    class="px-4 py-2 bg-gray-400 text-white rounded-md">
                    Cancel
                </button>
                <button 
                    type="submit" 
                    name="save" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md">
                    Save
                </button>
            </div>
        </form>

        <!-- Table -->
        <table class="min-w-full bg-white shadow-md rounded-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border border-gray-300">Event</th>
                    <th class="p-2 border border-gray-300">Attendee Name</th>
                    <th class="p-2 border border-gray-300">Gender</th>
                    <th class="p-2 border border-gray-300">Email</th>
                    <th class="p-2 border border-gray-300">Date</th>
                    <th class="p-2 border border-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Add your PHP loop to fetch and display attendees here -->
                <!-- Example row -->
                <tr>
                    <td class="p-2 border border-gray-300">Sample Event</td>
                    <td class="p-2 border border-gray-300">John Doe</td>
                    <td class="p-2 border border-gray-300">Male</td>
                    <td class="p-2 border border-gray-300">john.doe@example.com</td>
                    <td class="p-2 border border-gray-300">2024-12-04</td>
                    <td class="p-2 border border-gray-300">
                        <a href="#" class="text-blue-500">Edit</a> |
                        <a href="#" class="text-red-500">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
