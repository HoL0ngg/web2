<!-- Main Content -->
<main class="main-content">
    <header>
        <h1>Quản Lý Đơn Hàng</h1>
    </header>

    <!-- Danh sách đơn hàng -->
    <section class="order-list">
        <table>
            <thead>
                <tr>
                    <th>Mã hóa đơn</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="orderTable">
                <tr>
                    <td>HD001</td>
                    <td>Nguyễn Văn A</td>
                    <td>2025-04-07</td>
                    <td>5,000,000đ</td>
                    <td class="status-cell">
                        <div class="status">Đang chờ</div>
                        <button class="confirm-btn">✅ Xác nhận</button>
                    </td>
                    <td>
                        <button class="detail-btn" data-order-id="HD001">📄 Chi tiết</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
</main>

<style>
    /* Dùng lại các class gốc từ người dùng */

.order-list {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

.order-list table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.order-list th,
.order-list td {
    border: 1px solid #BDC3C7;
    padding: 10px;
    text-align: center;
}

.order-list th {
    background: #3498DB;
    color: white;
}

.order-list td a {
    text-decoration: none;
    color: black;
}

.edit-btn,
.delete-btn-order {
    border: none;
    width: 70px;
    height: 30px;
    cursor: pointer;
    border-radius: 5px;
    border: 1px solid #BDC3C7;
}

.edit-btn {
    background: white;
}

.delete-btn-order {
    background: white;
    color: black;
}

.edit-btn:hover {
    background: #D4AC0D;
}

.delete-btn-order:hover {
    background: #C0392B;
}

/* Nút Xác nhận */
.confirm-btn {
    background: #2980B9;
    color: white;
    border: none;
    width: 100px;
    height: 30px;
    border-radius: 5px;
    cursor: pointer;
}

.confirm-btn:hover {
    background: #1F618D;
}


</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Xử lý nút xác nhận đơn hàng
        const confirmButtons = document.querySelectorAll('.confirm-btn');

        confirmButtons.forEach(button => {
            button.addEventListener('click', function () {
                const statusDiv = this.closest('.status-cell').querySelector('.status');
                const currentStatus = statusDiv.textContent.trim();

                if (currentStatus === 'Đang chờ') {
                    statusDiv.textContent = 'Đang xử lý';
                } else if (currentStatus === 'Đang xử lý') {
                    statusDiv.textContent = 'Đã xử lý';
                    this.disabled = true;
                    this.style.opacity = '0.6';
                    this.textContent = '✔️ Xong';
                }
            });
        });

        // Xử lý nút xem chi tiết
        const detailButtons = document.querySelectorAll('.detail-btn');

        detailButtons.forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-order-id');
                alert("Hiển thị chi tiết cho đơn hàng: " + orderId);
                // Ở đây có thể mở modal hoặc fetch chi tiết bằng Ajax nếu bạn muốn
            });
        });
    });
</script>


