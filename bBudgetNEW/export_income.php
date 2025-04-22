<?php
require_once 'setup_database.php';

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="income_report.xlsx"');
header('Cache-Control: max-age=0');

// Fetch income data
$sql = "SELECT source, amount, income_date, notes FROM income ORDER BY income_date DESC";
$result = $conn->query($sql);

// Create Excel content
$excel = "Income Source\tAmount (₹)\tDate\tNotes\n";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $excel .= $row['source'] . "\t" . 
                 $row['amount'] . "\t" . 
                 $row['income_date'] . "\t" . 
                 $row['notes'] . "\n";
    }
}

// Output Excel content
echo base64_encode($excel);
$conn->close();
?> 