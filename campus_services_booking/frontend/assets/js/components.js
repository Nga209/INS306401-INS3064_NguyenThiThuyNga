/* ================================================================
   FILE: components.js - QUẢN LÝ COMPONENT VÀ UI UTILITIES
   ================================================================ */

// 1. Hàm nạp Sidebar dùng chung
async function loadSidebar(activeId) {
    try {
        const response = await fetch('../components/sidebar.html');
        const html = await response.text();
        
        // Tìm container sidebar cũ hoặc chèn vào vị trí phù hợp
        let sidebarWrapper = document.getElementById('sidebar-wrapper');
        if (!sidebarWrapper) {
            sidebarWrapper = document.createElement('div');
            sidebarWrapper.id = 'sidebar-wrapper';
            document.body.prepend(sidebarWrapper);
        }
        sidebarWrapper.innerHTML = html;

        // Đánh dấu menu đang hoạt động
        if (activeId) {
            const menus = document.querySelectorAll('.sidebar-menu a');
            menus.forEach(menu => {
                if (menu.id === `menu-${activeId}` || menu.getAttribute('href').includes(activeId)) {
                    menu.classList.add('active');
                }
            });
        }
        
        // Ẩn các menu không dành cho user
        const user = typeof layUser === 'function' ? layUser() : null;
        if (user && user.role === 'user') {
            const menuDashboard = document.getElementById('menu-dashboard');
            const menuApprovals = document.getElementById('menu-approvals');
            const menuReports = document.getElementById('menu-reports');
            if (menuDashboard) menuDashboard.style.display = 'none';
            if (menuApprovals) menuApprovals.style.display = 'none';
            if (menuReports) menuReports.style.display = 'none';
        }
    } catch (error) {
        console.error("Không thể tải Sidebar:", error);
    }
}

// 2. Hệ thống thông báo Toast chuyên nghiệp
window.showToast = function(message, type = 'success') {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <i class="fas ${icon}" style="color: ${type === 'success' ? '#10b981' : '#ef4444'}"></i>
        <span style="font-weight: 500; color: #1e293b;">${message}</span>
    `;

    container.appendChild(toast);

    // Tự động xóa sau 3 giây
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        toast.style.transition = '0.5s';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
};

// Ghi đè hàm alert mặc định bằng Toast cho xịn
// window.alert = (msg) => showToast(msg, 'info');
