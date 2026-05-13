<?php
include "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = trim($_POST["first_name"] ?? "");
    $last_name = trim($_POST["last_name"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $dob = $_POST["dob"] ?? "";
    $region = trim($_POST["region"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    if (
        $first_name === "" ||
        $last_name === "" ||
        $username === "" ||
        $email === "" ||
        $dob === "" ||
        $password === "" ||
        $confirm_password === ""
    ) {
        $message = "<div class='alert error'>Please fill in all required fields.</div>";
    } elseif (strlen($username) < 6) {
        $message = "<div class='alert error'>Username must be at least 6 characters.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert error'>Please enter a valid email address.</div>";
    } elseif (strlen($password) < 8) {
        $message = "<div class='alert error'>Password must be at least 8 characters.</div>";
    } elseif ($password !== $confirm_password) {
        $message = "<div class='alert error'>Passwords do not match.</div>";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $check_result = $check->get_result();

        if ($check_result && $check_result->num_rows > 0) {
            $message = "<div class='alert error'>Username or email already exists.</div>";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                INSERT INTO users
                (first_name, last_name, username, email, dob, region, password_hash)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "sssssss",
                $first_name,
                $last_name,
                $username,
                $email,
                $dob,
                $region,
                $password_hash
            );

            if ($stmt->execute()) {
                $message = "<div class='alert success'>Registration successful! You can now log in.</div>";
            } else {
                $message = "<div class='alert error'>Error creating account. Please try again.</div>";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - CTO Bird Study</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:linear-gradient(to bottom,#eef2ef,#f7faf7);
    color:#1b4332;
}

a{
    text-decoration:none;
}

.navbar{
    width:100%;
    margin:0;
    background:linear-gradient(to right,#0b3225,#0f4a33);
    padding:16px 42px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.14);
    border-radius:0;
}

.logo{
    display:flex;
    align-items:center;
    gap:12px;
    color:white;
    font-weight:700;
    font-size:1.35rem;
}

.logo-icon{
    font-size:2rem;
}

.nav-links{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.nav-links a{
    color:#eef5ef;
    font-size:0.95rem;
    font-weight:500;
    padding:10px 14px;
    border-radius:10px;
    transition:0.25s ease;
}

.nav-links a:hover{
    background:rgba(255,255,255,0.10);
}

.nav-cta{
    background:#40916c;
    color:white !important;
    padding:12px 18px !important;
    font-weight:600 !important;
}

.nav-cta:hover{
    background:#52b788 !important;
}

.page-wrapper{
    min-height:calc(100vh - 110px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px 20px 60px;
}

.register-layout{
    width:100%;
    max-width:1180px;
    display:grid;
    grid-template-columns:1fr 1.1fr;
    background:white;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 18px 48px rgba(0,0,0,0.10);
}

.register-left{
    background:
        linear-gradient(rgba(11,50,37,0.82), rgba(15,74,51,0.86)),
        url("https://images.unsplash.com/photo-1444464666168-49d633b86797?auto=format&fit=crop&w=1200&q=80");
    background-size:cover;
    background-position:center;
    color:white;
    padding:60px 46px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.register-left h1{
    font-size:2.6rem;
    line-height:1.15;
    margin-bottom:18px;
}

.register-left p{
    font-size:1rem;
    line-height:1.8;
    color:#e8f3eb;
    max-width:430px;
}

.register-left ul{
    margin-top:24px;
    padding-left:18px;
    color:#eef7f0;
    line-height:1.9;
}

.register-right{
    padding:42px 38px;
}

.form-card h2{
    font-size:2rem;
    margin-bottom:8px;
    color:#1b4332;
}

.subtext{
    color:#5f6f66;
    margin-bottom:22px;
    font-size:0.96rem;
}

.alert{
    padding:13px 15px;
    border-radius:12px;
    margin-bottom:18px;
    font-size:0.95rem;
    font-weight:500;
}

.alert.error{
    background:#fdeaea;
    color:#a12626;
    border:1px solid #efc2c2;
}

.alert.success{
    background:#e7f6ec;
    color:#1f6a3a;
    border:1px solid #b9e2c6;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.form-group{
    margin-bottom:16px;
}

.form-group.full{
    grid-column:1 / -1;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
    color:#244634;
    font-size:0.93rem;
}

input{
    width:100%;
    padding:13px 14px;
    border-radius:12px;
    border:1px solid #cfd8d1;
    font-size:0.95rem;
    outline:none;
    transition:0.25s ease;
    background:#fff;
}

input:focus{
    border-color:#40916c;
    box-shadow:0 0 0 3px rgba(64,145,108,0.12);
}

button{
    width:100%;
    padding:15px;
    border:none;
    border-radius:12px;
    background:#2d6a4f;
    color:white;
    font-size:1rem;
    font-weight:600;
    cursor:pointer;
    transition:0.25s ease;
    margin-top:6px;
}

button:hover{
    background:#1b4332;
}

.bottom-link{
    text-align:center;
    margin-top:18px;
    font-size:0.94rem;
    color:#617168;
}

.bottom-link a{
    color:#2d6a4f;
    font-weight:600;
}

.bottom-link a:hover{
    text-decoration:underline;
}

@media (max-width: 980px){
    .register-layout{
        grid-template-columns:1fr;
    }

    .register-left{
        min-height:260px;
        padding:42px 28px;
    }

    .register-right{
        padding:34px 24px;
    }
}

@media (max-width: 640px){
    .navbar{
        flex-direction:column;
        gap:14px;
        text-align:center;
    }

    .nav-links{
        justify-content:center;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .register-left h1{
        font-size:2rem;
    }
}
</style>
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <span class="logo-icon">🐦</span>
        <span>CTO Bird Study</span>
    </div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="index.php#about">About</a>
        <a href="view_posts.php">View Posts</a>
        <a href="login.php">Login</a>
        <a href="register.php" class="nav-cta">Register</a>
    </div>
</nav>

<div class="page-wrapper">
    <div class="register-layout">
        <div class="register-left">
            <h1>Join CTO Bird Study</h1>
            <p>
                Create your account to record sightings, contribute to environmental
                research, and become part of a growing bird observation community in Centrala.
            </p>

            <ul>
                <li>Track bird observations professionally</li>
                <li>Upload sightings and support research</li>
                <li>Join a structured conservation platform</li>
            </ul>
        </div>

        <div class="register-right">
            <div class="form-card">
                <h2>Create Account</h2>
                <p class="subtext">Complete the form below to register your member profile.</p>

                <?php echo $message; ?>

                <form method="POST" action="">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" placeholder="Enter your username" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                        </div>

                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" required>
                        </div>

                        <div class="form-group">
                            <label for="region">Region / Location</label>
                            <input type="text" id="region" name="region" placeholder="Optional">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        </div>

                        <div class="form-group full">
                            <button type="submit">Register</button>
                        </div>
                    </div>
                </form>

                <div class="bottom-link">
                    Already have an account?
                    <a href="login.php">Login here</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>