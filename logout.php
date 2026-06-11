<?php
session_start();
session_unset();     // Removes all session variables
session_destroy();   // Destroys the secure login session completely

// Send the user back to the login screen immediately
header("Location: login_form.php");
exit;
?>