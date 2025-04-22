<?php
// Database connections
function getExpenseDB() {
    $conn = new mysqli("localhost", "root", "", "expense_tracker");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function getBudgetDB() {
    $conn = new mysqli("localhost", "root", "", "budgetdb");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>