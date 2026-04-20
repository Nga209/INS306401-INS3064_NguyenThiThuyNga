<?php
// app/Models/AuthService.php
require_once __DIR__ . '/User.php';

class AuthService {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
        session_start();
    }
    
    // Đăng nhập
    public function login($email, $password): bool {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $userData = $stmt->fetch();
        
        if ($userData && password_verify($password, $userData['password'])) {
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['user_email'] = $userData['email'];
            $_SESSION['user_name'] = $userData['full_name'];
            $_SESSION['user_role'] = $userData['role'];
            return true;
        }
        
        return false;
    }
    
    // Đăng xuất
    public function logout(): void {
        $_SESSION = [];
        session_destroy();
    }
    
    // Lấy thông tin user hiện tại
    public function currentUser(): ?User {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        
        $sql = "SELECT id, email, full_name, role, created_at FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $_SESSION['user_id']]);
        $data = $stmt->fetch();
        
        return $data ? User::fromArray($data) : null;
    }
    
    // Kiểm tra đã đăng nhập chưa
    public function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }
    
    // Kiểm tra có phải staff không
    public function isStaff(): bool {
        return isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['staff', 'admin']);
    }
    
    // Kiểm tra có phải admin không
    public function isAdmin(): bool {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
}