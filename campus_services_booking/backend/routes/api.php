<?php

// 1. NHÓM TEST & DEBUG
$router->get('/', function () {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Backend is running! Thử truy cập /test-db xem sao.']);
});

$router->get('/test-db', function () {
    header('Content-Type: application/json');
    try {
        $db = new Database();
        $conn = $db->connect(); 
        $stmt = $conn->query("SELECT COUNT(*) AS total_users FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode([
            'status' => 'success', 
            'message' => 'Kết nối database thành công!',
            'total_users' => $result['total_users']
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Lỗi kết nối: ' . $e->getMessage()
        ]);
    }
});

// 2. CHỨC NĂNG ĐẶT CHỖ (BOOKINGS)
$router->get('/available-slots', 'BookingController@getAvailableSlots');
$router->post('/bookings', 'BookingController@store');
$router->get('/my-bookings', 'BookingController@myBookings'); 

// 3. XÁC THỰC (AUTH)
$router->post('/login', 'AuthController@login');
$router->get('/users', 'UserController@index');

// 4. TÀI NGUYÊN & KHUNG GIỜ (RESOURCES & TIME SLOTS)
$router->get('/resources', 'ResourceController@getAll');
$router->get('/time-slots', 'TimeSlotController@index');

// 5. ADMIN & BÁO CÁO
$router->get('/approvals', 'ApprovalController@index');
$router->post('/bookings/approve', 'ApprovalController@approve');
$router->get('/admin/stats', 'ReportController@getSummary');
$router->get('/reports/summary', 'ReportController@getSummary');

// 6. REAL-TIME (SSE)
$router->get('/sse/updates', 'SSEController@stream');