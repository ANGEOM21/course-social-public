<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
                background-color: var(--gray-100);
            }
            
            .dark body {
                color: var(--gray-200);
                background-color: var(--gray-900);
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
                max-width: 42rem;
                width: 100%;
                background: white;
                border-radius: 1rem;
                padding: 3rem;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 
                            0 10px 10px -5px rgba(0, 0, 0, 0.04);
                position: relative;
                overflow: hidden;
            }
            
            .dark .error-content {
                background: var(--gray-800);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25), 
                            0 10px 10px -5px rgba(0, 0, 0, 0.1);
            }
            
            /* Decorative elements */
            .error-decoration {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 0.5rem;
                background: linear-gradient(90deg, var(--primary), var(--primary-light));
            }
            
            .error-icon {
                font-size: 5rem;
                margin-bottom: 1.5rem;
                color: var(--error);
                opacity: 0.9;
            }
            
            .dark .error-icon {
                color: var(--error-light);
            }
            
            /* Error code */
            .error-code {
                font-size: 6rem;
                font-weight: 800;
                line-height: 1;
                margin-bottom: 1rem;
                color: var(--error);
                display: inline-block;
                position: relative;
            }
            
            .dark .error-code {
                color: var(--error-light);
            }
            
            /* Error message */
            .error-message {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 2rem;
                color: var(--gray-700);
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
            }
            
            .dark .error-description {
                color: var(--gray-400);
            }
            
            /* Action button */
            .error-action {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                font-weight: 500;
                border-radius: 0.5rem;
                background-color: var(--primary);
                color: white;
                text-decoration: none;
                transition: all 0.2s ease;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            }
            
            .error-action:hover {
                background-color: var(--primary-dark);
                transform: translateY(-1px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            
            .error-action:focus {
                outline: none;
                ring: 2px;
                ring-color: var(--primary-light);
            }
            
            /* Responsive adjustments */
            @media (max-width: 640px) {
                .error-content {
                    padding: 2rem 1.5rem;
                }
                
                .error-code {
                    font-size: 4rem;
                }
                
                .error-message {
                    font-size: 1.25rem;
                }
            }
        </style>
        
        <!-- Inter font from Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body class="antialiased">
        <div class="error-container">
            <div class="error-content">
                <div class="error-decoration"></div>
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h1 class="error-code">@yield('code')</h1>
                <h2 class="error-message">@yield('message')</h2>
                <p class="error-description">
                    Oops! Something went wrong. The page you're looking for might have been removed, 
                    had its name changed, or is temporarily unavailable.
                </p>
                <a href="/" class="error-action">
                    <i class="fas fa-home mr-2"></i> Return to Homepage
                </a>
            </div>
        </div>
    </body>
</html>