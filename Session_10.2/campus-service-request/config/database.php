<?php
// config/database.php
class Database {
    private static $instance = null;
    private $connection;
    
    // Thông tin kết nối database
    private $host = 'localhost';
    private $dbname = 'campus_service_db';
    private $username = 'root';      // XAMPP dùng 'root'
    private $password = '';           // XAMPP để trống
    
    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Kết nối database thất bại: " . $e->getMessage());
        }
    }
    
    // Singleton pattern - chỉ tạo 1 kết nối duy nhất
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
}