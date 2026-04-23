<?php
// app/Controllers/RequestController.php
require_once __DIR__ . '/../Models/RequestService.php';
require_once __DIR__ . '/../Models/AuthService.php';

class RequestController {
    private $requestService;
    private $authService;
    
    public function __construct(RequestService $service, AuthService $auth) {
        $this->requestService = $service;
        $this->authService = $auth;
    }
    
    // GET /requests - Xem danh sách
    public function index() {
        // Kiểm tra đăng nhập
        $user = $this->authService->currentUser();
        if (!$user) {
            header('Location: /index.php?action=login');
            return;
        }
        
        // Lấy danh sách request
        $isStaff = $this->authService->isStaff();
        $requests = $this->requestService->getRequestsForUser($user->id, $isStaff);
        
        // Hiển thị view
        require_once __DIR__ . '/../Views/requests/index.php';
    }
    
    // GET /requests/create - Hiển thị form tạo mới
    public function create() {
        if (!$this->authService->isLoggedIn()) {
            header('Location: /index.php?action=login');
            return;
        }
        require_once __DIR__ . '/../Views/requests/create.php';
    }
    
    // POST /requests - Lưu request mới
    public function store() {
        $user = $this->authService->currentUser();
        if (!$user) {
            header('Location: /index.php?action=login');
            return;
        }
        
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        
        $request = $this->requestService->createRequest($title, $description, $user->id);
        
        if ($request) {
            $_SESSION['success'] = "Tạo yêu cầu thành công!";
            header('Location: /index.php?action=show&id=' . $request->id);
        } else {
            header('Location: /index.php?action=create');
        }
    }
    
    // GET /requests/{id} - Xem chi tiết
    public function show($id) {
        $user = $this->authService->currentUser();
        if (!$user) {
            header('Location: /index.php?action=login');
            return;
        }
        
        $isStaff = $this->authService->isStaff();
        $request = $this->requestService->getRequestDetail($id, $user->id, $isStaff);
        
        if (!$request) {
            $_SESSION['errors'] = ['Không tìm thấy yêu cầu hoặc bạn không có quyền xem'];
            header('Location: /index.php?action=index');
            return;
        }
        
        require_once __DIR__ . '/../Views/requests/show.php';
    }
    
    // POST /requests/{id}/status - Cập nhật trạng thái
    public function updateStatus($id) {
        // Kiểm tra quyền (chỉ staff mới được)
        if (!$this->authService->isStaff()) {
            $_SESSION['errors'] = ['Bạn không có quyền thực hiện hành động này'];
            header('Location: /index.php?action=index');
            return;
        }
        
        $user = $this->authService->currentUser();
        $newStatus = $_POST['status'] ?? '';
        
        $success = $this->requestService->changeStatus($id, $newStatus, $user->id);
        
        if ($success) {
            $_SESSION['success'] = "Cập nhật trạng thái thành công!";
        }
        
        header('Location: /index.php?action=show&id=' . $id);
    }
}