<?php
session_start();
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CTO Bird Study</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f4f6f3;
    color:#222;
}

img{
    max-width:100%;
    display:block;
}

a{
    text-decoration:none;
}

.container{
    width:min(92%, 1280px);
    margin:0 auto;
}

/* NAVBAR */
.navbar-wrap{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    z-index:20;
}

.navbar{
    width:100%;
    margin:0;
    background:linear-gradient(to right,#0b3225,#0f4a33);
    border-radius:0;
    padding:10px 26px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 4px 16px rgba(0,0,0,0.15);
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
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
    border-radius:8px !important;
}

.nav-cta:hover{
    background:#52b788 !important;
}

/* HERO */
.hero{
    min-height:82vh;
    background:
        linear-gradient(to right, rgba(0,0,0,0.60), rgba(0,0,0,0.20)),
        url('images/hero.jpg');
    background-size:cover;
    background-position:center right;
    display:flex;
    align-items:center;
    padding:90px 0 58px;
    position:relative;
}

.hero-content{
    color:white;
    max-width:610px;
}

.hero h1{
    font-size:4.2rem;
    line-height:1.02;
    margin-bottom:18px;
    font-weight:800;
    letter-spacing:-2px;
}

.hero p{
    font-size:1.12rem;
    line-height:1.75;
    margin-bottom:24px;
    color:#f0f5f0;
    max-width:500px;
}

.hero-buttons{
    display:flex;
    gap:14px;
    flex-wrap:wrap;
}

.btn{
    display:inline-block;
    padding:12px 24px;
    border-radius:10px;
    font-weight:700;
    transition:0.28s ease;
    font-size:0.98rem;
}

.btn-primary{
    background:#2d6a4f;
    color:white;
}

.btn-primary:hover{
    transform:translateY(-2px);
    background:#40916c;
}

.btn-secondary{
    background:white;
    color:#123826;
}

.btn-secondary:hover{
    background:#eaf4ee;
    transform:translateY(-2px);
}

/* FEATURES */
.features{
    margin-top:-34px;
    position:relative;
    z-index:5;
}

.features-grid{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:20px;
}

.feature-link{
    display:block;
    color:inherit;
}

.feature-card{
    background:white;
    padding:22px 20px;
    border-radius:16px;
    text-align:center;
    box-shadow:0 8px 24px rgba(0,0,0,0.08);
    transition:0.28s ease;
    cursor:pointer;
    min-height:185px;
}

.feature-link:hover .feature-card{
    transform:translateY(-8px);
    box-shadow:0 18px 36px rgba(0,0,0,0.12);
}

.feature-icon{
    width:58px;
    height:58px;
    margin:0 auto 12px;
    border-radius:50%;
    background:#eaf4ee;
    color:#2d6a4f;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.35rem;
}

.feature-link:hover .feature-icon{
    background:#dcefe4;
    color:#1b5e42;
}

.feature-card h3{
    font-size:1.1rem;
    margin-bottom:8px;
}

.feature-card p{
    font-size:0.9rem;
    line-height:1.55;
}

/* SECTIONS */
.section{
    padding:52px 0 0;
}

.section-soft{
    background:#eef2ec;
    margin-top:48px;
    padding:48px 0;
}

.section-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    margin-bottom:22px;
}

.section-header h2{
    font-size:1.75rem;
    color:#1b4332;
}

.section-header a{
    color:#2d6a4f;
    font-weight:700;
    font-size:0.95rem;
}

/* SIGHTINGS */
.sightings-grid{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:20px;
}

.sighting-card{
background:white;
border-radius:10px;
overflow:hidden;
box-shadow:0 8px 24px rgba(0,0,0,0.07);
transition:0.3s ease;
}

.sighting-card:hover{
    transform:translateY(-4px);
}

.sighting-image{
width:100%;
height:220px;
object-fit:cover;
object-position:center;
display:block;
}

.sighting-content{
    padding:15px 15px 13px;
}

.sighting-content h3{
    font-size:1.18rem;
    color:#1b4332;
    margin-bottom:10px;
}

.sighting-meta{
    list-style:none;
    margin-bottom:8px;
}

.sighting-meta li{
    color:#55625a;
    margin-bottom:6px;
    font-size:0.92rem;
}

.sighting-footer{
    padding-top:10px;
    border-top:1px solid #edf0ec;
    font-size:0.84rem;
    color:#768178;
}

/* STATS */
.stats{
    padding:36px 0;
    background:white;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:16px;
}

.stat-box{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    padding:8px;
}

.stat-icon{
    width:54px;
    height:54px;
    border:2px solid #8dc9a9;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.25rem;
    color:#1b4332;
    background:#fff;
}

.stat-box h3{
    font-size:1.8rem;
    color:#1b4332;
    line-height:1;
    margin-bottom:4px;
}

.stat-box p{
    color:#5b675e;
    font-size:0.9rem;
}

/* FOOTER */
.footer{
    background:linear-gradient(to right,#0a3124,#0f4a33);
    color:white;
    margin-top:0;
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

.socials{
    display:flex;
    gap:10px;
    margin-top:14px;
}

.social{
    width:34px;
    height:34px;
    border:1px solid rgba(255,255,255,0.26);
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:0.9rem;
}

.footer-bottom{
    text-align:center;
    color:#cfe0d5;
    border-top:1px solid rgba(255,255,255,0.10);
    margin-top:26px;
    padding-top:14px;
    font-size:0.84rem;
}

/* RESPONSIVE */
@media(max-width:1180px){
    .hero h1{
        font-size:3.7rem;
    }

    .features-grid,
    .sightings-grid,
    .stats-grid,
    .footer-grid{
        grid-template-columns:repeat(2, 1fr);
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

    .hero{
        min-height:auto;
        padding:150px 0 58px;
    }

    .hero h1{
        font-size:3rem;
    }

    .hero p{
        font-size:1rem;
    }

    .features{
        margin-top:24px;
    }

    .section-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .features-grid,
    .sightings-grid,
    .stats-grid,
    .footer-grid{
        grid-template-columns:1fr;
    }

    .stat-box{
        justify-content:flex-start;
    }
}

@media(max-width:560px){
    .logo{
        font-size:1.35rem;
    }

    .nav-links a{
        font-size:0.92rem;
    }

    .hero h1{
        font-size:2.45rem;
    }

    .hero-buttons{
        flex-direction:column;
        align-items:flex-start;
    }

    .btn{
        width:100%;
        text-align:center;
    }
}
</style>
</head>

<body>

<?php if (isset($_SESSION["success_message"])): ?>
<div style="
width:90%;
margin:20px auto;
padding:15px;
background:#d1fae5;
color:#065f46;
border:1px solid #10b981;
border-radius:10px;
font-weight:700;
text-align:center;
box-shadow:0 6px 14px rgba(0,0,0,0.08);
">
<?php
echo $_SESSION["success_message"];
unset($_SESSION["success_message"]);
?>
</div>
<?php endif; ?>

<div class="navbar-wrap">
    <nav class="navbar">
        <div class="logo">
            <span class="logo-icon">🐦</span>
            <span>CTO Bird Study</span>
        </div>

        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="#about">About</a>
            <a href="view_posts.php">View Posts</a>
            <a href="create_post.php">New Post</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="register.php" class="nav-cta">Get Started</a>
        </div>
    </nav>
</div>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Explore Birdlife in Centrala</h1>

            <p>
                Share your bird sightings, help track species and support environmental research.
            </p>

            <div class="hero-buttons">
                <a href="register.php" class="btn btn-primary">Get Started</a>
                <a href="view_posts.php" class="btn btn-secondary">View Recent Sightings</a>
            </div>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <div class="features-grid">

            <a href="create_post.php" class="feature-link">
                <div class="feature-card">
                    <div class="feature-icon">🦉</div>
                    <h2>Record Sightings</h2>
                    <p>Submit your bird observations and help build a valuable local dataset.</p>
                </div>
            </a>

            <a href="view_posts.php" class="feature-link">
                <div class="feature-card">
                    <div class="feature-icon">🌿</div>
                    <h3>Support Nature</h3>
                    <p>Your data helps environmental planning for a greener and healthier Centrala.</p>
                </div>
            </a>

            <a href="create_post.php" class="feature-link">
                <div class="feature-card">
                    <div class="feature-icon">📷</div>
                    <h3>Upload Photos</h3>
                    <p>Add optional images to help identify bird species and observation details.</p>
                </div>
            </a>

        </div>
    </div>
</section>

<section class="section section-soft">
<div class="container">

<div class="section-header">
<h2>Recent Sightings</h2>
<a href="view_posts.php">View all posts →</a>
</div>

<div class="sightings-grid">

<div class="sighting-card">
<img class="sighting-image" src="images/blue-tit.jpg" alt="House Sparrow">
<div class="sighting-content">
<h3>Blue Tit</h3>
<ul class="sighting-meta">
<li>📍 Tallan</li>
<li>🌿 Feeding</li>
<li>⏱ 15 mins</li>
</ul>
<div class="sighting-footer">by Emma | 2 hours ago</div>
</div>
</div>

<div class="sighting-card">
<img class="sighting-image" src="images/house-sparrow.jpg" alt="House Sparrow">
<div class="sighting-content">
<h3>House Sparrow</h3>
<ul class="sighting-meta">
<li>📍 Ryall</li>
<li>🌿 Nesting</li>
<li>⏱ 30 mins</li>
</ul>
<div class="sighting-footer">by James | 5 hours ago</div>
</div>
</div>

<div class="sighting-card">
<img class="sighting-image" src="images/wood-pigeon.jpg" alt="Wood Pigeon">
<div class="sighting-content">
<h3>Wood Pigeon</h3>
<ul class="sighting-meta">
<li>📍 Brunad</li>
<li>🌿 Visit</li>
<li>⏱ 10 mins</li>
</ul>
<div class="sighting-footer">by Sarah | 1 day ago</div>
</div>
</div>

</div>
</div>
</section>

<section class="stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-icon">📝</div>
                <div>
                    <h3>350+</h3>
                    <p>Posts</p>
                </div>
            </div>

            <div class="stat-box">
                <div class="stat-icon">👤</div>
                <div>
                    <h3>120+</h3>
                    <p>Members</p>
                </div>
            </div>

            <div class="stat-box">
                <div class="stat-icon">🐦</div>
                <div>
                    <h3>8</h3>
                    <p>Bird Species</p>
                </div>
            </div>

            <div class="stat-box">
                <div class="stat-icon">📍</div>
                <div>
                    <h3>15+</h3>
                    <p>Regions Covered</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer" id="about">
    <div class="container footer-inner">
        <div class="footer-grid">
            <div>
                <h3>About CTO</h3>
                <p>
                    The Centrala Trust for Ornithology (CTO) encourages and supports
                    the observation and conservation of birdlife in and around Centrala.
                </p>

                <div class="socials">
                    <a href="#" class="social">f</a>
                    <a href="#" class="social">t</a>
                    <a href="#" class="social">◎</a>
                </div>
            </div>

            <div>
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#about">About</a></li>
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



