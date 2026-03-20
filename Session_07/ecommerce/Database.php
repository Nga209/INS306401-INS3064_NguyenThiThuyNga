<?php
// File: Database.php
// Singleton Pattern - Đảm bảo chỉ một kết nối PDO duy nhất

class Database {
    private static $instance = null;
    private $connection;

    /**
     * Constructor private - Khởi tạo kết nối PDO
     */
    private function __construct() {
        $host = 'localhost';
        $dbname = 'ecommerce_db';
        $username = 'root';
        $password = ''; // XAMPP để trống password
        $charset = 'utf8mb4';
        
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->connection = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            die("❌ Kết nối database thất bại: " . $e->getMessage());
        }
    }

    /**
     * Lấy instance duy nhất của Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Lấy kết nối PDO
     */
    public function getConnection() {
        return $this->connection;
    }
}
?>