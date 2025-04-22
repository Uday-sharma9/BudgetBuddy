<?php
require_once '../includes/db_connect.php';
header('Content-Type: application/json');

$conn = getExpenseDB();

$sql = "SELECT * FROM expenses ORDER BY date DESC LIMIT 5";
$result = $conn->query($sql);

$expenses = [];
while ($row = $result->fetch_assoc()) {
    $expenses[] = [
        'date' => $row['date'],
        'category' => $row['category'],
        'description' => $row['description'],
        'amount' => (float)$row['amount']
    ];
}

echo json_encode($expenses);
$conn->close();
?>