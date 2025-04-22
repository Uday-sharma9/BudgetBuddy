<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'expense_tracker');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $item = $_POST['item'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $note = $_POST['note'] ?? null;
    
    // Handle file upload
    $receipt_path = null;
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['receipt'];
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        if (in_array($file['type'], $allowed_types) && $file['size'] <= $max_size) {
            $upload_dir = 'uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            $receipt_path = $upload_dir . $filename;
            
            if (!move_uploaded_file($file['tmp_name'], $receipt_path)) {
                $_SESSION['message'] = "Error uploading receipt file.";
                $_SESSION['message_type'] = "error";
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Invalid file type or size too large.";
            $_SESSION['message_type'] = "error";
            header("Location: index.php");
            exit();
        }
    }
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO expenses (category, item, amount, date, note, receipt_path) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsss", $category, $item, $amount, $date, $note, $receipt_path);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Expense added successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error adding expense: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
    
    $stmt->close();
    header("Location: index.php");
    exit();
}

$conn->close();
?>