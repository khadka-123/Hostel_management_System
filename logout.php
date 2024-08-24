<!-- End the session and reload in login page -->
<?php

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit; // Ensure that no further code is executed after the redirect
?>