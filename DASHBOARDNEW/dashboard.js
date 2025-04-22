// Dashboard functionality
async function loadDashboardData() {
    try {
        // Fetch expense data
        const expenseResponse = await fetch('api/expense_stats.php');
        const expenseData = await expenseResponse.json();
        
        // Fetch income data
        const incomeResponse = await fetch('api/income_stats.php');
        const incomeData = await incomeResponse.json();
        
        updateOverviewCards(incomeData, expenseData);
        createComparisonChart(incomeData.monthly, expenseData.monthly);
        createCategoryChart(expenseData.categories);
        loadRecentTransactions();
    } catch (error) {
        console.error('Error loading dashboard data:', error);
    }
}

function updateOverviewCards(incomeData, expenseData) {
    const totalIncome = incomeData.total;
    const totalExpenses = expenseData.total;
    const netBalance = totalIncome - totalExpenses;
    const savingsRate = ((totalIncome - totalExpenses) / totalIncome * 100).toFixed(1);
    
    document.getElementById('totalIncome').textContent = '₹' + totalIncome.toFixed(2);
    document.getElementById('totalExpenses').textContent = '₹' + totalExpenses.toFixed(2);
    document.getElementById('netBalance').textContent = '₹' + netBalance.toFixed(2);
    document.getElementById('savingsRate').textContent = savingsRate + '%';
}

function createComparisonChart(incomeData, expenseData) {
    const ctx = document.getElementById('comparisonChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Income',
                    data: incomeData,
                    backgroundColor: 'rgba(40, 167, 69, 0.5)',
                    borderColor: 'rgb(40, 167, 69)',
                    borderWidth: 1
                },
                {
                    label: 'Expenses',
                    data: expenseData,
                    backgroundColor: 'rgba(220, 53, 69, 0.5)',
                    borderColor: 'rgb(220, 53, 69)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createCategoryChart(categories) {
    const ctx = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: categories.map(cat => cat.category),
            datasets: [{
                data: categories.map(cat => cat.amount),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#FF6384', '#36A2EB'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
}

async function loadRecentTransactions() {
    try {
        // Load recent income
        const incomeResponse = await fetch('api/fetch_income.php');
        const incomeData = await incomeResponse.json();
        
        const incomeBody = document.getElementById('recentIncome');
        incomeBody.innerHTML = '';
        incomeData.slice(0, 5).forEach(income => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${new Date(income.income_date).toLocaleDateString()}</td>
                <td>${income.source}</td>
                <td>₹${parseFloat(income.amount).toFixed(2)}</td>
                <td>${income.notes || ''}</td>
            `;
            incomeBody.appendChild(row);
        });

        // Load recent expenses
        const expenseResponse = await fetch('api/fetch_expenses.php');
        const expenseData = await expenseResponse.json();
        
        const expenseBody = document.getElementById('recentExpenses');
        expenseBody.innerHTML = '';
        expenseData.slice(0, 5).forEach(expense => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${new Date(expense.date).toLocaleDateString()}</td>
                <td>${expense.category}</td>
                <td>${expense.description}</td>
                <td>₹${parseFloat(expense.amount).toFixed(2)}</td>
            `;
            expenseBody.appendChild(row);
        });
    } catch (error) {
        console.error('Error loading transactions:', error);
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', loadDashboardData);