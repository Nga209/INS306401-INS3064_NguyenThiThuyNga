/* ================================================================
   FILE: auth.js - QUẢN LÝ ĐĂNG NHẬP VÀ PHÂN QUYỀN TẬP TRUNG
   ================================================================ */

const KEY_USER = 'campus_user';

// Xóa bỏ các key cũ nếu tồn tại để tránh xung đột dữ liệu
const OLD_KEYS = ['user', 'user_role', 'thong_tin_user'];
OLD_KEYS.forEach(key => {
    if (localStorage.getItem(key)) {
        console.warn(`Đang dọn dẹp key cũ: ${key}`);
        localStorage.removeItem(key);
    }
});

console.log("Auth System initialized. Current User:", localStorage.getItem(KEY_USER));

// 1. Hàm đăng nhập (Dùng cho trang login.html)
async function xuLyDangNhap(email, password, role) {
    try {
        const ketQua = await goiApi('/login', 'POST', { email, password, role });
        
        if (ketQua.status === 'success') {
            localStorage.setItem(KEY_USER, JSON.stringify(ketQua.user));
            
            // Điều hướng dựa trên role
            const redirectMap = {
                'admin': 'dashboard.html',
                'teacher': 'dashboard.html',
                'user': '../index/index.html'
            };
            
            window.location.href = redirectMap[ketQua.user.role] || '../index/index.html';
            return { success: true };
        } else {
            return { success: false, message: ketQua.message || 'Sai thông tin đăng nhập' };
        }
    } catch (error) {
        return { success: false, message: 'Lỗi kết nối hệ thống' };
    }
}

// 2. Hàm đăng xuất
function dangXuat() {
    localStorage.removeItem(KEY_USER);
    const path = window.location.pathname;
    
    // Xử lý đường dẫn linh hoạt dựa trên thư mục hiện tại
    if (path.includes('/pages/')) {
        window.location.href = 'login.html';
    } else if (path.includes('/index/')) {
        window.location.href = '../pages/login.html';
    } else {
        window.location.href = 'pages/login.html';
    }
}

// 3. Lấy thông tin user hiện tại
function layUser() {
    const data = localStorage.getItem(KEY_USER);
    return data ? JSON.parse(data) : null;
}

// 4. Bảo vệ trang (Chặn truy cập trái phép)
function baoVeTrang(rolesYeuCau = []) {
    const user = layUser();
    if (!user) {
        // Tìm đường dẫn tới login.html
        const isInsidePages = window.location.pathname.includes('/pages/');
        window.location.href = isInsidePages ? 'login.html' : 'pages/login.html';
        return;
    }
    
    if (rolesYeuCau.length > 0 && !rolesYeuCau.includes(user.role)) {
        alert('Bạn không có quyền truy cập chức năng này!');
        window.location.href = user.role === 'user' ? 'resources.html' : 'dashboard.html';
    }
}

// 5. Cập nhật giao diện Navbar (Dùng cho trang chủ)
function capNhatNavbar() {
    const user = layUser();
    const navRight = document.querySelector('.nav-right');
    if (!navRight) return;

    if (user) {
        const dashboardLink = user.role === 'user' ? '../pages/resources.html' : '../pages/dashboard.html';
        const dashboardText = user.role === 'user' ? `<li><a href="${dashboardLink}">Đặt phòng</a></li>` : `<li><a href="${dashboardLink}">Dashboard</a></li>`;
        
        navRight.innerHTML = `
            <ul class="nav-menu">
                <li><a href="#hero">Trang chủ</a></li>
                ${dashboardText}
                <li class="user-info-nav">
                    <span style="margin-right: 15px; color: #1e293b; font-weight: 600;">
                        <i class="fas fa-user-circle"></i> ${user.fullname || user.username || user.email || 'User'}
                    </span>
                </li>
            </ul>
            <a href="javascript:void(0)" onclick="dangXuat()" class="nav-btn-login" style="background: #ef4444;">Đăng xuất</a>
        `;
    }
}

// Tự động chạy cập nhật navbar nếu đang ở trang chủ
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.main-nav')) {
        capNhatNavbar();
    }
});