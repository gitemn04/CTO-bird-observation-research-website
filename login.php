<?php
session_start();
include "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $message = "<div class='alert error'>Please fill in all fields.</div>";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password_hash"])) {
                unset($_SESSION["logout_message"]);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];

                $message = "<div class='alert success'>Login successful. You are now logged in.</div>";
            } else {
                $message = "<div class='alert error'>Invalid username or password.</div>";
            }
        } else {
            $message = "<div class='alert error'>Invalid username or password.</div>";
        }

        $stmt->close();
    }
}
?>

<?php include "navbar.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - CTO Bird Study</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to bottom, #eef2ef, #f8fbf8);
    color: #1b4332;
}

.page-wrapper {
    min-height: calc(100vh - 90px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 50px 20px;
}

.login-layout {
    width: 100%;
    max-width: 1000px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: white;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 14px 40px rgba(0, 0, 0, 0.10);
}

.login-left {
    background:
        linear-gradient(rgba(15, 61, 46, 0.82), rgba(27, 67, 50, 0.88)),
        url("https://images.unsplash.com/photo-1444464666168-49d633b86797?auto=format&fit=crop&w=1200&q=80");
    background-size: cover;
    background-position: center;
    color: white;
    padding: 60px 45px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-left h1 {
    font-size: 42px;
    line-height: 1.15;
    margin-bottom: 18px;
}

.login-left p {
    font-size: 18px;
    line-height: 1.7;
    color: #edf6ef;
    max-width: 420px;
}

.login-right {
    padding: 50px 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-card {
    width: 100%;
    max-width: 380px;
}

.form-card h2 {
    margin-bottom: 8px;
    font-size: 30px;
    color: #1b4332;
}

.form-card .subtext {
    margin-bottom: 24px;
    color: #5b6d63;
    font-size: 15px;
}

.alert {
    padding: 12px 14px;
    border-radius: 10px;
    margin-bottom: 18px;
    font-size: 14px;
    font-weight: 500;
}

.alert.error {
    background: #fdeaea;
    color: #a12626;
    border: 1px solid #efc2c2;
}

.alert.success {
    background: #e7f7ed;
    color: #1f6b3b;
    border: 1px solid #b7e4c7;
}

.form-group {
    margin-bottom: 16px;
}

label {
    display: block;
    margin-bottom: 7px;
    font-weight: 600;
    color: #1f3b2d;
    font-size: 14px;
}

input {
    width: 100%;
    padding: 13px 14px;
    border-radius: 10px;
    border: 1px solid #ccd5cf;
    font-size: 15px;
    outline: none;
    transition: 0.25s ease;
    box-sizing: border-box;
}

input:focus {
    border-color: #40916c;
    box-shadow: 0 0 0 3px rgba(64, 145, 108, 0.12);
}

button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: #2d6a4f;
    color: white;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.25s ease;
}

button:hover {
    background: #1b4332;
}

.bottom-link {
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
    color: #5b6d63;
}

.bottom-link a {
    color: #2d6a4f;
    text-decoration: none;
    font-weight: 600;
}

.bottom-link a:hover {
    text-decoration: underline;
}

@media (max-width: 900px) {
    .login-layout {
        grid-template-columns: 1fr;
    }

    .login-left {
        min-height: 260px;
        padding: 40px 28px;
    }

    .login-left h1 {
        font-size: 34px;
    }

    .login-right {
        padding: 35px 24px;
    }
}
</style>
</head>
<body>

<div class="page-wrapper">
    <div class="login-layout">
        <div class="login-left">
            <h1>Welcome back to CTO Bird Study</h1>
            <p>
                Sign in to record bird sightings, manage your observations,
                and support environmental research across Centrala.
            </p>
        </div>

        <div class="login-right">
            <div class="form-card">
                <h2>Login</h2>
                <p class="subtext">Enter your username and password to continue.</p>

                <?php
                if (!empty($message)) {
                    echo $message;
                } elseif (isset($_SESSION["logout_message"])) {
                    echo "<div class='alert success'>" . $_SESSION["logout_message"] . "</div>";
                    unset($_SESSION["logout_message"]);
                }
                ?>

                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Enter your username"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >
                    </div>

                    <button type="submit">Login</button>
                </form>

                <div class="bottom-link">
                    Don’t have an account?
                    <a href="register.php">Register here</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>