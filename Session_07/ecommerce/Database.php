<?php
// File: Database.php
class Database {
    // Biến static lưu instance duy nhất
    private static $instance = null;
    
    // Biến lưu kết nối PDO
    private $connection;

    /**
     * Constructor private - chỉ được gọi từ bên trong class
     * Khởi tạo kết nối PDO đến MySQL
     */
    private function __construct() {
        // Cấu hình kết nối
        $host = 'localhost';
        $dbname = 'ecommerce_db';
        $username = 'root';
        $password = ''; // XAMPP để trống password
        $charset = 'utf8mb4';
        
        // DSN (Data Source Name)
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        
        // Các tùy chọn cho PDO
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   // Ném exception khi có lỗi
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Trả về mảng kết hợp
            PDO::ATTR_EMULATE_PREPARES => false,           // Tắt giả lập prepared statements
        ];

        try {
            // Tạo kết nối PDO
            $this->connection = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            // Xử lý lỗi kết nối
            die("❌ Kết nối database thất bại: " . $e->getMessage());
        }
    }

    /**
     * Lấy instance duy nhất của Database
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Lấy kết nối PDO
     * @return PDO
     */
    public function getConnection() {
        return $this->connection;
    }
}
?>