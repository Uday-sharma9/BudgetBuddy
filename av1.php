<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BudgetBuddy Navbar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-violet-600 p-4 h-[80px] shadow-lg fixed w-full z-50 top-0 left-0">
    <div class="container mx-auto flex justify-between items-center px-6">

      <!-- Logo -->
      <div class="flex items-center space-x-2">
        <!-- <img src="https://via.placeholder.com/40" alt="Logo" class="w-10 h-10 rounded-full"> -->
        <i class="fa-solid fa-pen-to-square" style="font-size: 3rem; color: #fdfdfd;"></i>
        <span class="text-white text-2xl font-bold">BudgetBuddy</span>
      </div>

      <!-- Desktop Menu -->
      <ul class="hidden md:flex space-x-8 text-white font-semibold text-xl ml-[-150px]">
        <li><a href="av1.php" class="hover:underline underline-offset-8">Home</a></li>
        <li><a href="DASHBOARDNEW/index.php" class="hover:underline underline-offset-8">Dashboard</a></li>
        <li><a href="bBudgetNEW/index.html" class="hover:underline underline-offset-8">Budget</a></li>
        <li><a href="EXPENSESNEW/index.php" class="hover:underline underline-offset-8">Expenses</a></li>
        <li><a href="savings.html" class="hover:underline underline-offset-8">Savings</a></li>
      </ul>

      <!-- Profile Button -->
      <div class="hidden md:flex items-center space-x-4">
        <div class="relative group">
          <button class="flex items-center space-x-2 text-white hover:text-gray-200" onclick="toggleProfileMenu()">
            <i class="fas fa-user-circle text-3xl"></i>
            <i class="fas fa-chevron-down"></i>
          </button>
          <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden">
            <a href="profile.html" class="block px-4 py-2 text-gray-800 hover:bg-violet-100">My Profile</a>
            <a href="signUpLogin/logout.php" class="block px-4 py-2 text-gray-800 hover:bg-violet-100">Logout</a>
          </div>
        </div>
      </div>

      <!-- Mobile Menu Button -->
      <button class="md:hidden text-white focus:outline-none" onclick="toggleMenu()">
        <i class="fas fa-bars text-2xl" id="menu-icon"></i>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden bg-violet-700 text-white text-center absolute w-full top-[80px] transition-transform duration-300">
      <ul class="px-6 py-4 space-y-3 text-xl">
        <li><a href="av1.php" class="block py-2 hover:underline underline-offset-8">Home</a></li>
        <li><a href="DASHBOARDNEW/index.php" class="block py-2 hover:underline underline-offset-8">Dashboard</a></li>
        <li><a href="bBudgetNEW/index.html" class="block py-2 hover:underline underline-offset-8">Budget</a></li>
        <li><a href="EXPENSESNEW/index.php" class="block py-2 hover:underline underline-offset-8">Expenses</a></li>
        <li><a href="savings.html" class="block py-2 hover:underline underline-offset-8">Savings</a></li>
        <li><a href="profile.html" class="block py-2 bg-white text-violet-600 rounded-lg">My Profile</a></li>
        <li><a href="signUpLogin/logout.php" class="block py-2 bg-violet-500 text-white rounded-lg">Logout</a></li>
      </ul>
    </div>
  </nav>

  <script>
    function toggleMenu() {
      const menu = document.getElementById('mobile-menu');
      const icon = document.getElementById('menu-icon');

      if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
      } else {
        menu.classList.add('hidden');
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
      }
    }

    function toggleProfileMenu() {
      const dropdown = document.getElementById('profile-dropdown');
      if (dropdown.classList.contains('hidden')) {
        dropdown.classList.remove('hidden');
      } else {
        dropdown.classList.add('hidden');
      }
    }
  </script>
    <br><br>


  <div class="max-w-5xl mx-auto mt-14 bg-violet-600 rounded-2xl shadow-2xl overflow-hidden p-6">
    <section class="relative w-full h-[50vh] bg-cover bg-center rounded-2xl" style="background-image: url('https://source.unsplash.com/1600x900/?finance,budget');">
        <div class="absolute inset-0  flex flex-col items-center justify-center text-center px-6 ">
            <div>
              <i class="fa-solid fa-pen-to-square" style="font-size: 3rem; color: #fdfdfd;"></i>
                <span class="text-6xl font-bold text-white mx-2 "> BudgetBuddy</span><br>
                <p class="text-4xl text-white mt-4 ">Spend Smart, Budget Like a Pro!</p>
            </div>
        </div>
    </section>
</div>


<div> 
  <br><br>
  <h1 class="text-4xl font-bold text-gray-800 mb-10 text-center">Why to Choose BudgetBuddy?</h1>

  <div class="flex flex-wrap justify-center gap-6">
      
      <!-- Smart Analytics Card -->
      <div class="bg-white p-8 rounded-lg transition-all duration-300 hover:scale-105 transition-transform duration-300 shadow-lg w-64 text-center hover:shadow-2xl">
          <i class="fa-solid fa-chart-line text-5xl text-violet-600 mb-4"></i>
          <h2 class="text-2xl font-semibold mb-2">Smart Analytics</h2>
          <p class="text-gray-600 text-lg">Track your spending patterns with detailed insights</p>
      </div>

      <!-- Savings Goals Card -->
      <div class="bg-white p-8 rounded-lg shadow-lg w-64 text-center hover:scale-105 transition-transform duration-300 hover:shadow-2xl">
          <i class="fa-solid fa-piggy-bank text-5xl text-violet-600 mb-4"></i>
          <h2 class="text-2xl font-semibold mb-2">Savings Goals</h2>
          <p class="text-gray-600 text-lg">Set and achieve your financial goals</p>
      </div>

      <!-- Smart Alerts Card -->
      <div class="bg-white p-8 rounded-lg shadow-lg w-64 text-center hover:scale-105 transition-transform duration-300 hover:shadow-2xl">
          <i class="fa-solid fa-bell text-5xl text-violet-600 mb-4"></i>
          <h2 class="text-2xl font-semibold mb-2">Smart Alerts</h2>
          <p class="text-gray-600 text-lg">Get notified about overspending and bill reminders</p>
      </div>

      <!-- Secure Card -->
      <div class="bg-white p-8 rounded-lg shadow-lg w-64 text-center hover:scale-105 transition-transform duration-300 hover:shadow-2xl">
          <i class="fa-solid fa-shield text-5xl text-violet-600 mb-4"></i>
          <h2 class="text-2xl font-semibold mb-2">Secure</h2>
          <p class="text-gray-600 text-lg">Your financial data is safe with us</p>
      </div>

    
  </div>

</div>


<br><br>

<!-- Financial Tips Section -->
<div class="max-w-6xl mx-auto mt-8 bg-white rounded-2xl shadow-2xl p-6">
  <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">Financial Tips</h2>
  
  <div class="relative">
    <div class="overflow-hidden">
      <div id="tips-slider" class="flex transition-transform duration-300 ease-in-out">
        <!-- First set of tips -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 min-w-full">
          <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
            <div class="text-violet-600 mb-3">
              <i class="fas fa-piggy-bank text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">50/30/20 Rule</h3>
            <p class="text-gray-600 text-sm">Allocate 50% of your income to needs, 30% to wants, and 20% to savings and debt repayment.</p>
          </div>
          
          <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
            <div class="text-violet-600 mb-3">
              <i class="fas fa-chart-line text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Emergency Fund</h3>
            <p class="text-gray-600 text-sm">Build an emergency fund with 3-6 months of expenses to handle unexpected financial challenges.</p>
          </div>
          
          <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
            <div class="text-violet-600 mb-3">
              <i class="fas fa-receipt text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Track Every Expense</h3>
            <p class="text-gray-600 text-sm">Record all your expenses, no matter how small, to identify spending patterns and areas to cut back.</p>
          </div>
        </div>
        
        <!-- Second set of tips -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 min-w-full">
          <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
            <div class="text-violet-600 mb-3">
              <i class="fas fa-credit-card text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Pay Yourself First</h3>
            <p class="text-gray-600 text-sm">Set aside a portion of your income for savings before paying bills or spending on discretionary items.</p>
          </div>
          
          <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
            <div class="text-violet-600 mb-3">
              <i class="fas fa-hand-holding-usd text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Avoid Lifestyle Inflation</h3>
            <p class="text-gray-600 text-sm">As your income increases, resist the urge to increase spending proportionally. Save the difference instead.</p>
          </div>
          
          <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
            <div class="text-violet-600 mb-3">
              <i class="fas fa-university text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Invest for the Long Term</h3>
            <p class="text-gray-600 text-sm">Start investing early and focus on long-term growth rather than short-term market fluctuations.</p>
          </div>
        </div>
        
        <!-- Third set of tips -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 min-w-full">
          <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
            <div class="text-violet-600 mb-3">
              <i class="fas fa-file-invoice-dollar text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Automate Your Savings</h3>
            <p class="text-gray-600 text-sm">Set up automatic transfers to your savings account to ensure you consistently save without thinking about it.</p>
          </div>
          
          <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
            <div class="text-violet-600 mb-3">
              <i class="fas fa-chart-pie text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Diversify Your Income</h3>
            <p class="text-gray-600 text-sm">Consider multiple income streams like side hustles, investments, or passive income to increase financial security.</p>
          </div>
          
          <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
            <div class="text-violet-600 mb-3">
              <i class="fas fa-balance-scale text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Live Below Your Means</h3>
            <p class="text-gray-600 text-sm">Spend less than you earn and avoid unnecessary debt to build wealth over time.</p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Navigation buttons -->
    <!-- Removing the left and right arrow buttons -->
    
    <!-- Dots indicator -->
    <div class="flex justify-center mt-4 space-x-2">
      <button class="tip-dot w-3 h-3 rounded-full bg-violet-300" data-index="0"></button>
      <button class="tip-dot w-3 h-3 rounded-full bg-violet-100" data-index="1"></button>
      <button class="tip-dot w-3 h-3 rounded-full bg-violet-100" data-index="2"></button>
    </div>
  </div>
</div>

<br><br>

<!-- Testimonials Section -->
<div class="max-w-6xl mx-auto mt-8 bg-white rounded-2xl shadow-2xl p-6">
  <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">What Our Users Say</h2>
  
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- First Testimonial -->
    <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
      <div class="text-violet-600 mb-3">
        <i class="fas fa-quote-left text-3xl"></i>
      </div>
      <p class="text-gray-700 mb-4">"BudgetBuddy helped me save 20% of my salary! The insights and tracking features are amazing."</p>
      <div class="flex items-center">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="John Doe" class="w-12 h-12 rounded-full mr-3">
        <div>
          <h3 class="font-semibold text-gray-800">John Doe</h3>
          <p class="text-sm text-gray-500">Software Engineer</p>
        </div>
      </div>
    </div>
    
    <!-- Second Testimonial -->
    <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
      <div class="text-violet-600 mb-3">
        <i class="fas fa-quote-left text-3xl"></i>
      </div>
      <p class="text-gray-700 mb-4">"Now I track my expenses easily! The app is intuitive and helps me stay on budget every month."</p>
      <div class="flex items-center">
        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Emily Smith" class="w-12 h-12 rounded-full mr-3">
        <div>
          <h3 class="font-semibold text-gray-800">Emily Smith</h3>
          <p class="text-sm text-gray-500">Marketing Manager</p>
        </div>
      </div>
    </div>
    
    <!-- Third Testimonial -->
    <div class="bg-violet-50 p-6 rounded-lg shadow-sm">
      <div class="text-violet-600 mb-3">
        <i class="fas fa-quote-left text-3xl"></i>
      </div>
      <p class="text-gray-700 mb-4">"Best budgeting tool for students! It's helped me manage my limited income while in college."</p>
      <div class="flex items-center">
        <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Michael Johnson" class="w-12 h-12 rounded-full mr-3">
        <div>
          <h3 class="font-semibold text-gray-800">Michael Johnson</h3>
          <p class="text-sm text-gray-500">College Student</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Features Showcase Section -->
<div class="max-w-6xl mx-auto mt-16 bg-white rounded-2xl shadow-2xl p-8">
  <h2 class="text-3xl font-bold text-center text-gray-900 mb-10">Powerful Features</h2>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Feature 1 -->
    <div class="flex items-start space-x-4 p-6 bg-violet-50 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
      <div class="bg-violet-100 p-4 rounded-full">
        <i class="fas fa-chart-pie text-3xl text-violet-600"></i>
      </div>
      <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Expense Categorization</h3>
        <p class="text-gray-600">Automatically categorize your expenses to get a clear picture of where your money is going.</p>
      </div>
    </div>
    
    <!-- Feature 2 -->
    <div class="flex items-start space-x-4 p-6 bg-violet-50 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
      <div class="bg-violet-100 p-4 rounded-full">
        <i class="fas fa-calendar-alt text-3xl text-violet-600"></i>
      </div>
      <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Bill Reminders</h3>
        <p class="text-gray-600">Never miss a payment with customizable reminders for your recurring bills.</p>
      </div>
    </div>
    
    <!-- Feature 3 -->
    <div class="flex items-start space-x-4 p-6 bg-violet-50 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
      <div class="bg-violet-100 p-4 rounded-full">
        <i class="fas fa-mobile-alt text-3xl text-violet-600"></i>
      </div>
      <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Mobile App</h3>
        <p class="text-gray-600">Access your budget on the go with our mobile app for iOS and Android devices.</p>
      </div>
    </div>
    
    <!-- Feature 4 -->
    <div class="flex items-start space-x-4 p-6 bg-violet-50 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
      <div class="bg-violet-100 p-4 rounded-full">
        <i class="fas fa-file-export text-3xl text-violet-600"></i>
      </div>
      <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Export Reports</h3>
        <p class="text-gray-600">Generate and export detailed financial reports in PDF or CSV format for your records.</p>
      </div>
    </div>
  </div>
</div>

<!-- FAQ Section -->
<div class="max-w-6xl mx-auto mt-16 bg-white rounded-2xl shadow-2xl p-8">
  <h2 class="text-3xl font-bold text-center text-gray-900 mb-10">Frequently Asked Questions</h2>
  
  <div class="space-y-6">
    <!-- FAQ Item 1 -->
    <div class="border-b border-gray-200 pb-6">
      <button class="flex justify-between items-center w-full text-left focus:outline-none" onclick="toggleFAQ(this)">
        <h3 class="text-xl font-semibold text-gray-800">How does BudgetBuddy help me save money?</h3>
        <i class="fas fa-chevron-down text-violet-600"></i>
      </button>
      <div class="mt-4 text-gray-600 hidden">
        <p>BudgetBuddy helps you save money by providing detailed insights into your spending habits, setting up savings goals, and sending alerts when you're close to exceeding your budget. Our analytics help identify areas where you can cut back, and our automated savings features make it easy to put money aside.</p>
      </div>
    </div>
    
    <!-- FAQ Item 2 -->
    <div class="border-b border-gray-200 pb-6">
      <button class="flex justify-between items-center w-full text-left focus:outline-none" onclick="toggleFAQ(this)">
        <h3 class="text-xl font-semibold text-gray-800">Is my financial data secure?</h3>
        <i class="fas fa-chevron-down text-violet-600"></i>
      </button>
      <div class="mt-4 text-gray-600 hidden">
        <p>Yes, we take your financial security seriously. All data is encrypted using industry-standard protocols, and we never store your bank account credentials. Our servers are protected with advanced security measures, and we regularly undergo security audits to ensure your information remains safe.</p>
      </div>
    </div>
    
    <!-- FAQ Item 3 -->
    <div class="border-b border-gray-200 pb-6">
      <button class="flex justify-between items-center w-full text-left focus:outline-none" onclick="toggleFAQ(this)">
        <h3 class="text-xl font-semibold text-gray-800">Can I use BudgetBuddy on multiple devices?</h3>
        <i class="fas fa-chevron-down text-violet-600"></i>
      </button>
      <div class="mt-4 text-gray-600 hidden">
        <p>Yes, BudgetBuddy is available on web browsers, iOS, and Android devices. Your data syncs automatically across all your devices, so you can access your budget information wherever you are. Simply log in with the same account on each device.</p>
      </div>
    </div>
    
    <!-- FAQ Item 4 -->
    <div class="border-b border-gray-200 pb-6">
      <button class="flex justify-between items-center w-full text-left focus:outline-none" onclick="toggleFAQ(this)">
        <h3 class="text-xl font-semibold text-gray-800">How do I cancel my subscription?</h3>
        <i class="fas fa-chevron-down text-violet-600"></i>
      </button>
      <div class="mt-4 text-gray-600 hidden">
        <p>You can cancel your subscription at any time by going to your account settings and selecting "Subscription." Click on "Cancel Subscription" and follow the prompts. Your subscription will remain active until the end of your current billing period, after which you'll be downgraded to the free plan.</p>
      </div>
    </div>
  </div>
</div>

<!-- Contact Section -->
<div class="max-w-4xl mx-auto mt-16 mb-16">
  <div class="bg-white rounded-2xl shadow-2xl p-8">
    <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Contact Us</h2>
    
    <form id="contactForm" class="space-y-6" onsubmit="submitContactForm(event)">
      <div id="formMessage" class="hidden rounded-lg p-4 mb-4 text-sm"></div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
          <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition duration-200" placeholder="Your Name" required>
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition duration-200" placeholder="your@email.com" required>
        </div>
      </div>
      
      <div>
        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
        <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition duration-200" placeholder="How can we help?" required>
      </div>
      
      <div>
        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
        <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition duration-200 resize-none" placeholder="Your message here..." required></textarea>
      </div>
      
      <div class="flex justify-center">
        <button type="submit" id="submitBtn" class="bg-violet-600 text-white px-8 py-3 rounded-lg hover:bg-violet-700 transition duration-200 flex items-center space-x-2">
          <span>Send Message</span>
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>
    </form>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
      <div class="flex flex-col items-center">
        <div class="bg-violet-100 p-3 rounded-full mb-3">
          <i class="fas fa-envelope text-violet-600 text-xl"></i>
        </div>
        <h3 class="font-semibold">Email</h3>
        <p class="text-gray-600">support@budgetbuddy.com</p>
      </div>
      
      <div class="flex flex-col items-center">
        <div class="bg-violet-100 p-3 rounded-full mb-3">
          <i class="fas fa-phone text-violet-600 text-xl"></i>
        </div>
        <h3 class="font-semibold">Phone</h3>
        <p class="text-gray-600">+91 98765 43210</p>
      </div>
      
      <div class="flex flex-col items-center">
        <div class="bg-violet-100 p-3 rounded-full mb-3">
          <i class="fas fa-map-marker-alt text-violet-600 text-xl"></i>
        </div>
        <h3 class="font-semibold">Location</h3>
        <p class="text-gray-600">Punjab, India</p>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-black text-white mt-6 py-6 ms-0 w-full">
    <div class="max-w-7xl mx-auto md:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center text">
            
            <!-- Left: BudgetBuddy Branding -->
            <div>
                <h2 class="text-lg font-bold">BudgetBuddy</h2>
                <p class="text-white mt-1 text-sm">Your trusted partner in financial planning</p>
                <div class="space-x-3 font-bold mt-2">
                    <a href="#" class="inline-block text-white hover:text-violet-300 transition-colors duration-300">
                        <i class="fa-brands fa-facebook" style="font-size: 1.5rem"></i>
                    </a>
                    <a href="#" class="inline-block text-white hover:text-violet-300 transition-colors duration-300">
                        <i class="fa-brands fa-instagram" style="font-size: 1.5rem"></i>
                    </a>
                    <a href="#" class="inline-block text-white hover:text-violet-300 transition-colors duration-300">
                        <i class="fa-brands fa-twitter" style="font-size: 1.5rem"></i>
                    </a>
                    <a href="#" class="inline-block text-white hover:text-violet-300 transition-colors duration-300">
                        <i class="fa-brands fa-linkedin" style="font-size: 1.5rem"></i>
                    </a>
                </div>
            </div>

            <!-- Middle: Quick Links -->
            <div>
                <h2 class="text-lg font-bold">Quick Links</h2>
                <ul class="mt-1 space-y-1">
                    <li>
                        <a href="av1.php" class="text-white text-sm hover:text-violet-300 transition-colors duration-300">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="DASHBOARDNEW/index.php" class="text-white text-sm hover:text-violet-300 transition-colors duration-300">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="bBudgetNEW/index.html" class="text-white text-sm hover:text-violet-300 transition-colors duration-300">
                            Budget
                        </a>
                    </li>
                    <li>
                        <a href="EXPENSESNEW/index.php" class="text-white text-sm hover:text-violet-300 transition-colors duration-300">
                            Expenses
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Right: Contact Info -->
            <div>
                <h2 class="text-lg font-bold">Contact Us</h2>
                <div class="mt-1 space-y-1">
                    <p class="text-white text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-envelope text-white"></i>
                        <span>Email: support@budgetbuddy.com</span>
                    </p>
                    <p class="text-white text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-phone text-white"></i>
                        <span>Phone: 1100198763</span>
                    </p>
                    <p class="text-white text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-map-marker-alt text-white"></i>
                        <span>Address: BudgetBuddy Office,Phagwara,Punjab, India</span>
                    </p>
                </div>
            </div>
        
        </div>

        <!-- Bottom: Copyright -->
        <div class="mt-4 border-t border-gray-700 pt-3 text-center text-white text-sm">
            © 2025 BudgetBuddy. All rights reserved.
        </div>
    </div>
</footer>

<script>
  // Financial Tips Slider
  document.addEventListener('DOMContentLoaded', function() {
    let currentTipIndex = 0;
    const totalTips = 3;
    const tipsSlider = document.getElementById('tips-slider');
    const tipDots = document.querySelectorAll('.tip-dot');
    
    function updateTipsSlider() {
      tipsSlider.style.transform = `translateX(-${currentTipIndex * 100}%)`;
      
      // Update dots
      tipDots.forEach((dot, index) => {
        if (index === currentTipIndex) {
          dot.classList.remove('bg-violet-100');
          dot.classList.add('bg-violet-300');
        } else {
          dot.classList.remove('bg-violet-300');
          dot.classList.add('bg-violet-100');
        }
      });
    }
    
    // Remove event listeners for prev/next buttons
    
    tipDots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        currentTipIndex = index;
        updateTipsSlider();
      });
    });
    
    // Auto-advance tips every 5 seconds
    setInterval(() => {
      currentTipIndex = (currentTipIndex + 1) % totalTips;
      updateTipsSlider();
    }, 5000);
    
    // Initialize the slider
    updateTipsSlider();
    
    // FAQ Toggle Function
    window.toggleFAQ = function(button) {
      const content = button.nextElementSibling;
      const icon = button.querySelector('i');
      
      if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
      } else {
        content.classList.add('hidden');
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
      }
    };
  });

// Contact form submission
function submitContactForm(event) {
  event.preventDefault();
  
  const form = document.getElementById('contactForm');
  const formMessage = document.getElementById('formMessage');
  const submitBtn = document.getElementById('submitBtn');
  
  // Disable submit button
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<span>Sending...</span> <i class="fas fa-spinner fa-spin"></i>';
  
  // Get form data
  const formData = new FormData(form);
  
  // Send form data
  fetch('submit_contact.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    formMessage.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700');
    
    if (data.success) {
      // Success message
      formMessage.classList.add('bg-green-100', 'text-green-700');
      form.reset();
    } else {
      // Error message
      formMessage.classList.add('bg-red-100', 'text-red-700');
    }
    
    formMessage.textContent = data.message;
    formMessage.scrollIntoView({ behavior: 'smooth', block: 'start' });
  })
  .catch(error => {
    formMessage.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700');
    formMessage.classList.add('bg-red-100', 'text-red-700');
    formMessage.textContent = 'An error occurred. Please try again later.';
    formMessage.scrollIntoView({ behavior: 'smooth', block: 'start' });
  })
  .finally(() => {
    // Re-enable submit button
    submitBtn.disabled = false;
    submitBtn.innerHTML = '<span>Send Message</span> <i class="fas fa-paper-plane"></i>';
  });
}
</script>

<style>
  .testimonial-card {
      flex-shrink: 0;
      width: 300px;
      background-color: #f3f4f6;
      padding: 24px;
      border-radius: 12px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      text-align: center;
  }

  /* Add video background styles */
  .video-background {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
  }

  .video-background video {
    position: absolute;
    top: 50%;
    left: 50%;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    transform: translate(-50%, -50%);
    z-index: -1;
  }

  .video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 0;
  }

  .hero-content {
    position: relative;
    z-index: 1;
  }
</style>

</body>
</html>
