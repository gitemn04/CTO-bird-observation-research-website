<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>

<style>
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    background:linear-gradient(to right,#2b4f81,#3a6edc);
    color:white;
}

.logo{
    font-size:20px;
    font-weight:600;
}

.nav-links{
    display:flex;
    align-items:center;
    gap:20px;
}

.nav-links a{
    color:white;
    text-decoration:none;
    font-size:14px;
    transition:0.3s;
}

.nav-links a:hover{
    opacity:0.8;
}

.nav-btn{
    padding:6px 12px;
    border-radius:6px;
    background:rgba(255,255,255,0.15);
}

.logout{
    background:#d62828;
}
</style>

<div class="navbar">

    <div class="logo">CTO Bird Study</div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="create_post.php">New Post</a>
        <a href="messageboard.php">Message Board</a>
        <a href="view_posts.php">View Posts</a>
        <a href="statistics.php">Statistics</a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="nav-btn logout">Logout</a>
        <?php else: ?>
            <a href="login.php" class="nav-btn">Login</a>
            <a href="register.php" class="nav-btn">Register</a>
        <?php endif; ?>
    </div>

</div>