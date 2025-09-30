<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Version Error</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --danger: #f43f5e;
            --success: #22c55e;
            --warning: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
        }
        
        .card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            margin-bottom: 30px;
        }
        
        .card-header {
            background: var(--primary);
            color: white;
            padding: 25px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .card-header i {
            font-size: 28px;
        }
        
        .card-header h1 {
            font-size: 24px;
            font-weight: 600;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .error-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .error-icon {
            font-size: 64px;
            color: var(--danger);
            margin-bottom: 10px;
        }
        
        .error-title {
            font-size: 22px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .error-description {
            color: var(--gray);
            line-height: 1.6;
        }
        
        .version-info {
            display: flex;
            justify-content: space-between;
            background: #f1f5f9;
            padding: 20px;
            border-radius: 12px;
            margin: 25px 0;
        }
        
        .version-item {
            text-align: center;
            flex: 1;
        }
        
        .version-label {
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 8px;
        }
        
        .version-value {
            font-size: 18px;
            font-weight: 700;
        }
        
        .required {
            color: var(--success);
        }
        
        .current {
            color: var(--danger);
        }
        
        .divider {
            width: 1px;
            background: #cbd5e1;
            margin: 0 20px;
        }
        
        .solution-section {
            background: #f0fdf4;
            border-left: 4px solid var(--success);
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .solution-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .solution-title i {
            color: var(--success);
        }
        
        .solution-steps {
            padding-left: 20px;
            color: var(--gray);
        }
        
        .solution-steps li {
            margin-bottom: 8px;
            line-height: 1.5;
        }
        
        .actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background: #4f46e5;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: white;
            color: var(--gray);
            border: 1px solid #cbd5e1;
        }
        
        .btn-secondary:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
        }
        
        .footer {
            text-align: center;
            color: var(--gray);
            font-size: 14px;
            margin-top: 20px;
        }
        
        @media (max-width: 640px) {
            .version-info {
                flex-direction: column;
                gap: 20px;
            }
            
            .divider {
                width: 100%;
                height: 1px;
                margin: 10px 0;
            }
            
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h1>PHP Version Incompatibility</h1>
            </div>
            <div class="card-body">
                <div class="error-content">
                    <div class="error-icon">
                        <i class="fas fa-plug-circle-exclamation"></i>
                    </div>
                    <h2 class="error-title">Your PHP version is not compatible with this application</h2>
                    <p class="error-description">
                        The application requires a newer version of PHP to function properly. 
                        Using an outdated PHP version may cause security vulnerabilities and compatibility issues.
                    </p>
                </div>
                
                <div class="version-info">
                    <div class="version-item">
                        <div class="version-label">Required Version</div>
                        <div class="version-value required">PHP >= 8.2</div>
                    </div>
                    <div class="divider"></div>
                    <div class="version-item">
                        <div class="version-label">Current Version</div>
                        <div class="version-value current"><?= PHP_VERSION ?></div>
                    </div>
                </div>
                
                <div class="solution-section">
                    <div class="solution-title">
                        <i class="fas fa-lightbulb"></i>
                        <span>How to resolve this issue</span>
                    </div>
                    <ol class="solution-steps">
                        <li>Contact your hosting provider to upgrade your PHP version</li>
                        <li>If you have server access, update PHP using your package manager</li>
                        <li>Alternatively, use a local development environment like Laravel Valet, Homestead, or Docker</li>
                        <li>After upgrading, verify your PHP version in your hosting control panel</li>
                    </ol>
                </div>
                
                <div class="actions">
                    <a href="https://www.php.net/downloads.php" class="btn btn-primary">
                        <i class="fas fa-download"></i> Download Latest PHP
                    </a>
                    <a href="https://laravel.com/docs" class="btn btn-secondary">
                        <i class="fas fa-book"></i> Laravel Documentation
                    </a>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>Need assistance? Contact your system administrator or development team.</p>
        </div>
    </div>
</body>
</html>