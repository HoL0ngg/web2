    <?php
    require_once './handles/CustomerController.php';
    require_once './handles/AddressController.php';
    require_once './handles/DetailOrderController.php';
    $funcId = 'donhang';
    $phanquyenController = new PhanQuyenController();
    $canUpdate = $phanquyenController->hasPermission($funcId, 'update', $_SESSION['permissions']);
    $canDelete = $phanquyenController->hasPermission($funcId, 'delete', $_SESSION['permissions']);
    $canAdd = $phanquyenController->hasPermission($funcId, 'create', $_SESSION['permissions']);

    ?>
    <script src="./js/customer-info.js"></script>

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
            <header  id="header">
                <h1>Quản Lý Đơn Hàng</h1>
                <div class="search-box">
                        <input type="text" id="search-input" placeholder="Nhập tên khách hàng cần tìm">
                        <button onclick="filterOrders()" class="search-btn">🔍</button>
                </div>    
            </header>
            <div class="filter-form">
                <div class="filter-form_input">

                    <label>Ngày từ:
                        <input type="date" id="fromDate">
                    </label>
    
                    <label>đến:
                        <input type="date" id="toDate">
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
                    <label>Thành Phố-Tỉnh:
                        <select name="thanhpho" id="thanhpho">
                            <option value="">Chọn thành phố/tỉnh</option>
                        </select>
                    </label>
                    <label>Quận-Huyện:
                        <select name="quan" id="quan">
                            <option value="">Chọn quận/huyện</option>
                        </select>
                    </label>
                    <label>Phường-Xã
                        <select name="phuong" id="phuong">
                            <option value="">Chọn phường/xã</option>
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
                            $AddressController = new AddressController();
                            $name = $order['customer_recipient_name'];
                            $phone = $order['phone'];
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
                                    <?php if ($canUpdate && ($order['status'] === 'processing' || $order['status'] === 'shipping')): ?>
                                        <button class="confirm-btn">✅ Xác nhận</button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="detail-btn" onclick="showOrderDetail(this)" value="<?= $order['order_id'] ?> | <?= $customer['customer_name'] ?> | <?= $order['status'] ?>">📄 Chi tiết</button>
                                </td>
                                <td>
                                    <?php if ($canUpdate): ?>
                                        <button class="cancel-btn">❌ Hủy đơn </button>
                                    <?php endif; ?> 
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
                        Swal.fire({
                            title: "Thông báo",
                            text: "Xác nhận hủy đơn hàng!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#3085d6",
                            confirmButtonText: "Có",
                            cancelButtonText: "Không"
                        }).then((result) => {
                                if (result.isConfirmed) {
                                    fetch('change_status_order.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded'
                                            },
                                            body: `order_id=${orderId}&status=${newStatus}`
                                        })
                                        .then(res => res.text())
                                        .then(data => {
                                            const statusElement = statusCell.querySelector('.status');
                                            statusElement.innerText = newStatus;

                                            const statusStyles = {
                                                'processing': 'background-color: rgba(218, 174, 0, 0.7); color: #fff; ',
                                                'shipping': 'background-color: rgba(41, 128, 185, 0.7); color: #fff;',
                                                'delivered': 'background-color: rgba(39, 174, 96, 0.7); color: #fff;',
                                                'cancelled': 'background-color: rgba(192, 57, 43, 0.7); color: #fff;'
                                            };

                                            // Update the style based on newStatus
                                            statusElement.style.cssText =  statusStyles[newStatus] + ';display: inline-block; padding: 4px 8px; font-size: 14px; border-radius: 6px;' || 'background-color: rgba(0, 0, 0, 0.2); color: #fff;';

                                            if (newStatus === 'delivered' || newStatus === "cancelled") {
                                                confirmBtn.style.display = 'none';
                                            }
                                            showToast("Thay đổi thành công", true);
                                            // statusCell.querySelector('.status').innerText = newStatus;
                                            
                                            // if (newStatus === 'delivered' || newStatus === "cancelled") {
                                            //     confirmBtn.style.display = 'none';
                                            // }
                                            // showToast("Thay đổi thành công", true);
                                        })
                                }
                        })
                    });

                });
            }

            function confirmOrder() {
                const confirmButtons = document.querySelectorAll('.confirm-btn');

                confirmButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        console.log("Confirm button clicked");
                        // const row = this.closest('tr');
                        const statusCell = this.closest('.status-cell');
                        const confirmBtn = this.closest('.confirm-btn'); // lấy nút xác nhận trong cùng dòng
                        const orderId = statusCell.dataset.orderId;
                        const currentStatus = statusCell.querySelector('.status').innerText.trim();

                        console.log("Current status: " + currentStatus);
                    
                        let newStatus = "";
                        if (currentStatus === 'processing') newStatus = 'shipping';
                        else if (currentStatus === 'shipping') newStatus = 'delivered';
                        else return;

                        console.log("New status: " + newStatus);

                        Swal.fire({
                            title: "Thông báo",
                            text: "Xác nhận đơn hàng?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#3085d6",
                            confirmButtonText: "Có",
                            cancelButtonText: "Không"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch('change_status_order.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: `order_id=${orderId}&status=${newStatus}`
                                })
                                .then(res => res.text())
                                .then(data => {

                                    console.log("After confirmed: New status: " + newStatus);
                                    const statusElement = statusCell.querySelector('.status');
                                    statusElement.innerText = newStatus;

                                    const statusStyles = {
                                        'processing': 'background-color: rgba(218, 174, 0, 0.7); color: #fff;',
                                        'shipping': 'background-color: rgba(41, 128, 185, 0.7); color: #fff;',
                                        'delivered': 'background-color: rgba(39, 174, 96, 0.7); color: #fff;',
                                        'cancelled': 'background-color: rgba(192, 57, 43, 0.7); color: #fff;'
                                    };

                                    // Update the style based on newStatus
                                    statusElement.style.cssText = statusStyles[newStatus] + ';display: inline-block; padding: 4px 8px; font-size: 14px; border-radius: 6px;' || 'background-color: rgba(0, 0, 0, 0.2); color: #fff;';
                                    if (newStatus === 'delivered' || newStatus === "cancelled") {
                                        confirmBtn.style.display = 'none';
                                    }
                                    showToast("Thay đổi thành công", true);

                                });
                            }
                        })
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Xử lý nút xác nhận đơn hàng

                confirmOrder();
                cancelOrder();
                document.getElementById("search-input").addEventListener("keyup", () => filterOrders());


            });

            function filterOrders() {
                const from = document.getElementById('fromDate').value;
                const to = document.getElementById('toDate').value;
                const status = document.getElementById('orderStatus').value;
                const thanhpho = document.getElementById('thanhpho').value
                const quan = document.getElementById('quan').value
                const phuong = document.getElementById('phuong').value
                const keyword = document.getElementById("search-input").value.trim();


                const formData = new URLSearchParams();
                formData.append('from', from);
                formData.append('to', to);
                formData.append('keyword', keyword);
                formData.append('status', status);
                formData.append('thanhpho', thanhpho);
                formData.append('quan', quan);
                formData.append('phuong', phuong);

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
                document.getElementById('search-input').value = "";
                document.getElementById('orderStatus').selectedIndex = 0;
                document.getElementById('thanhpho').value = "";
                document.getElementById('quan').value = "";
                document.getElementById('phuong').value = "";
                filterOrders();
            }
        </script>


    </body>

    </html>