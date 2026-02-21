<?php
$title = '404 - Page Not Found';
$baseUrl = \App\Config\Config::getAppUrl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }
        
        .error-container {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 500px;
            margin: 20px;
        }
        
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #667eea;
            line-height: 1;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .error-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .error-message {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .home-link {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background 0.3s ease;
        }
        
        .home-link:hover {
            background: #5a67d8;
        }
        
        .debug-info {
            margin-top: 20px;
            padding: 10px;
            background: #f7f7f7;
            border-radius: 5px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-title">Page Not Found</div>
        <div class="error-message">
            The page you are looking for might have been removed,<br>
            had its name changed, or is temporarily unavailable.
        </div>
        <a href="<?= $baseUrl ?>" class="home-link">Go to Homepage</a>
        
        <?php if (isset($_GET['debug']) && $_GET['debug'] == '1'): ?>
        <div class="debug-info">
            <?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>