<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CTO Bird Study</title>

<style>

/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", sans-serif;
}

/* BODY */
body {
    background: #f5f7f6;
}

/* NAVBAR */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background: rgba(20, 50, 40, 0.95);
    color: white;
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo-circle {
    width: 40px;
    height: 40px;
    background: #2F5D50;
    border-radius: 50%;
}

.nav-links a {
    color: #e5e7eb;
    text-decoration: none;
    margin: 0 15px;
}

.nav-links a:hover {
    color: white;
}

/* HERO */
.hero {
    height: 80vh;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                url("nature.jpg");
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
}

.hero h1 {
    font-size: 48px;
    margin-bottom: 10px;
}

.hero p {
    font-size: 18px;
    color: #e5e7eb;
}

/* SECTION */
.section {
    padding: 60px 40px;
    text-align: center;
}

.section h2 {
    margin-bottom: 20px;
    color: #1f2937;
}

/* FEATURES */
.features {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 30px;
}

.card {
    background: white;
    padding: 25px;
    width: 250px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* BUTTON */
.btn {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 20px;
    background: #2F5D50;
    color: white;
    text-decoration: none;
    border-radius: 8px;
}

.btn:hover {
    background: #244a3f;
}

/* FOOTER */
.footer {
    background: #1f2937;
    color: #d1d5db;
    padding: 20px;
    text-align: center;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">
        <div class="logo-circle"></div>
        <h3>CTO Bird Study</h3>
    </div>

    <div class="nav-links">
        <a href="#">Home</a>
        <a href="#">Register</a>
        <a href="#">Login</a>
        <a href="#">New Post</a>
        <a href="#">Message Board</a>
        <a href="#">Statistics</a>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <div>
        <h1>Explore Birdlife in Centrala</h1>
        <p>Contribute observations and support environmental research</p>
        <a href="#" class="btn">Get Started</a>
    </div>
</div>

<!-- ABOUT -->
<div class="section">
    <h2>About the Project</h2>
    <p>This platform allows citizens and researchers to record and analyze bird observations for environmental conservation.</p>
</div>

<!-- FEATURES -->
<div class="section">
    <h2>Features</h2>

    <div class="features">
        <div class="card">
            <h3>Submit Observations</h3>
            <p>Record bird sightings easily.</p>
        </div>

        <div class="card">
            <h3>View Data</h3>
            <p>Explore collected observations.</p>
        </div>

        <div class="card">
            <h3>Statistics</h3>
            <p>Analyze trends and patterns.</p>
        </div>
    </div>
</div>

<!-- FOOTER -->
<div class="footer">
    <p>© 2026 CTO Bird Study | Environmental Research Platform</p>
</div>

</body>
</html>