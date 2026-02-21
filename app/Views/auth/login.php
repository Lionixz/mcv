<?php
$title = 'Register Student Account - CCSFP';
$baseUrl = \App\Config\Config::getAppUrl();
$showScripts = true;
ob_start();
?>

<div class="login-container">
    <div class="left-side">
        <img src="<?= $baseUrl ?>/public/images/system/ccsfp-building.jpg" alt="building" class="bg-img">
        
        <!-- Logo and School Name Container -->
        <div class="logo-container">
            <img src="<?= $baseUrl ?>/public/images/system/logo.png" alt="Logo" class="logo-img">
            <h1 class="school-name">City College of San Fernando – San Fernando Pampanga</h1>
        </div>
        
        <div class="overlay-text">
            <h1>VISION</h1>
            <p>By 2040, the City College of San Fernando Pampanga is a leading institution of higher education advancing the quality of life of Fernandinos.</p>
            <h1>MISSION</h1>
            <p>To provide innovative and industry-responsive education, sustained by community engagement with robust institutional structure.</p>
        </div>
    </div>
    
    <!-- RIGHT SIDE -->
    <div class="right-side">
        <div class="login-form">
            <h2>Register Student Account</h2>
            
            <!-- Display error message if any -->
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message" style="color: red; margin-bottom: 15px; padding: 10px; background: #ffeeee; border-radius: 5px;">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>
            
            <!-- FAKE FORM (for demo/design purposes) -->
            <form id="registerForm" onsubmit="return false;">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
                <label>Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <label>Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                <button type="submit" class="btn-login" onclick="alert('Please use Google Login instead')">Register</button>
            </form>
            
            <div class="divider">OR</div>
            
            <!-- Google login -->
            <a id="googleLoginBtn" href="<?= htmlspecialchars($loginUrl) ?>" class="btn-google">
                Login with Google
            </a>
            
            <div class="info-text">
                Please login using your Google account to access your student portal.
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>