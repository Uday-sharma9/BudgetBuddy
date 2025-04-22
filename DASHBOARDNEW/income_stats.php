<?php
require_once '../includes/db_connect.php';
header('Content-Type: application/json');

$conn = getBudgetDB();

// Get total income
$total_sql = "SELECT SUM(amount) AS total FROM income";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'] ?? 0;

// Get monthly income data
$monthly_sql = "SELECT MONTH(income_date) as month, SUM(amount) as total 
                FROM income 
                WHERE YEAR(income_date) = YEAR(CURRENT_DATE)
                GROUP BY MONTH(income_date)
                ORDER BY month";
$monthly_result = $conn->query($monthly_sql);

$monthly = array_fill(0, 12, 0); // Initialize array with zeros for all months
while ($row = $monthly_result->fetch_assoc()) {
    $monthly[$row['month'] - 1] = (float)$row['total'];
}

// Get source-wise income
$sources_sql = "SELECT source, SUM(amount) AS amount 
                FROM income 
                GROUP BY source 
                ORDER BY amount DESC";
$sources_result = $conn->query($sources_sql);
$sources = [];
while ($row = $sources_result->fetch_assoc()) {
    $sources[] = [
        'source' => $row['source'],
        'amount' => (float)$row['amount']
    ];
}

$response = [
    'total' => (float)$total,
    'monthly' => $monthly,
    'sources' => $sources
];

echo json_encode($response);
$conn->close();
?>