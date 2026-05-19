<?php
class ResourceRepository {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Lấy toàn bộ danh sách phòng/thiết bị - Đã xóa bỏ WHERE status để hết lỗi đỏ
    public function getAllResources() {
        $sql = "SELECT * FROM resources"; 
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm đếm để Dashboard nhảy số
    public function countAll() {
        $sql = "SELECT COUNT(*) FROM resources";
        return $this->db->query($sql)->fetchColumn();
    }

    // Tìm chi tiết 1 phòng theo ID
    public function find($id) {
        $sql = "SELECT * FROM resources WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}