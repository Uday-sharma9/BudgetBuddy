<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "budgetdb";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if this is a delete request
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
        $id = $_POST['id'];
        
        // First, get the document path if it exists
        $stmt = $conn->prepare("SELECT document FROM income WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Delete the file if it exists
        if ($result && $result['document'] && file_exists($result['document'])) {
            unlink($result['document']);
        }
        
        // Delete the record
        $stmt = $conn->prepare("DELETE FROM income WHERE id = ?");
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Income deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No income record found with the given ID']);
        }
        exit;
    }

    // Handle update request
    if (!isset($_POST['id'])) {
        throw new Exception('Income ID is required');
    }

    $id = $_POST['id'];
    $source = $_POST['source'];
    $amount = $_POST['amount'];
    $income_date = $_POST['income_date'];
    $notes = isset($_POST['notes']) ? $_POST['notes'] : null;
    
    // Check if a new document was uploaded
    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['document'];
        $allowed_types = ['application/pdf', 'image/jpeg', 'image/png'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        if (!in_array($file['type'], $allowed_types)) {
            throw new Exception('Invalid file type. Only PDF, JPG, and PNG files are allowed.');
        }
        
        if ($file['size'] > $max_size) {
            throw new Exception('File size too large. Maximum size is 2MB.');
        }
        
        // Create uploads directory if it doesn't exist
        $upload_dir = 'uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $filepath = $upload_dir . $filename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            throw new Exception('Failed to upload file.');
        }
        
        // Delete old document if it exists
        $stmt = $conn->prepare("SELECT document FROM income WHERE id = ?");
        $stmt->execute([$id]);
        $old_doc = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($old_doc && $old_doc['document'] && file_exists($old_doc['document'])) {
            unlink($old_doc['document']);
        }
        
        // Update with new document
        $stmt = $conn->prepare("UPDATE income SET source = ?, amount = ?, income_date = ?, notes = ?, document = ? WHERE id = ?");
        $stmt->execute([$source, $amount, $income_date, $notes, $filepath, $id]);
    } else {
        // Update without changing document
        $stmt = $conn->prepare("UPDATE income SET source = ?, amount = ?, income_date = ?, notes = ? WHERE id = ?");
        $stmt->execute([$source, $amount, $income_date, $notes, $id]);
    }
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Income updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No changes were made to the income record']);
    }
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 