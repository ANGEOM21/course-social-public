<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <style>
            /* Modern CSS Reset */
            :root {
                --primary: #4f46e5;
                --primary-light: #6366f1;
                --primary-dark: #4338ca;
                --secondary: #ec4899;
                --secondary-light: #f472b6;
                --secondary-dark: #db2777;
                --accent: #10b981;
                --accent-light: #34d399;
                --accent-dark: #059669;
                --error: #ef4444;
                --error-light: #f87171;
                --error-dark: #dc2626;
                --gray-100: #f3f4f6;
                --gray-200: #e5e7eb;
                --gray-300: #d1d5db;
                --gray-400: #9ca3af;
                --gray-500: #6b7280;
                --gray-600: #4b5563;
                --gray-700: #374151;
                --gray-800: #1f2937;
                --gray-900: #111827;
                
                /* Gradient colors */
                --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
                --gradient-5: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            }
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 
                            "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                line-height: 1.5;
                -webkit-font-smoothing: antialiased;
                color: var(--gray-800);
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
            }
            
            .dark body {
                color: var(--gray-200);
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            }
            
            /* Main container */
            .error-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem;
                text-align: center;
            }
            
            /* Error content */
            .error-content {
                max-width: 48rem;
                width: 100%;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 1.5rem;
                padding: 3.5rem;
                box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15), 
                            0 10px 20px -5px rgba(0, 0, 0, 0.08);
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
            
            .dark .error-content {
                background: rgba(30, 41, 59, 0.8);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3), 
                            0 10px 20px -5px rgba(0, 0, 0, 0.2);
            }
            
            /* Decorative elements */
            .error-decoration {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 0.5rem;
                background: var(--gradient-1);
                animation: gradientShift 8s ease infinite;
                background-size: 400% 400%;
            }
            
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            .error-icon {
                font-size: 6rem;
                margin-bottom: 2rem;
                background: var(--gradient-2);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                display: inline-block;
                animation: float 6s ease-in-out infinite;
            }
            
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0px); }
            }
            
            /* Error code */
            .error-code {
                font-size: 8rem;
                font-weight: 800;
                line-height: 1;
                margin-bottom: 1rem;
                background: var(--gradient-3);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                display: inline-block;
                position: relative;
                text-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }
            
            /* Error message */
            .error-message {
                font-size: 1.75rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
                color: var(--gray-700);
                position: relative;
                display: inline-block;
            }
            
            .error-message::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 50%;
                transform: translateX(-50%);
                width: 80px;
                height: 3px;
                background: var(--gradient-4);
                border-radius: 3px;
            }
            
            .dark .error-message {
                color: var(--gray-300);
            }
            
            /* Description */
            .error-description {
                font-size: 1.125rem;
                color: var(--gray-500);
                margin-bottom: 2.5rem;
                max-width: 36rem;
                margin-left: auto;
                margin-right: auto;
                line-height: 1.7;
            }
            
            .dark .error-description {
                color: var(--gray-400);
            }
            
            /* Action button */
            .error-action {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.875rem 2rem;
                font-size: 1.1rem;
                font-weight: 600;
                border-radius: 0.75rem;
                background: var(--gradient-5);
                color: white;
                text-decoration: none;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px 0 rgba(0, 0, 0, 0.15);
                gap: 0.75rem;
                position: relative;
                overflow: hidden;
                z-index: 1;
            }
            
            .error-action::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: var(--gradient-1);
                opacity: 0;
                transition: opacity 0.3s ease;
                z-index: -1;
            }
            
            .error-action:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 25px 0 rgba(0, 0, 0, 0.2);
            }
            
            .error-action:hover::before {
                opacity: 1;
            }
            
            .error-action:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5), 0 4px 15px 0 rgba(0, 0, 0, 0.15);
            }
            
            /* Floating shapes */
            .floating-shapes {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: -1;
                pointer-events: none;
            }
            
            .shape {
                position: absolute;
                opacity: 0.1;
                border-radius: 50%;
                animation: floatShape 15s infinite linear;
            }
            
            .shape:nth-child(1) {
                width: 80px;
                height: 80px;
                background: var(--primary);
                top: 10%;
                left: 10%;
                animation-delay: 0s;
            }
            
            .shape:nth-child(2) {
                width: 120px;
                height: 120px;
                background: var(--secondary);
                top: 70%;
                left: 80%;
                animation-delay: -5s;
            }
            
            .shape:nth-child(3) {
                width: 60px;
                height: 60px;
                background: var(--accent);
                top: 20%;
                left: 85%;
                animation-delay: -10s;
            }
            
            .shape:nth-child(4) {
                width: 100px;
                height: 100px;
                background: var(--error);
                top: 80%;
                left: 15%;
                animation-delay: -7s;
            }
            
            @keyframes floatShape {
                0% {
                    transform: translateY(0) rotate(0deg);
                }
                50% {
                    transform: translateY(-20px) rotate(180deg);
                }
                100% {
                    transform: translateY(0) rotate(360deg);
                }
            }
            
            /* Quote section */
            .inspirational-quote {
                margin-top: 2.5rem;
                padding: 1.5rem;
                border-radius: 1rem;
                background: rgba(255, 255, 255, 0.5);
                backdrop-filter: blur(5px);
                border-left: 4px solid var(--accent);
                text-align: left;
                max-width: 36rem;
                margin-left: auto;
                margin-right: auto;
            }
            
            .dark .inspirational-quote {
                background: rgba(30, 41, 59, 0.5);
            }
            
            .quote-text {
                font-style: italic;
                color: var(--gray-600);
                margin-bottom: 0.5rem;
                line-height: 1.6;
            }
            
            .dark .quote-text {
                color: var(--gray-400);
            }
            
            .quote-author {
                font-weight: 600;
                color: var(--accent);
                text-align: right;
            }
            
            /* Responsive adjustments */
            @media (max-width: 768px) {
                .error-content {
                    padding: 2.5rem 1.5rem;
                }
                
                .error-code {
                    font-size: 5rem;
                }
                
                .error-message {
                    font-size: 1.5rem;
                }
                
                .error-icon {
                    font-size: 4.5rem;
                }
                
                .floating-shapes {
                    display: none;
                }
            }
            
            @media (max-width: 480px) {
                .error-code {
                    font-size: 4rem;
                }
                
                .error-message {
                    font-size: 1.25rem;
                }
                
                .error-icon {
                    font-size: 3.5rem;
                }
                
                .error-action {
                    padding: 0.75rem 1.5rem;
                    font-size: 1rem;
                }
            }
        </style>
        
        <!-- Inter font from Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body class="antialiased">
        <div class="error-container">
            <div class="error-content">
                <div class="error-decoration"></div>
                <div class="floating-shapes">
                    <div class="shape"></div>
                    <div class="shape"></div>
                    <div class="shape"></div>
                    <div class="shape"></div>
                </div>
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h1 class="error-code">@yield('code')</h1>
                <h2 class="error-message">@yield('message')</h2>
                <p class="error-description">
                    Ups! Ada yang salah. Jangan khawatir, perjalanan terbaik pun punya jalan memutar yang tak terduga. Mari kita bantu Anda kembali ke jalur yang benar.
                </p>
                <a href="/" class="error-action">
                    <i class="fas fa-home"></i>
                    Kembali 😌
                </a>
                
                <div class="inspirational-quote">
                    <p class="quote-text">
                        "Satu-satunya kesalahan yang sebenarnya adalah kesalahan yang tidak bisa kita pelajari darinya"
                    </p>
                    <p class="quote-author">- Henry Ford</p>
                </div>
            </div>
        </div>
    </body>
</html>