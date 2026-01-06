<?php
// Destroy all session variables
session_start();
session_destroy();

// Redirect to the main page
header("Location: index.html");
exit();
?>