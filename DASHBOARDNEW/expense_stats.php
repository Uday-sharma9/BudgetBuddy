<?php
require_once '../includes/db_connect.php';
header('Content-Type: application/json');

$conn = getExpenseDB();

// Get total expenses
$total_sql = "SELECT SUM(amount) AS total FROM expenses";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'] ?? 0;

// Get monthly expenses data
$monthly_sql = "SELECT MONTH(date) as month, SUM(amount) as total 
                FROM expenses 
                WHERE YEAR(date) = YEAR(CURRENT_DATE)
                GROUP BY MONTH(date)
                ORDER BY month";
$monthly_result = $conn->query($monthly_sql);

$monthly = array_fill(0, 12, 0); // Initialize array with zeros for all months
while ($row = $monthly_result->fetch_assoc()) {
    $monthly[$row['month'] - 1] = (float)$row['total'];
}

// Get category-wise expenses
$categories_sql = "SELECT category, SUM(amount) AS amount 
                  FROM expenses 
                  GROUP BY category 
                  ORDER BY amount DESC";
$categories_result = $conn->query($categories_sql);
$categories = [];
while ($row = $categories_result->fetch_assoc()) {
    $categories[] = [
        'category' => $row['category'],
        'amount' => (float)$row['amount']
    ];
}

$response = [
    'total' => (float)$total,
    'monthly' => $monthly,
    'categories' => $categories
];

echo json_encode($response);
$conn->close();
?>