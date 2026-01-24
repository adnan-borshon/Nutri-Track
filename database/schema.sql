-- NutriTrack Database Schema
-- Run this SQL in phpMyAdmin to create all required tables
-- Database: nutritrack

CREATE DATABASE IF NOT EXISTS nutritrack;
USE nutritrack;

-- =============================================
-- USERS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    role ENUM('user', 'nutritionist', 'admin') DEFAULT 'user',
    status ENUM('active', 'pending', 'inactive') DEFAULT 'active',
    nutritionist_id INT DEFAULT NULL,
    specialty VARCHAR(100) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    goal VARCHAR(50) DEFAULT NULL,
    weight DECIMAL(5,2) DEFAULT NULL,
    height DECIMAL(5,2) DEFAULT NULL,
    age INT DEFAULT NULL,
    health_conditions TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nutritionist_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- FOOD CATEGORIES TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS food_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    icon VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- FOODS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS foods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    category_id INT DEFAULT NULL,
    calories INT NOT NULL DEFAULT 0,
    protein DECIMAL(6,2) DEFAULT 0,
    carbs DECIMAL(6,2) DEFAULT 0,
    fat DECIMAL(6,2) DEFAULT 0,
    fiber DECIMAL(6,2) DEFAULT 0,
    serving_size VARCHAR(50) DEFAULT '100g',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES food_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- DIET PLANS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS diet_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nutritionist_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    daily_calories INT DEFAULT 2000,
    protein_goal INT DEFAULT 0,
    carbs_goal INT DEFAULT 0,
    fat_goal INT DEFAULT 0,
    duration_weeks INT DEFAULT 4,
    start_date DATE DEFAULT NULL,
    end_date DATE DEFAULT NULL,
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (nutritionist_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- DIET PLAN MEALS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS diet_plan_meals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    diet_plan_id INT NOT NULL,
    meal_type ENUM('breakfast', 'lunch', 'dinner', 'snack') NOT NULL,
    food_id INT DEFAULT NULL,
    custom_food_name VARCHAR(100) DEFAULT NULL,
    servings DECIMAL(4,2) DEFAULT 1,
    notes TEXT DEFAULT NULL,
    FOREIGN KEY (diet_plan_id) REFERENCES diet_plans(id) ON DELETE CASCADE,
    FOREIGN KEY (food_id) REFERENCES foods(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- MEAL LOGS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS meal_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    food_id INT NOT NULL,
    meal_type ENUM('breakfast', 'lunch', 'dinner', 'snack') NOT NULL,
    servings DECIMAL(4,2) DEFAULT 1,
    log_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (food_id) REFERENCES foods(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- WATER LOGS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS water_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    glasses INT DEFAULT 0,
    log_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY user_date (user_id, log_date),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- SLEEP LOGS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS sleep_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hours DECIMAL(4,2) NOT NULL,
    quality ENUM('excellent', 'good', 'fair', 'poor') DEFAULT NULL,
    bedtime TIME DEFAULT NULL,
    wake_time TIME DEFAULT NULL,
    log_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY user_date (user_id, log_date),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- WEIGHT LOGS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS weight_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    notes TEXT DEFAULT NULL,
    log_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- SYSTEM SETTINGS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS system_settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- MESSAGES TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- APPOINTMENTS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nutritionist_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    duration_minutes INT DEFAULT 30,
    status ENUM('scheduled', 'completed', 'cancelled') DEFAULT 'scheduled',
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (nutritionist_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- MEAL SUGGESTIONS TABLE (Recipes)
-- =============================================
CREATE TABLE IF NOT EXISTS meal_suggestions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nutritionist_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    meal_type ENUM('breakfast', 'lunch', 'dinner', 'snack') NOT NULL,
    calories INT DEFAULT 0,
    prep_time INT DEFAULT 0,
    ingredients TEXT DEFAULT NULL,
    instructions TEXT DEFAULT NULL,
    tags VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nutritionist_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- NUTRITION GUIDES TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS nutrition_guides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nutritionist_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50) DEFAULT 'General',
    difficulty ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    read_time INT DEFAULT 5,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nutritionist_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- INSERT SAMPLE DATA
-- =============================================

-- Insert demo users (password: demo123)
INSERT INTO users (name, email, password, role, status, specialty, goal) VALUES
('John Doe', 'user@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', NULL, 'weight_loss'),
('Dr. Sarah Mitchell', 'nutritionist@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nutritionist', 'active', 'Weight Management', NULL),
('Admin User', 'admin@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active', NULL, NULL);

-- Assign user to nutritionist
UPDATE users SET nutritionist_id = 2 WHERE email = 'user@demo.com';

-- Insert food categories
INSERT INTO food_categories (name, description, icon) VALUES
('Fruits', 'Fresh and dried fruits', '🍎'),
('Vegetables', 'Fresh vegetables and greens', '🥬'),
('Proteins', 'Meat, fish, eggs, and legumes', '🍗'),
('Dairy', 'Milk, cheese, and yogurt', '🥛'),
('Grains', 'Bread, rice, pasta, and cereals', '🍞'),
('Beverages', 'Drinks and smoothies', '🥤'),
('Snacks', 'Healthy snacks and treats', '🥜');

-- Insert sample foods
INSERT INTO foods (name, category_id, calories, protein, carbs, fat, fiber, serving_size) VALUES
('Apple', 1, 95, 0.5, 25, 0.3, 4.4, '1 medium'),
('Banana', 1, 105, 1.3, 27, 0.4, 3.1, '1 medium'),
('Orange', 1, 62, 1.2, 15, 0.2, 3.1, '1 medium'),
('Spinach', 2, 7, 0.9, 1.1, 0.1, 0.7, '1 cup raw'),
('Broccoli', 2, 55, 3.7, 11, 0.6, 5.1, '1 cup'),
('Carrot', 2, 25, 0.6, 6, 0.1, 1.7, '1 medium'),
('Chicken Breast', 3, 165, 31, 0, 3.6, 0, '100g'),
('Salmon', 3, 208, 20, 0, 13, 0, '100g'),
('Eggs', 3, 155, 13, 1.1, 11, 0, '2 large'),
('Greek Yogurt', 4, 100, 17, 6, 0.7, 0, '170g'),
('Milk', 4, 149, 8, 12, 8, 0, '1 cup'),
('Brown Rice', 5, 216, 5, 45, 1.8, 3.5, '1 cup cooked'),
('Oatmeal', 5, 158, 6, 27, 3, 4, '1 cup cooked'),
('Whole Wheat Bread', 5, 81, 4, 14, 1, 2, '1 slice'),
('Almonds', 7, 164, 6, 6, 14, 3.5, '1 oz'),
('Green Tea', 6, 2, 0, 0, 0, 0, '1 cup');

-- Note: Run setup_demo_users.php to fix passwords to 'demo123'
