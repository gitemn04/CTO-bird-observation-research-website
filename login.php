<?php include "navbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>

body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#f4f6f5;
}

/* CARD */
.container{
    display:flex;
    justify-content:center;
    align-items:center;
    height:80vh;
}

.card{
    background:white;
    padding:30px;
    width:350px;
    border-radius:12px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

/* TITLE */
.card h2{
    text-align:center;
    color:#1b4332;
}

/* INPUTS */
input{
    width:100%;
    padding:10px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#2d6a4f;
    color:white;
    font-size:14px;
    cursor:pointer;
}

button:hover{
    background:#1b4332;
}

</style>

</head>

<body>

<div class="container">
    <div class="card">

        <h2>User Login</h2>

        <form action="login.php" method="POST">

            <input type="text" name="username" placeholder="Enter Username" required>

            <input type="password" name="password" placeholder="Enter Password" required>

            <button type="submit">Login</button>

        </form>

    </div>
</div>

</body>
</html>