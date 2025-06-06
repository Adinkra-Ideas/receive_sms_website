<?php
// 1. Include required model files
require_once dirname(__FILE__, 1) . '/models/Country.php';

// 2. Include your database connection file
require_once dirname(__FILE__, 1) . '/config/Database.php';

// 3. Obtain a database connection
$database = new Database();
$conn = $database->getConnection();

// Instantiate required models
$country = new Country($conn);

// Get builder object required to fill this template page
$builder = $country->getAll();

// json decode into php array
$builder = json_decode($builder, true);

// pluck the data payload from the builder object
$countries = $builder['data'];

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
    <title>Receive The SMS | Free Disposable Numbers</title>
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

        /* Promotional Section */
        .promo-section {
            background: linear-gradient(145deg, #f8faff, #e6f0ff);
            padding: 40px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .promo-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .promo-heading {
            color: #1a202c;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            line-height: 1.4;
        }

        .promo-heading strong {
            color: #1a56db;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .countries-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 20px 0;
        }

        .country-tag {
            background: rgba(74, 158, 255, 0.1);
            color: #1a56db;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .security-note {
            color: #718096;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e2e8f0;
            font-size: 0.9em;
        }

        .highlight-text {
            color: #48bb78;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .promo-heading {
                font-size: 1.6rem;
            }

            .feature-card {
                padding: 20px;
            }
        }

        /* Country Cards Grid */
        .countries {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
            margin: 40px 0;
        }

        .country-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .country-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        .country-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #4a9eff;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .country-card:hover::before {
            opacity: 1;
        }

        .flag-container {
            width: 80px;
            height: 50px;
            margin: 0 auto 15px;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .country-flag {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .country-name {
            color: #2d3748;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .number-count {
            color: #4a5568;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .view-numbers-btn {
            background: #f7fafc;
            color: #4a9eff;
            border: 1px solid #e2e8f0;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .country-card:hover .view-numbers-btn {
            background: #4a9eff;
            color: white;
            border-color: #4a9eff;
        }

        @media (max-width: 768px) {
            .countries {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 15px;
            }

            .country-card {
                padding: 15px;
            }
        }

        /* Numbers List */
        .numbers-list {
            margin-top: 30px;
            background: white;
            padding: 20px;
            border-radius: 5px;
        }

        .number-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .copy-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
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
            <h1>Temporary Phone Numbers</h1>
            <p>Receive SMS Anonymously • 100% Free • No Registration Required</p>
        </div>
    </header>

    <section class="promo-section">
        <div class="promo-content container">
            <h2 class="promo-heading">
                <strong>Global SMS Reception</strong> Protecting Your Privacy Worldwide
            </h2>

            <div class="countries-list">
                <div class="country-tag">
                    🇺🇸 USA
                </div>
                <div class="country-tag">
                    🇨🇦 Canada
                </div>
                <div class="country-tag">
                    🇬🇧 United Kingdom
                </div>
                <div class="country-tag">
                    🇸🇪 Sweden
                </div>
                <div class="country-tag">
                    🇫🇮 Finland
                </div>
                <div class="country-tag">
                    🇧🇪 Belgium
                </div>
                <div class="country-tag">
                    🇳🇱 Netherlands
                </div>
                <div class="country-tag">
                    ...
                </div>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <h3>🛡️ Secure Verification</h3>
                    <p>Use our disposable numbers for online services' verifications without revealing your personal information</p>
                </div>

                <div class="feature-card">
                    <h3>🌐 Global Access</h3>
                    <p>Receive SMS from anywhere using our international temporary phone numbers</p>
                </div>

                <div class="feature-card">
                    <h3>⏳ Auto-Refresh</h3>
                    <p>Numbers are changed on <span class="highlight-text">regular intervals</span> for continued privacy</p>
                </div>
            </div>

            <p class="security-note">
                🔒 All messages are automatically deleted as they get replaced by newer batches.
                <span class="highlight-text">No logs kept · No personal data stored · Complete anonymity</span>
            </p>
        </div>
    </section>

    <main class="container">
        <section class="countries">

            <?php foreach ($countries as $country): ?>

                <div class="country-card">
                    <div class="flag-container">
                        <img src="images/<?= $country['alias'] ?>.png" alt="<?= $country['alias'] ?> Flag" class="country-flag">
                    </div>
                    <h3 class="country-name"><?= $country['name'] ?></h3>
                    <p class="number-count">📱 <?= $country['active_number_count'] > 0 ? $country['active_number_count'] . '+ Active Numbers' : '' ?> </p>
                    <a href="/views/countries/<?= $country['alias'] ?>" class="view-numbers-btn">View Numbers</a>
                </div>

            <?php endforeach; ?>

            <!--  <div class="country-card">
                <div class="flag-container">
                    <img src="images/it.png" alt="Netherlands Flag" class="country-flag">
                </div>
                <h3 class="country-name">Italy</h3>
                <p class="number-count">📱 5+ Active Numbers</p>
                <a href="#netherlands-numbers" class="view-numbers-btn">View Numbers</a>
            </div> -->

        </section>


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
