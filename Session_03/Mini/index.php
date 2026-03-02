<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/helpers.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required';
    } elseif (!validateEmail($email)) {
        $error = 'Invalid email format';
    } elseif (Database::findUserByEmail($email)) {
        $error = 'Email already registered';
    } elseif (!validatePassword($password)) {
        $error = 'Password must be at least 8 characters with letters and numbers';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Tạo user mới
        $user = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'bio' => '',
            'avatar' => '',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        Database::createUser($user);
        $success = 'Registration successful! You can now login.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?php echo SITE_NAME; ?></title>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            display: flex;
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .welcome-section {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-section {
            flex: 1;
            padding: 60px 40px;
        }
        
        .logo {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            font-size: 36px;
        }
        
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: var(--dark-color);
        }
        
        .welcome-section h2 {
            font-size: 42px;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .welcome-section p {
            font-size: 18px;
            line-height: 1.6;
            opacity: 0.9;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark-color);
            font-weight: 500;
        }
        
        input {
            width: 100%;
            padding: 14px;
            border: 2px solid #e1e5ee;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            width: 100%;
        }
        
        .btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-secondary {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        
        .btn-secondary:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: rgba(76, 201, 240, 0.1);
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .alert-danger {
            background-color: rgba(247, 37, 133, 0.1);
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-footer {
            text-align: center;
            margin-top: 30px;
            color: var(--gray-color);
        }
        
        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
        
        .password-requirements {
            font-size: 14px;
            color: var(--gray-color);
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .welcome-section, .form-section {
                padding: 40px 20px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <div class="logo">
                <i class="fas fa-user-circle"></i>
                <?php echo SITE_NAME; ?>
            </div>
            <h2>Create Your Account</h2>
            <p>Join our community and manage your profile with ease. Get access to exclusive features and personalize your experience.</p>
            <div style="margin-top: 40px;">
                <p><i class="fas fa-shield-alt"></i> Secure & Encrypted</p>
                <p><i class="fas fa-bolt"></i> Fast & Reliable</p>
                <p><i class="fas fa-users"></i> Join 10,000+ Users</p>
            </div>
        </div>
        
        <div class="form-section">
            <h1>Sign Up</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name">
                </div>
                
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" required placeholder="Create a password">
                    <div class="password-requirements">
                        Must be at least 8 characters with letters and numbers
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password"><i class="fas fa-lock"></i> Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm your password">
                </div>
                
                <button type="submit" class="btn">Create Account</button>
            </form>
            
            <div class="form-footer">
                Already have an account? <a href="login.php">Sign In</a>
            </div>
        </div>
    </div>
    
    <script>
        // Password strength indicator (optional enhancement)
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm_password');
        
        function checkPasswordMatch() {
            if (passwordInput.value && confirmInput.value) {
                if (passwordInput.value !== confirmInput.value) {
                    confirmInput.style.borderColor = '#f72585';
                } else {
                    confirmInput.style.borderColor = '#4cc9f0';
                }
            }
        }
        
        passwordInput.addEventListener('input', checkPasswordMatch);
        confirmInput.addEventListener('input', checkPasswordMatch);
    </script>
</body>
</html>