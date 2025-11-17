-- Add Discount Settings to Existing Database
-- Run this SQL in phpMyAdmin or MySQL command line if you already have the settings table

INSERT INTO `settings` (`setting_key`, `setting_value`, `category`, `description`, `created_at`, `updated_at`) VALUES
('discount_min', '0', 'commission', 'Minimum Discount Percentage', NOW(), NOW()),
('discount_max', '50', 'commission', 'Maximum Discount Percentage', NOW(), NOW())
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`), `updated_at` = NOW();

