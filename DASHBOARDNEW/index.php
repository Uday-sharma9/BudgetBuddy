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

// Handle API requests
if(isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    switch($_GET['action']) {
        case 'expense_stats':
            $conn = getExpenseDB();
            
            // Get total expenses
            $total_sql = "SELECT SUM(amount) AS total FROM expenses";
            $total_result = $conn->query($total_sql);
            $total_row = $total_result->fetch_assoc();
            $total = $total_row['total'] ?? 0;
            
            // Get monthly expenses data
            $monthly_sql = "SELECT MONTH(date) as month, SUM(amount) as total 
                          FROM expenses 
                          WHERE YEAR(date) = YEAR(CURRENT_DATE)
                          GROUP BY MONTH(date)
                          ORDER BY month";
            $monthly_result = $conn->query($monthly_sql);
            
            $monthly = array_fill(0, 12, 0);
            while ($row = $monthly_result->fetch_assoc()) {
                $monthly[$row['month'] - 1] = (float)$row['total'];
            }
            
            // Get category-wise expenses
            $categories_sql = "SELECT category, SUM(amount) AS amount 
                            FROM expenses 
                            GROUP BY category 
                            ORDER BY amount DESC";
            $categories_result = $conn->query($categories_sql);
            $categories = [];
            while ($row = $categories_result->fetch_assoc()) {
                $categories[] = [
                    'category' => $row['category'],
                    'amount' => (float)$row['amount']
                ];
            }
            
            echo json_encode([
                'total' => (float)$total,
                'monthly' => $monthly,
                'categories' => $categories
            ]);
            $conn->close();
            exit;
            
        case 'income_stats':
            $conn = getBudgetDB();
            
            // Get total income
            $total_sql = "SELECT SUM(amount) AS total FROM income";
            $total_result = $conn->query($total_sql);
            $total_row = $total_result->fetch_assoc();
            $total = $total_row['total'] ?? 0;
            
            // Get monthly income data
            $monthly_sql = "SELECT MONTH(income_date) as month, SUM(amount) as total 
                          FROM income 
                          WHERE YEAR(income_date) = YEAR(CURRENT_DATE)
                          GROUP BY MONTH(income_date)
                          ORDER BY month";
            $monthly_result = $conn->query($monthly_sql);
            
            $monthly = array_fill(0, 12, 0);
            while ($row = $monthly_result->fetch_assoc()) {
                $monthly[$row['month'] - 1] = (float)$row['total'];
            }
            
            echo json_encode([
                'total' => (float)$total,
                'monthly' => $monthly
            ]);
            $conn->close();
            exit;
            
        case 'recent_expenses':
            $conn = getExpenseDB();
            $sql = "SELECT * FROM expenses ORDER BY date DESC LIMIT 5";
            $result = $conn->query($sql);
            
            $expenses = [];
            while ($row = $result->fetch_assoc()) {
                $expenses[] = [
                    'date' => $row['date'],
                    'category' => $row['category'],
                    'description' => $row['description'],
                    'amount' => (float)$row['amount']
                ];
            }
            
            echo json_encode($expenses);
            $conn->close();
            exit;
            
        case 'recent_income':
            $conn = getBudgetDB();
            $sql = "SELECT * FROM income ORDER BY income_date DESC LIMIT 5";
            $result = $conn->query($sql);
            
            $income = [];
            while ($row = $result->fetch_assoc()) {
                $income[] = [
                    'income_date' => $row['income_date'],
                    'source' => $row['source'],
                    'amount' => (float)$row['amount'],
                    'notes' => $row['notes'] ?? ''
                ];
            }
            
            echo json_encode($income);
            $conn->close();
            exit;
            
        case 'expensesnew_recent':
            $conn = getExpenseDB();
            $sql = "SELECT id, category, item as description, amount, date, note as notes FROM expenses ORDER BY date DESC LIMIT 5";
            $result = $conn->query($sql);
            
            $expenses = [];
            while ($row = $result->fetch_assoc()) {
                $expenses[] = [
                    'date' => $row['date'],
                    'category' => $row['category'],
                    'description' => $row['description'],
                    'amount' => (float)$row['amount'],
                    'notes' => $row['notes'] ?? ''
                ];
            }
            
            echo json_encode($expenses);
            $conn->close();
            exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #7c3aed; /* violet-600 */
            --primary-light: #8b5cf6; /* violet-500 */
            --primary-dark: #6d28d9; /* violet-700 */
            --primary-lighter: #a78bfa; /* violet-400 */
            --primary-darker: #5b21b6; /* violet-800 */
            --white: #ffffff;
            --white-off: #f8f9fa;
            --white-dark: #e9ecef;
            --accent-color: #7c3aed; /* Changed to violet-600 */
            --accent-light: #8b5cf6; /* Changed to violet-500 */
            --accent-dark: #6d28d9; /* Changed to violet-700 */
            --success-color: #7c3aed; /* Changed to violet-600 */
            --warning-color: #7c3aed; /* Changed to violet-600 */
            --info-color: #7c3aed; /* Changed to violet-600 */
        }
        
        /* Navigation Bar Styles */
        .nav-container {
            background: var(--primary-color); /* violet-600 */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 80px;
        }

        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem; /* Increased padding */
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            height: 100%;
        }

        /* Remove old logo styles */
        .logo {
            display: none;
        }

        .flex.items-center.space-x-2 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .flex.items-center.space-x-2 span {
            font-size: 1.5rem; /* text-2xl */
            font-weight: bold;
            color: white;
        }

        .desktop-menu {
            display: flex;
            gap: 3rem; /* Increased gap */
            align-items: center;
            margin: 0 auto;
        }

        .nav-link {
            text-decoration: none;
            color: var(--white);
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 0; /* Increased padding */
            font-size: 1.2rem; /* Increased font size */
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--white);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--white);
            background: none;
        }

        .profile-button {
            position: absolute;
            right: 1.5rem; /* Adjusted position */
            background: none;
            border: none;
            cursor: pointer;
            color: var(--white);
            font-size: 1.8rem; /* Increased icon size */
            transition: all 0.3s ease;
            padding: 0.75rem; /* Increased padding */
        }

        .profile-button:hover {
            transform: translateY(-2px);
            background: none;
        }

        .dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--white);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 0.75rem; /* Increased padding */
            display: none;
            margin-top: 0.75rem; /* Increased margin */
            min-width: 200px; /* Increased width */
            z-index: 1001;
        }

        .dropdown.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem; /* Increased gap */
            padding: 1rem 1.25rem; /* Increased padding */
            text-decoration: none;
            color: var(--primary-dark);
            transition: all 0.3s ease;
            border-radius: 0.25rem;
            font-size: 1.1rem; /* Increased font size */
        }

        .dropdown-item:hover {
            background: rgba(111, 66, 193, 0.1);
            color: var(--primary-color);
        }

        .dropdown-item i {
            color: var(--primary-color);
        }

        .mobile-menu-button {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            color: var(--white);
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-dark);
            padding: 1rem;
            z-index: 1001;
        }

        .mobile-menu.show {
            display: block;
        }

        .mobile-menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem;
            position: relative;
        }

        .mobile-menu-header .logo {
            position: static;
            margin: 0 auto;
        }

        .mobile-menu-close {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            color: var(--white);
        }

        .mobile-menu-links {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            text-align: center;
            padding: 1rem;
        }

        .mobile-menu-links .nav-link {
            color: var(--white);
            padding: 1rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .mobile-menu-links .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 768px) {
            .desktop-menu {
                display: none;
            }

            .mobile-menu-button {
                display: block;
            }
        }
        
        body {
            background: linear-gradient(135deg, var(--white-off) 0%, var(--white-dark) 100%);
            color: var(--primary-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            background-image: url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 25px;
            padding-top: 110px; /* Increased padding for larger navigation */
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(248, 249, 250, 0.85);
            z-index: -1;
            pointer-events: none;
        }
        
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><circle cx="50" cy="50" r="1" fill="%236f42c1" opacity="0.1"/></svg>');
            opacity: 0.5;
            z-index: -1;
            pointer-events: none;
        }
        
        .container {
            padding-top: 2rem;
            padding-bottom: 2rem;
            animation: fadeIn 0.8s ease-out;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            margin-top: 2rem;
            margin-bottom: 2rem;
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .dashboard-header {
            margin-top: 1rem;
            text-align: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: transparent;
            border-radius: 0;
            box-shadow: none;
            position: relative;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .dashboard-header h1 {
            font-weight: 700;
            margin: 0;
            color: var(--primary-color);
            text-shadow: none;
            position: relative;
            z-index: 1;
            font-size: 2.5rem;
            font-family: 'Audiowide', cursive;
            letter-spacing: 1px;
            text-transform: uppercase;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
        
        .dashboard-header h1 i {
            transition: transform 0.5s ease;
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
        
        .dashboard-header:hover h1 i {
            transform: rotate(15deg) scale(1.2);
        }
        
        /* Overview Cards Row */
        .row.mb-4 {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .col-md-4 {
            flex: 0 0 calc(33.333% - 1rem);
            max-width: calc(33.333% - 1rem);
        }
        
        .dashboard-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid var(--primary-lighter);
            border-radius: 20px;
            overflow: hidden;
            height: 100%;
            background: var(--white);
            box-shadow: 0 4px 6px rgba(124, 58, 237, 0.1);
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            max-width: 300px;
        }
        
        .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
        .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
        .dashboard-card:nth-child(3) { animation-delay: 0.3s; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
        }
        
        .dashboard-card:hover::before {
            opacity: 1;
        }
        
        .dashboard-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 6px 12px rgba(124, 58, 237, 0.2);
        }
        
        .dashboard-card .card-body {
            padding: 2rem;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }
        
        .dashboard-card:hover .card-body {
            color: var(--white);
        }
        
        .dashboard-card .card-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            font-size: 1.25rem;
        }
        
        .dashboard-card:hover .card-title {
            color: var(--white);
        }
        
        .dashboard-card .card-title i {
            margin-right: 12px;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .dashboard-card:hover .card-title i {
            transform: scale(1.2) rotate(10deg);
        }
        
        .dashboard-card .highlight-number {
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--primary-dark);
            transition: all 0.3s ease;
        }
        
        .dashboard-card:hover .highlight-number {
            color: var(--white);
            transform: scale(1.05);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        
        /* Income card with accent */
        .income-card {
            border-top: 5px solid var(--primary-color);
        }
        
        /* Expense card with accent */
        .expense-card {
            border-top: 5px solid var(--accent-color);
        }
        
        /* Balance card with accent */
        .balance-card {
            border-top: 5px solid var(--success-color);
        }
        
        /* Make net balance text white on hover */
        .balance-card:hover .highlight-number {
            color: var(--white) !important;
        }
        
        /* Transactions Section */
        .transaction-card {
            background: var(--white);
            border: 1px solid var(--primary-lighter);
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(124, 58, 237, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s ease-out 0.6s forwards;
            opacity: 0;
            position: relative;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 2rem;
        }
        
        .transaction-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
        }
        
        .transaction-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 6px 12px rgba(124, 58, 237, 0.2);
        }
        
        .transaction-card .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-bottom: none;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .transaction-card .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
            transition: all 0.5s ease;
        }
        
        .transaction-card:hover .card-header::before {
            transform: rotate(60deg);
        }
        
        .transaction-card .card-title {
            margin: 0;
            font-size: 1.5rem;
            color: var(--white);
            position: relative;
            z-index: 1;
        }
        
        .transaction-card .card-title i {
            transition: transform 0.3s ease;
            display: inline-block;
        }
        
        .transaction-card:hover .card-title i {
            transform: rotate(15deg) scale(1.2);
        }
        
        .refresh-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .refresh-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }
        
        .refresh-btn i {
            margin-right: 5px;
            transition: transform 0.5s ease;
        }
        
        .refresh-btn:hover i {
            transform: rotate(180deg);
        }
        
        .nav-tabs {
            border-bottom: 1px solid rgba(111, 66, 193, 0.2);
            padding: 0 1.5rem;
        }
        
        .nav-tabs .nav-link {
            color: var(--primary-color);
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 0;
            opacity: 0.7;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-size: 1.1rem;
        }
        
        .nav-tabs .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-color);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        
        .nav-tabs .nav-link:hover::before,
        .nav-tabs .nav-link.active::before {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .nav-tabs .nav-link:hover {
            opacity: 1;
            background: rgba(111, 66, 193, 0.05);
        }
        
        .nav-tabs .nav-link.active {
            font-weight: bold;
            color: var(--primary-color);
            background: rgba(111, 66, 193, 0.05);
            border: none;
            opacity: 1;
        }
        
        .nav-tabs .nav-link i {
            transition: transform 0.3s ease;
            display: inline-block;
        }
        
        .nav-tabs .nav-link:hover i {
            transform: translateY(-3px);
        }
        
        .table {
            color: var(--primary-dark);
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table thead th {
            background: rgba(111, 66, 193, 0.05);
            color: var(--primary-color);
            font-weight: 600;
            border-bottom: 2px solid rgba(111, 66, 193, 0.2);
            padding: 0.75rem;
            font-size: 1.1rem;
        }
        
        .table td {
            border-color: rgba(111, 66, 193, 0.1);
            vertical-align: middle;
            padding: 0.75rem;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        
        .table-hover tbody tr {
            transition: all 0.3s ease;
        }
        
        .table-hover tbody tr:hover {
            background: rgba(111, 66, 193, 0.05);
            transform: translateX(5px);
        }
        
        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            background: var(--primary-color);
            color: var(--white);
            font-size: 1rem;
        }
        
        .badge:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(111, 66, 193, 0.2);
        }
        
        .badge-income {
            background: var(--primary-color);
        }
        
        .badge-expense {
            background: var(--accent-color);
        }
        
        .badge-balance {
            background: var(--success-color);
        }
        
        .footer {
            text-align: center;
            padding: 1.5rem;
            margin-top: 2rem;
            color: var(--primary-dark);
            opacity: 0.7;
            font-size: 0.9rem;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }
        
        /* Add new styles for savings goals section */
        .savings-overview {
            margin-top: 3rem;
            padding: 2rem;
            background: transparent;
            border-radius: 0;
            box-shadow: none;
            border-top: none;
            animation: fadeInUp 0.8s ease-out 0.4s forwards;
            opacity: 0;
            position: relative;
            overflow: hidden;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .savings-overview::before {
            display: none;
        }

        .savings-overview h3 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            text-align: center;
            position: relative;
            padding-bottom: 1.5rem;
            z-index: 1;
        }
        
        .savings-overview h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }
        
        .savings-overview h3 i {
            font-size: 2.2rem;
            color: var(--primary-color);
        }

        .goals-grid {
            display: flex;
            flex-direction: row;
            gap: 2rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
            justify-content: center;
            flex-wrap: nowrap;
            width: 100%;
        }

        .goal-box {
            background: var(--white);
            border: 1px solid var(--primary-lighter);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(124, 58, 237, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            flex: 1;
            max-width: 350px;
            min-width: 300px;
            margin: 0 1rem;
        }

        .goal-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
        }

        .goal-box:hover {
            border-color: var(--primary-color);
            box-shadow: 0 6px 12px rgba(124, 58, 237, 0.2);
        }

        .goal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .goal-progress {
            margin: 1.5rem 0;
        }

        .progress-bar-container {
            height: 12px;
            background: var(--white-dark);
            border-radius: 6px;
            overflow: hidden;
            margin: 1rem 0;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 6px;
            transition: width 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .goal-details {
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            color: var(--primary-dark);
            margin-top: 1rem;
        }

        .goal-amount {
            font-weight: 600;
        }

        .goal-percentage {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .days-left {
            font-size: 1.1rem;
            color: #666;
            margin-top: 1rem;
            text-align: right;
        }

        .days-left span {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .goals-grid {
                flex-direction: column;
                align-items: center;
            }
            
            .goal-box {
                width: 100%;
                max-width: 100%;
                margin: 0.5rem 0;
            }
        }
        
        /* Add new styles for graphs section */
        .graphs-container {
            margin: 2rem 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            animation: fadeInUp 0.8s ease-out 0.5s forwards;
            opacity: 0;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .graph-card {
            background: var(--white);
            border: 1px solid var(--primary-lighter);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(124, 58, 237, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .graph-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
        }
        
        .graph-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 6px 12px rgba(124, 58, 237, 0.2);
        }
        
        .graph-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            justify-content: center;
            position: relative;
            padding-bottom: 0.75rem;
        }
        
        .graph-card h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }
        
        .graph-container {
            height: 400px;
            position: relative;
            padding: 0.75rem;
        }
        
        @media (max-width: 768px) {
            .graphs-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="nav-container bg-violet-700">
        <div class="nav-content">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-pen-to-square" style="font-size: 3rem; color: #fdfdfd;"></i>
                <span class="text-white text-3xl font-bold">BudgetBuddy</span>
            </div>
            
            <div class="desktop-menu">
                <a href="../av1.php" class="nav-link">Home</a>
                <a href="index.php" class="nav-link">Dashboard</a>
                <a href="../bBudgetNEW/index.html" class="nav-link">Budget</a>
                <a href="../EXPENSESNEW/index.php" class="nav-link">Expenses</a>
                <a href="../savings.html" class="nav-link">Savings</a>
                <button class="profile-button" onclick="toggleDropdown()">
                    <i class="fas fa-user-circle text-3xl"></i>
                    <i class="fas fa-chevron-down ml-2" style="font-size: 0.75rem;"></i>
                </button>
                <div id="profile-dropdown" class="dropdown">
                    <a href="../profile.html" class="dropdown-item">
                        <i class="fas fa-user"></i>
                        My Profile
                    </a>
                    <a href="../signUpLogin/logout.php" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>

            <button class="mobile-menu-button" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-header">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-pen-to-square" style="font-size: 3rem; color: #fdfdfd;"></i>
                <span class="text-white text-3xl font-bold">BudgetBuddy</span>
            </div>
            <button class="mobile-menu-close" onclick="toggleMobileMenu()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-menu-links">
            <a href="../av1.php" class="nav-link">Home</a>
            <a href="index.php" class="nav-link">Dashboard</a>
            <a href="../bBudgetNEW/index.html" class="nav-link">Budget</a>
            <a href="../EXPENSESNEW/index.php" class="nav-link">Expenses</a>
            <a href="../savings.html" class="nav-link">Savings</a>
            <a href="../signUpLogin/logout.php" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('show');
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profile-dropdown');
            const profileButton = document.querySelector('.profile-button');
            
            if (!profileButton.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Get user data from session storage or localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const userData = JSON.parse(localStorage.getItem('userData')) || {
                name: 'User',
                profileImage: 'https://via.placeholder.com/40'
            };
            
            const profileImage = document.getElementById('profile-image');
            if (profileImage) {
                profileImage.src = userData.profileImage;
            }
        });
    </script>

    <div class="dashboard-header">
        <h1><i class="fas fa-chart-pie"></i> Financial Dashboard</h1>
    </div>
    
    <!-- Overview Cards Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card dashboard-card income-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-hand-holding-usd"></i> Total Income</h5>
                    <h3 class="card-text highlight-number" id="totalIncome">Loading...</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card dashboard-card expense-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-file-invoice-dollar"></i> Total Expenses</h5>
                    <h3 class="card-text highlight-number" id="totalExpenses">Loading...</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card dashboard-card balance-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-piggy-bank"></i> Net Balance</h5>
                    <h3 class="card-text highlight-number" id="netBalance">Loading...</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this section where you want to display the savings goals -->
    <div class="savings-overview">
        <h3><i class="fas fa-piggy-bank"></i> Top Savings Goals</h3>
        <div class="goals-grid">
            <div id="topGoals">
                <!-- Goals will be inserted here by JavaScript -->
            </div>
        </div>
    </div>
    
    <!-- Graphs Section -->
    <div class="graphs-container">
        <div class="graph-card">
            <h3><i class="fas fa-chart-pie"></i> Expense Categories</h3>
            <div class="graph-container">
                <canvas id="expenseCategoriesChart"></canvas>
            </div>
        </div>
        <div class="graph-card">
            <h3><i class="fas fa-chart-bar"></i> Income Sources</h3>
            <div class="graph-container">
                <canvas id="incomeSourcesChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Transactions Section -->
    <div class="card transaction-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title"><i class="fas fa-exchange-alt"></i> Recent Transactions</h5>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-3" id="transactionTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="income-tab" data-bs-toggle="tab" href="#income" role="tab">
                        <i class="fas fa-money-bill-wave"></i> Recent Income
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="expenses-tab" data-bs-toggle="tab" href="#expenses" role="tab">
                        <i class="fas fa-receipt"></i> Recent Expenses
                    </a>
                </li>
            </ul>
            
            <div class="tab-content" id="transactionTabContent">
                <div class="tab-pane fade show active" id="income" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Source</th>
                                    <th>Amount</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody id="recentIncome"></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="expenses" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="recentExpenses"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        async function loadDashboardData() {
            try {
                // Fetch expense data
                const expenseResponse = await fetch('index.php?action=expense_stats');
                const expenseData = await expenseResponse.json();
                
                // Fetch income data
                const incomeResponse = await fetch('index.php?action=income_stats');
                const incomeData = await incomeResponse.json();
                
                updateOverviewCards(incomeData, expenseData);
                loadRecentTransactions();
                initializeCharts(expenseData, incomeData);
            } catch (error) {
                console.error('Error loading dashboard data:', error);
            }
        }

        function updateOverviewCards(incomeData, expenseData) {
            const totalIncome = incomeData.total;
            const totalExpenses = expenseData.total;
            const netBalance = totalIncome - totalExpenses;
            
            document.getElementById('totalIncome').textContent = '₹' + totalIncome.toFixed(2);
            document.getElementById('totalExpenses').textContent = '₹' + totalExpenses.toFixed(2);
            document.getElementById('netBalance').textContent = '₹' + netBalance.toFixed(2);
            
            // Add color indicators based on values
            const netBalanceElement = document.getElementById('netBalance');
            if (netBalance >= 0) {
                netBalanceElement.style.color = 'var(--primary-color)';
            } else {
                netBalanceElement.style.color = 'var(--primary-color)';
            }
        }

        async function loadRecentTransactions() {
            try {
                // Load recent income
                const incomeResponse = await fetch('index.php?action=recent_income');
                const incomeData = await incomeResponse.json();
                
                const incomeBody = document.getElementById('recentIncome');
                incomeBody.innerHTML = '';
                incomeData.forEach(income => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${new Date(income.income_date).toLocaleDateString()}</td>
                        <td>${income.source}</td>
                        <td><span class="badge badge-income">₹${parseFloat(income.amount).toFixed(2)}</span></td>
                        <td>${income.notes || ''}</td>
                    `;
                    incomeBody.appendChild(row);
                });

                // Load recent expenses
                const expenseResponse = await fetch('index.php?action=expensesnew_recent');
                const expenseData = await expenseResponse.json();
                
                const expenseBody = document.getElementById('recentExpenses');
                expenseBody.innerHTML = '';
                expenseData.forEach(expense => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${new Date(expense.date).toLocaleDateString()}</td>
                        <td>${expense.category}</td>
                        <td>${expense.description}</td>
                        <td><span class="badge badge-expense">₹${parseFloat(expense.amount).toFixed(2)}</span></td>
                    `;
                    expenseBody.appendChild(row);
                });
            } catch (error) {
                console.error('Error loading transactions:', error);
            }
        }

        // Initialize dashboard when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardData();
            
            // Set up auto-refresh every 30 seconds
            setInterval(loadDashboardData, 30000);
        });

        function loadTopSavingsGoals() {
            const goals = JSON.parse(localStorage.getItem("savingsGoals")) || [];
            const topGoalsContainer = document.getElementById("topGoals");
            
            if (goals.length === 0) {
                topGoalsContainer.innerHTML = '<p class="text-center text-gray-500">No savings goals found</p>';
                return;
            }

            // Calculate progress percentage and sort goals
            const goalsWithProgress = goals.map(goal => {
                const percentage = Math.min((goal.current / goal.target) * 100, 100);
                const daysLeft = calculateDaysLeft(goal.targetDate);
                return { ...goal, percentage, daysLeft };
            })
            .filter(goal => goal.percentage < 100) // Filter out completed goals
            .sort((a, b) => b.percentage - a.percentage) // Sort by percentage completion
            .slice(0, 3); // Get top 3 goals

            // Create HTML for each goal
            const goalsHTML = goalsWithProgress.map(goal => `
                <div class="goal-box">
                    <div class="goal-title">
                        <i class="fas fa-star"></i>
                        ${goal.title}
                    </div>
                    <div class="goal-details">
                        <span class="goal-amount">${formatCurrency(goal.current)} / ${formatCurrency(goal.target)}</span>
                    </div>
                    <div class="goal-progress">
                        <div class="progress-bar-container">
                            <div class="progress-bar-fill" style="width: ${goal.percentage}%"></div>
                        </div>
                        <div class="goal-percentage">${goal.percentage.toFixed(1)}% Complete</div>
                    </div>
                    <div class="days-left">
                        <span>${goal.daysLeft}</span> days remaining
                    </div>
                </div>
            `).join('');

            // Set the HTML directly to the container
            topGoalsContainer.innerHTML = goalsHTML;
            
            // Add a class to the container to ensure it displays as a row
            topGoalsContainer.style.display = 'flex';
            topGoalsContainer.style.flexDirection = 'row';
            topGoalsContainer.style.flexWrap = 'nowrap';
            topGoalsContainer.style.justifyContent = 'center';
            topGoalsContainer.style.width = '100%';
            topGoalsContainer.style.gap = '1rem';
        }

        function calculateDaysLeft(targetDate) {
            const today = new Date();
            const target = new Date(targetDate);
            const diffTime = target - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays > 0 ? diffDays : 0;
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR',
                maximumFractionDigits: 0
            }).format(amount);
        }

        // Call this function when the page loads
        document.addEventListener('DOMContentLoaded', loadTopSavingsGoals);
        
        // Initialize Charts
        function initializeCharts(expenseData, incomeData) {
            // Expense Categories Chart
            const expenseCategoriesCtx = document.getElementById('expenseCategoriesChart').getContext('2d');
            const expenseCategoriesChart = new Chart(expenseCategoriesCtx, {
                type: 'doughnut',
                data: {
                    labels: expenseData.categories.map(cat => cat.category),
                    datasets: [{
                        data: expenseData.categories.map(cat => cat.amount),
                        backgroundColor: [
                            '#6f42c1', '#8a6fd1', '#a08ad9', '#b8a5e1', '#d0c0e9',
                            '#e8d5f1', '#f0eaf9', '#6f42c1', '#8a6fd1', '#a08ad9'
                        ],
                        borderWidth: 1,
                        borderColor: '#ffffff',
                        hoverOffset: 10,
                        hoverBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    size: 12
                                },
                                padding: 15,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${context.label}: ₹${value.toFixed(2)} (${percentage}%)`;
                                }
                            },
                            backgroundColor: 'rgba(111, 66, 193, 0.8)',
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: true
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    }
                }
            });
            
            // Income Sources Chart
            const incomeSourcesCtx = document.getElementById('incomeSourcesChart').getContext('2d');
            
            // Generate random income sources data for demonstration
            const incomeSources = [
                { source: 'Salary', amount: incomeData.total * 0.7 },
                { source: 'Freelance', amount: incomeData.total * 0.15 },
                { source: 'Investments', amount: incomeData.total * 0.1 },
                { source: 'Other', amount: incomeData.total * 0.05 }
            ];
            
            const incomeSourcesChart = new Chart(incomeSourcesCtx, {
                type: 'bar',
                data: {
                    labels: incomeSources.map(source => source.source),
                    datasets: [{
                        label: 'Income Sources',
                        data: incomeSources.map(source => source.amount),
                        backgroundColor: [
                            'rgba(111, 66, 193, 0.8)',
                            'rgba(138, 111, 209, 0.8)',
                            'rgba(160, 138, 217, 0.8)',
                            'rgba(184, 165, 225, 0.8)'
                        ],
                        borderColor: [
                            'rgba(111, 66, 193, 1)',
                            'rgba(138, 111, 209, 1)',
                            'rgba(160, 138, 217, 1)',
                            'rgba(184, 165, 225, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 5,
                        barThickness: 'flex',
                        maxBarThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `₹${context.raw.toFixed(2)}`;
                                }
                            },
                            backgroundColor: 'rgba(111, 66, 193, 0.8)',
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(111, 66, 193, 0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value.toLocaleString();
                                },
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }
    </script>
</div> <!-- Close the container div -->
</body>
</html>