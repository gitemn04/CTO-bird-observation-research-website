<?php
include "config/auth.php";
include "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION["user_id"];
    $location = $_POST["location"];
    $date = $_POST["date_of_observation"];
    $time = $_POST["time_of_observation"];
    $species = $_POST["bird_species"];
    $activity = $_POST["primary_activity"];
    $duration = $_POST["duration_minutes"];
    $comments = substr($_POST["comments"], 0, 500);
    /* Server-side validation */
if (
    empty($location) ||
    empty($date) ||
    empty($time) ||
    empty($species) ||
    empty($activity) ||
    empty($duration)
) {
    $message = "<p style='color:red;'>All required fields must be filled.</p>";
} elseif (!is_numeric($duration) || $duration <= 0) {
    $message = "<p style='color:red;'>Duration must be a positive number.</p>";
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
        $message = "<p style='color:red;'>Invalid file type or file too large (max 1.2MB).</p>";
    }
}
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
        $message = "<p style='color:green;'>Post created successfully!</p>";
    } else {
        $message = "<p style='color:red;'>Error creating post.</p>";
    }
    $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
</head>
<body>

<h2>Create Bird Observation</h2>

<?php echo $message; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Location:</label><br>
    <input type="text" name="location"><br><br>

    <label>Date:</label><br>
    <input type="date" name="date_of_observation"><br><br>

    <label>Time:</label><br>
    <input type="time" name="time_of_observation"><br><br>

    <label>Bird Species:</label><br>
    <input type="text" name="bird_species"><br><br>

    <label>Primary Activity:</label><br>
    <input type="text" name="primary_activity"><br><br>

    <label>Duration (minutes):</label><br>
    <input type="number" name="duration_minutes"><br><br>

    <label>Comments:</label><br>
    <textarea name="comments"></textarea><br><br>
    <label>Upload Image (jpg/png max 1.2MB):</label><br>
    <input type="file" name="image" accept="image/jpeg,image/png"><br><br>
    

    <button type="submit">Create Post</button>
</form>

</body>
</html>