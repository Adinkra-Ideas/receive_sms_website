<?php

// If illegal access, output nothing
if (! isset($_GET['slug'])
    || (isset($_GET['slug']) && isset($_GET['slug']) === '')
) {
    die;
}

// Include required Dependencies
require_once dirname(__FILE__, 2) . '/Functions.php';

// 1. Include required model files
require_once dirname(__FILE__, 2) . '/models/Message.php';

// 2. Include your database connection file
require_once dirname(__FILE__, 2) . '/config/Database.php';

// 3. Obtain a database connection
$database = new Database();
$conn = $database->getConnection();

// Instantiate required models
$message = new Message($conn);

// Get builder object required to fill this template page
$builder = $message->getAllMessageBySender($_GET['slug']);

// json decode into php array
$builder = json_decode($builder, true);

// pluck the data payload from the builder object
$phone = $builder['data'];


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
    <title>+<?= $phone['number'] ?> SMS Messages <?= $phone['country'] ?> Virtual Number - ReceiveTheSMS</title>
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



        /* SMS Display Page Specific Styles */
        .number-header {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin: 2rem auto;
            padding: 1rem;
            width: 90%;
            max-width: 500px; /* Increased width for better horizontal layout */
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .number-header-top {
            display: flex;
            flex-direction: row; /* Changed to row layout */
            align-items: center;
            justify-content: center;
            gap: 1rem;
            width: 100%;
            text-align: left;
            padding-bottom: 0.5rem;
        }
        .flag-container-header {
            width: 50px;
            height: 35px;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            flex-shrink: 0; /* Prevent flag from shrinking */
        }
        .phone-number-header {
            font-size: 1.3rem; /* Slightly reduced font size */
            color: #1a202c;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .number-status-header {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(72, 187, 120, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .status-dot-active {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #48bb78;
            box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.2);
            animation: pulse 1.5s infinite;
        }
        .status-active-text {
            color: #48bb78;
        }
        .status-dot-inactive {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #f56565;
            box-shadow: 0 0 0 3px rgba(245, 101, 101, 0.2);
            animation: pulse 1.5s infinite;
        }
        .status-inactive-text {
            color: #f56565;
        }

        .header-actions {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 1.5rem;
            margin-top: 0;
            gap: 1rem;
        }

        .refresh-section {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .refresh-btn {
            background: rgba(72, 187, 120, 0.1);
            color: #137333;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            width: 100%;
            justify-content: center;
        }

        .refresh-btn:hover {
            background: #48bb78;
            color: white;
            transform: translateY(-1px);
        }

        .copy-number-btn {
            background: #4a9eff;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            width: 100%;
            justify-content: center;
        }
        .copy-number-btn:disabled {
            background: #e2e8f0;
            color: #a0aec0;
            cursor: not-allowed;
        }
        .copy-number-btn:hover {
            background: rgba(74, 158, 255, 0.1);
            color: #1a56db;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .number-header {
                padding: 0.75rem;
                max-width: 90%;
            }
            .number-header-top {
                flex-direction: column; /* Stack vertically on mobile */
                text-align: center;
                gap: 0.5rem;
            }

            .phone-number-header {
                justify-content: center; /* Center content on mobile */
                font-size: 1.2rem;
                flex-direction: column;
                gap: 0.2rem;
                margin-bottom: 0.5rem;
            }


            .number-meta {
                justify-content: center; /* Centers elements in flex container */
                text-align: center;
                width: 100%;
            }
        }




        /* Updated SMS List Styles */
        .sms-list {
            display: grid;
            gap: 1rem;
            margin: 2rem 0;
        }

        .sms-card {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            display: grid;
            grid-template-columns: 120px 1fr 130px;
            align-items: start;
            gap: 1rem;
            transition: all 0.2s ease;
        }

        .sms-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .sms-sender {
            color: #1a202c;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            padding-right: 1rem;
            border-right: 1px solid #e2e8f0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sms-content {
            color: #4a5568;
            line-height: 1.5;
            font-size: 0.95rem;
            padding-right: 1rem;
        }

        .sms-time {
            color: #718096;
            font-size: 0.85rem;
            text-align: right;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .sms-card {
                grid-template-columns: 1fr;
                gap: 0.5rem;
                padding: 1rem;
            }

            .sms-sender {
                border-right: none;
                padding-right: 0;
                border-bottom: 1px solid #e2e8f0;
                padding-bottom: 0.5rem;
            }

            .sms-time {
                justify-content: flex-start;
                text-align: left;
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
    <!-- Same Header as Homepage -->
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
                <img src="/images/<?= $phone['country_alias'] ?>.png" alt="<?= $phone['country_alias'] ?> Flag" class="header-flag">
                +<?= $phone['number'] ?>
            </h1>
            <p>Active Temporary Number - Refresh Messages Button Refreshes New Messages</p>
        </div>
    </header>

    <main class="container">
        <div class="number-header">
            <div class="number-header-top">
                <div class="flag-container-header">
                    <img src="/images/<?= $phone['country_alias'] ?>.png" alt="<?= $phone['country_alias'] ?> Flag" class="header-flag">
                </div>
                <div>
                    <div class="phone-number-header">
                        <span class="phone-number">+<?= $phone['number'] ?></span>
                        <span class="number-status-header">
                            <span class="status-dot-<?= $phone['service_status'] ? 'active' : 'inactive' ?>"></span>
                            <span class="status-<?= $phone['service_status'] ? 'active' : 'inactive' ?>-text"> <?= $phone['service_status'] ? 'active' : 'inactive' ?> </span>
                        </span>
                    </div>
                    <div class="number-meta">
                        <span class="country-name"> <?= $phone['country'] ?> </span>
                    </div>
                </div>
            </div>

            <div class="header-actions">
                <div class="refresh-section">
                    <button class="refresh-btn" onclick="refreshMessages()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh Messages
                    </button>
                </div>
                <button class="copy-number-btn" onclick="copyNumber()">
                    <i class="far fa-copy"></i>
                    Copy Number
                </button>
            </div>
        </div>


        <div class="sms-list">

            <?php foreach ($phone['messages'] as $message): ?>

                <div class="sms-card">
                    <div class="sms-sender">
                        <i class="fas fa-sms" style="color:#4a9eff"></i>
                        <?= $message['sender'] ?>
                    </div>
                    <div class="sms-content">
                        <?= $message['sms'] ?>
                    </div>
                    <div class="sms-time">
                        <i class="far fa-clock"></i>
                        <?= time_ago($message['send_time']) ?>
                    </div>
                </div>

            <?php endforeach; ?>

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
        function refreshMessages() {
            const btn = document.querySelector('.refresh-btn');
            btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Refreshing...`;

            setTimeout(() => {
                btn.innerHTML = `<i class="fas fa-sync-alt"></i> Refresh Messages`;
            }, 2000);

            window.location.reload(true);
        }

        function copyNumber() {
            const btn = document.querySelector('.copy-number-btn');

            if(! btn.disabled) {
                const number = document.querySelector('.phone-number').textContent;
                navigator.clipboard.writeText(number.trim());
            }

            const originalText = btn.innerHTML;

            btn.innerHTML = `<i class="fas fa-check"></i> Copied!`;
            btn.style.background = '#48bb78';

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.background = '#4a9eff';
            }, 2000);
        }
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
