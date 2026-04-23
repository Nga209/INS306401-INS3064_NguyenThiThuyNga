<?php
// app/Models/Request.php
class Request {
    public $id;
    public $title;
    public $description;
    public $status;
    public $user_id;
    public $created_at;
    public $updated_at;
    
    // Danh sách trạng thái hợp lệ
    public static $validStatuses = ['Pending', 'In Progress', 'Done'];
    
    public function __construct($title = '', $description = '', $user_id = 0) {
        $this->title = $title;
        $this->description = $description;
        $this->user_id = $user_id;
        $this->status = 'Pending';
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
    
    // Chuyển từ mảng dữ liệu (database) thành object Request
    public static function fromArray($data) {
        $request = new Request();
        $request->id = $data['id'] ?? null;
        $request->title = $data['title'] ?? '';
        $request->description = $data['description'] ?? '';
        $request->status = $data['status'] ?? 'Pending';
        $request->user_id = $data['user_id'] ?? 0;
        $request->created_at = $data['created_at'] ?? '';
        $request->updated_at = $data['updated_at'] ?? '';
        return $request;
    }
}