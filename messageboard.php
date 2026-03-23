<?php
session_start();
include "config/db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Message Board</title>
</head>
<body>

<h2>Message Board</h2>

<p>This page displays all bird observations submitted by users.</p>

<?php
$result = $conn->query("SELECT * FROM observations ORDER BY id DESC");

while($row = $result->fetch_assoc()){
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";
    echo "<strong>Species:</strong> " . $row['bird_species'] . "<br>";
    echo "<strong>Location:</strong> " . $row['location'] . "<br>";
    echo "<strong>Date:</strong> " . $row['date_of_observation'] . "<br>";
    echo "</div>";
}
?>

</body>
</html>