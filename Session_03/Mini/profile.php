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
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name'] ?? '');
    $bio = sanitizeInput($_POST['bio'] ?? '');
    
    // Validation
    if (empty($name)) {
        $error = 'Name is required';
    } else {
        $updateData = ['name' => $name, 'bio' => $bio];
        
        // Handle avatar upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['avatar'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];
            
            // Check file type
            if (!in_array($fileType, ALLOWED_AVATAR_TYPES)) {
                $error = 'Only JPG, PNG, and GIF files are allowed';
            }
            // Check file size
            elseif ($fileSize > MAX_AVATAR_SIZE) {
                $error = 'File is too large. Maximum size is 2MB';
            }
            // Check for executable files (simulate .exe/.pdf rejection)
            elseif (preg_match('/\.(exe|pdf)$/i', $fileName)) {
                $error = 'Executable and PDF files are not allowed for avatars';
            } else {
                // Create uploads directory if not exists
                if (!file_exists('uploads')) {
                    mkdir('uploads', 0755, true);
                }
                
                // Generate unique filename
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $newFileName = uniqid('avatar_', true) . '.' . $fileExt;
                $uploadPath = 'uploads/' . $newFileName;
                
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    // Delete old avatar if exists
                    if (!empty($user['avatar']) && file_exists($user['avatar'])) {
                        unlink($user['avatar']);
                    }
                    $updateData['avatar'] = $uploadPath;
                } else {
                    $error = 'Failed to upload avatar';
                }
            }
        }
        
        if (!$error) {
            // Update user in database
            $updatedUser = Database::updateUser($user['email'], $updateData);
            if ($updatedUser) {
                // Update session
                $_SESSION['user'] = $updatedUser;
                $user = $updatedUser;
                $success = 'Profile updated successfully!';
            } else {
                $error = 'Failed to update profile';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - <?php echo SITE_NAME; ?></title>
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
        
        .avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 32px;
            font-weight: 600;
            overflow: hidden;
            border: 3px solid white;
        }
        
        .avatar-large img {
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
        
        .alert-danger {
            background-color: rgba(247, 37, 133, 0.1);
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .profile-form {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
        
        .form-group {
            margin-bottom: 30px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            color: var(--dark-color);
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        input, textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5ee;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        textarea {
            min-height: 150px;
            resize: vertical;
            font-family: inherit;
        }
        
        .avatar-upload {
            display: flex;
            align-items: center;
            gap: 30px;
        }
        
        .avatar-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 3px dashed #dee2e6;
        }
        
        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .upload-controls {
            flex: 1;
        }
        
        .file-input-wrapper {
            position: relative;
            margin-bottom: 15px;
        }
        
        .file-input-wrapper input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-input-label {
            display: inline-block;
            padding: 12px 25px;
            background: var(--primary-color);
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .file-input-label:hover {
            background: var(--secondary-color);
        }
        
        .file-info {
            font-size: 14px;
            color: var(--gray-color);
            margin-top: 10px;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 40px;
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
            
            .avatar-large {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
            
            .nav-link {
                justify-content: center;
                padding: 15px;
            }
            
            .avatar-upload {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .profile-form {
                padding: 25px;
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
            <div class="avatar-large">
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
            <a href="dashboard.php" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="profile.php" class="nav-link active">
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
            <h1>Edit Profile</h1>
            <a href="dashboard.php" class="logout-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="profile-form">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                    <small style="color: var(--gray-color); font-size: 14px; margin-top: 5px; display: block;">
                        Email address cannot be changed
                    </small>
                </div>
                
                <div class="form-group">
                    <label for="bio"><i class="fas fa-edit"></i> Bio</label>
                    <textarea id="bio" name="bio" placeholder="Tell us about yourself..."><?php echo htmlspecialchars($user['bio']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-camera"></i> Profile Picture</label>
                    <div class="avatar-upload">
                        <div class="avatar-preview">
                            <?php if (!empty($user['avatar'])): ?>
                                <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar Preview">
                            <?php else: ?>
                                <div style="color: var(--gray-color); text-align: center; padding: 20px;">
                                    <i class="fas fa-user" style="font-size: 40px; margin-bottom: 10px;"></i>
                                    <div>No avatar</div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="upload-controls">
                            <div class="file-input-wrapper">
                                <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif">
                                <span class="file-input-label">
                                    <i class="fas fa-upload"></i> Choose Image
                                </span>
                            </div>
                            <div class="file-info">
                                <p>Max file size: 2MB</p>
                                <p>Allowed formats: JPG, PNG, GIF</p>
                                <p>Restricted: .exe, .pdf files</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Preview avatar before upload
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.querySelector('.avatar-preview');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview">`;
                }
                
                reader.readAsDataURL(file);
            }
        });
        
        // XSS protection check for bio field (client-side validation)
        document.querySelector('form').addEventListener('submit', function(e) {
            const bioField = document.getElementById('bio');
            const dangerousPatterns = [
                /<script\b[^>]*>([\s\S]*?)<\/script>/gi,
                /javascript:/gi,
                /on\w+\s*=/gi
            ];
            
            for (const pattern of dangerousPatterns) {
                if (pattern.test(bioField.value)) {
                    e.preventDefault();
                    alert('Security Warning: Your bio contains potentially unsafe content. Please remove any script tags or event handlers.');
                    bioField.focus();
                    return;
                }
            }
        });
    </script>
</body>
</html>