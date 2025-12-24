<?php
session_start();
include "../includes/db.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.95)),
                        url("../assets/images/image1.png") center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .login-box {
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid rgba(255, 0, 255, 0.4);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 30px rgba(255, 0, 255, 0.3);
        }
        
        .login-title {
            text-align: center;
            color: #ff00ff;
            margin-bottom: 30px;
            font-family: 'Orbitron', sans-serif;
            font-size: 28px;
            text-shadow: 0 0 15px rgba(255, 0, 255, 0.7);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #ffccff;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 0, 255, 0.5);
            border-radius: 10px;
            color: white;
            font-size: 16px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #ff00ff;
            box-shadow: 0 0 15px rgba(255, 0, 255, 0.5);
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff00ff, #a100ff);
            color: #000;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(255, 0, 255, 0.8);
        }
        
        .error {
            color: #ff6666;
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background: rgba(255, 0, 0, 0.1);
            border-radius: 5px;
            border: 1px solid rgba(255, 0, 0, 0.3);
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #aaa;
            text-decoration: none;
        }
        
        .back-link:hover {
            color: #ff00ff;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1 class="login-title">🎤 KARAFLOW Admin</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn-login">Log In</button>
        </form>
        
        <a href="../public/index.php" class="back-link">← Back to Home</a>
    </div>
</body>
</html>
