    <?php
    require_once './handles/CustomerController.php';
    require_once './handles/AddressController.php';
    require_once './handles/DetailOrderController.php';
    require_once './handles/CustomerController.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- Gọi file CSS -->
        <link rel="stylesheet" href="css/admin_order.css">
    </head>

    <body>
        <main class="main-content">
            <header>
                <h1>Quản Lý Đơn Hàng</h1>
            </header>
            <div class="filter-form">
                <div class="filter-form_input">

                    <label>Ngày từ:
                        <input type="date" id="fromDate">
                    </label>
    
                    <label>đến:
                        <input type="date" id="toDate">
                    </label>
    
                    <!-- ------------ -->
    
                    <label>Khách hàng:
                        <select id="customerId">
                            <option value="">Tất cả</option>
                            <?php
                            $CustomerController = new CustomerController();
                            $khachhangs = $CustomerController->getAllKhachHang();
                            foreach ($khachhangs as $khachhang):
                            ?>
                                <option value="<?= $khachhang['customer_id'] ?>"><?= $khachhang['customer_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
    
                    <label>Trạng thái:
                        <select id="orderStatus">
                            <option value="">Tất cả</option>
                            <option value="processing">processing</option>
                            <option value="shipping">shipping</option>
                            <option value="delivered">delivered</option>
                            <option value="cancelled">cancelled</option>
                        </select>
                    </label>
                </div>
                <div class="filter-form_button">
                    <button onclick="filterOrders()">Lọc</button>
                    <button onclick="refreshOrders()">Làm mới</button>
                </div>

            </div>

            <!-- Danh sách đơn hàng -->
            <section class="order-list">
                <table>
                    <thead>
                        <tr>
                            <th>Mã hóa đơn</th>
                            <th>Khách hàng</th>
                            <th>SĐT</th>
                            <th>Địa chỉ</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                            <th>Hủy đơn</th>
                        </tr>
                    </thead>
                    <tbody id="orderTable">
                        <?php
                        foreach ($orders as $order):
                            $CustomerController = new CustomerController();
                            $AddressController = new AddressController();
                            $name = $CustomerController->getNameCustomerByID($order['customer_id']);
                            $phone = $CustomerController->getPhoneCustomerByID($order['customer_id']);
                            $address = $AddressController->getAddressByID($order['address_id']);
                        ?>
                            <tr>
                                <td><?= $order['order_id'] ?></td>
                                <td><?= $name ?></td>
                                <td><?= $phone ?></td>
                                <td><?= $address ?></td>
                                <td><?= $order['orderDate'] ?></td>
                                <td><?= $order['total'] ?></td>
                                <td class="status-cell" data-order-id="<?= $order['order_id'] ?>">
                                    <?php
                                    // Định nghĩa màu nền và kiểu dáng cho từng trạng thái
                                    $statusStyles = [
                                        'processing' => 'background-color: rgba(218, 174, 0, 0.7); color: #fff;', // Vàng mờ
                                        'shipping' => 'background-color: rgba(41, 128, 185, 0.7); color: #fff;', // Xanh nước biển mờ
                                        'delivered' => 'background-color: rgba(39, 174, 96, 0.7); color: #fff;', // Xanh lá mờ
                                        'cancelled' => 'background-color: rgba(192, 57, 43, 0.7); color: #fff;' // Đỏ mờ
                                    ];
                                    // Lấy kiểu dáng tương ứng với trạng thái, mặc định là nền xám nếu trạng thái không hợp lệ
                                    $style = isset($statusStyles[$order['status']]) ? $statusStyles[$order['status']] : 'background-color: rgba(0, 0, 0, 0.2); color: #fff;';
                                    ?>
                                    <div class="status" style="display: inline-block; padding: 4px 8px; font-size: 14px; border-radius: 6px; <?= $style ?>"><?= $order['status'] ?></div>
                                    <?php if ($order['status'] === 'processing' || $order['status'] === 'shipping'): ?>
                                        <button class="confirm-btn">✅ Xác nhận</button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="detail-btn" onclick="showOrderDetail(this)" value="<?= $order['order_id'] ?> | <?= $customer['customer_name'] ?> | <?= $order['status'] ?>">📄 Chi tiết</button>
                                </td>
                                <td>
                                    <button class="cancel-btn">❌ Hủy đơn </button>
                                </td>
                            </tr>
                        <?php endforeach;
                        ?>
                    </tbody>
                </table>
            </section>


            <div id="order-detail-popup">
                <div id="order-detail-content">
                    <h2>Chi tiết đơn hàng</h2>
                    <table id="detail-table">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <button id="close-btn" onclick="hideOrderDetail()">Đóng</button>
                </div>
            </div>

        </main>


        <script>
            function cancelOrder() {
                const cancelButtons = document.querySelectorAll('.cancel-btn');
                cancelButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const row = this.closest('tr');
                        const confirmBtn = row.querySelector('.confirm-btn'); // lấy nút xác nhận trong cùng dòng
                        const statusCell = row.querySelector('.status-cell');
                        const orderId = statusCell.dataset.orderId;
                        const currentStatus = statusCell.querySelector('.status').innerText.trim();
                        let newStatus = "cancelled";
                        if (currentStatus === 'shipping' || currentStatus === 'delivered') {
                            showToast('Đơn hàng đã được xử lý không thể hủy');
                            return;
                        }
                        if (currentStatus === 'cancelled') {
                            showToast('Đơn hàng đã được hủy');
                            return;
                        }
                        if (confirm("xác nhận đơn hàng")) {
                            fetch('change_status_order.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `order_id=${orderId}&status=${newStatus}`
                                })
                                .then(res => res.text())
                                .then(data => {
                                    statusCell.querySelector('.status').innerText = newStatus;
                                    if (newStatus === 'delivered' || newStatus === "cancelled") {
                                        confirmBtn.style.display = 'none';
                                    }
                                    showToast("Thay đổi thành công", true);
                                })
                        }
                    });

                });
            }

            function confirmOrder() {
                const confirmButtons = document.querySelectorAll('.confirm-btn');

                confirmButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const statusCell = this.closest('.status-cell');
                        const orderId = statusCell.dataset.orderId;
                        const currentStatus = statusCell.querySelector('.status').innerText.trim();

                        let newStatus = "";
                        if (currentStatus === 'processing') newStatus = 'shipping';
                        else if (currentStatus === 'shipping') newStatus = 'delivered';
                        else return;

                        if (confirm("xác nhận đơn hàng")) {
                            fetch('change_status_order.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `order_id=${orderId}&status=${newStatus}`
                                })
                                .then(res => res.text())
                                .then(data => {
                                    statusCell.querySelector('.status').innerText = newStatus;
                                    if (newStatus === 'delivered') {
                                        this.style.display = 'none';

                                    }
                                    showToast("Thay đổi thành công", true);
                                })
                        }
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Xử lý nút xác nhận đơn hàng

                confirmOrder();
                cancelOrder();


            });

            function filterOrders() {
                const from = document.getElementById('fromDate').value;
                const to = document.getElementById('toDate').value;
                const customerId = document.getElementById('customerId').value;
                const status = document.getElementById('orderStatus').value;

                const formData = new URLSearchParams();
                formData.append('from', from);
                formData.append('to', to);
                formData.append('customerId', customerId);
                formData.append('status', status);

                fetch('get_filter_order.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: formData.toString()
                    })
                    .then(res => res.text())
                    .then(data => {
                        const tbody = document.getElementById('orderTable');
                        tbody.innerHTML = data;
                        confirmOrder();
                        cancelOrder();
                    })
                    .catch(error => {
                        console.error("Lỗi khi lọc đơn hàng:", error);
                    });
            }

            function refreshOrders() {
                document.getElementById('fromDate').value = "";
                document.getElementById('toDate').value = "";
                document.getElementById('customerId').selectedIndex = 0;
                document.getElementById('orderStatus').selectedIndex = 0;
                filterOrders();
            }
        </script>


    </body>

    </html>