<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($settings['site_name']) ? htmlspecialchars($settings['site_name']) : 'London Aesthetics UK'; ?> - <?php echo isset($settings['site_tagline']) ? htmlspecialchars($settings['site_tagline']) : 'Affiliate Program'; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
            background: #fff;
            color: #1b1f23;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Top Bar */
        .top-bar {
            background: linear-gradient(to bottom, #F4EFEF 0%, rgb(119, 61, 93) 20%, rgb(119, 61, 93) 80%, #F4EFEF 100%);
            color: #fff;
            padding: 15px 40px;
            text-align: center;
            font-size: 16px;
        }

        .top-bar-text {
            font-style: italic;
            font-weight: 500;
        }

        /* Header */
        .main-header {
            background: #fff;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo-section {
            display: flex;
            align-items: center;
        }

        .logo-img {
            height: 50px;
            width: auto;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
            padding: 5px;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: rgb(119, 61, 93);
            transition: all 0.3s;
            border-radius: 2px;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        .nav-menu {
            display: flex;
            gap: 25px;
            list-style: none;
        }

        .nav-menu li a {
            color: rgb(119, 61, 93);
            font-weight: 600;
            padding: 8px 0;
            transition: color 0.3s;
            position: relative;
        }

        .nav-menu li a:hover {
            color: #d4af37;
        }

        .nav-menu li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #d4af37;
            transition: width 0.3s;
        }

        .nav-menu li a:hover::after {
            width: 100%;
        }

        .header-btn {
            background: rgb(212, 175, 55);
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .header-btn:hover {
            background: #d4af37;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 600px;
            background-image: url('<?php echo isset($settings['hero_image']) && !empty($settings['hero_image']) ? htmlspecialchars($settings['hero_image']) : 'https://londonaesthetics.com.pk/wp-content/uploads/2025/07/joint-1.png'; ?>');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            padding: 0 40px;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(119, 61, 93, 0.7) 0%, rgba(119, 61, 93, 0.5) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            color: #fff;
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-content p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #f0f0f0;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
        }

        .btn-primary {
            background: #d4af37;
            color: #fff;
            padding: 14px 30px;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #b8941f;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: #fff;
            padding: 14px 30px;
            border: 2px solid #d4af37;
            border-radius: 6px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: #d4af37;
        }

        /* Consultation Cards */
        .consultation-section {
            max-width: 1200px;
            margin: -80px auto 80px;
            padding: 0 40px;
            position: relative;
            z-index: 10;
        }

        .consultation-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .consultation-card {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .consultation-card h3 {
            font-size: 28px;
            color: rgb(119, 61, 93);
            margin-bottom: 20px;
            font-weight: 700;
        }

        .consultation-card p {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.8;
        }

        .service-list {
            list-style: none;
            margin-bottom: 25px;
        }

        .service-list li {
            padding: 12px 0;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #333;
        }

        .service-list li::before {
            content: '✓';
            color: #d4af37;
            font-weight: 900;
            font-size: 20px;
        }

        .view-all-link {
            color: #d4af37;
            font-weight: 600;
            transition: color 0.3s;
        }

        .view-all-link:hover {
            color: #b8941f;
        }

        .consultation-card.dark {
            background: rgb(119, 61, 93);
            color: #fff;
        }

        .consultation-card.dark h3 {
            color: #fff;
        }

        .consultation-card.dark p {
            color: #e0e0e0;
        }

        .phone-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

        .phone-icon {
            width: 50px;
            height: 50px;
            background: #d4af37;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .phone-number {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
        }

        /* About Us Section */
        .about-section {
            padding: 80px 40px;
            background: #f8f7fa;
        }

        .about-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-text {
            position: relative;
        }

        .section-label {
            color: #d4af37;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .about-text h2 {
            font-size: 42px;
            color: rgb(119, 61, 93);
            margin-bottom: 25px;
            font-weight: 800;
            line-height: 1.2;
        }

        .about-text p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .feature-item {
            display: flex;
            gap: 15px;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: #d4af37;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .feature-content h4 {
            color: rgb(119, 61, 93);
            font-size: 18px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .feature-content p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .about-images {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .about-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Statistics Section */
        .stats-section {
            background: #fdf0e6;
            padding: 80px 40px;
        }

        .stats-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 56px;
            font-weight: 800;
            color: rgb(119, 61, 93);
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 18px;
            color: #666;
            font-weight: 600;
        }

        /* Services Section */
        .services-section {
            padding: 80px 40px;
            background: #fff;
        }

        .services-header {
            max-width: 1200px;
            margin: 0 auto 50px;
            text-align: center;
        }

        .services-header .section-label {
            display: inline-block;
        }

        .services-header h2 {
            font-size: 42px;
            color: rgb(119, 61, 93);
            margin: 15px 0 20px;
            font-weight: 800;
        }

        .services-header p {
            color: #666;
            font-size: 16px;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .services-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .service-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .service-card-image {
            width: 100%;
            height: 250px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
        }

        .service-card-content {
            padding: 30px;
        }

        .service-card h3 {
            font-size: 24px;
            color: rgb(119, 61, 93);
            margin-bottom: 15px;
            font-weight: 700;
        }

        .service-card p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .read-more {
            color: #d4af37;
            font-weight: 600;
            transition: color 0.3s;
        }

        .read-more:hover {
            color: #b8941f;
        }

        /* Procedure Steps */
        .procedure-section {
            padding: 80px 40px;
            background: #f8f7fa;
        }

        .procedure-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .procedure-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .procedure-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .procedure-steps {
            list-style: none;
        }

        .procedure-steps li {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            align-items: flex-start;
        }

        .step-icon {
            width: 60px;
            height: 60px;
            background: #d4af37;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .step-content h4 {
            font-size: 22px;
            color: rgb(119, 61, 93);
            margin-bottom: 8px;
            font-weight: 700;
        }

        .step-content p {
            color: #666;
            line-height: 1.6;
        }

        /* Testimonials */
        .testimonial-section {
            padding: 80px 40px;
            background: #fff;
        }

        .testimonial-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .testimonial-card {
            background: rgb(119, 61, 93);
            padding: 50px;
            border-radius: 12px;
            color: #fff;
        }

        .testimonial-stars {
            color: #d4af37;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .testimonial-quote {
            font-size: 24px;
            line-height: 1.6;
            margin-bottom: 30px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #d4af37;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .author-info h5 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .author-info p {
            font-size: 14px;
            color: #ccc;
            margin: 0;
        }

        /* Main Content Sections */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .section-title {
            text-align: center;
            font-size: 42px;
            font-weight: 800;
            color: rgb(119, 61, 93);
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: #d4af37;
            margin: 20px auto;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: #fff;
            padding: 35px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 20px;
            display: block;
        }

        .card-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .card h3 {
            font-size: 22px;
            font-weight: 700;
            color: rgb(119, 61, 93);
            margin-bottom: 15px;
        }

        .card p {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
        }

        .btn-signup {
            background: rgb(119, 61, 93);
            color: #fff;
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s;
            display: block;
            margin: 30px auto;
        }

        .btn-signup:hover {
            background: #d4af37;
            transform: translateY(-2px);
        }

        /* Footer */
        footer {
            background: #1a0f2a;
            color: #fff;
            padding: 60px 40px 30px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h4 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #d4af37;
            font-weight: 700;
        }

        .footer-column p,
        .footer-column ul {
            font-size: 14px;
            line-height: 1.8;
            color: #ccc;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            color: #ccc;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: #d4af37;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgb(119, 61, 93);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background: #d4af37;
            transform: scale(1.1);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #aaa;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .consultation-cards,
            .about-content,
            .procedure-content,
            .testimonial-content {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-content h1 {
                font-size: 38px;
            }
        }

        @media (max-width: 768px) {
            .top-bar {
                padding: 12px 20px;
                font-size: 14px;
            }

            .main-header {
                flex-wrap: wrap;
                padding: 15px 20px;
                justify-content: space-between;
            }

            .logo-section {
                order: 1;
            }

            .hamburger {
                display: flex;
                order: 2;
            }

            nav {
                order: 3;
                width: 100%;
                display: none;
                flex-direction: column;
                gap: 15px;
                margin-top: 15px;
            }

            nav.active {
                display: flex;
            }

            .nav-menu {
                flex-direction: column;
                gap: 0;
                width: 100%;
                text-align: left;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                overflow: hidden;
            }

            .nav-menu li {
                width: 100%;
                border-bottom: 1px solid #f0f0f0;
            }

            .nav-menu li:last-child {
                border-bottom: none;
            }

            .nav-menu li a {
                display: block;
                padding: 15px 20px;
                color: rgb(119, 61, 93);
            }

            .nav-menu li a:hover {
                background: #f8f7fa;
            }

            .header-btn {
                width: 100%;
                text-align: center;
                margin-top: 10px;
            }

            .logo-img {
                height: 40px;
            }

            .hero-section {
                height: 400px;
                padding: 0 15px;
            }

            .hero-content {
                max-width: 100%;
            }

            .hero-content h1 {
                font-size: 28px;
                margin-bottom: 15px;
            }

            .hero-content p {
                font-size: 14px;
                margin-bottom: 20px;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                padding: 12px 20px;
                font-size: 14px;
            }

            .consultation-section {
                margin-top: -30px;
                padding: 0 15px;
            }

            .consultation-cards {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .consultation-card {
                padding: 25px 20px;
            }

            .consultation-card h3 {
                font-size: 24px;
            }

            .about-section {
                padding: 50px 20px;
            }

            .about-content {
                gap: 30px;
            }

            .about-text h2 {
                font-size: 32px;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats-section {
                padding: 50px 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
            }

            .stat-number {
                font-size: 42px;
            }

            .stat-label {
                font-size: 14px;
            }

            .services-section {
                padding: 50px 20px;
            }

            .services-header h2 {
                font-size: 32px;
            }

            .services-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .service-card-content {
                padding: 20px;
            }

            .container {
                padding: 40px 15px;
            }

            .section-title {
                font-size: 28px;
            }

            .cards-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .card {
                padding: 25px 20px;
            }

            .procedure-section {
                padding: 50px 20px;
            }

            .procedure-content {
                gap: 30px;
            }

            .procedure-content h2 {
                font-size: 28px;
            }

            .procedure-steps li {
                margin-bottom: 25px;
            }

            .step-icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .step-content h4 {
                font-size: 18px;
            }

            .testimonial-section {
                padding: 50px 20px;
            }

            .testimonial-content {
                gap: 30px;
            }

            .testimonial-card {
                padding: 30px 20px;
            }

            .testimonial-quote {
                font-size: 18px;
            }

            footer {
                padding: 40px 20px 20px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .section-label {
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                height: 350px;
            }

            .hero-content h1 {
                font-size: 24px;
            }

            .hero-content p {
                font-size: 13px;
            }

            .consultation-section {
                margin-top: -20px;
            }

            .about-text h2 {
                font-size: 26px;
            }

            .services-header h2 {
                font-size: 26px;
            }

            .section-title {
                font-size: 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-number {
                font-size: 36px;
            }

        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-text"><?php echo isset($settings['site_tagline']) ? htmlspecialchars($settings['site_tagline']) : 'Let Your Skin Shine Brighter with London Aesthetics UK'; ?></div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="logo-section">
            <img src="https://affiliates.londonaesthetics.com.pk/wp-content/uploads/2025/06/Logo-scaled-1.png" alt="London Aesthetics Logo" class="logo-img">
        </div>
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav id="nav-menu">
            <ul class="nav-menu">
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Affiliate Program</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <a href="<?php echo base_url('auth/login'); ?>" class="header-btn">Affiliate Login →</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1><?php echo isset($settings['hero_title']) ? htmlspecialchars($settings['hero_title']) : 'We Provide Best Affiliate Program For You'; ?></h1>
            <p><?php echo isset($settings['hero_subtitle']) ? htmlspecialchars($settings['hero_subtitle']) : 'Join London Aesthetics UK Affiliate Program and start earning commissions by promoting our premium skincare and aesthetics services. Build your network and grow your income.'; ?></p>
            <div class="hero-buttons">
                <a href="<?php echo base_url('auth/signup'); ?>" class="btn-primary" style="text-decoration: none; display: inline-block;">Sign Up</a>
                <button class="btn-secondary">Watch Video</button>
            </div>
        </div>
    </section>

    <!-- Consultation Cards -->
    <div class="consultation-section">
        <div class="consultation-cards">
            <div class="consultation-card">
                <h3>How Can I Help You?</h3>
                <p>Discover our comprehensive affiliate program designed to help you earn while promoting quality aesthetic services.</p>
                <ul class="service-list">
                    <li>Training Academy Referrals</li>
                    <li>Patient Care Services</li>
                    <li>Skincare Products</li>
                    <li>Aesthetic Treatments</li>
                    <li>Franchise Opportunities</li>
                </ul>
                <a href="#" class="view-all-link">View All Services →</a>
            </div>
            <div class="consultation-card dark">
                <h3>Consultation With Our Team</h3>
                <p>Get in touch with our affiliate support team to learn more about our program and how you can maximize your earnings.</p>
                <div class="phone-info">
                    <div class="phone-icon">📞</div>
                    <div class="phone-number"><?php echo isset($settings['contact_phone']) ? htmlspecialchars($settings['contact_phone']) : '(+44) 20 1234 5678'; ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Us Section -->
    <section class="about-section">
        <div class="about-content">
            <div class="about-text">
                <div class="section-label">About Us</div>
                <h2><?php echo isset($settings['about_title']) ? htmlspecialchars($settings['about_title']) : 'We Provide The Best Affiliate Program Since 2020'; ?></h2>
                <p><?php echo isset($settings['about_description']) ? htmlspecialchars($settings['about_description']) : 'London Aesthetics UK offers a comprehensive affiliate program that allows you to earn commissions by promoting our premium services. Join thousands of successful affiliates who are building their income streams with us.'; ?></p>
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">🏥</div>
                        <div class="feature-content">
                            <h4>Modern Technology</h4>
                            <p>Access to advanced tracking and reporting tools</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">💰</div>
                        <div class="feature-content">
                            <h4>Affordable Pricing</h4>
                            <p>Competitive commission rates up to 22%</p>
                        </div>
                    </div>
                </div>
                <a href="<?php echo base_url('auth/signup'); ?>" class="btn-primary" style="text-decoration: none; display: inline-block;">Sign Up</a>
            </div>
            <div class="about-images">
                <div class="about-image">
                    <img src="https://londonaesthetics.com.pk/wp-content/uploads/2025/07/joint.png" alt="Aesthetic Services">
                </div>
                <div class="about-image">
                    <img src="https://londonaesthetics.com.pk/wp-content/uploads/2025/07/hair-remover.png" alt="Training Academy">
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number"><?php echo isset($settings['stat_affiliates']) ? htmlspecialchars($settings['stat_affiliates']) : '1000+'; ?></div>
                <div class="stat-label">Happy Affiliates</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo isset($settings['stat_referrals']) ? htmlspecialchars($settings['stat_referrals']) : '5000+'; ?></div>
                <div class="stat-label">Online Referrals</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo isset($settings['stat_experience']) ? htmlspecialchars($settings['stat_experience']) : '5+'; ?></div>
                <div class="stat-label">Years of Experience</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo isset($settings['stat_team']) ? htmlspecialchars($settings['stat_team']) : '50+'; ?></div>
                <div class="stat-label">Team Members</div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="services-header">
            <div class="section-label">Our Services</div>
            <h2>What Service We Offer</h2>
            <p>Explore our comprehensive range of services that you can promote as an affiliate partner.</p>
            <button class="btn-primary">View All Services</button>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-card-image">💉</div>
                <div class="service-card-content">
                    <h3>Training Academy</h3>
                    <p>Professional training programs for aesthetic practitioners and skincare specialists.</p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </div>
            <div class="service-card">
                <div class="service-card-image">✨</div>
                <div class="service-card-content">
                    <h3>Patient Care Services</h3>
                    <p>Premium aesthetic treatments and personalized skincare solutions.</p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </div>
            <div class="service-card">
                <div class="service-card-image">🏥</div>
                <div class="service-card-content">
                    <h3>Franchise Opportunities</h3>
                    <p>Join our network as a franchisee and build your own aesthetic clinic.</p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </div>
            <div class="service-card">
                <div class="service-card-image">💆</div>
                <div class="service-card-content">
                    <h3>Skincare Products</h3>
                    <p>High-quality skincare products and treatment solutions.</p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </div>
            <div class="service-card">
                <div class="service-card-image">🌟</div>
                <div class="service-card-content">
                    <h3>Aesthetic Treatments</h3>
                    <p>Advanced aesthetic procedures and beauty treatments.</p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </div>
            <div class="service-card">
                <div class="service-card-image">📚</div>
                <div class="service-card-content">
                    <h3>Educational Resources</h3>
                    <p>Comprehensive guides and resources for affiliates.</p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Easy To Start Section -->
    <div class="container">
        <h2 class="section-title">Easy To Start</h2>
        <div class="cards-grid">
            <div class="card">
                <div class="card-icon">
                    <img src="https://s.w.org/images/core/emoji/16.0.1/svg/1f4dd.svg" alt="Sign Up">
                </div>
                <h3>Sign Up For Free</h3>
                <p>Register instantly and get your personal affiliate dashboard.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <img src="https://s.w.org/images/core/emoji/16.0.1/svg/1f517.svg" alt="Share Link">
                </div>
                <h3>Share Your Unique Link</h3>
                <p>Promote London Aesthetics UK via social media, messages, and personal network.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <img src="https://s.w.org/images/core/emoji/16.0.1/svg/1f4b0.svg" alt="Earn">
                </div>
                <h3>Earn Commissions & Rewards</h3>
                <p>Earn up to 22% direct commissions, plus bonuses from your growing affiliate team!</p>
            </div>
        </div>
        <a href="<?php echo base_url('auth/signup'); ?>" class="btn-signup" style="text-decoration: none; display: inline-block;">Sign Up Now</a>
    </div>

    <!-- Procedure Steps -->
    <section class="procedure-section">
        <div class="procedure-content">
            <div class="procedure-image">
                <img src="https://londonaesthetics.com.pk/wp-content/uploads/2025/07/dental.png" alt="Join Our Affiliate Program">
            </div>
            <div>
                <div class="section-label">Our Approach</div>
                <h2 style="font-size: 42px; color: rgb(119, 61, 93); margin-bottom: 30px; font-weight: 800;">The Procedure for Joining Our Affiliate Program</h2>
                <p style="color: #666; margin-bottom: 40px; line-height: 1.8;">Follow these simple steps to start earning with our affiliate program.</p>
                <ul class="procedure-steps">
                    <li>
                        <div class="step-icon">1</div>
                        <div class="step-content">
                            <h4>Sign Up</h4>
                            <p>Create your free affiliate account in minutes</p>
                        </div>
                    </li>
                    <li>
                        <div class="step-icon">2</div>
                        <div class="step-content">
                            <h4>Get Your Link</h4>
                            <p>Receive your unique tracking link and promotional materials</p>
                        </div>
                    </li>
                    <li>
                        <div class="step-icon">3</div>
                        <div class="step-content">
                            <h4>Start Promoting</h4>
                            <p>Share your link and start earning commissions</p>
                        </div>
                    </li>
                    <li>
                        <div class="step-icon">4</div>
                        <div class="step-content">
                            <h4>Get Paid</h4>
                            <p>Receive your earnings through our secure payment system</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonial-section">
        <div class="testimonial-content">
            <div>
                <img src="https://londonaesthetics.com.pk/wp-content/uploads/2025/07/dental-1-300x300.png" alt="Success Story" style="width: 100%; height: auto; border-radius: 12px; display: block;">
            </div>
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <div class="testimonial-quote">"Joining London Aesthetics UK's affiliate program has been a game-changer for me. The support is excellent and the commissions are generous. Highly recommended!"</div>
                <div class="testimonial-author">
                    <div class="author-avatar">SR</div>
                    <div class="author-info">
                        <h5>Sarah Rimer</h5>
                        <p>Affiliate Partner</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h4 style="color: #d4af37; font-size: 24px; margin-bottom: 15px;"><?php echo isset($settings['site_name']) ? strtoupper(htmlspecialchars($settings['site_name'])) : 'LONDON Aesthetics UK'; ?></h4>
                <p><?php echo isset($settings['footer_text']) ? htmlspecialchars($settings['footer_text']) : 'Your trusted partner in skincare and aesthetics excellence. Join our affiliate program and start earning today.'; ?></p>
                <div class="social-icons" style="margin-top: 20px;">
                    <?php if (isset($settings['social_facebook']) && !empty($settings['social_facebook']) && $settings['social_facebook'] != '#'): ?>
                    <a href="<?php echo htmlspecialchars($settings['social_facebook']); ?>" target="_blank" class="social-icon">f</a>
                    <?php endif; ?>
                    <?php if (isset($settings['social_twitter']) && !empty($settings['social_twitter']) && $settings['social_twitter'] != '#'): ?>
                    <a href="<?php echo htmlspecialchars($settings['social_twitter']); ?>" target="_blank" class="social-icon">t</a>
                    <?php endif; ?>
                    <?php if (isset($settings['social_instagram']) && !empty($settings['social_instagram']) && $settings['social_instagram'] != '#'): ?>
                    <a href="<?php echo htmlspecialchars($settings['social_instagram']); ?>" target="_blank" class="social-icon">📷</a>
                    <?php endif; ?>
                    <?php if (isset($settings['social_linkedin']) && !empty($settings['social_linkedin']) && $settings['social_linkedin'] != '#'): ?>
                    <a href="<?php echo htmlspecialchars($settings['social_linkedin']); ?>" target="_blank" class="social-icon">in</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Affiliate Program</a></li>
                    <li><a href="#">Appointment</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms and Conditions</a></li>
                    <li><a href="#">Disclaimer</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Make Appointment</h4>
                <p><?php echo isset($settings['working_hours']) ? htmlspecialchars($settings['working_hours']) : '9 AM - 10 PM, Monday - Saturday'; ?></p>
                <button class="btn-primary" style="margin-top: 20px; width: 100%;">Call Us Today</button>
            </div>
        </div>
        <div class="footer-bottom">
            <p><?php 
                $copyright = isset($settings['footer_copyright']) ? $settings['footer_copyright'] : 'Copyright © 2024. All right reserved.';
                $copyright = str_replace('{year}', date('Y'), $copyright);
                echo htmlspecialchars($copyright);
            ?></p>
        </div>
    </footer>

    <script>
        // Set current year
        const yearElement = document.querySelector('.footer-bottom p');
        if (yearElement) {
            yearElement.innerHTML = `Copyright © ${new Date().getFullYear()}. All right reserved.`;
        }

        // Hamburger Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('nav-menu');

        if (hamburger && navMenu) {
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navMenu.classList.toggle('active');
            });

            // Close menu when clicking on a link
            const navLinks = document.querySelectorAll('.nav-menu li a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    navMenu.classList.remove('active');
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInsideNav = navMenu.contains(event.target);
                const isClickOnHamburger = hamburger.contains(event.target);
                
                if (!isClickInsideNav && !isClickOnHamburger && navMenu.classList.contains('active')) {
                    hamburger.classList.remove('active');
                    navMenu.classList.remove('active');
                }
            });
        }
    </script>
</body>
</html>
