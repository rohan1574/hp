<?php
// Start the session
session_start();

// Destroy all session data
session_unset();  // Unsets all session variables
session_destroy(); // Destroys the session

// Redirect to the student login page
header("Location: login.php"); // Adjust the path to the correct student login page if needed
exit();
?>
