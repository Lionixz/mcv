<?php
// Admin Dashboard Content
$baseUrl = \App\Config\Config::getAppUrl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CCSFP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
        }
        
        .navbar {
            background: #2c3e50;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .nav-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .nav-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .nav-user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        
        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .logout-btn:hover {
            background: #c0392b;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .welcome-card h1 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stat-card h3 {
            color: #7f8c8d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-top: 0.5rem;
        }
        
        .admin-badge {
            background: #3498db;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-left: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">
            CCSFP Admin Panel
            <span class="admin-badge">Admin</span>
        </div>
        <div class="nav-user">
            <span>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
            <img src="<?= htmlspecialchars($_SESSION['user_picture']) ?>" alt="Profile">
            <a href="<?= $baseUrl ?>/auth/logout" class="logout-btn">Logout</a>
        </div>
    </nav>
    
    <div class="container">
        <div class="welcome-card">
            <h1>Admin Dashboard</h1>
            <p>Welcome to the admin panel. You have full access to manage the system.</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <div class="number">1,234</div>
                </div>
                <div class="stat-card">
                    <h3>Active Sessions</h3>
                    <div class="number">56</div>
                </div>
                <div class="stat-card">
                    <h3>New Today</h3>
                    <div class="number">12</div>
                </div>
                <div class="stat-card">
                    <h3>Pending Approvals</h3>
                    <div class="number">3</div>
                </div>
            </div>
        </div>
        
        <!-- Add more admin content here -->
    </div>
</body>
</html>