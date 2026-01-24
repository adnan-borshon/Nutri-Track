-- Update diet_plan_meals table to support daily meal planning
ALTER TABLE `diet_plan_meals` 
ADD COLUMN `day_of_week` ENUM('monday','tuesday','wednesday','thursday','friday','saturday','sunday') NOT NULL AFTER `diet_plan_id`,
MODIFY COLUMN `meal_items` TEXT NOT NULL COMMENT 'JSON format: [{"food_name":"Oatmeal","quantity":"1 cup","calories":150}]';

-- Drop existing index if any and create new composite index
DROP INDEX IF EXISTS `diet_plan_meals_unique` ON `diet_plan_meals`;
ALTER TABLE `diet_plan_meals` 
ADD UNIQUE KEY `diet_plan_meals_unique` (`diet_plan_id`, `day_of_week`, `meal_type`);