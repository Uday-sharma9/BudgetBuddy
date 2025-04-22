<?php
// This file will help debug AJAX requests
header('Content-Type: application/json');

// Log the request
$log_file = 'ajax_debug.log';
$timestamp = date('Y-m-d H:i:s');
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
$request_data = file_get_contents('php://input');
$post_data = $_POST;
$get_data = $_GET;

$log_entry = "=== $timestamp ===\n";
$log_entry .= "Request Method: $request_method\n";
$log_entry .= "Request URI: $request_uri\n";
$log_entry .= "POST Data: " . print_r($post_data, true) . "\n";
$log_entry .= "GET Data: " . print_r($get_data, true) . "\n";
$log_entry .= "Raw Request Data: $request_data\n\n";

file_put_contents($log_file, $log_entry, FILE_APPEND);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "budgetdb";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if notes and document columns exist
    $checkColumns = $conn->query("SHOW COLUMNS FROM income LIKE 'notes'");
    $hasNotes = $checkColumns->rowCount() > 0;
    
    $checkColumns = $conn->query("SHOW COLUMNS FROM income LIKE 'document'");
    $hasDocument = $checkColumns->rowCount() > 0;

    // Prepare SQL based on column existence
    if ($hasNotes && $hasDocument) {
        $sql = "SELECT id, source, amount, income_date, notes, document FROM income ORDER BY income_date DESC";
    } else {
        $sql = "SELECT id, source, amount, income_date FROM income ORDER BY income_date DESC";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Log the result
    $log_entry = "SQL Query: $sql\n";
    $log_entry .= "Result Count: " . count($result) . "\n";
    $log_entry .= "Result: " . json_encode($result) . "\n\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND);

    // Return the result
    echo json_encode([
        'status' => 'success',
        'data' => $result,
        'debug_info' => [
            'has_notes' => $hasNotes,
            'has_document' => $hasDocument,
            'sql' => $sql
        ]
    ]);
} catch(PDOException $e) {
    // Log the error
    $log_entry = "Error: " . $e->getMessage() . "\n\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND);

    // Return the error
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?> 