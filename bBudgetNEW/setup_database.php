<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "budgetdb";

try {
    // Connect to MySQL without selecting a database
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green'>Connected to MySQL server successfully!</p>";
    
    // Check if database exists
    $result = $conn->query("SHOW DATABASES LIKE '$dbname'");
    if($result->rowCount() > 0) {
        echo "<p style='color:green'>Database '$dbname' exists!</p>";
    } else {
        // Create database
        $sql = "CREATE DATABASE $dbname";
        $conn->exec($sql);
        echo "<p style='color:green'>Database '$dbname' created successfully!</p>";
    }
    
    // Select the database
    $conn->exec("USE $dbname");
    
    // Check if table exists
    $result = $conn->query("SHOW TABLES LIKE 'income'");
    if($result->rowCount() > 0) {
        echo "<p style='color:green'>Table 'income' exists!</p>";
        
        // Check if notes and document columns exist
        $checkColumns = $conn->query("SHOW COLUMNS FROM income LIKE 'notes'");
        $hasNotes = $checkColumns->rowCount() > 0;
        
        $checkColumns = $conn->query("SHOW COLUMNS FROM income LIKE 'document'");
        $hasDocument = $checkColumns->rowCount() > 0;
        
        if(!$hasNotes || !$hasDocument) {
            // Add missing columns
            $alterSql = "ALTER TABLE income";
            $alterSql .= $hasNotes ? "" : " ADD COLUMN notes TEXT AFTER income_date";
            $alterSql .= $hasDocument ? "" : ($hasNotes ? " ADD COLUMN document VARCHAR(255) AFTER notes" : ", ADD COLUMN document VARCHAR(255) AFTER notes");
            
            $conn->exec($alterSql);
            echo "<p style='color:green'>Added missing columns to the 'income' table!</p>";
        } else {
            echo "<p style='color:green'>All required columns exist in the 'income' table!</p>";
        }
    } else {
        // Create table
        $sql = "CREATE TABLE income (
            id INT AUTO_INCREMENT PRIMARY KEY,
            source VARCHAR(255) NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            income_date DATE NOT NULL,
            notes TEXT,
            document VARCHAR(255)
        )";
        $conn->exec($sql);
        echo "<p style='color:green'>Table 'income' created successfully!</p>";
    }
    
    // Show table structure
    $result = $conn->query("DESCRIBE income");
    echo "<h3>Table Structure:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr style='background-color: #f2f2f2;'><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Count records
    $result = $conn->query("SELECT COUNT(*) as count FROM income");
    $count = $result->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p>Number of records in income table: <strong>" . $count . "</strong></p>";
    
    // Add a sample record if no records exist
    if($count == 0) {
        $sql = "INSERT INTO income (source, amount, income_date, notes) VALUES ('Sample Income', 5000, CURDATE(), 'This is a sample income record')";
        $conn->exec($sql);
        echo "<p style='color:green'>Added a sample income record!</p>";
    }
    
    echo "<p><a href='index.html' style='color:blue;'>Go to the main page</a></p>";
    
} catch(PDOException $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?> 