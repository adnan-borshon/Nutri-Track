-- NutriTrack Sample Data
-- Run this SQL in phpMyAdmin AFTER running schema.sql
-- Database: nutritrack

USE nutritrack;

-- Disable foreign key checks during import
SET FOREIGN_KEY_CHECKS = 0;

-- Clear existing data (optional - comment out if you want to keep existing data)
TRUNCATE TABLE messages;
TRUNCATE TABLE appointments;
TRUNCATE TABLE meal_suggestions;
TRUNCATE TABLE nutrition_guides;
TRUNCATE TABLE weight_logs;
TRUNCATE TABLE sleep_logs;
TRUNCATE TABLE water_logs;
TRUNCATE TABLE meal_logs;
TRUNCATE TABLE diet_plans;
TRUNCATE TABLE foods;
TRUNCATE TABLE food_categories;
TRUNCATE TABLE system_settings;
TRUNCATE TABLE users;

-- =============================================
-- SAMPLE USERS (Password for all: password123)
-- Password hash is for 'password123' using password_hash()
-- =============================================

-- Admin User
INSERT INTO users (name, email, password, role, status, created_at) VALUES
('Admin User', 'admin@nutritrack.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active', DATE_SUB(NOW(), INTERVAL 60 DAY));

-- Nutritionists
INSERT INTO users (name, email, password, phone, role, status, specialty, bio, created_at) VALUES
('Dr. Sarah Johnson', 'sarah.johnson@nutritrack.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-0101', 'nutritionist', 'active', 'Weight Management', 'Certified nutritionist with 10+ years experience in weight management and metabolic health. Specializing in sustainable diet plans.', DATE_SUB(NOW(), INTERVAL 45 DAY)),
('Dr. Michael Chen', 'michael.chen@nutritrack.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-0102', 'nutritionist', 'active', 'Sports Nutrition', 'Sports nutritionist working with professional athletes. Expert in performance optimization and muscle building diets.', DATE_SUB(NOW(), INTERVAL 40 DAY)),
('Dr. Emily Rodriguez', 'emily.rodriguez@nutritrack.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-0103', 'nutritionist', 'active', 'Diabetes Management', 'Specialized in diabetic nutrition and blood sugar management. Helping patients achieve better glucose control through diet.', DATE_SUB(NOW(), INTERVAL 35 DAY));

-- Regular Users (assigned to nutritionists)
INSERT INTO users (name, email, password, phone, role, status, nutritionist_id, goal, weight, height, age, created_at) VALUES
('John Smith', 'john.smith@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1001', 'user', 'active', 2, 'weight_loss', 85.5, 175, 32, DATE_SUB(NOW(), INTERVAL 30 DAY)),
('Emma Wilson', 'emma.wilson@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1002', 'user', 'active', 2, 'maintain', 62.0, 165, 28, DATE_SUB(NOW(), INTERVAL 28 DAY)),
('David Brown', 'david.brown@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1003', 'user', 'active', 3, 'build_muscle', 78.0, 180, 25, DATE_SUB(NOW(), INTERVAL 25 DAY)),
('Sophie Taylor', 'sophie.taylor@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1004', 'user', 'active', 3, 'weight_loss', 70.5, 160, 35, DATE_SUB(NOW(), INTERVAL 22 DAY)),
('James Anderson', 'james.anderson@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1005', 'user', 'active', 4, 'gain_weight', 65.0, 178, 22, DATE_SUB(NOW(), INTERVAL 20 DAY)),
('Olivia Martinez', 'olivia.martinez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1006', 'user', 'active', 4, 'maintain', 58.0, 162, 30, DATE_SUB(NOW(), INTERVAL 18 DAY)),
('William Garcia', 'william.garcia@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1007', 'user', 'active', 2, 'weight_loss', 95.0, 182, 40, DATE_SUB(NOW(), INTERVAL 15 DAY)),
('Isabella Lee', 'isabella.lee@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1008', 'user', 'active', 3, 'build_muscle', 55.0, 158, 27, DATE_SUB(NOW(), INTERVAL 12 DAY));

-- =============================================
-- FOOD CATEGORIES
-- =============================================
INSERT INTO food_categories (name, description, icon) VALUES
('Proteins', 'Meat, fish, eggs, and plant-based proteins', '🥩'),
('Grains', 'Bread, rice, pasta, and cereals', '🌾'),
('Fruits', 'Fresh and dried fruits', '🍎'),
('Vegetables', 'Fresh and cooked vegetables', '🥦'),
('Dairy', 'Milk, cheese, yogurt products', '🥛'),
('Beverages', 'Drinks and smoothies', '🥤'),
('Snacks', 'Healthy snack options', '🥜');

-- =============================================
-- FOODS DATABASE
-- =============================================
INSERT INTO foods (name, description, category_id, calories, protein, carbs, fat, fiber, serving_size) VALUES
-- Proteins
('Grilled Chicken Breast', 'Lean protein, skinless', 1, 165, 31.0, 0.0, 3.6, 0.0, '100g'),
('Salmon Fillet', 'Rich in omega-3 fatty acids', 1, 208, 20.0, 0.0, 13.0, 0.0, '100g'),
('Eggs (2 large)', 'Complete protein source', 1, 143, 12.6, 0.7, 9.5, 0.0, '2 eggs'),
('Ground Turkey', 'Lean ground meat', 1, 149, 19.0, 0.0, 8.0, 0.0, '100g'),
('Tofu', 'Plant-based protein', 1, 76, 8.0, 1.9, 4.8, 0.3, '100g'),
('Greek Yogurt', 'High protein dairy', 1, 100, 17.0, 6.0, 0.7, 0.0, '170g'),
('Tuna (canned)', 'Lean fish protein', 1, 116, 25.5, 0.0, 0.8, 0.0, '100g'),
('Beef Steak', 'Grilled sirloin', 1, 271, 26.0, 0.0, 18.0, 0.0, '100g'),

-- Grains
('Brown Rice', 'Whole grain rice, cooked', 2, 216, 5.0, 45.0, 1.8, 3.5, '1 cup'),
('Oatmeal', 'Steel-cut oats, cooked', 2, 158, 6.0, 27.0, 3.2, 4.0, '1 cup'),
('Whole Wheat Bread', 'Fiber-rich bread', 2, 81, 4.0, 14.0, 1.0, 2.0, '1 slice'),
('Quinoa', 'Complete protein grain', 2, 222, 8.0, 39.0, 3.5, 5.0, '1 cup'),
('Pasta (whole wheat)', 'Whole grain pasta', 2, 174, 7.5, 37.0, 0.8, 6.0, '1 cup'),

-- Fruits
('Apple', 'Medium sized, with skin', 3, 95, 0.5, 25.0, 0.3, 4.4, '1 medium'),
('Banana', 'Potassium-rich fruit', 3, 105, 1.3, 27.0, 0.4, 3.1, '1 medium'),
('Orange', 'Vitamin C source', 3, 62, 1.2, 15.0, 0.2, 3.1, '1 medium'),
('Blueberries', 'Antioxidant-rich berries', 3, 84, 1.1, 21.0, 0.5, 3.6, '1 cup'),
('Strawberries', 'Low calorie berries', 3, 49, 1.0, 12.0, 0.5, 3.0, '1 cup'),
('Avocado', 'Healthy fats fruit', 3, 234, 2.9, 12.0, 21.0, 10.0, '1 medium'),

-- Vegetables
('Broccoli', 'Steamed, nutrient-dense', 4, 55, 3.7, 11.0, 0.6, 5.1, '1 cup'),
('Spinach', 'Raw, iron-rich', 4, 7, 0.9, 1.1, 0.1, 0.7, '1 cup'),
('Sweet Potato', 'Baked, with skin', 4, 103, 2.3, 24.0, 0.1, 3.8, '1 medium'),
('Carrots', 'Raw, vitamin A rich', 4, 52, 1.2, 12.0, 0.3, 3.6, '1 cup'),
('Bell Peppers', 'Mixed colors, raw', 4, 30, 1.0, 6.0, 0.3, 2.1, '1 cup'),
('Cauliflower', 'Steamed florets', 4, 29, 2.0, 5.0, 0.3, 2.0, '1 cup'),

-- Dairy
('Milk (2%)', 'Reduced fat milk', 5, 122, 8.1, 11.7, 4.8, 0.0, '1 cup'),
('Cheddar Cheese', 'Aged cheddar', 5, 113, 7.0, 0.4, 9.3, 0.0, '1 oz'),
('Cottage Cheese', 'Low fat', 5, 163, 28.0, 6.0, 2.3, 0.0, '1 cup'),
('Almond Milk', 'Unsweetened', 5, 30, 1.0, 1.0, 2.5, 0.0, '1 cup'),

-- Beverages
('Green Smoothie', 'Spinach, banana, almond milk', 6, 180, 5.0, 35.0, 3.0, 5.0, '16 oz'),
('Protein Shake', 'Whey protein with water', 6, 120, 24.0, 3.0, 1.0, 0.0, '1 scoop'),
('Orange Juice', 'Fresh squeezed', 6, 112, 1.7, 26.0, 0.5, 0.5, '1 cup'),

-- Snacks
('Almonds', 'Raw, unsalted', 7, 164, 6.0, 6.0, 14.0, 3.5, '1 oz'),
('Trail Mix', 'Nuts and dried fruit', 7, 173, 5.0, 18.0, 11.0, 2.0, '1 oz'),
('Hummus', 'With veggie sticks', 7, 166, 8.0, 14.0, 10.0, 4.0, '1/2 cup'),
('Dark Chocolate', '70% cacao', 7, 170, 2.0, 13.0, 12.0, 3.0, '1 oz'),
('Rice Cakes', 'Plain, whole grain', 7, 35, 0.7, 7.3, 0.3, 0.4, '1 cake');

-- =============================================
-- DIET PLANS
-- =============================================
INSERT INTO diet_plans (user_id, nutritionist_id, name, description, daily_calories, protein_goal, carbs_goal, fat_goal, duration_weeks, start_date, status) VALUES
(5, 2, 'Weight Loss Plan', 'Calorie deficit diet for sustainable weight loss', 1800, 120, 180, 60, 8, DATE_SUB(CURDATE(), INTERVAL 14 DAY), 'active'),
(6, 2, 'Maintenance Plan', 'Balanced nutrition for weight maintenance', 2000, 100, 250, 65, 12, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 'active'),
(7, 3, 'Muscle Building Plan', 'High protein diet for muscle gain', 2800, 180, 320, 80, 12, DATE_SUB(CURDATE(), INTERVAL 7 DAY), 'active'),
(8, 3, 'Gradual Weight Loss', 'Slow and steady weight loss approach', 1600, 100, 160, 55, 16, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 'active');

-- =============================================
-- MEAL LOGS (Sample data for users)
-- =============================================
INSERT INTO meal_logs (user_id, food_id, meal_type, servings, log_date) VALUES
-- John Smith's meals (last 7 days)
(5, 3, 'breakfast', 1, CURDATE()),
(5, 10, 'breakfast', 1, CURDATE()),
(5, 1, 'lunch', 1.5, CURDATE()),
(5, 9, 'lunch', 1, CURDATE()),
(5, 21, 'lunch', 1, CURDATE()),
(5, 2, 'dinner', 1, CURDATE()),
(5, 23, 'dinner', 1, CURDATE()),

(5, 3, 'breakfast', 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(5, 14, 'breakfast', 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(5, 4, 'lunch', 1.5, DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(5, 12, 'lunch', 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(5, 8, 'dinner', 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(5, 24, 'dinner', 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY)),

-- Emma Wilson's meals
(6, 10, 'breakfast', 1, CURDATE()),
(6, 17, 'breakfast', 1, CURDATE()),
(6, 6, 'lunch', 1, CURDATE()),
(6, 22, 'lunch', 2, CURDATE()),
(6, 5, 'dinner', 1.5, CURDATE()),
(6, 25, 'dinner', 1, CURDATE()),

-- David Brown's meals (high protein)
(7, 3, 'breakfast', 2, CURDATE()),
(7, 10, 'breakfast', 1.5, CURDATE()),
(7, 1, 'lunch', 2, CURDATE()),
(7, 9, 'lunch', 2, CURDATE()),
(7, 21, 'lunch', 1, CURDATE()),
(7, 8, 'dinner', 2, CURDATE()),
(7, 23, 'dinner', 2, CURDATE()),
(7, 35, 'snack', 2, CURDATE());

-- =============================================
-- WATER LOGS
-- =============================================
INSERT INTO water_logs (user_id, glasses, log_date) VALUES
(5, 8, CURDATE()),
(5, 7, DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(5, 6, DATE_SUB(CURDATE(), INTERVAL 2 DAY)),
(5, 8, DATE_SUB(CURDATE(), INTERVAL 3 DAY)),
(6, 10, CURDATE()),
(6, 9, DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(6, 8, DATE_SUB(CURDATE(), INTERVAL 2 DAY)),
(7, 12, CURDATE()),
(7, 11, DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(7, 10, DATE_SUB(CURDATE(), INTERVAL 2 DAY)),
(8, 6, CURDATE()),
(8, 7, DATE_SUB(CURDATE(), INTERVAL 1 DAY));

-- =============================================
-- SLEEP LOGS
-- =============================================
INSERT INTO sleep_logs (user_id, hours, quality, bedtime, wake_time, log_date) VALUES
(5, 7.5, 'good', '23:00:00', '06:30:00', CURDATE()),
(5, 8.0, 'excellent', '22:30:00', '06:30:00', DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(5, 6.5, 'fair', '00:00:00', '06:30:00', DATE_SUB(CURDATE(), INTERVAL 2 DAY)),
(6, 8.0, 'excellent', '22:00:00', '06:00:00', CURDATE()),
(6, 7.5, 'good', '22:30:00', '06:00:00', DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(7, 7.0, 'good', '23:30:00', '06:30:00', CURDATE()),
(7, 8.5, 'excellent', '22:00:00', '06:30:00', DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
(8, 6.0, 'fair', '01:00:00', '07:00:00', CURDATE());

-- =============================================
-- WEIGHT LOGS
-- =============================================
INSERT INTO weight_logs (user_id, weight, notes, log_date) VALUES
(5, 85.5, 'Starting weight', DATE_SUB(CURDATE(), INTERVAL 30 DAY)),
(5, 84.8, 'First week progress', DATE_SUB(CURDATE(), INTERVAL 23 DAY)),
(5, 84.2, 'Steady progress', DATE_SUB(CURDATE(), INTERVAL 16 DAY)),
(5, 83.5, 'Feeling great!', DATE_SUB(CURDATE(), INTERVAL 9 DAY)),
(5, 83.0, 'Keep going!', DATE_SUB(CURDATE(), INTERVAL 2 DAY)),
(6, 62.0, 'Maintenance check', DATE_SUB(CURDATE(), INTERVAL 14 DAY)),
(6, 61.8, 'Slight fluctuation', DATE_SUB(CURDATE(), INTERVAL 7 DAY)),
(6, 62.1, 'Back to normal', CURDATE()),
(7, 78.0, 'Starting muscle gain', DATE_SUB(CURDATE(), INTERVAL 21 DAY)),
(7, 78.8, 'Gaining steadily', DATE_SUB(CURDATE(), INTERVAL 14 DAY)),
(7, 79.5, 'Good progress', DATE_SUB(CURDATE(), INTERVAL 7 DAY)),
(7, 80.2, 'Muscle building working!', CURDATE());

-- =============================================
-- APPOINTMENTS
-- =============================================
INSERT INTO appointments (user_id, nutritionist_id, appointment_date, appointment_time, duration_minutes, status, notes) VALUES
(5, 2, DATE_ADD(CURDATE(), INTERVAL 3 DAY), '10:00:00', 30, 'scheduled', 'Monthly check-in'),
(6, 2, DATE_ADD(CURDATE(), INTERVAL 5 DAY), '14:00:00', 30, 'scheduled', 'Progress review'),
(7, 3, DATE_ADD(CURDATE(), INTERVAL 2 DAY), '11:00:00', 45, 'scheduled', 'Workout nutrition discussion'),
(8, 3, DATE_ADD(CURDATE(), INTERVAL 7 DAY), '09:00:00', 30, 'scheduled', 'Diet plan adjustment'),
(5, 2, DATE_SUB(CURDATE(), INTERVAL 14 DAY), '10:00:00', 30, 'completed', 'Initial consultation'),
(6, 2, DATE_SUB(CURDATE(), INTERVAL 7 DAY), '15:00:00', 30, 'completed', 'Follow-up session');

-- =============================================
-- MESSAGES (Chat history)
-- =============================================
INSERT INTO messages (sender_id, receiver_id, message, is_read, created_at) VALUES
(2, 5, 'Hi John! How is your diet plan going so far?', 1, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(5, 2, 'Hi Dr. Johnson! It is going well. I have already lost 2.5 kg!', 1, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(2, 5, 'That is fantastic progress! Keep up the great work. Remember to log your meals daily.', 1, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(5, 2, 'Thank you! I have a question about protein intake. Is 120g enough?', 0, DATE_SUB(NOW(), INTERVAL 6 HOUR)),

(3, 7, 'David, I reviewed your meal logs. Great job hitting your protein targets!', 1, DATE_SUB(NOW(), INTERVAL 3 DAY)),
(7, 3, 'Thanks Dr. Chen! Should I increase my calorie intake for more muscle gain?', 1, DATE_SUB(NOW(), INTERVAL 3 DAY)),
(3, 7, 'Let us discuss this in our upcoming appointment. We can fine-tune your plan.', 1, DATE_SUB(NOW(), INTERVAL 2 DAY)),

(4, 9, 'Hi James! Welcome to NutriTrack. I will be your nutritionist.', 1, DATE_SUB(NOW(), INTERVAL 5 DAY)),
(9, 4, 'Hi Dr. Rodriguez! Excited to start this journey!', 1, DATE_SUB(NOW(), INTERVAL 5 DAY));

-- =============================================
-- MEAL SUGGESTIONS (from nutritionists)
-- =============================================
INSERT INTO meal_suggestions (nutritionist_id, title, description, meal_type, calories, prep_time, ingredients, instructions, tags) VALUES
(2, 'Power Breakfast Bowl', 'High protein breakfast to start your day', 'breakfast', 450, 15, 'Greek yogurt, oats, mixed berries, honey, almonds', 'Mix oats with yogurt, top with berries and almonds, drizzle honey', 'High Protein,Quick,Healthy'),
(2, 'Mediterranean Lunch Plate', 'Balanced meal with lean protein and vegetables', 'lunch', 520, 25, 'Grilled chicken, quinoa, cucumber, tomatoes, feta cheese, olive oil', 'Grill chicken, prepare quinoa, chop vegetables, combine and dress with olive oil', 'Mediterranean,Balanced,Low Carb'),
(3, 'Muscle Builder Dinner', 'High protein dinner for muscle recovery', 'dinner', 650, 30, 'Salmon fillet, brown rice, steamed broccoli, lemon', 'Bake salmon with lemon, prepare rice, steam broccoli', 'High Protein,Omega-3,Muscle Building'),
(3, 'Pre-Workout Snack', 'Energy boost before training', 'snack', 200, 5, 'Banana, almond butter, whole grain crackers', 'Spread almond butter on crackers, slice banana on top', 'Pre-Workout,Quick,Energy'),
(4, 'Blood Sugar Friendly Lunch', 'Low glycemic index meal', 'lunch', 420, 20, 'Grilled turkey, mixed salad, avocado, olive oil dressing', 'Grill turkey, prepare fresh salad with avocado', 'Diabetes Friendly,Low GI,Healthy Fats');

-- =============================================
-- NUTRITION GUIDES
-- =============================================
INSERT INTO nutrition_guides (nutritionist_id, title, content, category, difficulty, read_time) VALUES
(2, 'Understanding Macronutrients', 'Macronutrients are the nutrients your body needs in large amounts: proteins, carbohydrates, and fats. Each plays a crucial role in your health and fitness goals. Proteins build muscle, carbs provide energy, and fats support hormone function.', 'Basics', 'beginner', 5),
(2, 'Meal Prep for Weight Loss', 'Preparing meals in advance helps you stick to your diet plan. Start by planning your weekly meals, shopping with a list, and dedicating 2-3 hours on Sunday to cook and portion your food.', 'Weight Loss', 'beginner', 8),
(3, 'Nutrition for Muscle Growth', 'Building muscle requires adequate protein intake (1.6-2.2g per kg of body weight), proper carbohydrate timing around workouts, and sufficient calories to support growth.', 'Muscle Building', 'intermediate', 10),
(3, 'Pre and Post Workout Nutrition', 'What you eat before and after exercise significantly impacts your performance and recovery. Aim for carbs and protein before training, and protein with fast carbs after.', 'Sports Nutrition', 'intermediate', 7),
(4, 'Managing Blood Sugar Through Diet', 'Choosing low glycemic index foods, eating fiber with every meal, and avoiding processed sugars helps maintain stable blood sugar levels throughout the day.', 'Health Conditions', 'beginner', 6);

-- =============================================
-- SYSTEM SETTINGS
-- =============================================
INSERT INTO system_settings (setting_key, setting_value) VALUES
('site_name', 'NutriTrack'),
('site_email', 'support@nutritrack.com'),
('default_calorie_goal', '2000'),
('default_water_goal', '8'),
('default_sleep_goal', '8'),
('maintenance_mode', 'false'),
('registration_enabled', 'true');

-- =============================================
-- LOGIN CREDENTIALS SUMMARY
-- =============================================
-- All passwords are: password123
--
-- ADMIN:
-- Email: admin@nutritrack.com
-- Password: password123
--
-- NUTRITIONISTS:
-- Email: sarah.johnson@nutritrack.com | Password: password123
-- Email: michael.chen@nutritrack.com | Password: password123
-- Email: emily.rodriguez@nutritrack.com | Password: password123
--
-- USERS:
-- Email: john.smith@email.com | Password: password123
-- Email: emma.wilson@email.com | Password: password123
-- Email: david.brown@email.com | Password: password123
-- Email: sophie.taylor@email.com | Password: password123
-- Email: james.anderson@email.com | Password: password123
-- Email: olivia.martinez@email.com | Password: password123
-- Email: william.garcia@email.com | Password: password123
-- Email: isabella.lee@email.com | Password: password123

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Done! All sample data inserted successfully.
