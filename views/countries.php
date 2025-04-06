<?php
// If illegal access, output nothing
if (! isset($_GET['slug'])
    || (isset($_GET['slug']) && isset($_GET['slug']) === '')
) {
    die;
}

// 1. Include required model files
require_once dirname(__FILE__, 2) . '/models/Country.php';

// 2. Include your database connection file
require_once dirname(__FILE__, 2) . '/config/Database.php';

// 3. Obtain a database connection
$database = new Database();
$conn = $database->getConnection();

// Instantiate required models
$countr = new Country($conn);

// Get builder object required to fill this template page
$builder = $countr->getAllCountryBySender($_GET['slug']);

// json decode into php array
$builder = json_decode($builder, true);

// pluck the data payload from the builder object
$country = $builder['data'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/images/favicon/site.webmanifest" />
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>USA Phone Numbers - Receive The SMS | Free Disposable Numbers</title>
    <style>
        /* CSS Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            overflow-x: hidden;
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        header {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('/images/header-logo.avif');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 1.5rem 0 4rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            position: relative;
            border-bottom: 3px solid #4a9eff;
            overflow: hidden;
        }
        /* Wave Animation Layer */
        header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                repeating-linear-gradient(
                    45deg,
                    rgba(255, 255, 255, 0.03) 0,
                    rgba(255, 255, 255, 0.03) 5%,
                    transparent 5%,
                    transparent 10%
                ),
                repeating-linear-gradient(
                    -45deg,
                    rgba(255, 255, 255, 0.03) 0,
                    rgba(255, 255, 255, 0.03) 5%,
                    transparent 5%,
                    transparent 10%
                );
            animation: waveAnimation 25s linear infinite;
            z-index: 0;
            pointer-events: none;
        }
        @keyframes waveAnimation {
                0% { transform: translate(0, 0) rotate(0deg); }
                50% { transform: translate(25%, 25%) rotate(3deg); }
                100% { transform: translate(0, 0) rotate(0deg); }
            }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        .logo a {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ffffff;
            text-decoration: none;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
            transition: opacity 0.3s ease;
        }
        .logo a:hover {
            opacity: 0.9;
        }
        .nav-links {
            display: flex;
            gap: 25px;
        }
        .nav-links a {
            text-decoration: none;
            color: rgba(255,255,255,0.9);
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 12px;
            border-radius: 4px;
        }
        .nav-links a:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
            color: #4a9eff;
        }
        /* Header Content */
        .header-content {
            margin-top: 60px;
            text-align: center;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            z-index: 0;
        }
        .header-content h1 {
            font-size: 2.5rem;
            margin-bottom: 1.2rem;
            line-height: 1.3;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.4);
        }
        .header-flag {
            width: 60px;
            height: 40px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .header-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            letter-spacing: 0.5px;
        }
        /* Mobile Styles */
        .menu-toggle {
            display: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 2;
        }
        @media (max-width: 852px) {
            header {
                padding: 1rem 0 2rem 0;
            }

            nav {
                padding: 0 15px;
            }

            .logo a {
                font-size: 1.5rem;
            }

            .menu-toggle {
                display: block;
            }

            .nav-links {
                position: fixed;
                top: 70px;
                right: -100%;
                flex-direction: column;
                background: rgba(0, 0, 0, 0.95);
                width: 70%;
                text-align: center;
                transition: all 0.5s ease;
                padding: 15px 0;
                border-radius: 5px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                gap: 10px;
            }

            .nav-links.active {
                right: 20px;
                width: 90%;
            }

            .nav-links a {
                padding: 12px;
                margin: 0 15px;
                background: rgba(255,255,255,0.05);
                font-size: 0.95rem;
            }

            .nav-links a:hover {
                transform: none;
                background: rgba(255,255,255,0.1);
            }

            .header-content {
                margin-top: 30px;
                padding: 0 15px;
            }

            .header-content h1 {
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }
            .header-flag {
                display: block;
                margin: auto;
                width: 60px;
            }

            .header-content p {
                font-size: 1rem;
            }
        }
        @media (max-width: 480px) {
            .nav-links {
                width: 80%;
                right: -100%;
            }

            .nav-links.active {
                right: 10px;
            }
        }


        /* Usage Intro Section */
        .usage-intro {
            background: linear-gradient(to bottom, #ffffff, #f8faff);
            padding: 4rem 0;
            position: relative;
            z-index: 0;
        }
        .intro-heading {
            text-align: center;
            font-size: 2rem;
            color: #1a202c;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        .intro-heading i {
            color: #4a9eff;
            font-size: 2.5rem;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
            color: white;
        }
        .bg-blue { background: #4a9eff; }
        .bg-green { background: #48bb78; }
        .bg-purple { background: #805ad5; }
        .feature-card h3 {
            color: #1a202c;
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
        }
        .feature-card p {
            color: #718096;
            line-height: 1.6;
        }
        .usage-description {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        .highlight {
            font-size: 1.25rem;
            color: #1a202c;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        .usage-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }
        .usage-badge {
            background: rgba(74, 158, 255, 0.1);
            color: #1a56db;
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .usage-badge:hover {
            background: rgba(74, 158, 255, 0.2);
            transform: translateY(-2px);
        }
        .usage-badge i {
            font-size: 1.1rem;
        }
        @media (max-width: 768px) {
            .intro-heading {
                flex-direction: column;
                text-align: center;
                font-size: 1.75rem;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .usage-badge {
                padding: 0.5rem 1rem;
            }
        }


        /* Phone number cards grid contents */
        .number-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .number-card {
            position: relative;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e2e8f0;
            min-width: 250px;
        }

        .number-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .number-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .country-flag {
            width: 35px;
            height: 25px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .phone-number-active {
            font-size: 1.1rem;
            color: #1a56db;
            margin: 0;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .phone-number-inactive {
            font-size: 1.1rem;
            color: #6d6d6d;
            margin: 0;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
        }
        .status-dot {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            z-index: 1;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .status-active {
            background: #48bb78;
            box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.2);
        }
        .status-inactive {
            background: #f56565;
            box-shadow: 0 0 0 3px rgba(245, 101, 101, 0.2);
        }

        .sms-link {
            color: #4a9eff;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9em;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1 0 auto;
        }

        .sms-link:hover {
            color: #1a56db;
            text-decoration: underline;
        }
        .copy-section {
            justify-content: space-between;
            gap: 15px;
        }

        .action-group {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
        }

        .copy-btn {
            background: linear-gradient(135deg, #4a9eff, #1a56db);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 0 1 auto;
            font-weight: 500;
            font-size: 0.9em;
        }

        .copy-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .copy-btn.copied {
            background: linear-gradient(135deg, #48bb78, #137333);
        }

        .copy-btn:disabled {
            background: #e2e8f0;
            color: #a0aec0;
            cursor: not-allowed;
        }

        @media (max-width: 480px) {
            .number-grid {
                grid-template-columns: 1fr;
            }

            .copy-section {
                flex-direction: column;
                gap: 12px;
            }

            .copy-btn {
                width: 100%;
                justify-content: center;
            }

            .status-badge {
                align-self: flex-start;
            }
        }



        /* How It Works Section */
        .how-it-works {
            background: #f8fafc;
            padding: 60px 0;
            margin-top: 50px;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }

        .steps-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            color: #1a202c;
            margin-bottom: 50px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .step-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-5px);
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: #4a9eff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 20px;
        }

        .step-title {
            font-size: 1.25rem;
            color: #2d3748;
            margin-bottom: 15px;
        }

        .step-description {
            color: #718096;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            .steps-grid {
                grid-template-columns: 1fr;
            }

            .step-card {
                padding: 25px;
            }
        }

        /* Footer */
        footer {
            background: #f8faff;
            color: #1a202c;
            padding: 50px 0 20px;
            margin-top: 80px;
            position: relative;
            border-top: 1px solid #e2e8f0;
            overflow: hidden;
        }

        /* Animated Wave Pattern */
        footer::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                repeating-linear-gradient(
                    45deg,
                    rgba(74, 158, 255, 0.03) 0,
                    rgba(74, 158, 255, 0.03) 5%,
                    transparent 5%,
                    transparent 10%
                ),
                repeating-linear-gradient(
                    -45deg,
                    rgba(74, 158, 255, 0.03) 0,
                    rgba(74, 158, 255, 0.03) 5%,
                    transparent 5%,
                    transparent 10%
                );
            animation: waveAnimation 20s linear infinite;
            z-index: 0;
        }

        @keyframes waveAnimation {
            0% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(25%, 25%) rotate(5deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        .footer-content {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            padding-bottom: 30px;
        }

        /* Keep other footer styles from previous version */
        .footer-brand .site-name {
            color: #1a56db;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-decoration: none;
            display: block;
            transition: color 0.3s ease;
        }

        .footer-brand .site-name:hover {
            color: #4a9eff;
        }

        .footer-contact a {
            color: #1a56db;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
            padding-bottom: 2px;
        }

        .footer-contact a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background: #4a9eff;
            transition: width 0.3s ease;
        }

        .footer-contact a:hover::after {
            width: 100%;
        }

        .footer-contact a:hover {
            color: #4a9eff;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
            position: relative;
            z-index: 1;
        }

        .footer-links {
            display: flex;
            gap: 20px;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo"><a href="/">ReceiveTheSMS</a></div>
            <i class="fas fa-bars menu-toggle"></i>
            <div class="nav-links">
                <a href="/views/countries/USA">USA</a>
                <a href="/views/countries/NL">Netherlands</a>
                <a href="/views/countries/SE">Sweden</a>
                <a href="/views/countries/PL">Poland</a>
                <a href="/views/countries/FI">Finland</a>
                <a href="/views/countries/DE">Germany</a>
            </div>
        </nav>

        <div class="header-content container">
            <h1>
                <img src="/images/<?= $country['alias'] ?>.png" alt="<?= $country['alias'] ?> Flag" class="header-flag">
                <?= $country['name'] ?> Phone Numbers
            </h1>
            <p>Free <?= $country['name'] ?> Temporary Phone Numbers for Secure SMS Verification</p>
        </div>
    </header>

    <section class="usage-intro">
        <div class="container">
            <div class="intro-content">
                <h2 class="intro-heading">
                    <i class="fas fa-mobile-alt"></i>
                    Secure Temporary Numbers for Online Verification
                </h2>
                <div class="feature-grid">
                    <div class="feature-card">
                        <div class="feature-icon bg-blue">
                            <i class="fas fa-shield-check"></i>
                        </div>
                        <h3>Protect Your Privacy</h3>
                        <p>Safely verify accounts without revealing your personal number</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon bg-green">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3>Global Accessibility</h3>
                        <p>Receive SMS from <?= $country['name'] ?> services anywhere in the world</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon bg-purple">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>Temporary & Disposable</h3>
                        <p>Numbers are changed regularly for continuous privacy</p>
                    </div>
                </div>

                <div class="usage-description">
                    <p class="highlight">
                        Our <?= $country['name'] ?> phone numbers are perfect for:
                    </p>
                    <div class="usage-badges">
                        <span class="usage-badge">
                            <i class="fab fa-facebook"></i> Social Media Verification
                        </span>
                        <span class="usage-badge">
                            <i class="fas fa-shopping-cart"></i> E-commerce Signups
                        </span>
                        <span class="usage-badge">
                            <i class="fas fa-envelope"></i> Email Account Creation
                        </span>
                        <span class="usage-badge">
                            <i class="fas fa-gamepad"></i> Gaming Platforms
                        </span>
                        <span class="usage-badge">
                            ...
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <main class="container">
        <div class="number-grid">

            <?php foreach ($country['phones'] as $phone): ?>

                <div class="number-card">
                    <span class="status-dot status-<?= $phone['service_status'] ? 'active' : 'inactive' ?>"></span>
                    <div class="number-header">
                        <img src="/images/<?= $country['alias'] ?>.png" alt="<?= $country['alias'] ?> Flag" class="country-flag">
                        <div class="number-info">
                            <?= $phone['service_status'] ? '<a href="/views/messages/'.$phone['number'].'" class="sms-link">' : '' ?>
                                <h3 class="phone-number-<?= $phone['service_status'] ? 'active' : 'inactive' ?>"> +<?= $phone['number'] ?> </h3>
                            <?= $phone['service_status'] ? '</a>' : '' ?>
                        </div>
                    </div>
                    <div class="copy-section">
                        <div class="action-group">
                            <?= $phone['service_status'] ? '<a href="/views/messages/'.$phone['number'].'" class="sms-link"> <i class="fas fa-comment-dots"></i> Receive SMS </a>' : '<span class="sms-link"></span>' ?>
                            <button class="copy-btn" <?= $phone['service_status'] ? '' : 'disabled' ?> >
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M8 4v12h12V4H8zM6 2h16v16H6V2z"/>
                                    <path d="M4 8H2v16h16v-2"/>
                                </svg>
                                <span class="innerBtnText"> Copy <span>
                            </button>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>


        <!--  How It Works Section -->
        <section class="how-it-works">
            <div class="steps-container">
                <h2 class="section-title">How to Receive SMS Online</h2>

                <div class="steps-grid">
                    <!-- Step 1 -->
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h3 class="step-title">Choose a Number</h3>
                        <p class="step-description">
                            Select your preferred country and available phone number from our list of temporary numbers.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h3 class="step-title">Use the Number</h3>
                        <p class="step-description">
                            Use the selected phone number for SMS verification or messaging. No registration required.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h3 class="step-title">Receive Messages</h3>
                        <p class="step-description">
                            Instantly view incoming SMS messages in your browser. Messages appear in real-time.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h3 class="step-title">Stay Anonymous</h3>
                        <p class="step-description">
                            Your personal information remains protected. Received SMS messages expires as they get replaced by new messages.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- footer-->
    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <a href="/" class="site-name">ReceiveTheSMS.com</a>
                <p>Online Anonymous SMS Receiving Made Simple</p>
            </div>

            <div class="footer-contact">
                <p>Need assistance? Contact us:</p>
                <a href="mailto:support@receivethesms.com">
                    📧 support@receivethesms.com
                </a>

                <div class="footer-links">
                    <a href="/privacy">
                        🔒 Privacy Policy
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            © 2025 ReceiveTheSMS.com • All Rights Reserved
        </div>
    </footer>

    <script>
        // Enhanced Copy Functionality
        document.querySelectorAll('.copy-btn').forEach(button => {
            if(!button.disabled) {
                button.addEventListener('click', () => {
                    const number = button.closest('.number-card').querySelector('h3').textContent;
                    navigator.clipboard.writeText(number.trim());

                    // Visual feedback
                    button.classList.add('copied');
                    button.querySelector('.innerBtnText').innerHTML = 'Copied!';

                    setTimeout(() => {
                        button.classList.remove('copied');
                        button.querySelector('.innerBtnText').innerHTML = 'Copy';
                    }, 2000);
                });
            }
        });
    </script>
    <script>
        // Mobile Menu Toggle
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const navLinks = document.querySelector('.nav-links');
            const menuToggle = document.querySelector('.menu-toggle');

            if (!navLinks.contains(event.target) && !menuToggle.contains(event.target)) {
                navLinks.classList.remove('active');
            }
        });
        // Close menu on resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.querySelector('.nav-links').classList.remove('active');
            }
        });
        // Close menu on scroll
        window.addEventListener('scroll', () => {
            document.querySelector('.nav-links').classList.remove('active');
        });
    </script>
</body>
</html>
