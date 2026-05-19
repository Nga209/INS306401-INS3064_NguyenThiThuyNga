<?php

class BookingService {
    private $repo;
    private $policy;

    public function __construct() {
        $this->repo = new BookingRepository();
        $this->policy = new PolicyService();
    }

    public function makeBooking($data) {
        // 1. Kiểm tra các quy tắc chính sách (Ngày, Giờ cao điểm, Giới hạn tuần)
        $valid = $this->policy->validateBooking($data);
        if ($valid !== true) {
            return ['status' => 'error', 'message' => $valid];
        }

        // 2. Check trùng ca
        if (!$this->repo->isRoomAvailable(
            $data['resource_id'], 
            $data['booking_date'], 
            $data['slot_id']
        )) {
            return ['status' => 'error', 'message' => 'Ca này đã có người đặt'];
        }

        // 3. Xác định trạng thái ban đầu (Cần duyệt hay Tự động duyệt)
        $requiresApproval = $this->policy->requiresApproval($data['resource_id'], $data['user_id']);
        $data['status'] = $requiresApproval ? 'pending' : 'approved';

        // 4. Lưu Database
        if ($this->repo->create($data)) {
            $msg = $requiresApproval ? 'Đã gửi yêu cầu đặt chỗ (Chờ phê duyệt)' : 'Đặt chỗ thành công';
            return ['status' => 'success', 'message' => $msg];
        }

        return ['status' => 'error', 'message' => 'Lỗi hệ thống khi lưu đơn'];
    }
}