<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "budgetdb";  // Changed to correct database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get form data
    $source = $_POST['source'];
    $amount = $_POST['amount'];
    $income_date = $_POST['income_date'];
    $notes = isset($_POST['notes']) ? $_POST['notes'] : null;

    // Handle file upload
    $document_path = null;
    if(isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $file = $_FILES['document'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // Get file extension
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Allowed file types
        $allowed = array('pdf', 'jpg', 'jpeg', 'png');

        if(in_array($file_ext, $allowed)) {
            if($file_error === 0) {
                if($file_size < 2097152) { // 2MB max
                    // Create unique file name
                    $file_name_new = uniqid('doc_', true) . "." . $file_ext;
                    
                    // Create uploads directory if it doesn't exist
                    $upload_dir = 'uploads/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    // Move file to uploads directory
                    $file_destination = $upload_dir . $file_name_new;
                    if(move_uploaded_file($file_tmp, $file_destination)) {
                        $document_path = $file_destination;
                    }
                }
            }
        }
    }

    // Check if notes and document columns exist
    $checkColumns = $conn->query("SHOW COLUMNS FROM income LIKE 'notes'");
    $notesExists = $checkColumns->rowCount() > 0;
    
    $checkColumns = $conn->query("SHOW COLUMNS FROM income LIKE 'document'");
    $documentExists = $checkColumns->rowCount() > 0;

    // Prepare SQL based on existing columns
    if($notesExists && $documentExists) {
        $sql = "INSERT INTO income (source, amount, income_date, notes, document) VALUES (:source, :amount, :income_date, :notes, :document)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':document', $document_path);
    } else {
        $sql = "INSERT INTO income (source, amount, income_date) VALUES (:source, :amount, :income_date)";
        $stmt = $conn->prepare($sql);
    }
    
    $stmt->bindParam(':source', $source);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':income_date', $income_date);

    // Execute the statement
    $stmt->execute();

    // Log for debugging
    error_log("Income added successfully: Source=$source, Amount=$amount, Date=$income_date");
    
    echo "success";

} catch(PDOException $e) {
    // Log the error for debugging
    error_log("Database error: " . $e->getMessage());
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
