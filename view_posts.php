<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "config/db.php";

$search = "";

if (isset($_GET["search"]) && !empty($_GET["search"])) {

    $search = "%" . $_GET["search"] . "%";

    $stmt = $conn->prepare("
        SELECT posts.*, users.username
        FROM posts
        JOIN users ON posts.user_id = users.id
        WHERE bird_species LIKE ? OR comments LIKE ?
        ORDER BY posts.created_at DESC
    ");

    $stmt->bind_param("ss", $search, $search);
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
<html>
<head>
    <title>View Posts</title>
</head>
<body>

<h2>All Bird Observations</h2>
<form method="GET">
    <input type="text" name="search" placeholder="Search by species or comment">
    <button type="submit">Search</button>
</form>
<br>

<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<hr>";
        echo "<strong>User:</strong> " . htmlspecialchars($row["username"]) . "<br>";
        echo "<strong>Location:</strong> " . htmlspecialchars($row["location"]) . "<br>";
        echo "<strong>Date:</strong> " . $row["date_of_observation"] . "<br>";
        echo "<strong>Time:</strong> " . $row["time_of_observation"] . "<br>";
        echo "<strong>Species:</strong> " . htmlspecialchars($row["bird_species"]) . "<br>";
        echo "<strong>Activity:</strong> " . htmlspecialchars($row["primary_activity"]) . "<br>";
        echo "<strong>Duration:</strong> " . $row["duration_minutes"] . " minutes<br>";
        echo "<strong>Comments:</strong> " . htmlspecialchars($row["comments"]) . "<br>";
        if (!empty($row["image_path"])) {
        echo "<img src='" . htmlspecialchars($row["image_path"]) . "' width='200'><br>";
}
        echo "<a href='edit_post.php?id=" . $row["id"] . "'>Edit</a><br>";
        echo "<a href='delete_post.php?id=" . $row["id"] . "' onclick=\"return confirm('Are you sure you want to delete this post?');\">Delete</a><br>";
    }
} else {
    echo "No posts found or query failed.";
}
?>

</body>
</html>