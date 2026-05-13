<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "config/db.php";

$search_value = "";
$result = null;

if (isset($_GET["search"]) && trim($_GET["search"]) !== "") {
    $search_value = trim($_GET["search"]);
    $search = "%" . $search_value . "%";

    $stmt = $conn->prepare("
        SELECT posts.*, users.username
        FROM posts
        JOIN users ON posts.user_id = users.id
        WHERE bird_species LIKE ? OR comments LIKE ? OR location LIKE ?
        ORDER BY posts.created_at DESC
    ");
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("
        SELECT posts.*, users.username
        FROM posts
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC
    ");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Posts - CTO Bird Study</title>
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
    background:#f4f6f3;
    color:#1e293b;
}

a{
    text-decoration:none;
}

img{
    max-width:100%;
    display:block;
}

.container{
    width:min(92%, 1280px);
    margin:0 auto;
}

/* ALERT MESSAGE */
.alert{
    padding:14px 16px;
    border-radius:14px;
    margin:0 0 22px;
    font-size:0.96rem;
    font-weight:600;
}

.alert.success{
    background:#e7f7ed;
    color:#1f6b3b;
    border:1px solid #b7e4c7;
}

/* NAVBAR */
.navbar-wrap{
    padding-top:0;
}

.navbar{
    width:100%;
    margin:0;
    background:linear-gradient(to right,#0b3225,#0f4a33);
    border-radius:0;
    padding:14px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 4px 14px rgba(0,0,0,0.15);
}

.logo{
    display:flex;
    align-items:center;
    gap:12px;
    color:white;
    font-weight:700;
    font-size:1.65rem;
}

.logo-icon{
    font-size:2rem;
}

.nav-links{
    display:flex;
    align-items:center;
    gap:8px;
    flex-wrap:wrap;
}

.nav-links a{
    color:#eef5ef;
    font-size:1rem;
    font-weight:600;
    padding:8px 10px;
    border-radius:8px;
    transition:0.25s ease;
}

.nav-links a:hover{
    background:rgba(255,255,255,0.10);
}

.nav-cta{
    background:#40916c;
    color:white !important;
    padding:8px 16px !important;
    font-weight:700 !important;
    border-radius:8px;
}

/* HERO */
.page-hero{
    margin:24px auto 26px;
    width:min(96%, 1380px);
    min-height:340px;
    display:flex;
    align-items:center;
    padding:60px;
    color:white;
    border-radius:0;
    overflow:hidden;
    background:
    linear-gradient(to right, rgba(0,0,0,0.72), rgba(0,0,0,0.20)),
    url('images/view-heroo.jpg');
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
}

.page-hero-content{
    padding:46px;
    color:white;
    max-width:640px;
}

.page-hero-content h1{
    font-size:3.1rem;
    line-height:1.05;
    margin-bottom:14px;
    font-weight:800;
}

.page-hero-content p{
    font-size:1.04rem;
    line-height:1.8;
    color:#edf6ef;
}

/* SEARCH */
.search-section{
    margin-bottom:26px;
}

.search-box{
    background:white;
    border-radius:18px;
    box-shadow:0 10px 26px rgba(0,0,0,0.06);
    padding:18px;
    display:flex;
    gap:12px;
    align-items:center;
    flex-wrap:wrap;
}

.search-box input{
    flex:1;
    min-width:260px;
    padding:14px 16px;
    border:1px solid #d4ddd6;
    border-radius:12px;
    font-size:0.98rem;
    outline:none;
    transition:0.25s ease;
    font-family:'Poppins',sans-serif;
}

.search-box input:focus{
    border-color:#40916c;
    box-shadow:0 0 0 3px rgba(64,145,108,0.10);
}

.search-box button{
    padding:14px 22px;
    border:none;
    border-radius:12px;
    background:#2d6a4f;
    color:white;
    font-size:0.98rem;
    font-weight:600;
    cursor:pointer;
    transition:0.25s ease;
    font-family:'Poppins',sans-serif;
}

.search-box button:hover{
    background:#1b4332;
}

.clear-link{
    color:#2d6a4f;
    font-weight:700;
    padding:10px 4px;
}

/* SECTION HEAD */
.section-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:14px;
    margin-bottom:18px;
}

.section-header h2{
    font-size:2rem;
    color:#1b4332;
}

.result-note{
    color:#5f6e65;
    font-size:0.94rem;
    font-weight:500;
}

/* POSTS GRID */
.posts-grid{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:24px;
    margin-bottom:50px;
}

.post-card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 28px rgba(0,0,0,0.08);
    transition:0.28s ease;
}

.post-card:hover{
    transform:translateY(-6px);
    box-shadow:0 18px 36px rgba(0,0,0,0.12);
}

.post-image{
    width:100%;
    height:220px;
    object-fit:cover;
    background:#eef2ec;
}

.post-body{
    padding:20px;
}

.post-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:12px;
    margin-bottom:12px;
}

.post-top h3{
    font-size:1.38rem;
    color:#1b4332;
    line-height:1.2;
}

.badge{
    background:#e8f3ec;
    color:#2d6a4f;
    border-radius:999px;
    padding:7px 11px;
    font-size:0.76rem;
    font-weight:700;
    white-space:nowrap;
}

.post-meta{
    display:grid;
    gap:8px;
    margin-bottom:14px;
}

.meta-item{
    color:#55625a;
    font-size:0.94rem;
    line-height:1.55;
}

.comments-box{
    margin-top:10px;
    background:#f6f8f6;
    border-radius:14px;
    padding:12px 13px;
    color:#4b5a51;
    font-size:0.92rem;
    line-height:1.65;
}

.post-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    border-top:1px solid #edf0ec;
    margin-top:16px;
    padding-top:14px;
    flex-wrap:wrap;
}

.author{
    color:#6a776f;
    font-size:0.9rem;
}

.actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.action-btn{
    display:inline-block;
    padding:9px 14px;
    border-radius:10px;
    font-size:0.87rem;
    font-weight:600;
    transition:0.25s ease;
}

.edit-btn{
    background:#e8f3ec;
    color:#1f6a3a;
}

.edit-btn:hover{
    background:#d6ecdf;
}

.delete-btn{
    background:#fdeaea;
    color:#a12626;
}

.delete-btn:hover{
    background:#f9d7d7;
}

/* EMPTY STATE */
.empty-state{
    background:white;
    border-radius:22px;
    box-shadow:0 10px 26px rgba(0,0,0,0.06);
    padding:48px 28px;
    text-align:center;
    margin-bottom:50px;
}

.empty-state h3{
    font-size:1.6rem;
    color:#1b4332;
    margin-bottom:10px;
}

.empty-state p{
    color:#637168;
    line-height:1.8;
    max-width:560px;
    margin:0 auto 18px;
}

.empty-state a{
    display:inline-block;
    background:#2d6a4f;
    color:white;
    padding:13px 22px;
    border-radius:12px;
    font-weight:600;
}

/* FOOTER */
.footer{
    background:linear-gradient(to right,#0a3124,#0f4a33);
    color:white;
    margin-top:20px;
}

.footer-inner{
    padding:40px 0 18px;
}

.footer-grid{
    display:grid;
    grid-template-columns:1.5fr 1fr 1.1fr;
    gap:30px;
}

.footer h3{
    font-size:1.18rem;
    margin-bottom:12px;
}

.footer p,
.footer li,
.footer a{
    color:#d6e4da;
    line-height:1.8;
    font-size:0.92rem;
}

.footer ul{
    list-style:none;
}

.footer a:hover{
    color:white;
}

.footer-bottom{
    text-align:center;
    color:#cfe0d5;
    border-top:1px solid rgba(255,255,255,0.10);
    margin-top:26px;
    padding-top:14px;
    font-size:0.84rem;
}

@media(max-width:1100px){
    .posts-grid,
    .footer-grid{
        grid-template-columns:repeat(2, 1fr);
    }

    .page-hero-content h1{
        font-size:2.6rem;
    }
}

@media(max-width:900px){
    .navbar{
        flex-direction:column;
        gap:12px;
        padding:14px 16px;
    }

    .nav-links{
        justify-content:center;
    }

    .posts-grid,
    .footer-grid{
        grid-template-columns:1fr;
    }

    .section-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .page-hero-content{
        padding:34px 24px;
    }

    .page-hero-content h1{
        font-size:2.15rem;
    }
}

@media(max-width:560px){
    .logo{
        font-size:1.35rem;
    }

    .nav-links a{
        font-size:0.92rem;
    }

    .search-box input,
    .search-box button{
        width:100%;
    }
}
</style>
</head>
<body>

<div class="navbar-wrap">
    <nav class="navbar">
        <div class="logo">
            <span class="logo-icon">🐦</span>
            <span>CTO Bird Study</span>
        </div>

        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="index.php#about">About</a>
            <a href="view_posts.php">View Posts</a>
            <a href="create_post.php">New Post</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php" class="nav-cta">Register</a>
            <?php endif; ?>
        </div>
    </nav>
</div>

<section class="page-hero">
    <div class="page-hero-content">
        <h1>All Bird Observations</h1>
        <p>
            Browse community sightings, search for species and review recent observations
            submitted across Centrala.
        </p>
    </div>
</section>

<div class="container">

<?php
if (isset($_SESSION["delete_message"])) {
    echo "<div class='alert success'>" . $_SESSION["delete_message"] . "</div>";
    unset($_SESSION["delete_message"]);
}
?>

<section class="search-section">
    <form method="GET" class="search-box">
        <input
            type="text"
            name="search"
            placeholder="Search by species, comment or location"
            value="<?php echo htmlspecialchars($search_value); ?>"
        >
        <button type="submit">Search</button>

        <?php if ($search_value !== ""): ?>
            <a class="clear-link" href="view_posts.php">Clear</a>
        <?php endif; ?>

    </form>
</section>

    <div class="section-header">
        <h2>Recent Sightings</h2>
        <div class="result-note">
            <?php echo ($search_value !== "") ? "Showing results for: " . htmlspecialchars($search_value) : "Showing all posts"; ?>
        </div>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="posts-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post-card">
                    <?php if (!empty($row["image_path"])): ?>
                        <img class="post-image" src="<?php echo htmlspecialchars($row["image_path"]); ?>" alt="Bird image">
                    <?php else: ?>
                        <img class="post-image" src="images/house-sparrow.jpeg" alt="Bird image">
                    <?php endif; ?>

                    <div class="post-body">
                        <div class="post-top">
                            <h3><?php echo htmlspecialchars($row["bird_species"]); ?></h3>
                            <span class="badge"><?php echo htmlspecialchars($row["duration_minutes"]); ?> mins</span>
                        </div>

                        <div class="post-meta">
                            <div class="meta-item">📍 <strong>Location:</strong> <?php echo htmlspecialchars($row["location"]); ?></div>
                            <div class="meta-item">📅 <strong>Date:</strong> <?php echo htmlspecialchars($row["date_of_observation"]); ?></div>
                            <div class="meta-item">⏰ <strong>Time:</strong> <?php echo htmlspecialchars($row["time_of_observation"]); ?></div>
                            <div class="meta-item">🌿 <strong>Activity:</strong> <?php echo htmlspecialchars($row["primary_activity"]); ?></div>
                        </div>

                        <div class="comments-box">
                            <strong>Comments:</strong><br>
                            <?php echo nl2br(htmlspecialchars($row["comments"])); ?>
                        </div>

                        <div class="post-footer">
                            <div class="author">
                                by <?php echo htmlspecialchars($row["username"]); ?>
                            </div>

                            <div class="actions">
                                <a class="action-btn edit-btn" href="edit_post.php?id=<?php echo $row["id"]; ?>">Edit</a>
                                <a class="action-btn delete-btn" href="delete_post.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h3>No bird observations found</h3>
            <p>
                There are currently no matching posts to display. Start by creating a new bird
                observation and your records will appear here in a styled card layout.
            </p>
            <a href="create_post.php">Create First Post</a>
        </div>
    <?php endif; ?>
</div>

<footer class="footer">
    <div class="container footer-inner">
        <div class="footer-grid">
            <div>
                <h3>About CTO</h3>
                <p>
                    The Centrala Trust for Ornithology supports bird observation,
                    conservation, and environmental research in and around Centrala.
                </p>
            </div>

            <div>
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="view_posts.php">View Posts</a></li>
                    <li><a href="create_post.php">New Post</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </div>

            <div>
                <h3>Contact</h3>
                <p>✉ info@cto-birdstudy.org</p>
                <p>☎ +44 123 456 7890</p>
                <p>📍 Centrala, Country</p>
            </div>
        </div>

        <div class="footer-bottom">
            © 2025 CTO Bird Study. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>