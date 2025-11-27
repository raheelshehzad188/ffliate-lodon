-- Add Currency Settings to Settings Table
-- Run this SQL to add currency_symbol and currency_code settings

INSERT INTO `settings` (`setting_key`, `setting_value`, `category`, `description`, `created_at`, `updated_at`) VALUES
('currency_symbol', '$', 'commission', 'Currency Symbol (e.g., $, £, €, ₹)', NOW(), NOW()),
('currency_code', 'USD', 'commission', 'Currency Code (e.g., USD, GBP, EUR, INR)', NOW(), NOW())
ON DUPLICATE KEY UPDATE 
    `setting_value` = VALUES(`setting_value`), 
    `updated_at` = NOW();

