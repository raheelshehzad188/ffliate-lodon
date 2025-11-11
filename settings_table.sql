-- Settings Table Creation SQL
-- Run this SQL in phpMyAdmin or MySQL command line

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `category` varchar(100) DEFAULT 'general',
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert Default Settings

INSERT INTO `settings` (`setting_key`, `setting_value`, `category`, `description`, `created_at`, `updated_at`) VALUES
-- General Settings
('site_name', 'London Aesthetics UK', 'general', 'Site Name', NOW(), NOW()),
('site_tagline', 'Affiliate Program', 'general', 'Site Tagline', NOW(), NOW()),
('site_email', 'info@londonaesthetics.com', 'general', 'Site Email', NOW(), NOW()),
('site_phone', '(+44) 20 1234 5678', 'general', 'Site Phone', NOW(), NOW()),

-- Homepage Settings
('hero_title', 'We Provide Best Affiliate Program For You', 'homepage', 'Hero Section Title', NOW(), NOW()),
('hero_subtitle', 'Join London Aesthetics UK Affiliate Program and start earning commissions by promoting our premium skincare and aesthetics services. Build your network and grow your income.', 'homepage', 'Hero Section Subtitle', NOW(), NOW()),
('hero_image', 'https://londonaesthetics.com.pk/wp-content/uploads/2025/07/joint-1.png', 'homepage', 'Hero Background Image', NOW(), NOW()),

-- About Section
('about_title', 'We Provide The Best Affiliate Program Since 2020', 'homepage', 'About Section Title', NOW(), NOW()),
('about_description', 'London Aesthetics UK offers a comprehensive affiliate program that allows you to earn commissions by promoting our premium services. Join thousands of successful affiliates who are building their income streams with us.', 'homepage', 'About Section Description', NOW(), NOW()),

-- Statistics
('stat_affiliates', '1000+', 'homepage', 'Happy Affiliates Count', NOW(), NOW()),
('stat_referrals', '5000+', 'homepage', 'Online Referrals Count', NOW(), NOW()),
('stat_experience', '5+', 'homepage', 'Years of Experience', NOW(), NOW()),
('stat_team', '50+', 'homepage', 'Team Members Count', NOW(), NOW()),

-- Contact Settings
('contact_phone', '(+44) 20 1234 5678', 'contact', 'Contact Phone', NOW(), NOW()),
('contact_email', 'info@londonaesthetics.com', 'contact', 'Contact Email', NOW(), NOW()),
('contact_address', 'London, UK', 'contact', 'Contact Address', NOW(), NOW()),
('working_hours', '9 AM - 10 PM, Monday - Saturday', 'contact', 'Working Hours', NOW(), NOW()),

-- Social Media
('social_facebook', '#', 'social', 'Facebook URL', NOW(), NOW()),
('social_twitter', '#', 'social', 'Twitter URL', NOW(), NOW()),
('social_instagram', '#', 'social', 'Instagram URL', NOW(), NOW()),
('social_linkedin', '#', 'social', 'LinkedIn URL', NOW(), NOW()),

-- Footer Settings
('footer_text', 'Your trusted partner in skincare and aesthetics excellence. Join our affiliate program and start earning today.', 'footer', 'Footer Description', NOW(), NOW()),
('footer_copyright', 'Copyright © 2024. All right reserved.', 'footer', 'Footer Copyright Text', NOW(), NOW()),

-- Commission Settings
('commission_rate', '22', 'commission', 'Default Commission Rate (%)', NOW(), NOW()),
('min_payout', '50', 'commission', 'Minimum Payout Amount', NOW(), NOW())
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`), `updated_at` = NOW();

