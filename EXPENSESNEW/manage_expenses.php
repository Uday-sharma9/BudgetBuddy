<?php
session_start();

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

// Handle delete operation
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // First, get the receipt path if it exists
    $stmt = $conn->prepare("SELECT receipt_path FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $expense = $result->fetch_assoc();
    
    // Delete the receipt file if it exists
    if ($expense && $expense['receipt_path']) {
        $file_path = $expense['receipt_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    // Delete from database
    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Expense deleted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error deleting expense: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
    
    $stmt->close();
    header("Location: index.php");
    exit();
}

// Handle edit operation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
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
            
            // Get old receipt path
            $stmt = $conn->prepare("SELECT receipt_path FROM expenses WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $old_receipt = $result->fetch_assoc()['receipt_path'];
            
            // Delete old receipt if exists
            if ($old_receipt && file_exists($old_receipt)) {
                unlink($old_receipt);
            }
            
            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            $receipt_path = $upload_dir . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $receipt_path)) {
                // Update with new receipt path
                $stmt = $conn->prepare("UPDATE expenses SET category = ?, item = ?, amount = ?, date = ?, note = ?, receipt_path = ? WHERE id = ?");
                $stmt->bind_param("ssdsssi", $category, $item, $amount, $date, $note, $receipt_path, $id);
            } else {
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
    } else {
        // Update without changing receipt
        $stmt = $conn->prepare("UPDATE expenses SET category = ?, item = ?, amount = ?, date = ?, note = ? WHERE id = ?");
        $stmt->bind_param("ssdssi", $category, $item, $amount, $date, $note, $id);
    }
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Expense updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating expense: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
    
    $stmt->close();
    header("Location: index.php");
    exit();
}

$conn->close();
?> 