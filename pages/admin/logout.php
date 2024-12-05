<?php
// Start the session
session_start();

// Destroy all session data
session_unset();  // Unsets all session variables
session_destroy(); // Destroys the session

// Redirect to the admin login page
header("Location: login.php"); // Change to the correct admin login page if needed
exit();
?>
