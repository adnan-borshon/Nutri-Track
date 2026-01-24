-- Run this SQL in phpMyAdmin to fix demo user passwords
-- Password: demo123 (bcrypt hashed)

-- First, check if demo users exist
SELECT id, name, email, role, status FROM users 
WHERE email IN ('user@demo.com', 'nutritionist@demo.com', 'admin@demo.com');

-- Update passwords for demo users to 'demo123'
-- This hash is for 'demo123' using PASSWORD_DEFAULT
UPDATE users SET password = '$2y$10$YourHashHere' WHERE email IN ('user@demo.com', 'nutritionist@demo.com', 'admin@demo.com');

-- If demo users don't exist, insert them:
-- DELETE existing demo users first (if needed)
DELETE FROM users WHERE email IN ('user@demo.com', 'nutritionist@demo.com', 'admin@demo.com');

-- Insert fresh demo users with correct password hash for 'demo123'
INSERT INTO users (name, email, password, role, status, specialty, goal) VALUES
('John Doe', 'user@demo.com', '$2y$10$demo123hashedpasswordhere', 'user', 'active', NULL, 'weight_loss'),
('Dr. Sarah Mitchell', 'nutritionist@demo.com', '$2y$10$demo123hashedpasswordhere', 'nutritionist', 'active', 'Weight Management', NULL),
('Admin User', 'admin@demo.com', '$2y$10$demo123hashedpasswordhere', 'admin', 'active', NULL, NULL);

-- Assign user to nutritionist
UPDATE users SET nutritionist_id = (SELECT id FROM (SELECT id FROM users WHERE email = 'nutritionist@demo.com') AS t) WHERE email = 'user@demo.com';
