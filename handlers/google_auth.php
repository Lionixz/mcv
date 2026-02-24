<?php

use Google\Service\Oauth2;

session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';

// logs out the current user and redirects
function logoutAndRedirect($url = "index.php") {
    session_unset();
    session_destroy();
    header("Location: $url");
    exit;
}

// Check if user is already logged in
if (!empty($_SESSION['session_token']) && !empty($_SESSION['user_id'])) {
    // Verify session token against database
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ? AND session_token = ?");
    $stmt->bind_param("is", $_SESSION['user_id'], $_SESSION['session_token']);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        // User is already logged in with valid session token
        $row = $res->fetch_assoc();
        $role = $row['role'];

        // Redirect user based on role
        $redirect_url = $role === 'admin' ? "../admin/index.php" : "../users/index.php";
        header("Location: $redirect_url");
        exit;
    }
    // else invalid token, fall through to normal login
}


// Handle existing Google access token
if (!empty($_SESSION['access_token'])) {
    $client->setAccessToken($_SESSION['access_token']);
    if ($client->isAccessTokenExpired()) {
        try {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $_SESSION['access_token'] = $client->getAccessToken();
        } catch (Exception $e) {
            error_log("Token refresh error: " . $e->getMessage());
            logoutAndRedirect();
        }
    }
}

// Handle Google OAuth callback
if (!empty($_GET['code']) && empty($_SESSION['access_token'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (!empty($token['error'])) throw new Exception($token['error']);

        $client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $oauth = new Oauth2($client);
        $user  = $oauth->userinfo->get();

        $_SESSION['user_id']      = $user->id;
        $_SESSION['user_email']   = $user->email;
        $_SESSION['user_name']    = $user->name;
        $_SESSION['user_picture'] = $user->picture;

        $now = date('Y-m-d H:i:s');

        // Check if user exists
        $stmt = $conn->prepare("SELECT id, role FROM users WHERE google_id = ?");
        $stmt->bind_param("s", $user->id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 0) {
            $role = 'user';
            $stmt = $conn->prepare(
                "INSERT INTO users (google_id, name, email, picture, role, last_seen) VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("ssssss", $user->id, $user->name, $user->email, $user->picture, $role, $now);
            $stmt->execute();
            $user_id = $conn->insert_id;
        } else {
            $row = $res->fetch_assoc();
            $user_id = $row['id'];
            $role    = $row['role'];

            $stmt = $conn->prepare("UPDATE users SET last_seen = ? WHERE google_id = ?");
            $stmt->bind_param("ss", $now, $user->id);
            $stmt->execute();
        }

        // Generate and store session token
        $session_token = bin2hex(random_bytes(32));
        $stmt = $conn->prepare("UPDATE users SET session_token = ? WHERE google_id = ?");
        $stmt->bind_param("ss", $session_token, $user->id);
        $stmt->execute();

        $_SESSION['session_token'] = $session_token;
        $_SESSION['role']          = $role;

        $redirect_url = $role === 'admin' ? "../admin/index.php" : "../users/index.php";
        header("Location: $redirect_url");
        exit;

    } catch (Exception $e) {
        error_log("Google Auth Error: " . $e->getMessage());
        logoutAndRedirect("../error.php");
    }
}