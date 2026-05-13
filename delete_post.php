<?php
include "config/auth.php";
include "config/db.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["delete_message"] = "Invalid post selected.";
    header("Location: view_posts.php");
    exit();
}

$id = (int) $_GET["id"];
$user_id = $_SESSION["user_id"];

/* Check ownership first */
$stmt = $conn->prepare("SELECT id FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION["delete_message"] = "Access denied. You can only delete your own posts.";
    header("Location: view_posts.php");
    exit();
}

/* If ownership confirmed → delete */
$delete = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$delete->bind_param("ii", $id, $user_id);

if ($delete->execute()) {
    $_SESSION["delete_message"] = "Observation deleted successfully.";
} else {
    $_SESSION["delete_message"] = "Unable to delete observation.";
}

header("Location: view_posts.php");
exit();
?>