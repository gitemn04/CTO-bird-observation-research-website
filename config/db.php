<?php
$conn = new mysqli("localhost", "root", "", "cto_birdboard", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>