-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 24, 2026 at 09:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nutritrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nutritionist_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `nutritionist_id`, `appointment_date`, `appointment_time`, `reason`, `status`, `created_at`) VALUES
(1, 1, 10, '2026-02-02', '15:00:00', 'SADSA', '', '2026-01-24 18:18:31'),
(2, 1, 2, '2026-03-02', '10:00:00', '', '', '2026-01-24 18:18:52'),
(3, 1, 2, '2026-02-02', '10:00:00', '', '', '2026-01-24 18:26:17'),
(4, 1, 2, '2026-02-02', '14:00:00', '', '', '2026-01-24 18:30:50'),
(5, 1, 2, '2026-02-02', '11:00:00', '', '', '2026-01-24 18:34:42'),
(6, 1, 2, '2026-02-22', '14:00:00', '', 'completed', '2026-01-24 18:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `diet_plans`
--

CREATE TABLE `diet_plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nutritionist_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `daily_calories` int(11) DEFAULT NULL,
  `protein_goal` int(11) DEFAULT NULL,
  `carbs_goal` int(11) DEFAULT NULL,
  `fat_goal` int(11) DEFAULT NULL,
  `duration_weeks` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('active','completed','cancelled') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_plans`
--

INSERT INTO `diet_plans` (`id`, `user_id`, `nutritionist_id`, `name`, `description`, `daily_calories`, `protein_goal`, `carbs_goal`, `fat_goal`, `duration_weeks`, `start_date`, `status`, `created_at`) VALUES
(1, 1, 2, 'Weight Loss Plan - John Doe', 'sdsds', 2000, 0, 0, 0, 2, '2026-01-24', 'active', '2026-01-24 16:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `diet_plan_meals`
--

CREATE TABLE `diet_plan_meals` (
  `id` int(11) NOT NULL,
  `diet_plan_id` int(11) NOT NULL,
  `day_of_week` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') NOT NULL,
  `meal_type` enum('breakfast','lunch','dinner','snack') NOT NULL,
  `meal_items` text NOT NULL COMMENT 'JSON format: [{"food_name":"Oatmeal","quantity":"1 cup","calories":150}]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_plan_meals`
--

INSERT INTO `diet_plan_meals` (`id`, `diet_plan_id`, `day_of_week`, `meal_type`, `meal_items`) VALUES
(27, 1, 'monday', 'breakfast', 'sada'),
(28, 1, 'monday', 'lunch', 'sdd'),
(29, 1, 'monday', 'dinner', 'sds'),
(30, 1, 'monday', 'snack', 'sda'),
(31, 1, 'tuesday', 'breakfast', 'sadas'),
(32, 1, 'tuesday', 'lunch', 'asddas'),
(33, 1, 'tuesday', 'snack', 'adsds'),
(34, 1, 'wednesday', 'breakfast', 'asdsa'),
(35, 1, 'wednesday', 'lunch', 'sdaas'),
(36, 1, 'wednesday', 'dinner', 'asd'),
(37, 1, 'wednesday', 'snack', 'asdsa'),
(38, 1, 'saturday', 'breakfast', 'saturday'),
(39, 1, 'saturday', 'lunch', 'sasad'),
(40, 1, 'saturday', 'dinner', 'sd'),
(41, 1, 'saturday', 'snack', 'saturday'),
(42, 1, 'sunday', 'breakfast', 'sdasd'),
(43, 1, 'sunday', 'lunch', 'sadsa'),
(44, 1, 'sunday', 'dinner', 'da'),
(45, 1, 'sunday', 'snack', 'das');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `calories` int(11) NOT NULL DEFAULT 0,
  `protein` decimal(5,2) DEFAULT 0.00,
  `carbs` decimal(5,2) DEFAULT 0.00,
  `fat` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `name`, `description`, `category_id`, `calories`, `protein`, `carbs`, `fat`, `created_at`) VALUES
(1, 'Apple', 'Fresh red apple', 1, 52, 0.30, 14.00, 0.20, '2026-01-24 14:20:02'),
(2, 'Banana', 'Fresh banana', 1, 105, 1.30, 27.00, 0.40, '2026-01-24 14:20:02'),
(3, 'Carrot', 'Fresh orange carrot', 2, 41, 0.90, 10.00, 0.20, '2026-01-24 14:20:02'),
(5, 'Brown Rice', 'Cooked brown rice', 3, 216, 5.00, 45.00, 1.80, '2026-01-24 14:20:02'),
(6, 'Oatmeal', 'Cooked oatmeal', 3, 150, 5.00, 27.00, 2.50, '2026-01-24 14:20:02'),
(7, 'Chicken Breast', 'Skinless, boneless', 4, 165, 31.00, 0.00, 3.60, '2026-01-24 14:20:02'),
(8, 'Salmon', 'Fresh salmon fillet', 4, 208, 20.00, 0.00, 13.00, '2026-01-24 14:20:02'),
(9, 'Eggs', 'Two large eggs', 4, 155, 13.00, 1.00, 11.00, '2026-01-24 14:20:02'),
(10, 'Greek Yogurt', 'Plain greek yogurt', 5, 100, 17.00, 6.00, 0.70, '2026-01-24 14:20:02'),
(11, 'Milk', 'Whole milk', 5, 61, 3.20, 4.80, 3.30, '2026-01-24 14:20:02'),
(12, 'Almonds', 'Raw almonds', 6, 164, 6.00, 6.00, 14.00, '2026-01-24 14:20:02'),
(13, 'Brown Rice', 'Whole grain rice, cooked', 2, 216, 5.00, 45.00, 1.80, '2026-01-24 18:01:26'),
(14, 'Oatmeal', 'Steel-cut oats, cooked', 2, 158, 6.00, 27.00, 3.20, '2026-01-24 18:01:26'),
(15, 'Whole Wheat Bread', 'Fiber-rich bread', 2, 81, 4.00, 14.00, 1.00, '2026-01-24 18:01:26'),
(16, 'Quinoa', 'Complete protein grain', 2, 222, 8.00, 39.00, 3.50, '2026-01-24 18:01:26'),
(17, 'Pasta (whole wheat)', 'Whole grain pasta', 2, 174, 7.50, 37.00, 0.80, '2026-01-24 18:01:26'),
(18, 'Apple', 'Medium sized, with skin', 3, 95, 0.50, 25.00, 0.30, '2026-01-24 18:01:26'),
(19, 'Banana', 'Potassium-rich fruit', 3, 105, 1.30, 27.00, 0.40, '2026-01-24 18:01:26'),
(20, 'Orange', 'Vitamin C source', 3, 62, 1.20, 15.00, 0.20, '2026-01-24 18:01:26'),
(21, 'Blueberries', 'Antioxidant-rich berries', 3, 84, 1.10, 21.00, 0.50, '2026-01-24 18:01:26'),
(22, 'Strawberries', 'Low calorie berries', 3, 49, 1.00, 12.00, 0.50, '2026-01-24 18:01:26'),
(23, 'Avocado', 'Healthy fats fruit', 3, 234, 2.90, 12.00, 21.00, '2026-01-24 18:01:26'),
(24, 'Broccoli', 'Steamed, nutrient-dense', 4, 55, 3.70, 11.00, 0.60, '2026-01-24 18:01:26'),
(25, 'Spinach', 'Raw, iron-rich', 4, 7, 0.90, 1.10, 0.10, '2026-01-24 18:01:26'),
(26, 'Sweet Potato', 'Baked, with skin', 4, 103, 2.30, 24.00, 0.10, '2026-01-24 18:01:26'),
(27, 'Carrots', 'Raw, vitamin A rich', 4, 52, 1.20, 12.00, 0.30, '2026-01-24 18:01:26'),
(28, 'Bell Peppers', 'Mixed colors, raw', 4, 30, 1.00, 6.00, 0.30, '2026-01-24 18:01:26'),
(29, 'Cauliflower', 'Steamed florets', 4, 29, 2.00, 5.00, 0.30, '2026-01-24 18:01:26'),
(30, 'Milk (2%)', 'Reduced fat milk', 5, 122, 8.10, 11.70, 4.80, '2026-01-24 18:01:26'),
(31, 'Cheddar Cheese', 'Aged cheddar', 5, 113, 7.00, 0.40, 9.30, '2026-01-24 18:01:26'),
(32, 'Cottage Cheese', 'Low fat', 5, 163, 28.00, 6.00, 2.30, '2026-01-24 18:01:26'),
(33, 'Almond Milk', 'Unsweetened', 5, 30, 1.00, 1.00, 2.50, '2026-01-24 18:01:26'),
(34, 'Green Smoothie', 'Spinach, banana, almond milk', 6, 180, 5.00, 35.00, 3.00, '2026-01-24 18:01:26'),
(35, 'Protein Shake', 'Whey protein with water', 6, 120, 24.00, 3.00, 1.00, '2026-01-24 18:01:26'),
(36, 'Orange Juice', 'Fresh squeezed', 6, 112, 1.70, 26.00, 0.50, '2026-01-24 18:01:26'),
(37, 'Almonds', 'Raw, unsalted', 7, 164, 6.00, 6.00, 14.00, '2026-01-24 18:01:26'),
(38, 'Trail Mix', 'Nuts and dried fruit', 7, 173, 5.00, 18.00, 11.00, '2026-01-24 18:01:26'),
(39, 'Hummus', 'With veggie sticks', 7, 166, 8.00, 14.00, 10.00, '2026-01-24 18:01:26'),
(40, 'Dark Chocolate', '70% cacao', 7, 170, 2.00, 13.00, 12.00, '2026-01-24 18:01:26'),
(41, 'Rice Cakes', 'Plain, whole grain', 7, 35, 0.70, 7.30, 0.30, '2026-01-24 18:01:26');

-- --------------------------------------------------------

--
-- Table structure for table `food_categories`
--

CREATE TABLE `food_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_categories`
--

INSERT INTO `food_categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Fruits', 'Fresh and dried fruits', '2026-01-24 14:20:02'),
(2, 'Vegetables', 'Fresh vegetables and greens', '2026-01-24 14:20:02'),
(3, 'Grains', 'Cereals, bread, and pasta', '2026-01-24 14:20:02'),
(4, 'Proteins', 'Meat, fish, and legumes', '2026-01-24 14:20:02'),
(5, 'Dairy', 'Milk, cheese, and yogurt', '2026-01-24 14:20:02'),
(6, 'Nuts & Seeds', 'Nuts, seeds, and oils', '2026-01-24 14:20:02'),
(7, 'Desserts', 'Sweets and treats', '2026-01-24 14:20:02'),
(11, 'Proteins', 'Meat, fish, eggs, and plant-based proteins', '2026-01-24 17:56:57'),
(12, 'Grains', 'Bread, rice, pasta, and cereals', '2026-01-24 17:56:57'),
(13, 'Fruits', 'Fresh and dried fruits', '2026-01-24 17:56:57'),
(14, 'Vegetables', 'Fresh and cooked vegetables', '2026-01-24 17:56:57'),
(15, 'Dairy', 'Milk, cheese, yogurt products', '2026-01-24 17:56:57'),
(16, 'Beverages', 'Drinks and smoothies', '2026-01-24 17:56:57'),
(17, 'Snacks', 'Healthy snack options', '2026-01-24 17:56:57');

-- --------------------------------------------------------

--
-- Table structure for table `meal_logs`
--

CREATE TABLE `meal_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `meal_type` enum('breakfast','lunch','dinner','snack') NOT NULL,
  `servings` decimal(3,1) NOT NULL DEFAULT 1.0,
  `log_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_logs`
--

INSERT INTO `meal_logs` (`id`, `user_id`, `food_id`, `meal_type`, `servings`, `log_date`, `created_at`) VALUES
(5, 1, 1, 'breakfast', 1.0, '2026-01-24', '2026-01-24 17:27:38'),
(6, 1, 12, 'breakfast', 1.0, '2026-01-24', '2026-01-24 17:28:11'),
(7, 1, 1, 'dinner', 1.0, '2026-01-24', '2026-01-24 17:28:17'),
(90, 1, 12, 'lunch', 1.0, '2026-01-24', '2026-01-24 19:23:11'),
(91, 1, 12, 'snack', 1.0, '2026-01-24', '2026-01-24 19:23:18'),
(92, 1, 1, 'lunch', 1.0, '2026-01-24', '2026-01-24 19:25:00'),
(93, 1, 23, 'snack', 1.0, '2026-01-24', '2026-01-24 19:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `meal_suggestions`
--

CREATE TABLE `meal_suggestions` (
  `id` int(11) NOT NULL,
  `nutritionist_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `meal_type` enum('breakfast','lunch','dinner','snack') NOT NULL,
  `calories` int(11) DEFAULT 0,
  `prep_time` int(11) DEFAULT 0,
  `ingredients` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_suggestions`
--

INSERT INTO `meal_suggestions` (`id`, `nutritionist_id`, `title`, `description`, `meal_type`, `calories`, `prep_time`, `ingredients`, `instructions`, `tags`, `created_at`, `image_path`) VALUES
(1, 2, 'sas', 'ds', 'breakfast', 23, 22, NULL, NULL, '', '2026-01-24 16:59:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 2, 'hello', 1, '2026-01-24 15:05:47'),
(2, 2, 1, 'hii', 1, '2026-01-24 15:06:05'),
(3, 1, 2, 'sds', 1, '2026-01-24 17:20:59'),
(4, 2, 1, 'sds', 1, '2026-01-24 19:22:40'),
(5, 1, 2, 'hii', 1, '2026-01-24 19:22:57'),
(6, 1, 2, 'i am borshon', 1, '2026-01-24 19:25:13');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nutrition_guides`
--

CREATE TABLE `nutrition_guides` (
  `id` int(11) NOT NULL,
  `nutritionist_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT 'General',
  `difficulty` enum('beginner','intermediate','advanced') DEFAULT 'beginner',
  `read_time` int(11) DEFAULT 5,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutrition_guides`
--

INSERT INTO `nutrition_guides` (`id`, `nutritionist_id`, `title`, `content`, `image_path`, `category`, `difficulty`, `read_time`, `created_at`, `updated_at`) VALUES
(1, 2, 'sds', 'asdsadasdsaaaaaaaaaaaaaa', NULL, 'General', 'intermediate', 5, '2026-01-24 16:59:33', '2026-01-24 16:59:33'),
(2, 2, 'zxzz', 'dsdsdadada', NULL, 'Meal Planning', 'beginner', 5, '2026-01-24 17:24:49', '2026-01-24 17:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `sleep_logs`
--

CREATE TABLE `sleep_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hours` decimal(3,1) NOT NULL,
  `quality` enum('excellent','good','fair','poor') DEFAULT NULL,
  `bedtime` time DEFAULT NULL,
  `wake_time` time DEFAULT NULL,
  `log_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sleep_logs`
--

INSERT INTO `sleep_logs` (`id`, `user_id`, `hours`, `quality`, `bedtime`, `wake_time`, `log_date`, `created_at`) VALUES
(1, 1, 2.0, 'excellent', NULL, NULL, '2026-01-24', '2026-01-24 16:02:46');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('user','nutritionist','admin') NOT NULL DEFAULT 'user',
  `status` enum('active','pending','inactive') NOT NULL DEFAULT 'pending',
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `goal` enum('weight_loss','maintain','gain_weight','build_muscle') DEFAULT NULL,
  `health_conditions` text DEFAULT NULL,
  `specialty` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `nutritionist_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `status`, `weight`, `height`, `age`, `goal`, `health_conditions`, `specialty`, `bio`, `rating`, `nutritionist_id`, `created_at`, `updated_at`, `profile_image`) VALUES
(1, 'John Doe sds', 'user@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'user', 'active', 76.00, 168.00, 25, 'weight_loss', 'diabetes', NULL, NULL, NULL, 2, '2026-01-24 14:20:02', '2026-01-24 17:20:47', NULL),
(2, 'Dr. Sarah Mitchellmain', 'nutritionist@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'nutritionist', 'active', NULL, NULL, NULL, NULL, NULL, 'Weight Management', '', NULL, NULL, '2026-01-24 14:20:02', '2026-01-24 15:15:22', NULL),
(3, 'Admin Userss', 'admin@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'admin', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-24 14:20:02', '2026-01-24 15:47:53', NULL),
(4, 'sdsd', 'adnan.borshon@gmail.com', '$2y$10$kXEUQK296hAAMMu64kzng.nMcXOwo.J8Kou0WEPJ1PGSLravAr8QK', NULL, 'user', 'active', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 2, '2026-01-24 15:40:56', '2026-01-24 16:18:17', NULL),
(6, 'sdsd', 'adnan@gmail.com', '$2y$10$HFMZtxHPygUQLW/ly8FB5ucOCEAxD1JOE0NWsDZCzR3sNhmpo4f7W', NULL, 'user', 'active', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2026-01-24 17:02:38', '2026-01-24 17:02:38', NULL),
(7, 'Admin User', 'admin@nutritrack.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'admin', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 17:55:53', '2026-01-24 17:55:53', NULL),
(8, 'Dr. Sarah Johnson', 'sarah.johnson@nutritrack.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-0101', 'nutritionist', 'active', NULL, NULL, NULL, NULL, NULL, 'Weight Management', 'Certified nutritionist with 10+ years experience in weight management and metabolic health. Specializing in sustainable diet plans.', NULL, NULL, '2025-12-10 17:55:53', '2026-01-24 17:55:53', NULL),
(9, 'Dr. Michael Chen', 'michael.chen@nutritrack.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-0102', 'nutritionist', 'active', NULL, NULL, NULL, NULL, NULL, 'Sports Nutrition', 'Sports nutritionist working with professional athletes. Expert in performance optimization and muscle building diets.', NULL, NULL, '2025-12-15 17:55:53', '2026-01-24 17:55:53', NULL),
(10, 'Dr. Emily Rodriguez', 'emily.rodriguez@nutritrack.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-0103', 'nutritionist', 'active', NULL, NULL, NULL, NULL, NULL, 'Diabetes Management', 'Specialized in diabetic nutrition and blood sugar management. Helping patients achieve better glucose control through diet.', NULL, NULL, '2025-12-20 17:55:53', '2026-01-24 17:55:53', NULL),
(11, 'John Smith', 'john.smith@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1001', 'user', 'active', 85.50, 175.00, 32, 'weight_loss', NULL, NULL, NULL, NULL, 2, '2025-12-25 17:55:53', '2026-01-24 17:55:53', NULL),
(12, 'Emma Wilson', 'emma.wilson@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1002', 'user', 'active', 62.00, 165.00, 28, 'maintain', NULL, NULL, NULL, NULL, 2, '2025-12-27 17:55:53', '2026-01-24 17:55:53', NULL),
(13, 'David Brown', 'david.brown@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1003', 'user', 'active', 78.00, 180.00, 25, '', NULL, NULL, NULL, NULL, NULL, '2025-12-30 17:55:53', '2026-01-24 20:20:14', NULL),
(14, 'Sophie Taylor', 'sophie.taylor@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1004', 'user', 'active', 70.50, 160.00, 35, 'weight_loss', NULL, NULL, NULL, NULL, 3, '2026-01-02 17:55:53', '2026-01-24 17:55:53', NULL),
(15, 'James Anderson', 'james.anderson@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1005', 'user', 'active', 65.00, 178.00, 22, 'gain_weight', NULL, NULL, NULL, NULL, 4, '2026-01-04 17:55:53', '2026-01-24 17:55:53', NULL),
(16, 'Olivia Martinez', 'olivia.martinez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1006', 'user', 'active', 58.00, 162.00, 30, 'maintain', NULL, NULL, NULL, NULL, 4, '2026-01-06 17:55:53', '2026-01-24 17:55:53', NULL),
(17, 'William Garcia', 'william.garcia@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1007', 'user', 'active', 95.00, 182.00, 40, 'weight_loss', NULL, NULL, NULL, NULL, 2, '2026-01-09 17:55:53', '2026-01-24 17:55:53', NULL),
(18, 'Isabella Lee', 'isabella.lee@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1-555-1008', 'user', 'active', 55.00, 158.00, 27, 'build_muscle', NULL, NULL, NULL, NULL, 3, '2026-01-12 17:55:53', '2026-01-24 17:55:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `water_logs`
--

CREATE TABLE `water_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `glasses` int(11) NOT NULL DEFAULT 0,
  `log_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `water_logs`
--

INSERT INTO `water_logs` (`id`, `user_id`, `glasses`, `log_date`, `created_at`) VALUES
(1, 1, 3, '2026-01-24', '2026-01-24 15:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `weight_logs`
--

CREATE TABLE `weight_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `log_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weight_logs`
--

INSERT INTO `weight_logs` (`id`, `user_id`, `weight`, `notes`, `log_date`, `created_at`) VALUES
(1, 1, 76.00, '', '2026-01-24', '2026-01-24 17:20:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `nutritionist_id` (`nutritionist_id`);

--
-- Indexes for table `diet_plans`
--
ALTER TABLE `diet_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `nutritionist_id` (`nutritionist_id`);

--
-- Indexes for table `diet_plan_meals`
--
ALTER TABLE `diet_plan_meals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `diet_plan_meals_unique` (`diet_plan_id`,`day_of_week`,`meal_type`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `food_categories`
--
ALTER TABLE `food_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meal_logs`
--
ALTER TABLE `meal_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `meal_suggestions`
--
ALTER TABLE `meal_suggestions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nutritionist_id` (`nutritionist_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nutrition_guides`
--
ALTER TABLE `nutrition_guides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nutritionist_id` (`nutritionist_id`);

--
-- Indexes for table `sleep_logs`
--
ALTER TABLE `sleep_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_date` (`user_id`,`log_date`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `nutritionist_id` (`nutritionist_id`);

--
-- Indexes for table `water_logs`
--
ALTER TABLE `water_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_date` (`user_id`,`log_date`);

--
-- Indexes for table `weight_logs`
--
ALTER TABLE `weight_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `diet_plans`
--
ALTER TABLE `diet_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `diet_plan_meals`
--
ALTER TABLE `diet_plan_meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `food_categories`
--
ALTER TABLE `food_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `meal_logs`
--
ALTER TABLE `meal_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `meal_suggestions`
--
ALTER TABLE `meal_suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nutrition_guides`
--
ALTER TABLE `nutrition_guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sleep_logs`
--
ALTER TABLE `sleep_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `water_logs`
--
ALTER TABLE `water_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `weight_logs`
--
ALTER TABLE `weight_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`nutritionist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diet_plans`
--
ALTER TABLE `diet_plans`
  ADD CONSTRAINT `diet_plans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diet_plans_ibfk_2` FOREIGN KEY (`nutritionist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diet_plan_meals`
--
ALTER TABLE `diet_plan_meals`
  ADD CONSTRAINT `diet_plan_meals_ibfk_1` FOREIGN KEY (`diet_plan_id`) REFERENCES `diet_plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `food_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meal_logs`
--
ALTER TABLE `meal_logs`
  ADD CONSTRAINT `meal_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meal_logs_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meal_suggestions`
--
ALTER TABLE `meal_suggestions`
  ADD CONSTRAINT `meal_suggestions_ibfk_1` FOREIGN KEY (`nutritionist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nutrition_guides`
--
ALTER TABLE `nutrition_guides`
  ADD CONSTRAINT `nutrition_guides_ibfk_1` FOREIGN KEY (`nutritionist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sleep_logs`
--
ALTER TABLE `sleep_logs`
  ADD CONSTRAINT `sleep_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`nutritionist_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `water_logs`
--
ALTER TABLE `water_logs`
  ADD CONSTRAINT `water_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `weight_logs`
--
ALTER TABLE `weight_logs`
  ADD CONSTRAINT `weight_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
