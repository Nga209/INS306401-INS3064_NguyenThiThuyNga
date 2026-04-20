<?php
// app/Controllers/AuthController.php
require_once __DIR__ . '/../Models/AuthService.php';

class AuthController {
    private $authService;
    
    public function __construct(AuthService $auth) {
        $this->authService = $auth;
    }
    
    // GET /login - Hiển thị form đăng nhập
    public function showLogin() {
        require_once __DIR__ . '/../Views/auth/login.php';
    }
    
    // POST /login - Xử lý đăng nhập
    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if ($this->authService->login($email, $password)) {
            $_SESSION['success'] = "Đăng nhập thành công!";
            header('Location: /index.php?action=index');
        } else {
            $_SESSION['errors'] = ['Email hoặc mật khẩu không đúng'];
            header('Location: /index.php?action=login');
        }
    }
    
    // GET /logout - Đăng xuất
    public function logout() {
        $this->authService->logout();
        $_SESSION['success'] = "Đã đăng xuất";
        header('Location: /index.php?action=login');
    }
}