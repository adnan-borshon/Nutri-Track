-- Update nutrition_guides table to support images
ALTER TABLE `nutrition_guides` 
ADD COLUMN `image_path` VARCHAR(255) DEFAULT NULL AFTER `content`;