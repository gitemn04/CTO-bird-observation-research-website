<?php
include "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    if(strlen($username) < 6){
    die("Username must be at least 6 characters.");
}

if(strlen($password) < 8){
    die("Password must be at least 8 characters.");
}

    // Hash password securely
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Prepare statement (prevents SQL injection)
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password_hash);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Registration successful!</p>";
    } else {
        echo "<p style='color:red;'>Error: Username may already exist.</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<form method="POST" action="">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Register</button>
</form>

</body>
</html>