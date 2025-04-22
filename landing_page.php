<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Buddy - Your Personal Finance Companion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #7c3aed;
            --primary-light: #8b5cf6;
            --primary-dark: #6d28d9;
            --primary-lighter: #a78bfa;
            --primary-darker: #5b21b6;
            --white: #ffffff;
            --white-off: #f8f9fa;
            --white-dark: #e9ecef;
            --accent-color: #7c3aed;
            --accent-light: #8b5cf6;
            --accent-dark: #6d28d9;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #7c3aed;
            background: linear-gradient(135deg, var(--white-off) 0%, var(--white-dark) 100%);
            background-image: url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
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
        
        .navbar {
            background: rgba(111, 66, 193, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 15px rgba(111, 66, 193, 0.2);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
            color: var(--white);
        }
        
        .navbar-brand i {
            color: var(--white);
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover i {
            transform: rotate(10deg);
        }
        
        .nav-link {
            color: var(--white) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background-color: var(--white);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::before {
            width: 80%;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--white) !important;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .navbar .btn-primary {
            background: var(--white);
            color: var(--primary-color) !important;
            border: none;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .navbar .btn-primary:hover {
            background: var(--white-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .hero-section {
            padding: 5rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(111, 66, 193, 0.1) 0%, rgba(111, 66, 193, 0) 70%);
            z-index: -1;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: #7c3aed;
            margin-bottom: 1.5rem;
            animation: fadeInDown 1s ease-out;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            color: #7c3aed;
            margin-bottom: 2rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeInUp 1s ease-out 0.3s forwards;
            opacity: 0;
        }
        
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
            animation: fadeInUp 1s ease-out 0.6s forwards;
            opacity: 0;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(111, 66, 193, 0.2);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(111, 66, 193, 0.2);
        }
        
        .features-section {
            padding: 5rem 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            margin: 2rem auto;
            max-width: 1400px;
            box-shadow: 0 15px 30px rgba(111, 66, 193, 0.1);
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #7c3aed;
            margin-bottom: 3rem;
            position: relative;
            padding-bottom: 1rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }
        
        .feature-card {
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 20px rgba(111, 66, 193, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            border-top: 5px solid var(--primary-color);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(111, 66, 193, 0.2);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }
        
        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #7c3aed;
            margin-bottom: 1rem;
        }
        
        .feature-text {
            color: #7c3aed;
            line-height: 1.6;
        }
        
        .about-section {
            padding: 5rem 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            margin: 2rem auto;
            max-width: 1400px;
            box-shadow: 0 15px 30px rgba(111, 66, 193, 0.1);
        }
        
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }
        
        .about-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(111, 66, 193, 0.2);
        }
        
        .about-image img {
            width: 100%;
            height: auto;
            transition: all 0.5s ease;
        }
        
        .about-image:hover img {
            transform: scale(1.05);
        }
        
        .about-text h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #7c3aed;
            margin-bottom: 1.5rem;
        }
        
        .about-text p {
            color: #7c3aed;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }
        
        .contact-section {
            padding: 5rem 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            margin: 2rem auto;
            max-width: 1400px;
            box-shadow: 0 15px 30px rgba(111, 66, 193, 0.1);
        }
        
        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }
        
        .contact-info {
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 20px rgba(111, 66, 193, 0.1);
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: rgba(111, 66, 193, 0.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .contact-text h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #7c3aed;
            margin-bottom: 0.25rem;
        }
        
        .contact-text p {
            color: #7c3aed;
            margin: 0;
        }
        
        .contact-form {
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 20px rgba(111, 66, 193, 0.1);
        }
        
        .footer {
            background: #000000;
            color: var(--white);
            padding: 2rem 0 1rem 0;
            margin-top: 3rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 2rem;
            margin-bottom: 1rem;
        }
        
        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .footer-logo i {
            color: white;
            font-size: 1.5rem;
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            font-size: 1.1rem;
            max-width: 400px;
        }
        
        .footer-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background: white;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.5rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        
        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .copyright {
            text-align: center;
            padding-top: 1rem;
            margin-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
        
        /* Login and Signup Styles */
        .auth-container {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border-radius: 30px;
            box-shadow: 0 8px 32px rgba(124, 58, 237, 0.15);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
            margin: 2rem auto;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .auth-form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
            background: linear-gradient(45deg, rgba(124, 58, 237, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
            backdrop-filter: blur(5px);
        }
        
        .auth-sign-in {
            left: 0;
            width: 50%;
            z-index: 2;
        }
        
        .auth-container.active .auth-sign-in {
            transform: translateX(100%);
        }
        
        .auth-sign-up {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }
        
        .auth-container.active .auth-sign-up {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: move 0.6s;
        }
        
        @keyframes move {
            0%, 49.99% {
                opacity: 0;
                z-index: 1;
            }
            50%, 100% {
                opacity: 1;
                z-index: 5;
            }
        }
        
        .auth-social-icons {
            margin: 20px 0;
        }
        
        .auth-social-icons a {
            border: 1px solid rgba(124, 58, 237, 0.2);
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 5px;
            width: 40px;
            height: 40px;
            transition: all 0.3s ease;
        }
        
        .auth-social-icons a:hover {
            transform: translateY(-2px);
            background: linear-gradient(45deg, #7c3aed, #8b5cf6);
            color: white;
        }
        
        .auth-toggle-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: all 0.6s ease-in-out;
            border-radius: 150px 0 0 100px;
            z-index: 1000;
        }
        
        .auth-container.active .auth-toggle-container {
            transform: translateX(-100%);
            border-radius: 0 150px 100px 0;
        }
        
        .auth-toggle {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 50%, #6d28d9 100%);
            height: 100%;
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }
        
        .auth-container.active .auth-toggle {
            transform: translateX(50%);
        }
        
        .auth-toggle-panel {
            position: absolute;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 30px;
            text-align: center;
            top: 0;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }
        
        .auth-toggle-left {
            transform: translateX(-200%);
        }
        
        .auth-container.active .auth-toggle-left {
            transform: translateX(0);
        }
        
        .auth-toggle-right {
            right: 0;
            transform: translateX(0);
        }
        
        .auth-container.active .auth-toggle-right {
            transform: translateX(200%);
        }
        
        .auth-form {
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            height: 100%;
            backdrop-filter: blur(5px);
            border-radius: 20px;
        }
        
        .auth-form input {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(124, 58, 237, 0.2);
            margin: 8px 0;
            padding: 12px 15px;
            font-size: 13px;
            border-radius: 8px;
            width: 100%;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .auth-form input:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 2px rgba(124, 58, 237, 0.1);
        }
        
        .auth-form button {
            background: linear-gradient(45deg, #7c3aed, #8b5cf6);
            color: #fff;
            font-size: 12px;
            padding: 12px 45px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.2);
        }
        
        .auth-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.3);
        }
        
        .auth-form button.hidden {
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.3));
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        
        .auth-form a {
            color: #333;
            font-size: 13px;
            text-decoration: none;
            margin: 15px 0 10px;
        }
        
        .auth-form span {
            font-size: 12px;
        }
        
        .auth-form p {
            font-size: 14px;
            line-height: 20px;
            letter-spacing: 0.3px;
            margin: 20px 0;
        }
        
        .auth-redirect-text {
            margin-top: 15px;
            font-size: 14px;
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 992px) {
            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .footer-logo {
                justify-content: center;
            }
            
            .footer-text {
                max-width: 100%;
            }
            
            .footer-title::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .footer-links a {
                justify-content: center;
            }
            
            .footer-links a:hover {
                transform: translateX(0) scale(1.05);
            }
        }
        
        @media (max-width: 991px) {
            .navbar-collapse {
                background: rgba(111, 66, 193, 0.98);
                padding: 1rem;
                border-radius: 10px;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-piggy-bank"></i> Budget Buddy
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signUpLogin/login.html">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white ms-2" href="signUpLogin/signup.html">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <h1 class="hero-title">Take Control of Your Finances</h1>
            <p class="hero-subtitle">Budget Buddy helps you track expenses, set savings goals, and achieve financial freedom with our intuitive personal finance dashboard.</p>
            <div class="hero-buttons">
                <a href="signUpLogin/signup.html" class="btn btn-primary">Get Started</a>
                <a href="#features" class="btn btn-outline-primary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Why Choose Budget Buddy?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Expense Tracking</h3>
                        <p class="feature-text">Easily track your daily expenses across different categories and visualize your spending patterns with interactive charts.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-piggy-bank"></i>
                        </div>
                        <h3 class="feature-title">Savings Goals</h3>
                        <p class="feature-text">Set and track your savings goals with progress indicators and reminders to help you stay on track.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h3 class="feature-title">Income Management</h3>
                        <p class="feature-text">Keep track of all your income sources and analyze your earning patterns over time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h3 class="feature-title">Budget Planning</h3>
                        <p class="feature-text">Create and manage budgets for different categories to ensure you're spending within your means.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3 class="feature-title">Smart Notifications</h3>
                        <p class="feature-text">Receive alerts when you're approaching budget limits or when it's time to contribute to your savings goals.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="feature-title">Mobile Friendly</h3>
                        <p class="feature-text">Access your financial dashboard from any device with our responsive design that works on all screen sizes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <h2 class="section-title">About Us</h2>
            <div class="about-content">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1554224154-26032ffc0d07?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="About Budget Buddy">
                </div>
                <div class="about-text">
                    <h3>Our Mission</h3>
                    <p>At Budget Buddy, we believe that financial freedom is achievable for everyone. Our mission is to provide individuals with the tools and insights they need to take control of their finances and build a secure future.</p>
                    
                    <h3>Our Values</h3>
                    <p>We are guided by our core values of transparency, simplicity, and empowerment. We believe in providing clear, honest information about personal finance and creating tools that are easy to use while delivering powerful insights.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <h2 class="section-title">Contact Us</h2>
            <div class="contact-container">
                <div class="contact-info">
                    <h3 class="mb-4">Get in Touch</h3>
                    <p class="mb-4">Have questions or feedback? We'd love to hear from you. Reach out to us using the contact information below or fill out the form.</p>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Address</h4>
                            <p>123 Finance Street, Money City, MC 12345</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Phone</h4>
                            <p>+1 (123) 456-7890</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Email</h4>
                            <p>info@budgetbuddy.com</p>
                        </div>
                    </div>
                    
                </div>
                
                <div class="contact-form">
                    <h3 class="mb-4">Send Us a Message</h3>
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" placeholder="Enter subject">
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Enter your message"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <div class="footer-logo">
                        <i class="fas fa-piggy-bank"></i>
                        <span>Budget Buddy</span>
                    </div>
                    <p class="footer-text">Your personal finance companion that helps you track expenses, set savings goals, and achieve financial freedom.</p>
                </div>
                
                <div class="footer-nav">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="#home"><i class="fas fa-chevron-right me-2"></i>Home</a></li>
                        <li><a href="#features"><i class="fas fa-chevron-right me-2"></i>Features</a></li>
                        <li><a href="#about"><i class="fas fa-chevron-right me-2"></i>About Us</a></li>
                        <li><a href="#contact"><i class="fas fa-chevron-right me-2"></i>Contact</a></li>
                        <li><a href="signUpLogin/login.html"><i class="fas fa-chevron-right me-2"></i>Login</a></li>
                        <li><a href="signUpLogin/signup.html"><i class="fas fa-chevron-right me-2"></i>Sign Up</a></li>
                    </ul>
                </div>
                
                <div class="footer-features">
                    <h4 class="footer-title">Features</h4>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Expense Tracking</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Savings Goals</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Income Management</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Budget Planning</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Smart Notifications</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 Budget Buddy. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Contact form submission
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Get form values
                    const name = document.getElementById('name').value;
                    const email = document.getElementById('email').value;
                    const subject = document.getElementById('subject').value;
                    const message = document.getElementById('message').value;
                    
                    // Simple validation
                    if (!name || !email || !subject || !message) {
                        alert('Please fill in all fields');
                        return;
                    }
                    
                    // In a real application, you would send this data to a server
                    // For now, we'll just show a success message
                    alert('Thank you for your message! We will get back to you soon.');
                    contactForm.reset();
                });
            }
        });
    </script>
</body>
</html> 