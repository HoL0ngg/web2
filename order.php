    <?php
    require_once './handles/EmployeeController.php';
    require_once './handles/AddressController.php';
    require_once './handles/DetailOrderController.php';
    require_once './handles/CustomerController.php';
    ?>
    <main class="main-content">
        <header>
            <h1>Quản Lý Đơn Hàng</h1>
        </header>
    <div class="filter-form">
        <label>Ngày từ:
            <input type="date" id="fromDate">
        </label>

        <label>đến:
            <input type="date" id="toDate">
        </label>

        <label>Khách hàng:
            <select id="customerId">
                <option value="">Tất cả</option>
                <?php
                $CustomerController = new CustomerController();
                $khachhangs = $CustomerController -> getAllKhachHang();
                foreach($khachhangs as $khachhang):
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

        <button onclick="filterOrders()">Lọc</button>
        <button onclick="refreshOrders()">Làm mới</button>
    </div>

        <!-- Danh sách đơn hàng -->
        <section class="order-list">
            <table>
                <thead>
                    <tr>
                        <th>Mã hóa đơn</th>
                        <th>Khách hàng</th>
                        <th>Địa chỉ</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Xem chi tiết</th>
                        <th>Hủy đơn</th>
                    </tr>
                </thead>
                <tbody id="orderTable">
                <?php 
                        foreach($orders as $order):
                            $CustomerController = new CustomerController();
                            $AddressController = new AddressController();
                            $name = $CustomerController->getNameCustomerByID($order['customer_id']);
                            $address = $AddressController->getAddressByID($order['address_id']);
                    ?>
                    <tr>
                        <td><?= $order['order_id'] ?></td>
                        <td><?= $name ?></td>
                        <td><?= $address ?></td>
                        <td><?= $order['orderDate'] ?></td>
                        <td><?= $order['total'] ?></td>
                        <td class="status-cell" data-order-id="<?= $order['order_id'] ?>">
                            <div class="status"><?= $order['status'] ?></div>
                            <?php if ($order['status'] === 'processing' || $order['status'] === 'shipping'): ?>
                                <button class="confirm-btn">✅ Xác nhận</button>
                            <?php endif; ?>
                        </td>
                        <td>    
                            <button onclick="showOrderDetail(this)" value="<?= $order['order_id'] ?>">📄 Chi tiết</button>
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



    <style>
        /* Dùng lại các class gốc từ người dùng */

        #content-wrapper {
        display: block;
    }

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





    /* Chi tiết đơn hàng popup */
    #order-detail-popup {
        position: fixed;
        top: -100%;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: top 0.4s ease;
        z-index: 999;
    }

    #order-detail-popup.show {
        top: 0;
    }

    #order-detail-content {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        width: 600px;
        max-height: 80%;
        overflow-y: auto;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        animation: slideDown 0.4s ease;
    }

    /* Hiệu ứng trượt xuống */
    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    #detail-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    #detail-table th,
    #detail-table td {
        border: 1px solid #BDC3C7;
        padding: 10px;
        text-align: center;
    }

    #detail-table th {
        background: #3498DB;
        color: white;
    }

    #close-btn {
        margin-top: 20px;
        padding: 8px 20px;
        background: #C0392B;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #close-btn:hover {
        background: #A93226;
    }



 .filter-form {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.filter-form label {
    display: flex;
    /* align-items: center; */
    justify-content: space-around;
    font-weight: bold;
}
.filter-form button{
    margin-top: 15px;
    height: 35px;
    width:100px;
    cursor: pointer;
    background-color: #3498DB;
    border: none;
    border-radius: 5px;
}

.filter-form button:hover{
    background-color:rgb(36, 108, 156);
} 

.filter-form input, .filter-form select, .filter-form button {
    margin-left: 5px;
    padding: 4px 6px;
    font-size: 14px;
} 
    </style>
    <script>
        function cancelOrder(){
            const cancelButtons = document.querySelectorAll('.cancel-btn');
            cancelButtons.forEach(button => {
                button.addEventListener('click',function(){
                    const row = this.closest('tr');
                    const confirmBtn = row.querySelector('.confirm-btn'); // lấy nút xác nhận trong cùng dòng
                    const statusCell = row.querySelector('.status-cell');
                    const orderId = statusCell.dataset.orderId;
                    const currentStatus = statusCell.querySelector('.status').innerText.trim();
                    let newStatus = "cancelled";
                    if(currentStatus === 'shipping'||currentStatus === 'delivered'){
                        showToast('Đơn hàng đã được xử lý không thể hủy');
                        return;
                    }
                    if(currentStatus === 'cancelled'){
                        showToast('Đơn hàng đã được hủy');
                        return;
                    }
                    if(confirm("xác nhận đơn hàng")){
                        fetch('change_status_order.php',{
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: `order_id=${orderId}&status=${newStatus}`
                        })
                    .then(res => res.text())
                    .then(data=>{
                        statusCell.querySelector('.status').innerText = newStatus;
                        if (newStatus === 'delivered'||newStatus ===  "cancelled") {
                            confirmBtn.style.display = 'none';    
                    }
                    showToast("Thay đổi thành công", true);
                    })
                    }
                });
                    
            });
        }

        function confirmOrder(){
                const confirmButtons = document.querySelectorAll('.confirm-btn');

                confirmButtons.forEach(button => {
                button.addEventListener('click', function(){
                const statusCell = this.closest('.status-cell');
                const orderId = statusCell.dataset.orderId;
                const currentStatus = statusCell.querySelector('.status').innerText.trim();

                let newStatus = "";
                if (currentStatus === 'processing') newStatus = 'shipping';
                else if (currentStatus === 'shipping') newStatus = 'delivered';
                else return;

                if(confirm("xác nhận đơn hàng")){
                    fetch('change_status_order.php',{
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `order_id=${orderId}&status=${newStatus}`
                    })
                .then(res => res.text())
                .then(data=>{
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

        document.addEventListener('DOMContentLoaded', function () {
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
 function refreshOrders(){
    document.getElementById('fromDate').value="";
    document.getElementById('toDate').value="";
    document.getElementById('customerId').selectedIndex = 0;
    document.getElementById('orderStatus').selectedIndex = 0;
    filterOrders();
 }


    </script>
