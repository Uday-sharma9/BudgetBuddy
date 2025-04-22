<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Expense Tracker</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* Enhanced Styles */
    .stat-box {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(145deg, #ffffff, #f0f0f0);
        border: 1px solid rgba(139, 92, 246, 0.1);
        padding: 0.75rem;
    }
    .stat-box:hover {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 10px 15px -5px rgba(139, 92, 246, 0.1), 0 6px 6px -5px rgba(139, 92, 246, 0.04);
    }
    .stat-box:hover .icon {
        transform: scale(1.1) rotate(5deg);
        color: #8b5cf6;
    }
    .stat-box:hover h3 {
        color: #8b5cf6;
        transform: translateX(2px);
    }

    .quick-expense-btn {
        background: linear-gradient(145deg, #f3f4f6, #ffffff);
        border: 1px solid rgba(139, 92, 246, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0.5rem;
        min-height: 100px;
    }
    .quick-expense-btn:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 10px 15px -5px rgba(139, 92, 246, 0.1), 0 6px 6px -5px rgba(139, 92, 246, 0.04);
        background: linear-gradient(145deg, #ffffff, #f3f4f6);
    }
    .quick-expense-btn:hover i {
        transform: scale(1.1) rotate(5deg);
        color: #8b5cf6;
    }
    .quick-expense-btn:hover p {
        color: #8b5cf6;
        transform: translateY(-1px);
    }

    /* Enhanced Form Styles */
    .form-input {
        transition: all 0.3s ease;
        background: linear-gradient(145deg, #ffffff, #f3f4f6);
        border: 1px solid rgba(139, 92, 246, 0.2);
        padding: 0.5rem;
    }
    .form-input:focus {
        transform: translateY(-1px);
        box-shadow: 0 8px 12px -3px rgba(139, 92, 246, 0.1), 0 3px 4px -2px rgba(139, 92, 246, 0.05);
        border-color: #8b5cf6;
    }

    /* Enhanced Button Styles */
    .btn-primary {
        background: linear-gradient(145deg, #8b5cf6, #7c3aed);
        transition: all 0.3s ease;
        box-shadow: 0 3px 4px -1px rgba(139, 92, 246, 0.1), 0 2px 3px -1px rgba(139, 92, 246, 0.06);
        padding: 0.5rem 1rem;
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 12px -3px rgba(139, 92, 246, 0.1), 0 3px 4px -2px rgba(139, 92, 246, 0.05);
    }

    /* Budget-related background pattern */
    body {
        background-color: #ffffff;
        background-image: 
            radial-gradient(circle at 20px 20px, rgba(139, 92, 246, 0.1) 2%, transparent 0%),
            radial-gradient(circle at 60px 60px, rgba(139, 92, 246, 0.1) 2%, transparent 0%);
        background-size: 80px 80px;
        position: relative;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: 
            linear-gradient(45deg, transparent 48%, rgba(139, 92, 246, 0.05) 48%, rgba(139, 92, 246, 0.05) 52%, transparent 52%),
            linear-gradient(-45deg, transparent 48%, rgba(139, 92, 246, 0.05) 48%, rgba(139, 92, 246, 0.05) 52%, transparent 52%);
        background-size: 50px 50px;
        opacity: 0.5;
        z-index: -1;
    }

    /* Ensure content stays above the background */
    .container {
        position: relative;
        z-index: 1;
        padding: 0.75rem;
    }

    .icon {
      transition: all 0.3s ease;
      font-size: 1.5rem;
    }
    .dark-mode {
      background: #1a1a1a;
      color: #ffffff;
    }
    .dark-mode .bg-white {
      background: #2d2d2d;
      color: #ffffff;
    }
    .dark-mode .text-black {
      color: #ffffff;
    }
    .dark-mode .border-violet-400 {
      border-color: #8b5cf6;
    }
    .dark-mode .bg-gray-200 {
      background: #3d3d3d;
    }
    .dark-mode .text-gray-600 {
      color: #a0a0a0;
    }
    .quick-expense-btn {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100px;
      transition: all 0.3s ease;
    }
    .quick-expense-btn:hover {
      transform: translateY(-3px) scale(1.03);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }
    .quick-expense-btn i {
      transition: all 0.3s ease;
      font-size: 1.75rem;
    }
    .quick-expense-btn:hover i {
      transform: scale(1.1);
      color: #8b5cf6;
    }
    .quick-expense-btn p {
      transition: all 0.3s ease;
      font-size: 0.9rem;
    }
    .quick-expense-btn:hover p {
      color: #8b5cf6;
    }
    .notification {
      animation: slideIn 0.5s ease-out;
    }
    @keyframes slideIn {
      from { transform: translateX(100%); }
      to { transform: translateX(0); }
    }
    /* Custom scrollbar for the edit modal */
    #editModal .overflow-y-auto::-webkit-scrollbar {
      width: 6px;
    }

    #editModal .overflow-y-auto::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 3px;
    }

    #editModal .overflow-y-auto::-webkit-scrollbar-thumb {
      background: #8b5cf6;
      border-radius: 3px;
    }

    #editModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
      background: #7c3aed;
    }
    
    /* Page title and subtitle styles */
    .page-title {
      font-size: 3.5rem;
      font-weight: 800;
      color: #6d28d9;
      margin-bottom: 0.5rem;
      text-align: center;
    }
    
    .page-subtitle {
      font-size: 1.25rem;
      color: #6b7280;
      margin-bottom: 2rem;
      text-align: center;
    }
    
    /* Main content styles */
    .main-content {
      padding-top: 2rem;
      padding-bottom: 2rem;
      flex: 1;
    }

    /* Footer styles */
    footer {
      margin-top: auto;
      width: 100%;
    }

    /* Add custom scrollbar styles */
    .custom-scrollbar::-webkit-scrollbar {
      width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: #8b5cf6;
      border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
      background: #7c3aed;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-violet-100 to-purple-100 min-h-screen pt-[80px]">
  <!-- Navbar -->
  <nav class="bg-violet-600 p-4 h-[80px] shadow-lg fixed w-full z-50 top-0 left-0">
    <div class="container mx-auto flex justify-between items-center h-full px-6">
    
      <!-- Logo -->
      <div class="flex items-center space-x-2">
        <i class="fa-solid fa-pen-to-square" style="font-size: 3rem; color: #fdfdfd;"></i>
        <span class="text-white text-2xl font-bold">BudgetBuddy</span>
      </div>

      <!-- Desktop Menu -->
      <ul class="hidden md:flex space-x-8 text-white font-semibold text-xl ml-[-150px]">
            <li><a href="../av1.php" class="hover:underline underline-offset-8">Home</a></li>
            <li><a href="../DASHBOARDNEW/index.php" class="hover:underline underline-offset-8">Dashboard</a></li>
            <li><a href="../bBudgetNEW/index.html" class="hover:underline underline-offset-8">Budget</a></li>
            <li><a href="index.php" class="hover:underline underline-offset-8">Expenses</a></li>
            <li><a href="../savings.html" class="hover:underline underline-offset-8">Savings</a></li>
      </ul>

          <!-- Profile Button -->
          <div class="hidden md:flex items-center space-x-4">
            <div class="relative group">
              <button class="flex items-center space-x-2 text-white hover:text-gray-200" onclick="toggleProfileMenu()">
                <i class="fas fa-user-circle text-3xl"></i>
                <i class="fas fa-chevron-down"></i>
              </button>
              <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden">
                <a href="../profile.html" class="block px-4 py-2 text-gray-800 hover:bg-violet-100">My Profile</a>
                <a href="../signUpLogin/logout.php" class="block px-4 py-2 text-gray-800 hover:bg-violet-100">Logout</a>
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
            <li><a href="../av1.php" class="block py-2 hover:underline underline-offset-8">Home</a></li>
            <li><a href="../DASHBOARDNEW/index.php" class="block py-2 hover:underline underline-offset-8">Dashboard</a></li>
            <li><a href="../bBudgetNEW/index.html" class="block py-2 hover:underline underline-offset-8">Budget</a></li>
            <li><a href="index.php" class="block py-2 hover:underline underline-offset-8">Expenses</a></li>
            <li><a href="../savings.html" class="block py-2 hover:underline underline-offset-8">Savings</a></li>
            <li><a href="../signUpLogin/logout.php" class="block py-2 bg-violet-500 text-white rounded-lg">Logout</a></li>
      </ul>
    </div>
  </nav>

    <!-- Main Content -->
    <div class="main-content">
    <!-- Theme Toggle -->
    <div class="fixed top-4 right-4">
      <button id="themeToggle" class="bg-violet-600 text-white p-2 rounded-full shadow-lg hover:bg-violet-700 transition-all duration-300">
        <i class="fas fa-moon"></i>
      </button>
    </div>

    <div class="max-w-4xl mx-auto">
    <!-- Main Heading -->
    <h1 class="page-title">Expense Tracker</h1>
    <p class="page-subtitle">Track your expenses, analyze spending patterns, and stay within your budget</p>

  <!-- Expense Summary Section -->
    <div class="w-full mb-8">
      <!-- First Row - Two Boxes -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <!-- Total Expense Box -->
        <div class="stat-box bg-white text-black p-8 rounded-2xl shadow-xl">
          <div class="flex items-center mb-3">
            <i class="icon fas fa-wallet text-3xl text-violet-700 mr-2"></i>
            <h3 class="text-2xl font-bold text-violet-700 transition-colors duration-300">Total Expense</h3>
          </div>
          <p class="text-2xl font-bold" id="totalExpense">Loading...</p>
          <div class="mt-3 text-base text-gray-600" id="expenseTrend"></div>
        </div>
        
        <!-- Highest Category Box -->
        <div class="stat-box bg-white text-black p-8 rounded-2xl shadow-xl">
          <div class="flex items-center mb-3">
            <i class="icon fas fa-chart-line text-3xl text-violet-700 mr-2"></i>
            <h3 class="text-2xl font-bold text-violet-700 transition-colors duration-300">Highest Spending</h3>
          </div>
          <p class="text-2xl font-bold" id="maxExpense">Loading...</p>
          <div class="mt-3 text-base text-gray-600" id="maxExpenseTrend"></div>
        </div>
      </div>
      
      <!-- Second Row - Two Boxes -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Average Expense Box -->
        <div class="stat-box bg-white text-black p-8 rounded-2xl shadow-xl">
          <div class="flex items-center mb-3">
            <i class="icon fas fa-calculator text-3xl text-violet-700 mr-2"></i>
            <h3 class="text-2xl font-bold text-violet-700 transition-colors duration-300">Average Expense</h3>
          </div>
          <p class="text-2xl font-bold" id="avgExpense">Loading...</p>
          <div class="mt-3 text-base text-gray-600" id="avgExpenseTrend"></div>
        </div>

        <!-- Most Frequent Category Box -->
        <div class="stat-box bg-white text-black p-8 rounded-2xl shadow-xl">
          <div class="flex items-center mb-3">
            <i class="icon fas fa-star text-3xl text-violet-700 mr-2"></i>
            <h3 class="text-2xl font-bold text-violet-700 transition-colors duration-300">Most Frequent</h3>
          </div>
          <p class="text-2xl font-bold" id="freqCategory">Loading...</p>
          <div class="mt-3 text-base text-gray-600" id="freqCategoryTrend"></div>
        </div>
      </div>
    </div>

    <!-- Quick Expense Buttons -->
    <div class="w-full mb-8">
      <h2 class="text-3xl font-bold text-violet-700 mb-6 text-center">Quick Add</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <button class="quick-expense-btn bg-violet-50 text-violet-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105" onclick="quickAdd('Food & Groceries')">
          <i class="fas fa-utensils text-4xl mb-3"></i>
          <p class="font-semibold text-lg">Food</p>
        </button>
        <button class="quick-expense-btn bg-violet-50 text-violet-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105" onclick="quickAdd('Transport & Fuel')">
          <i class="fas fa-car text-4xl mb-3"></i>
          <p class="font-semibold text-lg">Transport</p>
        </button>
        <button class="quick-expense-btn bg-violet-50 text-violet-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105" onclick="quickAdd('Entertainment')">
          <i class="fas fa-film text-4xl mb-3"></i>
          <p class="font-semibold text-lg">Entertainment</p>
        </button>
        <button class="quick-expense-btn bg-violet-50 text-violet-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105" onclick="quickAdd('Shopping')">
          <i class="fas fa-shopping-bag text-4xl mb-3"></i>
          <p class="font-semibold text-lg">Shopping</p>
        </button>
    </div>
  </div>

  <!-- Add Expense Section -->
    <div class="flex justify-center mb-8">
  <div class="bg-violet-50 text-violet-700 p-6 rounded-2xl shadow-xl w-full max-w-2xl transition-all duration-300 hover:shadow-2xl">
        <div class="flex justify-between items-center mb-4">
          <h1 class="text-4xl font-extrabold text-violet-700">Add New Expense</h1>
          <button onclick="openExpenseListModal()" class="text-violet-700 hover:text-violet-800 text-lg">
                        <i class="fas fa-list"></i> View Expenses
          </button>
        </div>
        <form action="add_expense.php" method="POST" enctype="multipart/form-data" class="space-y-3">
          <div class="space-y-1">
            <label class="text-sm font-medium text-black">Category</label>
            <div class="relative">
              <select name="category" id="categorySelect" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none text-black" required>
                <option value="" disabled selected>Select Category</option>
                <option value="Food & Groceries">🍔 Food & Groceries</option>
                <option value="Electricity">⚡ Electricity</option>
                <option value="Entertainment">🎬 Entertainment</option>
                <option value="Transport & Fuel">🚗 Transport & Fuel</option>
                <option value="Rent & Housing">🏠 Rent & Housing</option>
                <option value="Healthcare & Medical">🏥 Healthcare & Medical</option>
                <option value="Shopping">🛍️ Shopping</option>
                <option value="Education & Learning">📚 Education & Learning</option>
                <option value="Others">➕ Others</option>
              </select>
            </div>
            <div id="customCategoryContainer" class="hidden mt-2">
              <input type="text" id="customCategory" placeholder="Enter custom category" 
                     class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none text-black">
            </div>
          </div>

          <input type="text" name="item" placeholder="Item (e.g., Samosa)" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none" required>

          <input type="number" name="amount" placeholder="Amount (₹)" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none" required>

          <input type="date" name="date" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none" required>

          <!-- Note Field -->
          <div class="space-y-2">
            <label class="text-sm font-medium text-violet-700">Add a Note (Optional)</label>
            <textarea name="note" placeholder="Add any additional details about this expense..." 
                      class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none resize-none h-24"></textarea>
          </div>

          <!-- Receipt Upload Field -->
          <div class="space-y-2">
            <label class="text-sm font-medium text-violet-700">Upload Receipt (Optional)</label>
            <div class="flex items-center justify-center w-full">
              <label class="flex flex-col w-full h-32 border-2 border-violet-400 border-dashed rounded-lg cursor-pointer hover:bg-violet-50">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                  <i class="fas fa-cloud-upload-alt text-3xl text-violet-700 mb-2"></i>
                  <p class="mb-2 text-sm text-gray-500">Click to upload or drag and drop</p>
                  <p class="text-xs text-gray-500">PNG, JPG, PDF (MAX. 2MB)</p>
                </div>
                <input type="file" name="receipt" class="hidden" accept=".png,.jpg,.jpeg,.pdf" />
              </label>
            </div>
          </div>

          <button type="submit" class="w-full bg-violet-700 text-white py-3 font-semibold rounded-lg hover:bg-violet-800 transition-all duration-200">➕ Add Expense</button>
        </form>
      </div>
    </div>

    <!-- Filter Sections -->
    <div class="w-full space-y-8 mb-8">
      <div class="flex justify-center gap-8">
        <!-- Date Filter Box -->
        <div class="bg-violet-50 text-violet-700 p-6 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl w-full max-w-sm">
          <div class="flex items-center justify-center mb-4">
            <i class="fas fa-calendar text-3xl text-violet-700 mr-3"></i>
            <h2 class="text-2xl font-bold text-violet-700">Filter by Date</h2>
          </div>
          <div class="space-y-3">
            <input type="date" id="filterDate" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none">
            <button onclick="showExpensesByDate()" class="w-full bg-violet-700 text-white py-3 font-semibold rounded-lg hover:bg-violet-800 transition-all duration-200">
              <i class="fas fa-calendar-alt mr-2"></i>Show Expenses by Date
            </button>
          </div>
        </div>

        <!-- Category Filter Box -->
        <div class="bg-violet-50 text-violet-700 p-6 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl w-full max-w-sm">
          <div class="flex items-center justify-center mb-4">
            <i class="fas fa-tags text-3xl text-violet-700 mr-3"></i>
            <h2 class="text-2xl font-bold text-violet-700">Filter by Category</h2>
          </div>
          <div class="space-y-3">
            <select id="filterCategory" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none">
              <option value="" selected>All Categories</option>
              <option value="Food & Groceries">🍔 Food & Groceries</option>
              <option value="Electricity">⚡ Electricity</option>
              <option value="Entertainment">🎬 Entertainment</option>
              <option value="Transport & Fuel">🚗 Transport & Fuel</option>
              <option value="Rent & Housing">🏠 Rent & Housing</option>
              <option value="Healthcare & Medical">🏥 Healthcare & Medical</option>
              <option value="Shopping">🛍️ Shopping</option>
              <option value="Education & Learning">📚 Education & Learning</option>
            </select>
            <button onclick="showExpensesByCategory()" class="w-full bg-violet-700 text-white py-3 font-semibold rounded-lg hover:bg-violet-800 transition-all duration-200">
              <i class="fas fa-filter mr-2"></i>Show Expenses by Category
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Expense Distribution Section -->
    <div class="bg-violet-50 text-violet-700 p-6 rounded-2xl shadow-xl w-full mb-16">
      <h2 class="text-2xl font-bold text-violet-700 text-center mb-4">Expense Distribution</h2>
      <div class="space-y-4" id="expenseBars">
        <!-- Progress bars will be added here dynamically -->
      </div>
    </div>

    <!-- Expense List Modal -->
    <div id="expenseListModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
      <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[60vh] overflow-hidden custom-scrollbar">
          <!-- Modal Header -->
          <div class="flex justify-between items-center p-6 border-b border-gray-200 bg-violet-50">
            <h2 class="text-2xl font-bold text-black">Expense List</h2>
            <button onclick="closeExpenseListModal()" class="text-gray-700 hover:text-gray-900">
              <i class="fas fa-times text-2xl"></i>
            </button>
          </div>

          <!-- Modal Body -->
          <div class="p-6 overflow-y-auto max-h-[60vh] custom-scrollbar">
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead>
                  <tr class="bg-violet-100">
                    <th class="p-3 text-left text-black font-semibold">Actions</th>
                    <th class="p-3 text-left text-black font-semibold">Date</th>
                    <th class="p-3 text-left text-black font-semibold">Category</th>
                    <th class="p-3 text-left text-black font-semibold">Item</th>
                    <th class="p-3 text-left text-black font-semibold">Amount</th>
                    <th class="p-3 text-left text-black font-semibold">Note</th>
                    <th class="p-3 text-left text-black font-semibold">Receipt</th>
                  </tr>
                </thead>
                <tbody id="expenseList" class="text-black">
                  <!-- Expenses will be loaded here -->
                </tbody>
              </table>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="p-6 border-t border-gray-200 bg-violet-50 flex justify-end">
            <button onclick="closeExpenseListModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
              <i class="fas fa-times mr-2"></i>Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Expense Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
      <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md max-h-[80vh] overflow-hidden custom-scrollbar">
          <!-- Modal Header -->
          <div class="flex justify-between items-center p-6 border-b border-gray-200 bg-violet-50">
            <h2 class="text-2xl font-bold text-black">Edit Expense</h2>
            <button onclick="closeEditModal()" class="text-gray-700 hover:text-gray-900">
              <i class="fas fa-times text-2xl"></i>
            </button>
          </div>

          <!-- Modal Body -->
          <div class="overflow-y-auto max-h-[calc(80vh-140px)] p-6 custom-scrollbar">
            <form id="editForm" action="manage_expenses.php" method="POST" enctype="multipart/form-data" class="space-y-4">
              <input type="hidden" name="id" id="editId">
              <input type="hidden" name="edit" value="1">
              
              <div class="space-y-1">
                <label class="text-sm font-medium text-black">Category</label>
                <select name="category" id="editCategory" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none text-black" required>
                  <option value="" disabled selected>Select Category</option>
                  <option value="Food & Groceries">🍔 Food & Groceries</option>
                  <option value="Electricity">⚡ Electricity</option>
                  <option value="Entertainment">🎬 Entertainment</option>
                  <option value="Transport & Fuel">🚗 Transport & Fuel</option>
                  <option value="Rent & Housing">🏠 Rent & Housing</option>
                  <option value="Healthcare & Medical">🏥 Healthcare & Medical</option>
                  <option value="Shopping">🛍️ Shopping</option>
                  <option value="Education & Learning">📚 Education & Learning</option>
                </select>
              </div>

              <div class="space-y-1">
                <label class="text-sm font-medium text-black">Item</label>
                <input type="text" name="item" id="editItem" placeholder="Item" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none text-black" required>
              </div>

              <div class="space-y-1">
                <label class="text-sm font-medium text-black">Amount</label>
                <input type="number" name="amount" id="editAmount" placeholder="Amount" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none text-black" required>
              </div>

              <div class="space-y-1">
                <label class="text-sm font-medium text-black">Date</label>
                <input type="date" name="date" id="editDate" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none text-black" required>
              </div>

              <div class="space-y-1">
                <label class="text-sm font-medium text-black">Note (Optional)</label>
                <textarea name="note" id="editNote" placeholder="Add a note" class="w-full p-3 border border-violet-400 rounded-lg focus:ring-2 focus:ring-violet-700 focus:outline-none resize-none h-24 text-black"></textarea>
              </div>

              <div class="space-y-1">
                <label class="text-sm font-medium text-black">Receipt (Optional)</label>
                <div class="flex items-center justify-center w-full">
                  <label class="flex flex-col w-full h-32 border-2 border-violet-400 border-dashed rounded-lg cursor-pointer hover:bg-violet-50">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                      <i class="fas fa-cloud-upload-alt text-3xl text-violet-700 mb-2"></i>
                      <p class="mb-2 text-sm text-gray-600">Click to upload or drag and drop</p>
                      <p class="text-xs text-gray-600">PNG, JPG, PDF (MAX. 2MB)</p>
                    </div>
                    <input type="file" name="receipt" class="hidden" accept=".png,.jpg,.jpeg,.pdf" />
                  </label>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Footer -->
          <div class="p-6 border-t border-gray-200 bg-violet-50 flex justify-end space-x-3 sticky bottom-0">
            <button onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
              <i class="fas fa-times mr-2"></i>Cancel
            </button>
            <button onclick="showSaveConfirmation()" class="px-4 py-2 bg-violet-700 text-white rounded-lg hover:bg-violet-800">
              <i class="fas fa-save mr-2"></i>Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Save Confirmation Modal -->
    <div id="saveConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
      <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
          <div class="p-6 text-center">
            <i class="fas fa-question-circle text-4xl text-violet-700 mb-4"></i>
            <h3 class="text-xl font-bold text-black mb-2">Save Changes?</h3>
            <p class="text-gray-600 mb-4">Are you sure you want to save these changes to the expense?</p>
            <div class="flex justify-center space-x-4">
              <button onclick="closeSaveConfirmation()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                <i class="fas fa-times mr-2"></i>Cancel
              </button>
              <button onclick="saveExpenseChanges()" class="px-4 py-2 bg-violet-700 text-white rounded-lg hover:bg-violet-800">
                <i class="fas fa-check mr-2"></i>Yes, Save Changes
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed bottom-4 right-4 space-y-2"></div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
      <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
          <div class="p-6 text-center">
            <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
            <h3 class="text-xl font-bold text-black mb-2">Delete Expense?</h3>
            <p class="text-gray-600 mb-4">Are you sure you want to delete this expense? This action cannot be undone.</p>
            <div class="flex justify-center space-x-4">
              <button onclick="closeDeleteConfirmation()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                <i class="fas fa-times mr-2"></i>Cancel
              </button>
              <button onclick="confirmDelete()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                <i class="fas fa-trash mr-2"></i>Yes, Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Category Filter Results Modal -->
    <div id="categoryFilterModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
      <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
          <!-- Modal Header -->
          <div class="flex justify-between items-center p-6 border-b border-gray-200 bg-violet-50">
            <h2 class="text-2xl font-bold text-black">Expenses for <span id="selectedCategory"></span></h2>
            <button onclick="closeCategoryFilterModal()" class="text-gray-700 hover:text-gray-900">
              <i class="fas fa-times text-2xl"></i>
            </button>
          </div>

          <!-- Modal Body -->
          <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead>
                  <tr class="bg-violet-100">
                    <th class="p-3 text-left text-black font-semibold">Date</th>
                    <th class="p-3 text-left text-black font-semibold">Item</th>
                    <th class="p-3 text-left text-black font-semibold">Amount</th>
                    <th class="p-3 text-left text-black font-semibold">Note</th>
                    <th class="p-3 text-left text-black font-semibold">Receipt</th>
                  </tr>
                </thead>
                <tbody id="categoryFilterResults" class="text-black">
                  <!-- Results will be loaded here -->
                </tbody>
              </table>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="p-6 border-t border-gray-200 bg-violet-50 flex justify-between items-center">
            <div class="text-lg font-semibold text-violet-700">
              Total: ₹<span id="categoryTotal">0</span>
            </div>
            <button onclick="closeCategoryFilterModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
              <i class="fas fa-times mr-2"></i>Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Date Filter Results Modal -->
    <div id="dateFilterModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
      <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
          <!-- Modal Header -->
          <div class="flex justify-between items-center p-6 border-b border-gray-200 bg-violet-50">
            <h2 class="text-2xl font-bold text-black">Expenses for <span id="selectedDate"></span></h2>
            <button onclick="closeDateFilterModal()" class="text-gray-700 hover:text-gray-900">
              <i class="fas fa-times text-2xl"></i>
            </button>
          </div>

          <!-- Modal Body -->
          <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead>
                  <tr class="bg-violet-100">
                    <th class="p-3 text-left text-black font-semibold">Category</th>
                    <th class="p-3 text-left text-black font-semibold">Item</th>
                    <th class="p-3 text-left text-black font-semibold">Amount</th>
                    <th class="p-3 text-left text-black font-semibold">Note</th>
                    <th class="p-3 text-left text-black font-semibold">Receipt</th>
                  </tr>
                </thead>
                <tbody id="dateFilterResults" class="text-black">
                  <!-- Results will be loaded here -->
                </tbody>
              </table>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="p-6 border-t border-gray-200 bg-violet-50 flex justify-between items-center">
            <div class="text-lg font-semibold text-violet-700">
              Total: ₹<span id="dateTotal">0</span>
            </div>
            <button onclick="closeDateFilterModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
              <i class="fas fa-times mr-2"></i>Close
            </button>
          </div>
        </div>
      </div>
    </div>

        <!-- Confirmation Modal -->
        <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
                    <div class="p-6 text-center">
                        <i class="fas fa-question-circle text-4xl text-violet-700 mb-4"></i>
                        <h3 id="confirmationTitle" class="text-xl font-bold text-black mb-2"></h3>
                        <p id="confirmationMessage" class="text-gray-600 mb-4"></p>
                        <div class="flex justify-center space-x-4">
                            <button onclick="closeConfirmationModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                            <button onclick="handleConfirmation()" class="px-4 py-2 bg-violet-700 text-white rounded-lg hover:bg-violet-800">
                                <i class="fas fa-check mr-2"></i>Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>

  <!-- Footer from av1.php -->
  <footer class="bg-black text-white mt-6 py-6 ms-0 h-full w-full">
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
                        <a href="../av1.php" class="text-white text-sm hover:text-violet-300 transition-colors duration-300">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="../DASHBOARDNEW/index.php" class="text-white text-sm hover:text-violet-300 transition-colors duration-300">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="../bBudgetNEW/index.html" class="text-white text-sm hover:text-violet-300 transition-colors duration-300">
                            Budget
                        </a>
                    </li>
                    <li>
                        <a href="index.php" class="text-white text-sm hover:text-violet-300 transition-colors duration-300">
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
    // Quick Add Function
    function quickAdd(category) {
      const form = document.querySelector('form');
      form.querySelector('select[name="category"]').value = category;
      form.querySelector('input[name="amount"]').focus();
      showNotification(`Quick add: ${category} selected`, 'info');
    }

    // Notification System
    function showNotification(message, type = 'info') {
      const container = document.getElementById('notificationContainer');
      const notification = document.createElement('div');
      notification.className = `notification bg-white text-black p-4 rounded-lg shadow-lg flex items-center ${
        type === 'success' ? 'border-l-4 border-green-500' : 'border-l-4 border-blue-500'
      }`;
      
      notification.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'} text-${type === 'success' ? 'green' : 'blue'}-500 mr-2"></i>
        <span>${message}</span>
      `;
      
      container.appendChild(notification);
      setTimeout(() => {
        notification.remove();
      }, 3000);
    }

    // Function to create expense distribution bars
    function createExpenseBars(data) {
      const container = document.getElementById('expenseBars');
      container.innerHTML = ''; // Clear existing content

      // Ensure we have at least 4 categories
      const defaultCategories = [
        { category: 'Food & Groceries', amount: 0 },
        { category: 'Transport & Fuel', amount: 0 },
        { category: 'Entertainment', amount: 0 },
        { category: 'Shopping', amount: 0 }
      ];

      // Merge actual data with default categories
      const categories = [...defaultCategories];
      if (data.categories && data.total > 0) {
        data.categories.forEach(expense => {
          const index = categories.findIndex(cat => cat.category === expense.category);
          if (index !== -1) {
            categories[index].amount = expense.amount;
          } else {
            categories.push(expense);
          }
        });
      }

      // Sort categories by amount (descending)
      categories.sort((a, b) => b.amount - a.amount);

      // Create bars for each category
      categories.forEach(category => {
        const percentage = (category.amount / (data.total || 1)) * 100;
        const bar = document.createElement('div');
        bar.className = 'space-y-1';
        bar.innerHTML = `
          <div class="flex justify-between items-center">
            <span class="font-semibold">${category.category}</span>
            <span class="text-sm text-gray-600">₹${category.amount.toLocaleString()}</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="bg-violet-600 h-4 rounded-full transition-all duration-500 ease-out" 
                 style="width: ${percentage}%"></div>
          </div>
        `;
        container.appendChild(bar);
      });
    }

    // Update the fetch and display expense statistics
    fetch('expense_stats.php')
      .then(response => response.json())
      .then(data => {
        // Update total expense
        document.getElementById('totalExpense').textContent = `₹${data.total.toLocaleString()}`;
        
        // Update highest spending category
        if (data.highest_category) {
          document.getElementById('maxExpense').textContent = 
            `${data.highest_category.category}: ₹${data.highest_category.amount.toLocaleString()}`;
        } else {
          document.getElementById('maxExpense').textContent = 'No expenses recorded yet';
        }

        // Update average expense
        document.getElementById('avgExpense').textContent = `₹${Math.round(data.avg_amount).toLocaleString()}`;

        // Update most frequent category
        if (data.most_frequent_category) {
          document.getElementById('freqCategory').textContent = 
            `${data.most_frequent_category.category} (${data.most_frequent_category.frequency} times)`;
        } else {
          document.getElementById('freqCategory').textContent = 'No expenses recorded yet';
        }

        // Create expense distribution bars
        createExpenseBars(data);
      })
      .catch(error => console.error('Error fetching expense stats:', error));

    // File upload preview
    document.querySelector('input[type="file"]').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const preview = document.createElement('div');
          preview.className = 'mt-2 p-2 bg-violet-50 rounded-lg';
          preview.innerHTML = `
            <div class="flex items-center justify-between">
              <span class="text-sm text-violet-700">${file.name}</span>
              <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <i class="fas fa-times"></i>
              </button>
            </div>
          `;
          document.querySelector('.space-y-2').appendChild(preview);
        };
        reader.readAsDataURL(file);
      }
    });

    // Function to load expenses
    function loadExpenses() {
      fetch('fetch_expenses.php')
        .then(response => response.json())
        .then(data => {
          const expenseList = document.getElementById('expenseList');
          expenseList.innerHTML = '';
          
          data.forEach(expense => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-violet-50';
            row.innerHTML = `
              <td class="p-3">
                <button onclick="editExpense(${expense.id}, '${expense.category}', '${expense.item}', ${expense.amount}, '${expense.date}', '${expense.note || ''}')" 
                        class="text-violet-700 hover:text-violet-800 mr-2">
                  <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteExpense(${expense.id})" 
                        class="text-red-500 hover:text-red-700">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
              <td class="p-3 text-black">${expense.date}</td>
              <td class="p-3 text-black">${expense.category}</td>
              <td class="p-3 text-black">${expense.item}</td>
              <td class="p-3 text-black">₹${expense.amount.toLocaleString()}</td>
              <td class="p-3 text-black">${expense.note || '-'}</td>
              <td class="p-3">
                ${expense.receipt_path ? 
                  `<a href="${expense.receipt_path}" target="_blank" class="text-violet-700 hover:text-violet-800">
                    <i class="fas fa-file-alt"></i> View
                  </a>` : 
                  '<span class="text-gray-500">-</span>'
                }
              </td>
            `;
            expenseList.appendChild(row);
          });
        })
        .catch(error => console.error('Error loading expenses:', error));
    }

    // Load expenses when page loads
    document.addEventListener('DOMContentLoaded', loadExpenses);

    // Handle custom category input
    document.getElementById('categorySelect').addEventListener('change', function() {
      const customCategoryContainer = document.getElementById('customCategoryContainer');
      const customCategoryInput = document.getElementById('customCategory');
      
      if (this.value === 'Others') {
        customCategoryContainer.classList.remove('hidden');
        customCategoryInput.required = true;
      } else {
        customCategoryContainer.classList.add('hidden');
        customCategoryInput.required = false;
      }
    });

    // Update form submission to handle custom category
    document.querySelector('form').addEventListener('submit', function(e) {
      const categorySelect = document.getElementById('categorySelect');
      const customCategory = document.getElementById('customCategory');
      
      if (categorySelect.value === 'Others' && customCategory.value.trim() !== '') {
        // Create a hidden input to send the custom category
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'category';
        hiddenInput.value = customCategory.value.trim();
        this.appendChild(hiddenInput);
        
        // Remove the original select to prevent duplicate submission
        categorySelect.remove();
      }
    });

    // Function to show expenses by date
    function showExpensesByDate() {
      const date = document.getElementById('filterDate').value;
      if (!date) {
        showNotification('Please select a date', 'error');
        return;
      }

      // Format date for display
      const formattedDate = new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
      document.getElementById('selectedDate').textContent = formattedDate;

      // Show loading state
      const resultsBody = document.getElementById('dateFilterResults');
      resultsBody.innerHTML = '<tr><td colspan="5" class="text-center p-4">Loading...</td></tr>';

      // Show modal
      document.getElementById('dateFilterModal').classList.remove('hidden');

      // Fetch expenses for the selected date
      fetch(`fetch_expenses.php?date=${date}`)
        .then(response => response.json())
        .then(data => {
          resultsBody.innerHTML = '';
          
          if (data.length === 0) {
            resultsBody.innerHTML = '<tr><td colspan="5" class="text-center p-4 text-gray-500">No expenses found for this date</td></tr>';
            document.getElementById('dateTotal').textContent = '0';
            return;
          }

          let total = 0;
          data.forEach(expense => {
            total += parseFloat(expense.amount);
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-violet-50';
            row.innerHTML = `
              <td class="p-3 text-black">${expense.category}</td>
              <td class="p-3 text-black">${expense.item}</td>
              <td class="p-3 text-black">₹${expense.amount.toLocaleString()}</td>
              <td class="p-3 text-black">${expense.note || '-'}</td>
              <td class="p-3">
                ${expense.receipt_path ? 
                  `<a href="${expense.receipt_path}" target="_blank" class="text-violet-700 hover:text-violet-800">
                    <i class="fas fa-file-alt"></i> View
                  </a>` : 
                  '<span class="text-gray-500">-</span>'
                }
              </td>
            `;
            resultsBody.appendChild(row);
          });

          // Update total
          document.getElementById('dateTotal').textContent = total.toLocaleString();
        })
        .catch(error => {
          console.error('Error fetching expenses:', error);
          resultsBody.innerHTML = '<tr><td colspan="5" class="text-center p-4 text-red-500">Error loading expenses</td></tr>';
          document.getElementById('dateTotal').textContent = '0';
        });
    }

    // Function to close date filter modal
    function closeDateFilterModal() {
      document.getElementById('dateFilterModal').classList.add('hidden');
    }

    // Function to show expenses by category
    function showExpensesByCategory() {
      const category = document.getElementById('filterCategory').value;
      if (!category) {
        showNotification('Please select a category', 'error');
        return;
      }

      document.getElementById('selectedCategory').textContent = category;

      // Show loading state
      const resultsBody = document.getElementById('categoryFilterResults');
      resultsBody.innerHTML = '<tr><td colspan="5" class="text-center p-4">Loading...</td></tr>';

      // Show modal
      document.getElementById('categoryFilterModal').classList.remove('hidden');

      // Fetch expenses for the selected category
      fetch(`fetch_expenses.php?category=${encodeURIComponent(category)}`)
        .then(response => response.json())
        .then(data => {
          resultsBody.innerHTML = '';
          
          if (data.length === 0) {
            resultsBody.innerHTML = '<tr><td colspan="5" class="text-center p-4 text-gray-500">No expenses found for this category</td></tr>';
            document.getElementById('categoryTotal').textContent = '0';
            return;
          }

          let total = 0;
          data.forEach(expense => {
            total += parseFloat(expense.amount);
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-violet-50';
            row.innerHTML = `
              <td class="p-3 text-black">${expense.date}</td>
              <td class="p-3 text-black">${expense.item}</td>
              <td class="p-3 text-black">₹${expense.amount.toLocaleString()}</td>
              <td class="p-3 text-black">${expense.note || '-'}</td>
              <td class="p-3">
                ${expense.receipt_path ? 
                  `<a href="${expense.receipt_path}" target="_blank" class="text-violet-700 hover:text-violet-800">
                    <i class="fas fa-file-alt"></i> View
                  </a>` : 
                  '<span class="text-gray-500">-</span>'
                }
              </td>
            `;
            resultsBody.appendChild(row);
          });

          // Update total
          document.getElementById('categoryTotal').textContent = total.toLocaleString();
        })
        .catch(error => {
          console.error('Error fetching expenses:', error);
          resultsBody.innerHTML = '<tr><td colspan="5" class="text-center p-4 text-red-500">Error loading expenses</td></tr>';
          document.getElementById('categoryTotal').textContent = '0';
        });
    }

    // Function to close category filter modal
    function closeCategoryFilterModal() {
      document.getElementById('categoryFilterModal').classList.add('hidden');
    }

        // Function to edit expense
        function editExpense(id, category, item, amount, date, note) {
            openEditModal(id, category, item, amount, date, note);
            showConfirmationModal(
                'Edit Expense',
                'Are you sure you want to save these changes?',
                'edit',
                id
            );
        }

        // Function to open edit modal
        function openEditModal(id, category, item, amount, date, note) {
            document.getElementById('editId').value = id;
            document.getElementById('editCategory').value = category;
            document.getElementById('editItem').value = item;
            document.getElementById('editAmount').value = amount;
            document.getElementById('editDate').value = date;
            document.getElementById('editNote').value = note;
            document.getElementById('editModal').classList.remove('hidden');
        }

        // Function to close edit modal
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Function to open expense list modal
        function openExpenseListModal() {
            document.getElementById('expenseListModal').classList.remove('hidden');
            loadExpenses();
        }

        // Function to close expense list modal
        function closeExpenseListModal() {
            document.getElementById('expenseListModal').classList.add('hidden');
        }

        // Function to show save confirmation
        function showSaveConfirmation() {
            document.getElementById('saveConfirmationModal').classList.remove('hidden');
        }

        // Function to close save confirmation
        function closeSaveConfirmation() {
            document.getElementById('saveConfirmationModal').classList.add('hidden');
        }

        // Function to save expense changes
        function saveExpenseChanges() {
            document.getElementById('editForm').submit();
        }

        // Function to show confirmation modal
        function showConfirmationModal(title, message, action, id) {
            document.getElementById('confirmationTitle').textContent = title;
            document.getElementById('confirmationMessage').textContent = message;
            document.getElementById('confirmationModal').classList.remove('hidden');
            document.getElementById('confirmationModal').dataset.action = action;
            document.getElementById('confirmationModal').dataset.id = id;
        }

        // Function to show delete confirmation
        function showDeleteConfirmation(id) {
            document.getElementById('deleteConfirmationModal').dataset.id = id;
            document.getElementById('deleteConfirmationModal').classList.remove('hidden');
        }

        // Function to close delete confirmation
        function closeDeleteConfirmation() {
            document.getElementById('deleteConfirmationModal').classList.add('hidden');
        }

        // Function to confirm and execute delete
        function confirmDelete() {
            const id = document.getElementById('deleteConfirmationModal').dataset.id;
            window.location.href = `manage_expenses.php?delete=1&id=${id}`;
        }

        // Function to delete expense
        function deleteExpense(id) {
            showDeleteConfirmation(id);
        }

        // Function to toggle mobile menu
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
        
        // Function to toggle profile dropdown
        function toggleProfileMenu() {
            const dropdown = document.getElementById('profile-dropdown');
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profile-dropdown');
            const profileButton = document.querySelector('.relative.group button');
            
            if (dropdown && profileButton && !profileButton.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Function to close confirmation modal
        function closeConfirmationModal() {
            document.getElementById('confirmationModal').classList.add('hidden');
        }

        // Function to handle confirmation
        function handleConfirmation() {
            const modal = document.getElementById('confirmationModal');
            const action = modal.dataset.action;
            const id = modal.dataset.id;

            if (action === 'edit') {
                saveExpenseChanges();
            } else if (action === 'delete') {
                window.location.href = `manage_expenses.php?delete=1&id=${id}`;
            }

            closeConfirmationModal();
        }
  </script>
</body>
</html>