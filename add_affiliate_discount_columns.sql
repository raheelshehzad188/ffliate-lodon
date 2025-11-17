-- Add Discount Limit Columns to Affiliates Table
-- Run this SQL to add per-affiliate discount limit fields

ALTER TABLE `affiliates` 
ADD COLUMN `discount_min` decimal(5,2) DEFAULT NULL COMMENT 'Minimum discount % for this affiliate (NULL = use global setting)',
ADD COLUMN `discount_max` decimal(5,2) DEFAULT NULL COMMENT 'Maximum discount % for this affiliate (NULL = use global setting)';

