<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
* {
    box-sizing: border-box;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 48px;
    background: linear-gradient(to right, #0f3d2e, #1b4332);
    color: white;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.12);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.logo a {
    color: white;
    text-decoration: none;
    font-size: 26px;
    font-weight: 700;
    letter-spacing: 0.3px;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
}

.nav-links a {
    color: #f1f5f2;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    padding: 10px 14px;
    border-radius: 10px;
    transition: 0.25s ease;
}

.nav-links a:hover {
    background: rgba(255, 255, 255, 0.10);
    color: #ffffff;
}

.nav-btn {
    background: #40916c;
    color: white !important;
    padding: 10px 18px !important;
    border-radius: 10px;
    font-weight: 600 !important;
}

.nav-btn:hover {
    background: #52b788 !important;
}

.logout-btn {
    background: #c1121f;
    color: white !important;
    padding: 10px 18px !important;
    border-radius: 10px;
    font-weight: 600 !important;
}

.logout-btn:hover {
    background: #a30f1a !important;
}

@media (max-width: 900px) {
    .navbar {
        flex-direction: column;
        gap: 16px;
        padding: 20px;
        text-align: center;
    }

    .nav-links {
        justify-content: center;
    }
}
</style>

<div class="navbar">
    <div class="logo">
        <a href="index.php">CTO Bird Study</a>
    </div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="view_posts.php">View Posts</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="create_post.php">New Post</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php" class="nav-btn">Register</a>
        <?php endif; ?>
    </div>
</div>