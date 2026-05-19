<?php

class UserRepository {
    /** @var PDO */
    private $db;

    public function __construct() {
        $database = new Database();
        // Đã sửa từ getConnection() thành connect() cho khớp với file Database.php của bạn
        $this->db = $database->connect(); 
    }

    /**
     * Lấy tất cả người dùng (Dùng cho trang quản lý)
     */
    public function getAll() {
        try {
            $query = "SELECT id, username, email, role, status, created_at FROM users";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * HÀM QUAN TRỌNG: Tìm theo Email và Role
     * Giúp đăng nhập đúng vai trò đã chọn trên giao diện
     */
    public function findByEmailAndRole($email, $role) {
        try {
            $query = "SELECT * FROM users WHERE email = :email AND role = :role LIMIT 1";
            $stmt = $this->db->prepare($query);
            
            // Thực thi với tham số an toàn chống SQL Injection
            $stmt->execute([
                ':email' => $email,
                ':role'  => $role 
            ]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Tìm theo Username (Dùng khi cần kiểm tra trùng lặp hoặc lấy profile)
     */
    public function findByUsername($username) {
        try {
            $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':username' => $username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
}