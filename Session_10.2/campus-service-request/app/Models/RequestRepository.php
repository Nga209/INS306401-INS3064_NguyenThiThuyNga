<?php
// app/Models/RequestRepository.php
require_once __DIR__ . '/Request.php';

class RequestRepository {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    // Lưu request mới
    public function save(Request $request): ?Request {
        $sql = "INSERT INTO requests (title, description, status, user_id, created_at, updated_at) 
                VALUES (:title, :description, :status, :user_id, :created_at, :updated_at)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':title' => $request->title,
            ':description' => $request->description,
            ':status' => $request->status,
            ':user_id' => $request->user_id,
            ':created_at' => $request->created_at,
            ':updated_at' => $request->updated_at
        ]);
        
        $request->id = $this->db->lastInsertId();
        return $request;
    }
    
    // Tìm request theo ID
    public function find($id): ?Request {
        $sql = "SELECT * FROM requests WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        
        return $data ? Request::fromArray($data) : null;
    }
    
    // Lấy tất cả request (cho staff)
    public function all(): array {
        $sql = "SELECT * FROM requests ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        $requests = [];
        
        while ($row = $stmt->fetch()) {
            $requests[] = Request::fromArray($row);
        }
        return $requests;
    }
    
    // Lấy request theo user_id (cho student)
    public function findByUser($user_id): array {
        $sql = "SELECT * FROM requests WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $requests = [];
        
        while ($row = $stmt->fetch()) {
            $requests[] = Request::fromArray($row);
        }
        return $requests;
    }
    
    // Cập nhật status
    public function updateStatus($id, $newStatus): bool {
        $sql = "UPDATE requests SET status = :status, updated_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $newStatus,
            ':id' => $id
        ]);
    }
    
    // Cập nhật toàn bộ request
    public function update(Request $request): bool {
        $sql = "UPDATE requests SET title = :title, description = :description, 
                status = :status, updated_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':title' => $request->title,
            ':description' => $request->description,
            ':status' => $request->status,
            ':id' => $request->id
        ]);
    }
}