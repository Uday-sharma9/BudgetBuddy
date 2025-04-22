<?php
require_once '../includes/db_connect.php';
header('Content-Type: application/json');

$conn = getBudgetDB();

$sql = "SELECT * FROM income ORDER BY income_date DESC LIMIT 5";
$result = $conn->query($sql);

$income = [];
while ($row = $result->fetch_assoc()) {
    $income[] = [
        'income_date' => $row['income_date'],
        'source' => $row['source'],
        'amount' => (float)$row['amount'],
        'notes' => $row['notes'] ?? ''
    ];
}

echo json_encode($income);
$conn->close();
?>