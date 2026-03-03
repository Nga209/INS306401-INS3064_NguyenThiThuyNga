<?php
session_start();

// 1. HÀM HỖ TRỢ & KHỞI TẠO
function clean($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

// 2. ROUTING (ĐIỀU HƯỚNG)
$page = $_GET['page'] ?? (isset($_SESSION['user_logged_in']) ? 'dashboard' : 'login');
$error = ""; 
$success = "";

// 3. BẢO MẬT BẮT BUỘC (ACCESS CONTROL)
if (in_array($page, ['dashboard', 'profile']) && !isset($_SESSION['user_logged_in'])) {
    header("Location: index.php?page=login");
    exit();
}

// 4. XỬ LÝ LOGIC (CONTROLLER)
if ($page === 'logout') {
    unset($_SESSION['user_logged_in']);
    header("Location: index.php?page=login");
    exit();
}

// -- XỬ LÝ ĐĂNG KÝ
if (isset($_POST['register'])) {
    $user = clean($_POST['username']);
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (empty($user) || empty($pass)) {
        $error = "Vui lòng điền đầy đủ thông tin.";
    } elseif ($pass !== $confirm) {
        $error = "Mật khẩu xác nhận không khớp.";
    } elseif (isset($_SESSION['users'][$user])) {
        $error = "Tên đăng nhập đã tồn tại.";
    } else {
        $_SESSION['users'][$user] = [
            'password' => password_hash($pass, PASSWORD_DEFAULT),
            'bio' => 'Chưa có tiểu sử',
            'avatar' => 'default.png'
        ];
        
        // Mở khóa cho tài khoản mới đăng ký
        $_SESSION['login_attempts'][$user] = 0; 
        
        $success = "Đăng ký thành công. Vui lòng đăng nhập.";
        $page = 'login';
    }
}

// -- XỬ LÝ ĐĂNG NHẬP (ĐÃ SỬA CHỖ NÀY)
// -- XỬ LÝ ĐĂNG NHẬP
if (isset($_POST['login'])) {
    $user = clean($_POST['username']);
    $pass = $_POST['password'];

    // 1. Kiểm tra tài khoản có tồn tại hay không trước
    if (!isset($_SESSION['users'][$user])) {
        $error = "Tài khoản không tồn tại! Vui lòng kiểm tra lại hoặc Đăng ký.";
    } else {
        // 2. Nếu tài khoản TỒN TẠI, bắt đầu xử lý đếm số lần sai
        
        // Dọn dẹp session nếu bị lỗi kiểu dữ liệu cũ
        if (!isset($_SESSION['login_attempts']) || !is_array($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = [];
        }

        // Khởi tạo đếm = 0 cho tài khoản này nếu chưa có
        if (!isset($_SESSION['login_attempts'][$user])) {
            $_SESSION['login_attempts'][$user] = 0;
        }

        $attempts = $_SESSION['login_attempts'][$user];

        // Kiểm tra xem tài khoản này đã bị khóa chưa
        if ($attempts >= 3) {
            $error = "Tài khoản '$user' đang bị tạm khóa do nhập sai quá 3 lần.";
        } else {
            // Kiểm tra đúng mật khẩu
            if (password_verify($pass, $_SESSION['users'][$user]['password'])) {
                $_SESSION['login_attempts'][$user] = 0; // Reset số lần sai
                $_SESSION['user_logged_in'] = $user;
                header("Location: index.php?page=dashboard");
                exit();
            } else {
                // Sai mật khẩu -> Tăng số lần sai
                $_SESSION['login_attempts'][$user]++;
                $remaining = 3 - $_SESSION['login_attempts'][$user];
                
                if ($remaining > 0) {
                    $error = "Sai mật khẩu! Tài khoản '$user' còn $remaining lần thử.";
                } else {
                    $error = "Tài khoản '$user' đã bị khóa do nhập sai mật khẩu 3 lần.";
                }
            }
        }
    }
}

// -- XỬ LÝ CẬP NHẬT PROFILE
if (isset($_POST['update']) && $page === 'profile') {
    $user = $_SESSION['user_logged_in'];
    $_SESSION['users'][$user]['bio'] = $_POST['bio']; 

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['exe', 'pdf', 'sh', 'php'])) {
            $error = "Định dạng .$ext không được hỗ trợ.";
        } else {
            $newFileName = time() . "_" . basename($_FILES['avatar']['name']);
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], "uploads/" . $newFileName)) {
                $_SESSION['users'][$user]['avatar'] = $newFileName;
                $success = "Hồ sơ đã được cập nhật.";
            }
        }
    } elseif (empty($error)) {
        $success = "Thông tin đã được lưu.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        
        <?php if ($page === 'login'): ?>
            <form method="POST" action="index.php?page=login">
                <h2>Chào mừng trở lại</h2>
                <p class="subtitle">Đăng nhập để truy cập hệ thống</p>
                
                <?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
                <?php if($error) echo "<div class='alert alert-error'>$error</div>"; ?>
                
                <div class="form-group">
                    <label>Tên đăng nhập</label>
                    <input type="text" name="username" placeholder="Nhập tên đăng nhập" required>
                </div>
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" name="login">Đăng nhập</button>
                <p class="text-center mt-4"><a href="index.php?page=register" class="link">Tạo tài khoản mới</a></p>
            </form>

        <?php elseif ($page === 'register'): ?>
            <form method="POST" action="index.php?page=register">
                <h2>Tạo tài khoản</h2>
                <p class="subtitle">Điền thông tin để đăng ký</p>

                <?php if($error) echo "<div class='alert alert-error'>$error</div>"; ?>
                
                <div class="form-group">
                    <label>Tên đăng nhập</label>
                    <input type="text" name="username" placeholder="Nhập tên đăng nhập" required>
                </div>
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" placeholder="Tạo mật khẩu" required>
                </div>
                <div class="form-group">
                    <label>Xác nhận mật khẩu</label>
                    <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                </div>
                <button type="submit" name="register">Đăng ký</button>
                <p class="text-center mt-4"><a href="index.php?page=login" class="link">Đã có tài khoản? Đăng nhập</a></p>
            </form>

        <?php elseif ($page === 'dashboard'): 
            $user = $_SESSION['user_logged_in'];
            $userData = $_SESSION['users'][$user];
        ?>
            <div class="text-center">
                <h2>Trang tổng quan</h2>
                <p class="subtitle">Thông tin hồ sơ cá nhân</p>
                
                <img src="uploads/<?= $userData['avatar'] ?>" class="avatar-img" alt="Avatar">
                <h3><?= clean($user) ?></h3>
                <p style="color: var(--text-muted); margin: 1rem 0; font-style: italic; line-height: 1.5;">
                    "<?= nl2br(clean($userData['bio'])) ?>"
                </p>
                
                <button onclick="location.href='index.php?page=profile'">Chỉnh sửa hồ sơ</button>
                <button onclick="location.href='index.php?page=logout'" class="btn-danger mt-4">Đăng xuất</button>
            </div>

        <?php elseif ($page === 'profile'): 
            $user = $_SESSION['user_logged_in'];
        ?>
            <form method="POST" action="index.php?page=profile" enctype="multipart/form-data">
                <h2>Cập nhật hồ sơ</h2>
                <p class="subtitle">Chỉnh sửa thông tin cá nhân của bạn</p>

                <?php if($error) echo "<div class='alert alert-error'>$error</div>"; ?>
                <?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
                
                <div class="form-group">
                    <label>Tiểu sử (Bio)</label>
                    <textarea name="bio" rows="4" placeholder="Viết gì đó về bạn..."><?= clean($_SESSION['users'][$user]['bio']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Ảnh đại diện</label>
                    <input type="file" name="avatar" accept="image/*" style="border: none; padding: 0;">
                </div>
                
                <button type="submit" name="update">Lưu thay đổi</button>
                <button type="button" onclick="location.href='index.php?page=dashboard'" class="btn-secondary mt-4">Quay lại</button>
            </form>
        <?php endif; ?>

    </div>
</body>
</html>