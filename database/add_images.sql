-- Add image columns to existing tables
ALTER TABLE nutrition_guides ADD COLUMN image_path VARCHAR(255) DEFAULT NULL;
ALTER TABLE meal_suggestions ADD COLUMN image_path VARCHAR(255) DEFAULT NULL;
ALTER TABLE users ADD COLUMN profile_image VARCHAR(255) DEFAULT NULL;