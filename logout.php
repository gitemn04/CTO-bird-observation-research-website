<?php
session_start();
session_destroy();

// Go back to login page
header("Location: login.php");
exit();
?>