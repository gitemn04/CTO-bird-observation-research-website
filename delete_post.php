<?php
include "config/auth.php";
include "config/db.php";

$id = $_GET["id"];
$user_id = $_SESSION["user_id"];

/* Check ownership first */
$stmt = $conn->prepare("SELECT id FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Unauthorized access.");
}

/* If ownership confirmed → delete */
$delete = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$delete->bind_param("ii", $id, $user_id);
$delete->execute();

header("Location: view_posts.php");
exit();
?>