<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "expense_tracker");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Get total expenses
$total_sql = "SELECT SUM(amount) AS total FROM expenses";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'] ?? 0;

// Get category with highest spending
$category_sql = "SELECT category, SUM(amount) AS category_total 
                FROM expenses 
                GROUP BY category 
                ORDER BY category_total DESC 
                LIMIT 1";
$category_result = $conn->query($category_sql);
$category_row = $category_result->fetch_assoc();

// Get total number of expenses
$count_sql = "SELECT COUNT(*) AS total_count FROM expenses";
$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$total_count = $count_row['total_count'] ?? 0;

// Get average daily expense
$avg_sql = "SELECT AVG(amount) AS avg_amount FROM expenses";
$avg_result = $conn->query($avg_sql);
$avg_row = $avg_result->fetch_assoc();
$avg_amount = $avg_row['avg_amount'] ?? 0;

// Get most frequent category
$freq_sql = "SELECT category, COUNT(*) AS frequency 
             FROM expenses 
             GROUP BY category 
             ORDER BY frequency DESC 
             LIMIT 1";
$freq_result = $conn->query($freq_sql);
$freq_row = $freq_result->fetch_assoc();

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
    'total' => $total,
    'highest_category' => $category_row ? [
        'category' => $category_row['category'],
        'amount' => $category_row['category_total']
    ] : null,
    'total_count' => $total_count,
    'avg_amount' => $avg_amount,
    'most_frequent_category' => $freq_row ? [
        'category' => $freq_row['category'],
        'frequency' => $freq_row['frequency']
    ] : null,
    'categories' => $categories
];

echo json_encode($response);
$conn->close();
?> 