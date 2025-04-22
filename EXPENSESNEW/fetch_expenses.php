<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Build the query
$sql = "SELECT id, category, item, amount, date, note, receipt_path FROM expenses";

// Add filters if provided
$params = array();
$types = "";

if (isset($_GET['date']) && !empty($_GET['date'])) {
    $sql .= " WHERE date = ?";
    $params[] = $_GET['date'];
    $types .= "s";
}

if (isset($_GET['category']) && !empty($_GET['category'])) {
    if (strpos($sql, 'WHERE') === false) {
        $sql .= " WHERE";
    } else {
        $sql .= " AND";
    }
    $sql .= " category = ?";
    $params[] = $_GET['category'];
    $types .= "s";
}

$sql .= " ORDER BY date DESC";

// Prepare and execute the query
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$expenses = array();
while ($row = $result->fetch_assoc()) {
    $expenses[] = $row;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($expenses);

$stmt->close();
$conn->close();
?>
