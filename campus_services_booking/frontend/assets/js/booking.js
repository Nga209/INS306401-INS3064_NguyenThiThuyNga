/**
 * File: frontend/assets/js/booking.js
 */

let allResources = []; // Lưu trữ cache để tìm kiếm/lọc nhanh

document.addEventListener('DOMContentLoaded', async () => {
    // Tải lần đầu
    await hienThiDanhSachPhong();
    await taiDanhSachCa();

    // Thêm listener cho tìm kiếm
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            renderResources(filterResources(e.target.value, 'all'));
        });
    }

    // Tự động cập nhật mỗi 30 giây
    setInterval(async () => {
        if (window.location.pathname.includes('resources.html')) {
            await hienThiDanhSachPhong();
        }
    }, 30000);
});

async function hienThiDanhSachPhong() {
    const ketQua = await goiApi('/resources', 'GET');
    if (ketQua.status === 'success') {
        allResources = ketQua.data;
        renderResources(allResources);
    } else {
        const container = document.getElementById('resource-list');
        if (container) container.innerHTML = `<p style="color:red;">Lỗi kết nối: ${ketQua.message}</p>`;
    }
}

function renderResources(danhSach) {
    const container = document.getElementById('resource-list');
    if (!container) return;

    if (danhSach.length === 0) {
        container.innerHTML = '<p style="text-align: center; grid-column: 1/-1; padding: 50px; color: #64748b;">Không tìm thấy không gian nào khớp với yêu cầu.</p>';
        return;
    }

    container.innerHTML = danhSach.map(item => {
        let icon = 'fas fa-laptop-code';
        let iconClass = 'icon-blue';
        const nameLower = item.name.toLowerCase();
        
        if (nameLower.includes('sân')) {
            icon = 'fas fa-futbol';
            iconClass = 'icon-green';
        }
        else if (nameLower.includes('hội trường') || nameLower.includes('họp')) {
            icon = 'fas fa-users';
            iconClass = 'icon-purple';
        }
        else if (nameLower.includes('studio') || nameLower.includes('media')) {
            icon = 'fas fa-camera-retro';
            iconClass = 'icon-purple';
        }
        else if (nameLower.includes('máy')) {
            icon = 'fas fa-desktop';
            iconClass = 'icon-blue';
        }
        else if (nameLower.includes('tự học') || nameLower.includes('nhóm')) {
            icon = 'fas fa-book-reader';
            iconClass = 'icon-blue';
        }

        const statusClass = item.is_available == 1 ? 'status-available' : 'status-busy';
        const statusText = item.is_available == 1 ? 'Sẵn sàng' : 'Đang bận';

        return `
            <div class="f-card resource-card">
                <div class="status-badge ${statusClass}">
                    <i class="fas fa-circle" style="font-size: 8px;"></i> ${statusText}
                </div>
                
                <div class="resource-icon-v2 ${iconClass}">
                    <i class="${icon}"></i>
                </div>
                
                <h3 style="text-align: left; margin-bottom: 20px;">${item.name}</h3>
                
                <div class="resource-details">
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="detail-label">Vị trí</span>
                        <span class="detail-value">${item.location}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-users"></i>
                        <span class="detail-label">Sức chứa</span>
                        <span class="detail-value">${item.capacity} người</span>
                    </div>
                </div>

                <button class="btn-confirm" 
                        onclick="moModalDatPhong(${item.id}, '${item.name}')"
                        ${item.is_available == 0 ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : ''}>
                    ${item.is_available == 1 ? 'Đặt Chỗ Ngay' : 'Hết chỗ'}
                </button>
            </div>
        `;
    }).join('');
}

function filterResources(keyword, category) {
    return allResources.filter(item => {
        const matchKeyword = item.name.toLowerCase().includes(keyword.toLowerCase()) || 
                           item.location.toLowerCase().includes(keyword.toLowerCase());
        
        let matchCategory = false;
        const nameLower = item.name.toLowerCase();
        
        if (category === 'all') {
            matchCategory = true;
        } else if (category === 'Phòng tự học nhóm' && (nameLower.includes('tự học') || nameLower.includes('nhóm') || nameLower.includes('thảo luận'))) {
            matchCategory = true;
        } else if (category === 'Sân bóng đá' && nameLower.includes('sân')) {
            matchCategory = true;
        } else if (category === 'Phòng máy tính' && nameLower.includes('máy')) {
            matchCategory = true;
        } else if (category === 'Hội trường/Phòng họp' && (nameLower.includes('hội trường') || nameLower.includes('họp'))) {
            matchCategory = true;
        } else if (category === 'Phòng Studio/Media' && (nameLower.includes('studio') || nameLower.includes('media'))) {
            matchCategory = true;
        }

        return matchKeyword && matchCategory;
    });
}

function filterByCategory(category, btn) {
    // Update UI buttons
    document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const keyword = document.getElementById('search-input')?.value || '';
    renderResources(filterResources(keyword, category));
}

async function taiDanhSachCa() {
    const selectSlot = document.getElementById('select-slot');
    if (!selectSlot) return;

    const ketQua = await goiApi('/time-slots', 'GET');
    if (ketQua.status === 'success') {
        const danhSach = ketQua.data;
        selectSlot.innerHTML = danhSach.map(ca => {
            const timeStr = ca.start_time.substring(0, 5) + ' - ' + ca.end_time.substring(0, 5);
            return `<option value="${ca.id}">${ca.label} (${timeStr})</option>`;
        }).join('');
    }
}

function moModalDatPhong(id, tenPhong) {
    const modal = document.getElementById('booking-modal');
    if (modal) {
        document.getElementById('modal-title').innerText = "Đặt lịch: " + tenPhong;
        document.getElementById('target-resource-id').value = id;
        modal.style.display = 'block';
    }
}

function dongModal() {
    const modal = document.getElementById('booking-modal');
    if (modal) modal.style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('booking-modal');
    if (event.target == modal) {
        dongModal();
    }
}

const formDatCho = document.getElementById('form-dat-cho');
if (formDatCho) {
    formDatCho.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const resourceId = document.getElementById('target-resource-id').value;
        const bookingDate = document.getElementById('input-date').value;
        const slotId = document.getElementById('select-slot').value;
        const bookedForName = document.getElementById('input-booked-name').value;

        const user = layUser();
        if (!user) {
            showToast("Vui lòng đăng nhập để đặt phòng!", "error");
            return;
        }

        const data = {
            resource_id: resourceId,
            booking_date: bookingDate,
            slot_id: slotId,
            user_id: user.id,
            booked_for_name: bookedForName,
            reason: "Đặt lịch học tập/sinh hoạt"
        };

        const response = await goiApi('/bookings', 'POST', data);
        if (response.status === 'success') {
            showToast("Đã gửi yêu cầu đặt chỗ thành công! Vui lòng chờ phê duyệt.");
            dongModal();
            formDatCho.reset();
            await hienThiDanhSachPhong();
        } else {
            showToast("Lỗi: " + response.message, "error");
        }
    });
}