<?php
$conn = new mysqli("localhost", "root", "", "expense_tracker");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$month = $_POST['filterMonth'];
$category = $_POST['filterCategory'];

$sql = "SELECT * FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = '$month'";

if ($category !== "All") {
    $sql .= " AND category = '$category'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<li>{$row['date']} - {$row['category']}: {$row['item']} (₹{$row['amount']})</li>";
    }
} else {
    echo "<li>No expenses found for this filter.</li>";
}

$conn->close();
?>
