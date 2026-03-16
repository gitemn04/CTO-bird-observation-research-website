<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: /CTO_BirdBoard/login.php");
    exit();
}
?>