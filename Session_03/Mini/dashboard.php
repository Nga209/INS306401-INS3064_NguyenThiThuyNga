<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/helpers.php';

// Access control - redirect if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
$success = getSuccessMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo SITE_NAME; ?></title>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --sidebar-width: 250px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px 0;
            position: fixed;
            height: 100vh;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-header {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 24px;
            font-weight: 600;
            overflow: hidden;
        }
        
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-details h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .user-details p {
            font-size: 14px;
            opacity: 0.8;
        }
        
        .nav-links {
            padding: 25px 0;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 25px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }
        
        .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 30px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e1e5ee;
        }
        
        .header h1 {
            color: var(--dark-color);
            font-size: 32px;
        }
        
        .logout-btn {
            padding: 10px 25px;
            background: var(--danger-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .logout-btn:hover {
            background: #d11465;
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .alert-success {
            background-color: rgba(76, 201, 240, 0.1);
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--dark-color);
        }
        
        .card p {
            color: var(--gray-color);
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .card-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .card-link:hover {
            text-decoration: underline;
        }
        
        .profile-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .profile-section h2 {
            font-size: 24px;
            margin-bottom: 30px;
            color: var(--dark-color);
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .profile-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }
        
        .info-item {
            margin-bottom: 20px;
        }
        
        .info-label {
            font-size: 14px;
            color: var(--gray-color);
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .info-value {
            font-size: 18px;
            color: var(--dark-color);
            font-weight: 600;
        }
        
        .bio-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            line-height: 1.6;
            color: var(--dark-color);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 20px 0;
            }
            
            .sidebar-header, .user-details, .nav-link span {
                display: none;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .user-info {
                justify-content: center;
                padding: 20px 10px;
            }
            
            .avatar {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
            
            .nav-link {
                justify-content: center;
                padding: 15px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-user-cog"></i>
                <span>ProfileSys</span>
            </div>
        </div>
        
        <div class="user-info">
            <div class="avatar">
                <?php if (!empty($user['avatar'])): ?>
                    <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar">
                <?php else: ?>
                    <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                <?php endif; ?>
            </div>
            <div class="user-details">
                <h3><?php echo htmlspecialchars($user['name']); ?></h3>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>
        
        <div class="nav-links">
            <a href="dashboard.php" class="nav-link active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="profile.php" class="nav-link">
                <i class="fas fa-user-edit"></i>
                <span>Edit Profile</span>
            </a>
            <a href="profile.php" class="nav-link">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
            <a href="logout.php" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Dashboard Overview</h1>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3>Account Security</h3>
                <p>Your account is protected with advanced security measures including login attempt monitoring and session management.</p>
                <a href="#" class="card-link">
                    View Security Details
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Profile Completeness</h3>
                <p>Your profile is <?php echo empty($user['bio']) ? '50%' : '85%'; ?> complete. Add more details to improve your experience.</p>
                <a href="profile.php" class="card-link">
                    Complete Profile
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>Account Activity</h3>
                <p>Member since <?php echo date('F j, Y', strtotime($user['created_at'])); ?>. Last login was today.</p>
                <a href="#" class="card-link">
                    View Activity Log
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="profile-section">
            <h2>Your Profile Information</h2>
            <div class="profile-info">
                <div>
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><?php echo htmlspecialchars($user['name']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Account Created</div>
                        <div class="info-value"><?php echo date('F j, Y, g:i a', strtotime($user['created_at'])); ?></div>
                    </div>
                </div>
                
                <div>
                    <div class="info-item">
                        <div class="info-label">Profile Bio</div>
                        <?php if (!empty($user['bio'])): ?>
                            <div class="bio-content"><?php echo nl2br(htmlspecialchars($user['bio'])); ?></div>
                        <?php else: ?>
                            <div class="bio-content" style="color: var(--gray-color); font-style: italic;">
                                No bio added yet. <a href="profile.php">Add a bio</a> to tell others about yourself.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>