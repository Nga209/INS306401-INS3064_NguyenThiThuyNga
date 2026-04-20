<?php
// app/Models/RequestService.php
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/RequestRepository.php';
require_once __DIR__ . '/RequestValidator.php';

class RequestService {
    private $repository;
    private $validator;
    private $db;
    
    public function __construct(RequestRepository $repo, RequestValidator $val, $pdo) {
        $this->repository = $repo;
        $this->validator = $val;
        $this->db = $pdo;
    }
    
    // Tạo request mới
    public function createRequest($title, $description, $user_id): ?Request {
        // 1. Validate dữ liệu
        $errors = $this->validator->validateAll($title, $description);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            return null;
        }
        
        // 2. Tạo Request object
        $request = new Request($title, $description, $user_id);
        
        // 3. Lưu vào database
        return $this->repository->save($request);
    }
    
    // Đổi trạng thái (có kiểm tra logic)
    public function changeStatus($id, $newStatus, $changedBy): bool {
        // 1. Tìm request
        $request = $this->repository->find($id);
        if (!$request) return false;
        
        $oldStatus = $request->status;
        
        // 2. Kiểm tra logic: không thể từ Done về Pending
        if ($oldStatus == 'Done' && $newStatus == 'Pending') {
            $_SESSION['errors'] = ['Không thể chuyển từ Done về Pending'];
            return false;
        }
        
        // 3. Kiểm tra trạng thái hợp lệ
        if (!$this->validator->validateStatus($newStatus)) {
            $_SESSION['errors'] = ['Trạng thái không hợp lệ'];
            return false;
        }
        
        // 4. Cập nhật
        $result = $this->repository->updateStatus($id, $newStatus);
        
        // 5. Ghi log nếu thành công
        if ($result) {
            $this->logStatusChange($id, $oldStatus, $newStatus, $changedBy);
        }
        
        return $result;
    }
    
    // Ghi log lịch sử thay đổi
    private function logStatusChange($request_id, $oldStatus, $newStatus, $changedBy) {
        $sql = "INSERT INTO request_logs (request_id, old_status, new_status, changed_by) 
                VALUES (:request_id, :old_status, :new_status, :changed_by)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':request_id' => $request_id,
            ':old_status' => $oldStatus,
            ':new_status' => $newStatus,
            ':changed_by' => $changedBy
        ]);
    }
    
    // Lấy request theo user (có phân quyền)
    public function getRequestsForUser($user_id, $isStaff = false): array {
        if ($isStaff) {
            return $this->repository->all();
        } else {
            return $this->repository->findByUser($user_id);
        }
    }
    
    // Lấy chi tiết request kèm quyền
    public function getRequestDetail($id, $current_user_id, $isStaff): ?Request {
        $request = $this->repository->find($id);
        
        if (!$request) return null;
        
        // Kiểm tra quyền: staff được xem tất cả, student chỉ xem của mình
        if (!$isStaff && $request->user_id != $current_user_id) {
            return null;
        }
        
        return $request;
    }
}