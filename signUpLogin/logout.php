<?php
// Start session
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Clear localStorage and redirect to landing page
echo "<script>
    localStorage.removeItem('userData');
    window.location.href = '../landing_page.php';
</script>";
?>