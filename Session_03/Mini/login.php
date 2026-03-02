<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/helpers.php';

// Kiểm tra chế độ ẩn danh
if (isIncognito()) {
    $_SESSION['error'] = 'Please disable incognito mode to access your account.';
    header('Location: login.php?error=incognito');
    exit();
}

// Redirect nếu đã đăng nhập
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}

// Kiểm tra nếu có request clear session (cho mục đích debug)
if (isset($_GET['clear'])) {
    $_SESSION['login_attempts'] = [];
    $_SESSION['error'] = 'Login attempts have been cleared.';
    header('Location: login.php');
    exit();
}

$error = getErrorMessage();
$email_value = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $email_value = $email; // Lưu email để hiển thị lại
    
    // Kiểm tra nếu bị block
    if (isBlocked($email)) {
        $remainingTime = BLOCK_DURATION - (time() - end($_SESSION['login_attempts'][$email]));
        $error = "Account temporarily locked. Try again in " . ceil($remainingTime / 60) . " minutes.";
        $_SESSION['error'] = $error;
        header('Location: login.php');
        exit();
    }
    
    // Validation
    $errors = [];
    if (empty($email) || empty($password)) {
        $errors[] = 'Email and password are required';
    } elseif (!validateEmail($email)) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($errors)) {
        $user = Database::findUserByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            unset($_SESSION['login_attempts'][$email]);
            $_SESSION['user'] = $user;
            $_SESSION['success'] = 'Login successful! Welcome back, ' . htmlspecialchars($user['name']) . '!';
            header('Location: dashboard.php');
            exit();
        } else {
            // Login failed
            addLoginAttempt($email);
            $attempts = isset($_SESSION['login_attempts'][$email]) ? count($_SESSION['login_attempts'][$email]) : 1;
            $remainingAttempts = MAX_LOGIN_ATTEMPTS - $attempts;
            
            if ($remainingAttempts <= 0) {
                $error = "Account locked for 5 minutes due to multiple failed attempts.";
            } else {
                $error = "Invalid email or password. {$remainingAttempts} attempts remaining.";
            }
            
            $_SESSION['error'] = $error;
            header('Location: login.php');
            exit();
        }
    } else {
        $error = implode('<br>', $errors);
        $_SESSION['error'] = $error;
        header('Location: login.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo SITE_NAME; ?></title>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --warning-color: #ff9e00;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            animation: slideUp 0.5s ease-out;
            position: relative;
            overflow: hidden;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-color);
            font-size: 32px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }
        
        h1 {
            text-align: center;
            color: var(--dark-color);
            margin-bottom: 10px;
            font-size: 28px;
            font-weight: 600;
        }
        
        .subtitle {
            text-align: center;
            color: var(--gray-color);
            margin-bottom: 40px;
            font-size: 16px;
            line-height: 1.5;
        }
        
        .alert {
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-danger {
            background-color: rgba(247, 37, 133, 0.08);
            color: #721c24;
            border: 1px solid rgba(247, 37, 133, 0.2);
        }
        
        .alert-warning {
            background-color: rgba(255, 158, 0, 0.08);
            color: #856404;
            border: 1px solid rgba(255, 158, 0, 0.2);
        }
        
        .alert i {
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        
        .form-group {
            margin-bottom: 30px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            color: var(--dark-color);
            font-weight: 600;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
            font-size: 18px;
            z-index: 1;
        }
        
        input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border: 2px solid #e1e5ee;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 17px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 40px;
            color: var(--gray-color);
            font-size: 15px;
            padding-top: 25px;
            border-top: 1px solid #eaeaea;
        }
        
        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
        }
        
        .form-footer a:hover {
            color: var(--secondary-color);
        }
        
        .form-footer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s;
        }
        
        .form-footer a:hover::after {
            width: 100%;
        }
        
        .attempts-info {
            font-size: 14px;
            color: var(--warning-color);
            margin-top: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 158, 0, 0.08);
            padding: 10px 15px;
            border-radius: 8px;
            border-left: 3px solid var(--warning-color);
        }
        
        .forgot-password {
            text-align: right;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        
        .forgot-password a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .forgot-password a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-color);
            cursor: pointer;
            font-size: 18px;
            padding: 5px;
            transition: color 0.3s;
            z-index: 2;
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
        }
        
        .demo-credentials {
            background: rgba(76, 201, 240, 0.08);
            border: 1px solid rgba(76, 201, 240, 0.2);
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            font-size: 14px;
        }
        
        .demo-credentials h4 {
            color: var(--dark-color);
            margin-bottom: 10px;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .demo-credentials p {
            color: var(--gray-color);
            margin-bottom: 5px;
        }
        
        .demo-credentials code {
            background: rgba(0, 0, 0, 0.05);
            padding: 3px 8px;
            border-radius: 4px;
            font-family: monospace;
            color: var(--primary-color);
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 40px 25px;
            }
            
            .logo {
                font-size: 26px;
            }
            
            .logo-icon {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            input {
                padding: 14px 20px 14px 45px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <span><?php echo SITE_NAME; ?></span>
            </div>
            
            <h1>Welcome Back</h1>
            <p class="subtitle">Sign in to your account to continue</p>
            
            <?php if (isset($_GET['error']) && $_GET['error'] === 'incognito'): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Incognito Mode Detected</strong><br>
                        Please disable incognito mode to access your account for security reasons.
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div><?php echo $error; ?></div>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" id="loginForm">
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($email_value); ?>" 
                               required 
                               placeholder="Enter your email address"
                               autocomplete="email">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="input-with-icon">
                        <i class="fas fa-key"></i>
                        <input type="password" id="password" name="password" 
                               required 
                               placeholder="Enter your password"
                               autocomplete="current-password">
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    
                    <div class="forgot-password">
                        <a href="#" onclick="alert('Please contact administrator to reset your password.'); return false;">
                            <i class="fas fa-question-circle"></i> Forgot Password?
                        </a>
                    </div>
                    
                    <?php if (isset($_SESSION['login_attempts'][$email_value])): 
                        $attempts = count($_SESSION['login_attempts'][$email_value]);
                        if ($attempts > 0): 
                            $remainingAttempts = MAX_LOGIN_ATTEMPTS - $attempts;
                            if ($remainingAttempts > 0): ?>
                                <div class="attempts-info">
                                    <i class="fas fa-shield-alt"></i>
                                    <span><?php echo $remainingAttempts; ?> login attempt(s) remaining</span>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="btn" id="loginButton">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
            
            <?php
            // Hiển thị thông tin demo nếu không có user nào trong database
            $users = Database::getUsers();
            if (empty($users)): ?>
                <div class="demo-credentials">
                    <h4><i class="fas fa-info-circle"></i> Demo Account</h4>
                    <p>No users in database. Please register first.</p>
                    <p>After registration, use your credentials to login.</p>
                </div>
            <?php endif; ?>
            
            <div class="form-footer">
                Don't have an account? 
                <a href="index.php">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
                <br><br>
                <small style="font-size: 13px;">
                    <a href="login.php?clear=1" style="color: var(--gray-color); font-weight: normal;">
                        <i class="fas fa-sync-alt"></i> Clear Login Attempts
                    </a>
                </small>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = togglePassword.querySelector('i');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
        
        // Form validation
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            let errors = [];
            
            if (!email) {
                errors.push('Email is required');
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                errors.push('Please enter a valid email address');
            }
            
            if (!password) {
                errors.push('Password is required');
            } else if (password.length < 8) {
                errors.push('Password must be at least 8 characters');
            }
            
            if (errors.length > 0) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + errors.join('\n'));
                return false;
            }
            
            // Show loading state
            loginButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
            loginButton.disabled = true;
            return true;
        });
        
        // XSS protection check
        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');
        
        function sanitizeInput(input) {
            return input.replace(/[<>]/g, '');
        }
        
        emailField.addEventListener('blur', function() {
            this.value = sanitizeInput(this.value);
        });
        
        passwordField.addEventListener('blur', function() {
            this.value = sanitizeInput(this.value);
        });
        
        // Auto-focus on email field
        document.addEventListener('DOMContentLoaded', function() {
            if (!emailField.value) {
                emailField.focus();
            }
        });
        
        // Debug info (ẩn trong production)
        console.log('Login page loaded successfully');
        console.log('Max login attempts:', <?php echo MAX_LOGIN_ATTEMPTS; ?>);
        console.log('Block duration:', <?php echo BLOCK_DURATION; ?>, 'seconds');
    </script>
</body>
</html>