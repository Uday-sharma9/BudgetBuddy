-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS expense_tracker;
USE expense_tracker;

-- Create expenses table
CREATE TABLE IF NOT EXISTS expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT,
    expense_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    icon VARCHAR(50),
    color VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default categories
INSERT INTO categories (name, icon, color) VALUES
('Food & Dining', 'fa-utensils', '#FF6B6B'),
('Transportation', 'fa-car', '#4ECDC4'),
('Shopping', 'fa-shopping-bag', '#45B7D1'),
('Bills & Utilities', 'fa-file-invoice-dollar', '#96CEB4'),
('Entertainment', 'fa-film', '#FFEEAD'),
('Healthcare', 'fa-heartbeat', '#FF9999'),
('Education', 'fa-graduation-cap', '#99CCFF'),
('Travel', 'fa-plane', '#FFB366'),
('Home', 'fa-home', '#99FF99'),
('Other', 'fa-ellipsis-h', '#CCCCCC'); 