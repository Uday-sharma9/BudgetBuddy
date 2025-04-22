<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "expense_tracker");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get selected month and category from the form
$month = isset($_GET['month']) ? $_GET['month'] : "";
$category = isset($_GET['category']) ? $_GET['category'] : "All";

// Prepare SQL Query
$sql = "SELECT * FROM expenses WHERE 1"; // Default query

if (!empty($month)) {
    $sql .= " AND date LIKE '$month%'"; // Filter by month (YYYY-MM)
}

if ($category !== "All") {
    $sql .= " AND category = '$category'"; // Filter by category
}

// Execute Query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Expenses</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Filtered Expenses</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Item</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['item']}</td>
                        <td>₹{$row['amount']}</td>
                        <td>{$row['date']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No expenses found for the selected filters.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
