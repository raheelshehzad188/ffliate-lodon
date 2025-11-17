-- Add Discount Column to Leads Table
-- Run this SQL to add discount_percent field to track discount for each lead

ALTER TABLE `leads` 
ADD COLUMN `discount_percent` decimal(5,2) DEFAULT NULL COMMENT 'Discount percentage applied for this lead';

