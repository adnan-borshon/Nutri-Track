# NutriTrack Project Audit Report

## Overview
This report documents the comprehensive backend/database audit and fixes applied to the NutriTrack PHP project.

---

## Issues Found & Fixes Applied

### 1. Database Schema Issues

**File:** `database/schema.sql`

| Issue | Fix |
|-------|-----|
| Missing `description` column in `foods` table (referenced by admin_handler.php) | Added `description TEXT DEFAULT NULL` column to foods table |

### 2. Authentication & Redirect Issues

**File:** `auth_handler.php`

| Issue | Fix |
|-------|-----|
| Incorrect redirect path for user role: `'users/dashboard.php'` | Changed to `'user/dashboard.php'` |
| Registration redirect path: `'users/dashboard.php'` | Changed to `'user/dashboard.php'` |

**File:** `landing page/auth.php`

| Issue | Fix |
|-------|-----|
| Incorrect redirect path for user role: `'../users/dashboard.php'` | Changed to `'../user/dashboard.php'` |

### 3. Session Handling Issues

**File:** `user/sleep.php`

| Issue | Fix |
|-------|-----|
| Hardcoded session values overriding actual session | Replaced with proper `require_once '../includes/session.php'` and `checkAuth('user')` |
| No database integration for sleep data | Added database queries to fetch/display real sleep data |
| Missing sleep logging functionality | Added JavaScript form submission to save sleep data via `user_handler.php` |

### 4. Hardcoded Data Issues

**File:** `user/dashboard.php`

| Issue | Fix |
|-------|-----|
| Hardcoded calories, water, sleep, weight values | Added database queries to fetch real data |
| Hardcoded meals list | Dynamic meal fetching from `meal_logs` table |
| Hardcoded weight chart data | Dynamic weekly weight data from `weight_logs` table |
| Missing `include 'header.php'` | Added proper header include |

**File:** `nutritionists/dashboard.php`

| Issue | Fix |
|-------|-----|
| Hardcoded stat values (users: 24, plans: 18, etc.) | Added database queries for dynamic counts |
| Static assigned users count | Now queries `users` table where `nutritionist_id` matches |
| Static diet plans count | Now queries `diet_plans` table for active plans |
| Static unread messages count | Now queries `messages` table for unread count |
| Static appointments count | Now queries `appointments` table for today's appointments |

---

## Files Modified

1. `c:\xampp\htdocs\Health DIet\database\schema.sql`
2. `c:\xampp\htdocs\Health DIet\auth_handler.php`
3. `c:\xampp\htdocs\Health DIet\landing page\auth.php`
4. `c:\xampp\htdocs\Health DIet\user\sleep.php`
5. `c:\xampp\htdocs\Health DIet\user\dashboard.php`
6. `c:\xampp\htdocs\Health DIet\nutritionists\dashboard.php`

---

## Database Schema

The database uses MySQL with the following key tables:

| Table | Purpose |
|-------|---------|
| `users` | All users (admin, nutritionist, user roles) |
| `food_categories` | Food categories |
| `foods` | Food items with nutritional info |
| `diet_plans` | Diet plans assigned to users |
| `diet_plan_meals` | Meals within diet plans |
| `meal_logs` | User meal logging |
| `water_logs` | User water intake tracking |
| `sleep_logs` | User sleep tracking |
| `weight_logs` | User weight tracking |
| `messages` | Chat messages between users and nutritionists |
| `appointments` | User appointments with nutritionists |

---

## Testing Instructions (XAMPP)

### Step 1: Database Setup

1. Start XAMPP (Apache + MySQL)
2. Open phpMyAdmin: `http://localhost/phpmyadmin`
3. Create database: `CREATE DATABASE nutritrack;`
4. Select `nutritrack` database
5. Import schema: Go to **Import** tab → Select `database/schema.sql` → Click **Go**

### Step 2: Verify Configuration

Check `config/db.php` has correct settings:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'nutritrack');
```

### Step 3: Access the Application

| Role | URL | Demo Credentials |
|------|-----|------------------|
| Landing Page | `http://localhost/Health%20DIet/landing%20page/login.php` | - |
| User Dashboard | `http://localhost/Health%20DIet/user/dashboard.php` | user@demo.com / Demo@123 |
| Nutritionist Dashboard | `http://localhost/Health%20DIet/nutritionists/dashboard.php` | nutritionist@demo.com / Demo@123 |
| Admin Dashboard | `http://localhost/Health%20DIet/admin/dashboard.php` | admin@demo.com / Demo@123 |

### Step 4: Test Features

**User Features:**
- [ ] Login/Register
- [ ] Dashboard shows real data
- [ ] Meal logging (meals.php)
- [ ] Water tracking (water.php)
- [ ] Sleep logging (sleep.php)
- [ ] Chat with nutritionist
- [ ] Profile settings

**Nutritionist Features:**
- [ ] Dashboard stats show real counts
- [ ] Diet plan CRUD operations
- [ ] View assigned users
- [ ] Chat with users
- [ ] Profile settings

**Admin Features:**
- [ ] User management
- [ ] Nutritionist management
- [ ] Food/Category management
- [ ] Reports generation
- [ ] System settings

---

## Known Limitations

1. Admin/Nutritionist dashboards still have some hardcoded user lists in the HTML (users are fetched but display template uses static HTML)
2. Charts use placeholder data for visual representation
3. Password reset functionality not fully implemented

---

## Recommendations

1. Consider implementing AJAX-based data refresh for dashboards
2. Add input validation on client-side for all forms
3. Implement proper error logging for production
4. Add CSRF protection to forms
5. Consider password hashing migration if plain text passwords exist

---

**Report Generated:** January 2026
**Project Path:** `C:\xampp\htdocs\Health DIet\`
