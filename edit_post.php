<?php
include "config/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "navbar.php";

$message = "";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid post selected.";
    exit();
}

$id = (int) $_GET['id'];
$user_id = $_SESSION["user_id"];

/* First check if post exists at all */
$check_sql = "SELECT * FROM posts WHERE id='$id'";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) == 0) {
    echo "<div class='page-message error'>Post not found.</div>";
    exit();
}

$row = mysqli_fetch_assoc($check_result);

/* Check ownership */
if ($row['user_id'] != $user_id) {
    echo "<div class='page-message error'>Access denied. You can only edit your own posts.</div>";
    exit();
}

/* Update post */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $species = mysqli_real_escape_string($conn, $_POST['species']);
    $activity = mysqli_real_escape_string($conn, $_POST['activity']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $comments = $_POST['comments'];

    /* XSS validation */
    if (preg_match('/<script\b|<\/script>|javascript:|onerror=|onload=/i', $comments)) {

        $message = "<div class='alert error'>Unsafe input detected. Script content is not allowed.</div>";

    } else {

        $comments = mysqli_real_escape_string($conn, $comments);

        $update_sql = "UPDATE posts 
                       SET location='$location',
                           bird_species='$species',
                           primary_activity='$activity',
                           duration_minutes='$duration',
                           comments='$comments'
                       WHERE id='$id' AND user_id='$user_id'";

        if (mysqli_query($conn, $update_sql)) {
            $message = "<div class='alert success'>Record updated successfully.</div>";

            $refresh_sql = "SELECT * FROM posts WHERE id='$id' AND user_id='$user_id'";
            $refresh_result = mysqli_query($conn, $refresh_sql);
            $row = mysqli_fetch_assoc($refresh_result);

        } else {
            $message = "<div class='alert error'>Error updating post.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Bird Observation</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:linear-gradient(to right,#eef7f1,#ffffff);
}

.form-container{
    width:500px;
    margin:50px auto;
    background:white;
    padding:35px;
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.form-container h1{
    text-align:center;
    color:#1b4332;
    margin-bottom:30px;
}

.alert,
.page-message{
    width:500px;
    margin:30px auto 10px;
    padding:14px 16px;
    border-radius:10px;
    font-size:15px;
    font-weight:600;
    text-align:center;
    box-sizing:border-box;
}

.alert.success{
    background:#e7f7ed;
    color:#1f6b3b;
    border:1px solid #b7e4c7;
}

.alert.error,
.page-message.error{
    background:#fdeaea;
    color:#a12626;
    border:1px solid #efc2c2;
}

label{
    display:block;
    margin-top:15px;
    font-weight:600;
    color:#333;
}

input, textarea{
    width:100%;
    padding:12px;
    margin-top:8px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:15px;
    box-sizing:border-box;
}

textarea{
    resize:vertical;
    min-height:100px;
}

button{
    width:100%;
    margin-top:25px;
    padding:14px;
    border:none;
    border-radius:8px;
    background:#2d6a4f;
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#1b4332;
}
</style>
</head>
<body>

<div class="form-container">
    <h1>Edit Bird Observation</h1>

    <?php echo $message; ?>

    <form method="POST">
        <label for="location">Location</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required>

        <label for="species">Species</label>
        <input type="text" id="species" name="species" value="<?php echo htmlspecialchars($row['bird_species']); ?>" required>

        <label for="activity">Activity</label>
        <input type="text" id="activity" name="activity" value="<?php echo htmlspecialchars($row['primary_activity']); ?>" required>

        <label for="duration">Duration (minutes)</label>
        <input type="number" id="duration" name="duration" value="<?php echo htmlspecialchars($row['duration_minutes']); ?>" required>

        <label for="comments">Comments</label>
        <textarea id="comments" name="comments"><?php echo htmlspecialchars($row['comments']); ?></textarea>

        <button type="submit">Update Post</button>
    </form>
</div>

</body>
</html>