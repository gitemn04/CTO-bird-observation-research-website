<?php
include "config/auth.php";
include "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION["user_id"];
    $location = trim($_POST["location"] ?? "");
    $date = $_POST["date_of_observation"] ?? "";
    $time = $_POST["time_of_observation"] ?? "";
    $species = trim($_POST["bird_species"] ?? "");
    $activity = trim($_POST["primary_activity"] ?? "");
    $duration = $_POST["duration_minutes"] ?? "";
    $comments = substr(trim($_POST["comments"] ?? ""), 0, 500);

    if (
        empty($location) ||
        empty($date) ||
        empty($time) ||
        empty($species) ||
        empty($activity) ||
        empty($duration)
    ) {
        $message = "<div class='alert error'>All required fields must be filled.</div>";
    } elseif (!is_numeric($duration) || $duration <= 0) {
        $message = "<div class='alert error'>Duration must be a positive number.</div>";
    } else {

        $image_path = NULL;

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

            $allowed_types = ["image/jpeg", "image/png"];
            $file_type = $_FILES["image"]["type"];
            $file_size = $_FILES["image"]["size"];

            if (in_array($file_type, $allowed_types) && $file_size <= 1200000) {

                $file_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_path = "uploads/" . $file_name;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
                    $image_path = $target_path;
                }

            } else {
                $message = "<div class='alert error'>Invalid file type or file too large (max 1.2MB).</div>";
            }
        }

        if ($message === "") {
            $stmt = $conn->prepare("
                INSERT INTO posts
                (user_id, location, date_of_observation, time_of_observation, bird_species, primary_activity, duration_minutes, comments, image_path)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "issssssis",
                $user_id,
                $location,
                $date,
                $time,
                $species,
                $activity,
                $duration,
                $comments,
                $image_path
            );

            if ($stmt->execute()) {
                $message = "<div class='alert success'>Post created successfully!</div>";
            } else {
                $message = "<div class='alert error'>Error creating post.</div>";
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Post - CTO Bird Study</title>
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
    padding:14px 36px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 8px 24px rgba(0,0,0,0.14);
    border-radius:0;
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

.nav-cta:hover{
    background:#52b788 !important;
}

.page-wrapper{
    min-height:calc(100vh - 100px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:38px 20px 60px;
}

.form-layout{
    width:100%;
    max-width:1180px;
    display:grid;
    grid-template-columns:1fr 1.08fr;
    background:white;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 18px 48px rgba(0,0,0,0.10);
}

.form-left{
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

.form-left h1{
    font-size:2.45rem;
    line-height:1.15;
    margin-bottom:18px;
}

.form-left p{
    font-size:1rem;
    line-height:1.8;
    color:#e8f3eb;
    max-width:430px;
}

.form-left ul{
    margin-top:24px;
    padding-left:18px;
    color:#eef7f0;
    line-height:1.9;
}

.form-right{
    padding:40px 36px;
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

input,
select,
textarea{
    width:100%;
    padding:13px 14px;
    border-radius:12px;
    border:1px solid #cfd8d1;
    font-size:0.95rem;
    outline:none;
    transition:0.25s ease;
    background:#fff;
    font-family:'Poppins',sans-serif;
}

input:focus,
select:focus,
textarea:focus{
    border-color:#40916c;
    box-shadow:0 0 0 3px rgba(64,145,108,0.12);
}

textarea{
    min-height:120px;
    resize:vertical;
}

.file-note{
    margin-top:8px;
    font-size:0.84rem;
    color:#6a776f;
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
    margin-top:4px;
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
    .form-layout{
        grid-template-columns:1fr;
    }

    .form-left{
        min-height:260px;
        padding:42px 28px;
    }

    .form-right{
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

    .form-left h1{
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
        <a href="create_post.php">New Post</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="page-wrapper">
    <div class="form-layout">
        <div class="form-left">
            <h1>Create a Bird Observation</h1>
            <p>
                Submit a new sighting with location, bird species, activity,
                observation length and an optional image upload for CTO records.
            </p>

            <ul>
                <li>Choose from the official Centrala region list</li>
                <li>Select a CTO bird species or Other/Unknown</li>
                <li>Upload an optional JPG or PNG image</li>
            </ul>
        </div>

        <div class="form-right">
            <div class="form-card">
                <h2>New Observation</h2>
                <p class="subtext">Complete the form below to add a bird sighting to the message board.</p>

                <?php echo $message; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" required>
                                <option value="">Select a region</option>
                                <option value="Erean">Erean</option>
                                <option value="Brunad">Brunad</option>
                                <option value="Bylyn">Bylyn</option>
                                <option value="Docia">Docia</option>
                                <option value="Marend">Marend</option>
                                <option value="Pryn">Pryn</option>
                                <option value="Zord">Zord</option>
                                <option value="Yaean">Yaean</option>
                                <option value="Frestin">Frestin</option>
                                <option value="Stonyam">Stonyam</option>
                                <option value="Ryall">Ryall</option>
                                <option value="Ruril">Ruril</option>
                                <option value="Keivia">Keivia</option>
                                <option value="Tallan">Tallan</option>
                                <option value="Adohad">Adohad</option>
                                <option value="Obelyn">Obelyn</option>
                                <option value="Holmer">Holmer</option>
                                <option value="Vertwall">Vertwall</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="bird_species">Bird Species</label>
                            <select name="bird_species" id="bird_species" required>
                                <option value="">Select a bird</option>
                                <option value="Wood Pigeon">Wood Pigeon</option>
                                <option value="House Sparrow">House Sparrow</option>
                                <option value="Starling">Starling</option>
                                <option value="Blue Tit">Blue Tit</option>
                                <option value="Blackbird">Blackbird</option>
                                <option value="Robin">Robin</option>
                                <option value="Goldfinch">Goldfinch</option>
                                <option value="Magpie">Magpie</option>
                                <option value="Other/Unknown">Other/Unknown</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date_of_observation">Date</label>
                            <input type="date" name="date_of_observation" id="date_of_observation" required>
                        </div>

                        <div class="form-group">
                            <label for="time_of_observation">Time</label>
                            <input type="time" name="time_of_observation" id="time_of_observation" required>
                        </div>

                        <div class="form-group">
                            <label for="primary_activity">Primary Activity</label>
                            <select name="primary_activity" id="primary_activity" required>
                                <option value="">Select activity</option>
                                <option value="Visit">Visit</option>
                                <option value="Feeding">Feeding</option>
                                <option value="Nesting">Nesting</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="duration_minutes">Duration (minutes)</label>
                            <input type="number" name="duration_minutes" id="duration_minutes" min="1" required>
                        </div>

                        <div class="form-group full">
                            <label for="comments">Comments</label>
                            <textarea name="comments" id="comments" placeholder="Add any extra details about the sighting..."></textarea>
                        </div>

                        <div class="form-group full">
                            <label for="image">Upload Image</label>
                            <input type="file" name="image" id="image" accept="image/jpeg,image/png">
                            <div class="file-note">Accepted formats: JPG or PNG, maximum 1.2MB.</div>
                        </div>

                        <div class="form-group full">
                            <button type="submit">Create Post</button>
                        </div>
                    </div>
                </form>

                <div class="bottom-link">
                    Want to review existing observations?
                    <a href="view_posts.php">View all posts</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>