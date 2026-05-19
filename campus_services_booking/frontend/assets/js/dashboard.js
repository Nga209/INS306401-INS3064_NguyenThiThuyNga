async function taiThongKeDashboard() {
    try {
        // 1. Kiểm tra quyền Admin trước khi gọi API (Sử dụng hàm từ auth.js)
        const user = layUser();
        const role = user ? user.role : null;
        
        if (role !== 'admin' && role !== 'teacher') {
            alert("Bạn không có quyền truy cập trang này!");
            window.location.href = '../index/index.html';
            return;
        }

        // 2. Gọi đến API báo cáo/thống kê ở Backend
        const thongKe = await goiApi('/admin/stats'); 
        
        if (thongKe.status === 'success') {
            const data = thongKe.data;
            // Cập nhật các con số tổng quát
            document.getElementById('tong-don-dat').innerText = data.overview.total_bookings;
            document.getElementById('don-cho-duyet').innerText = data.overview.pending_requests;
            document.getElementById('so-tai-nguyen').innerText = data.overview.approved_requests; // Đổi thành Đơn đã duyệt cho ý nghĩa

            const recentList = document.getElementById('recent-activity-list');
            if (recentList && data.recent_activity) {
                if (data.recent_activity.length === 0) {
                    recentList.innerHTML = '<p style="text-align: center; color: #94a3b8; padding: 20px;">Chưa có hoạt động nào.</p>';
                    return;
                }

                recentList.innerHTML = data.recent_activity.map(act => {
                    const name = act.booked_for_name || act.fullname || 'User';
                    const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random&color=fff`;
                    const statusClass = act.status === 'pending' ? 'bg-warning-light' : (act.status === 'approved' ? 'bg-success-light' : 'bg-danger-light');
                    const statusText = act.status === 'pending' ? 'Mới' : (act.status === 'approved' ? 'Đã duyệt' : 'Từ chối');
                    
                    return `
                        <div class="activity-item">
                            <img src="${avatarUrl}" class="user-circle">
                            <div class="act-info">
                                <p><strong>${name}</strong> đặt ${act.resource_name}</p>
                                <span>${new Date(act.created_at).toLocaleString('vi-VN')}</span>
                            </div>
                            <span class="badge ${statusClass}">${statusText}</span>
                        </div>
                    `;
                }).join('');
            }
        } else {
            console.error("Lỗi lấy thống kê:", thongKe.message);
        }
    } catch (error) {
        console.error("Lỗi kết nối hệ thống:", error);
    }
}

// 3. Kết nối Real-time SSE để cập nhật dưới 1 giây
function ketNoiRealtime() {
    const sseSource = new EventSource(`${DUONG_DAN_GOC}/sse/updates`, { withCredentials: true });

    sseSource.addEventListener('update', (e) => {
        console.log("⚡ Nhận tín hiệu cập nhật Real-time:", e.data);
        taiThongKeDashboard();
    });

    sseSource.onerror = () => {
        console.warn("Mất kết nối SSE, đang thử kết nối lại...");
        sseSource.close();
        setTimeout(ketNoiRealtime, 3000); // Thử lại sau 3 giây nếu lỗi
    };
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.includes('dashboard.html')) {
        taiThongKeDashboard();
        ketNoiRealtime();
    }
});