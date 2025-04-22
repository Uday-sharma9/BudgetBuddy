<?php
require_once 'setup_database.php';

// Fetch all income data
$sql = "SELECT * FROM income ORDER BY income_date DESC";
$result = $conn->query($sql);

$backup_data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $backup_data[] = $row;
    }
}

// Convert to JSON and encode
$json_data = json_encode($backup_data, JSON_PRETTY_PRINT);
echo base64_encode($json_data);

$conn->close();
?> 