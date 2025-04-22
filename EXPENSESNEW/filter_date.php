<?php
$conn = new mysqli("localhost", "root", "", "expense_tracker");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = $_POST['filterDate'];
$sql = "SELECT * FROM expenses WHERE date = '$date'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<li>{$row['category']}: {$row['item']} (₹{$row['amount']})</li>";
    }
} else {
    echo "<li>No expenses found for this date.</li>";
}

$conn->close();
?>
