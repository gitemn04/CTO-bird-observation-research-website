<?php
include "config/auth.php";
include "config/db.php";

$user_id = $_SESSION["user_id"];

// 1) Validate id
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    die("Invalid post id.");
}

// 2) Fetch the post (ownership check)
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Unauthorized access.");
}

$post = $result->fetch_assoc();
$stmt->close();

// 3) Update on POST (only after ownership confirmed)
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $location = trim($_POST["location"] ?? "");
    $species  = trim($_POST["bird_species"] ?? "");
    $activity = trim($_POST["primary_activity"] ?? "");
    $duration = $_POST["duration_minutes"] ?? "";
    $comments = trim($_POST["comments"] ?? "");

    // Basic server-side validation
    if ($location === "" || $species === "" || $activity === "" || $duration === "") {
        $message = "<p style='color:red;'>All required fields must be filled.</p>";
    } elseif (!is_numeric($duration) || (int)$duration <= 0) {
        $message = "<p style='color:red;'>Duration must be a positive number.</p>";
    } else {
        $update = $conn->prepare("
            UPDATE posts
            SET location=?, bird_species=?, primary_activity=?, duration_minutes=?, comments=?
            WHERE id=? AND user_id=?
        ");
        $duration_int = (int)$duration;
        $update->bind_param("sssissi", $location, $species, $activity, $duration_int, $comments, $id, $user_id);
        $update->execute();
        $update->close();

        // Re-fetch updated post so the form shows clean updated values
        $stmt2 = $conn->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
        $stmt2->bind_param("ii", $id, $user_id);
        $stmt2->execute();
        $post = $stmt2->get_result()->fetch_assoc();
        $stmt2->close();

        $message = "<p style='color:green;'>Post updated successfully!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Bird Observation</title>
</head>
<body>

<h2>Edit Bird Observation</h2>

<?php echo $message; ?>

<form method="POST">
    Location:<br>
    <input type="text" name="location" value="<?php echo htmlspecialchars($post['location'] ?? ''); ?>"><br><br>

    Species:<br>
    <input type="text" name="bird_species" value="<?php echo htmlspecialchars($post['bird_species'] ?? ''); ?>"><br><br>

    Activity:<br>
    <input type="text" name="primary_activity" value="<?php echo htmlspecialchars($post['primary_activity'] ?? ''); ?>"><br><br>

    Duration (minutes):<br>
    <input type="number" name="duration_minutes" value="<?php echo htmlspecialchars($post['duration_minutes'] ?? ''); ?>"><br><br>

    Comments:<br>
    <textarea name="comments"><?php echo htmlspecialchars($post['comments'] ?? ''); ?></textarea><br><br>

    <button type="submit">Update Post</button>
</form>

</body>
</html>