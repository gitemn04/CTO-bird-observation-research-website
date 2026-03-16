<?php
session_start();
include "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Find user securely (prepared statement = prevents SQL injection)
    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $password_hash);
        $stmt->fetch();

        // Verify hashed password
        if (password_verify($password, $password_hash)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;

            $message = "<p style='color:green;'>Login successful!</p>";
        } else {
            $message = "<p style='color:red;'>Wrong password.</p>";
        }
    } else {
        $message = "<p style='color:red;'>User not found.</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php echo $message; ?>

<form method="POST" action="">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>