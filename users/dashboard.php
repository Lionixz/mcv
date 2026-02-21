<?php
// User Dashboard Content
$baseUrl = \App\Config\Config::getAppUrl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - CCSFP</title>
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
            background: #3498db;
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
        
        .profile-info {
            display: flex;
            gap: 2rem;
            align-items: center;
            margin-top: 1.5rem;
        }
        
        .profile-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #3498db;
        }
        
        .info-text p {
            margin: 0.5rem 0;
            color: #34495e;
        }
        
        .info-text strong {
            color: #2c3e50;
            width: 100px;
            display: inline-block;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .dashboard-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .dashboard-card h3 {
            color: #3498db;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0f2f5;
        }
        
        .user-badge {
            background: #2ecc71;
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
            CCSFP Student Portal
            <span class="user-badge">Student</span>
        </div>
        <div class="nav-user">
            <span>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
            <img src="<?= htmlspecialchars($_SESSION['user_picture']) ?>" alt="Profile">
            <a href="<?= $baseUrl ?>/auth/logout" class="logout-btn">Logout</a>
        </div>
    </nav>
    
    <div class="container">
        <div class="welcome-card">
            <h1>Student Dashboard</h1>
            
            <div class="profile-info">
                <img src="<?= htmlspecialchars($_SESSION['user_picture']) ?>" alt="Profile">
                <div class="info-text">
                    <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['user_name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user_email']) ?></p>
                    <p><strong>Account Type:</strong> Student User</p>
                    <p><strong>Status:</strong> Active</p>
                </div>
            </div>
        </div>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>My Courses</h3>
                <p>You are currently enrolled in 4 courses.</p>
                <ul style="margin-top: 1rem; list-style: none;">
                    <li>• Introduction to Programming</li>
                    <li>• Web Development</li>
                    <li>• Database Management</li>
                    <li>• Software Engineering</li>
                </ul>
            </div>
            
            <div class="dashboard-card">
                <h3>Upcoming Assignments</h3>
                <ul style="list-style: none;">
                    <li>• Web Dev Project - Due in 3 days</li>
                    <li>• Database Quiz - Tomorrow</li>
                    <li>• Programming Exercise - Next week</li>
                </ul>
            </div>
            
            <div class="dashboard-card">
                <h3>Announcements</h3>
                <ul style="list-style: none;">
                    <li>• School event this Friday</li>
                    <li>• Registration for next semester</li>
                    <li>• Library hours extended</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>