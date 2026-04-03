<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Please enter username and password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - National College, Nadakakvu</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #1e3a5f;
            --secondary: #2c5282;
            --accent: #f6993f;
            --light: #f7fafc;
            --dark: #1a202c;
            --white: #ffffff;
            --gray-600: #718096;
            --danger: #e53e3e;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }
        
        .login-box {
            background: var(--white);
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
        }
        
        .login-box .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-box .logo i {
            font-size: 3rem;
            color: var(--primary);
        }
        
        .login-box .logo h2 {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
            margin-top: 15px;
            font-size: 1.8rem;
        }
        
        .login-box .logo span {
            color: var(--gray-600);
            font-size: 0.9rem;
        }
        
        .login-box h3 {
            text-align: center;
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        
        .login-box p {
            text-align: center;
            color: var(--gray-600);
            margin-bottom: 30px;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .form-group .input-icon {
            position: relative;
        }
        
        .form-group .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-600);
        }
        
        .form-group .input-icon input {
            padding-left: 40px;
        }
        
        .btn {
            display: inline-block;
            width: 100%;
            padding: 14px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 1rem;
            background: var(--primary);
            color: var(--white);
        }
        
        .btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: var(--gray-600);
            text-decoration: none;
        }
        
        .back-link a:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">
            <i class="fas fa-graduation-cap"></i>
            <h2>National College</h2>
            <span>Admin Panel</span>
        </div>
        
        <h3>Welcome Back</h3>
        <p>Enter your credentials to access the admin panel</p>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" required placeholder="Enter your username">
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="back-link">
            <a href="../index.php"><i class="fas fa-arrow-left"></i> Back to Website</a>
        </div>
    </div>
</body>
</html>