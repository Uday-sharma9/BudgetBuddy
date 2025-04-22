<?php
$conn = new mysqli("localhost", "root", "", "expense_tracker");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT SUM(amount) AS total FROM expenses";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row['total'] ?? 0;

$conn->close();
?>
