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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Privacy Policy - ReceiveTheSMS.com</title>
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


        /* Privacy Policy Specific Styles */
        .privacy-content {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin: 40px auto;
            line-height: 1.7;
        }

        .privacy-section {
            margin-bottom: 3rem;
        }

        .policy-title {
            color: #1a56db;
            font-size: 2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .policy-title i {
            font-size: 1.5rem;
            width: 40px;
            height: 40px;
            background: rgba(74, 158, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .policy-subtitle {
            color: #1a202c;
            font-size: 1.3rem;
            margin: 2rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .policy-list {
            padding-left: 1.5rem;
            margin: 1rem 0;
        }

        .policy-list li {
            margin-bottom: 0.8rem;
        }

        .highlight-term {
            color: #1a56db;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .privacy-content {
                padding: 25px;
                margin: 20px;
            }

            .policy-title {
                font-size: 1.5rem;
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
    <!-- Header (Same as Homepage) -->
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
            <h1>Privacy Policy</h1>
            <p>Your Security and Privacy is Our Top Priority</p>
        </div>
    </header>

    <!-- Main Privacy Content -->
    <main class="container">
        <div class="privacy-content">
            <div class="privacy-section">
                <h2 class="policy-title">
                    <i class="fas fa-shield-alt"></i>
                    Data Protection Commitment
                </h2>

                <h3 class="policy-subtitle">Information Collection</h3>
                <p>We collect minimal data necessary to operate our service:</p>
                <ul class="policy-list">
                    <li><span class="highlight-term">Temporary Messages:</span> SMS content received through our numbers</li>
                    <li><span class="highlight-term">Usage Data:</span> Anonymized interaction metrics</li>
                    <li><span class="highlight-term">Technical Info:</span> Browser type and device characteristics</li>
                </ul>

                <h3 class="policy-subtitle">Data Retention</h3>
                <p>Strict deletion policies ensure your privacy:</p>
                <ul class="policy-list">
                    <li>SMS messages deleted within 7 days depending on phone number's incoming message traffic</li>
                    <li>Metadata purged after 7 days</li>
                    <li>No permanent storage of user activities</li>
                </ul>
            </div>

            <div class="privacy-section">
                <h2 class="policy-title">
                    <i class="fas fa-user-lock"></i>
                    User Rights & Controls
                </h2>

                <h3 class="policy-subtitle">Your Choices</h3>
                <p>You maintain full control over your data:</p>
                <ul class="policy-list">
                    <li>Request access to collected information</li>
                    <li>Ask for deletion of specific data</li>
                    <li>Opt-out of non-essential tracking</li>
                </ul>

                <h3 class="policy-subtitle">Security Measures</h3>
                <p>We employ enterprise-grade protections:</p>
                <ul class="policy-list">
                    <li>End-to-end TLS 1.3 encryption</li>
                    <li>Regular security audits</li>
                    <li>Restricted staff access</li>
                </ul>
            </div>

            <!-- Add more sections as needed -->

            <div class="privacy-section">
                <h2 class="policy-title">
                    <i class="fas fa-envelope"></i>
                    Contact Us
                </h2>
                <p>For privacy concerns or data requests:</p>
                <p>Email: <a href="mailto:support@receivethesms.com" class="highlight-term">support@receivethesms.com</a></p>
                <p>Response time: Within 72 business hours</p>
            </div>
        </div>
    </main>

    <!-- Footer (Same as Homepage) -->
    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <a href="/" class="site-name">ReceiveTheSMS.com</a>
                <p>Secure Anonymous SMS Reception</p>
            </div>
            <div class="footer-contact">
                <p>Need assistance? Contact us:</p>
                <a href="mailto:support@receivethesms.com">
                    <i class="fas fa-envelope"></i>
                    support@receivethesms.com
                </a>
                <div class="footer-links">
                    <a href="/privacy">
                        <i class="fas fa-shield-alt"></i>
                        Privacy Policy
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom container">
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
    </script>
</body>
</html>
