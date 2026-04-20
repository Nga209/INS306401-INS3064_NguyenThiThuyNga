<?php
// public/index.php - Front Controller (điểm vào duy nhất của ứng dụng)
session_start();

// Autoload đơn giản (tự động include file khi cần)
spl_autoload_register(function ($class_name) {
    $paths = [
        __DIR__ . '/../app/Models/',
        __DIR__ . '/../app/Controllers/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Kết nối database
require_once __DIR__ . '/../config/database.php';
$db = Database::getInstance()->getConnection();

// Khởi tạo các service và repository
$requestRepository = new RequestRepository($db);
$requestValidator = new RequestValidator();
$requestService = new RequestService($requestRepository, $requestValidator, $db);
$authService = new AuthService($db);

// Khởi tạo controllers
$requestController = new RequestController($requestService, $authService);
$authController = new AuthController($authService);

// Lấy action từ URL
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Routing
try {
    switch ($action) {
        case 'index':
            $requestController->index();
            break;
            
        case 'create':
            $requestController->create();
            break;
            
        case 'store':
            $requestController->store();
            break;
            
        case 'show':
            if ($id) {
                $requestController->show($id);
            } else {
                header('Location: /index.php?action=index');
            }
            break;
            
        case 'updateStatus':
            if ($id) {
                $requestController->updateStatus($id);
            } else {
                header('Location: /index.php?action=index');
            }
            break;
            
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->login();
            } else {
                $authController->showLogin();
            }
            break;
            
        case 'logout':
            $authController->logout();
            break;
            
        default:
            header('Location: /index.php?action=index');
            break;
    }
} catch (Exception $e) {
    die("Lỗi: " . $e->getMessage());
}
?>