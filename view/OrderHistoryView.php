<?php
require_once './handles/EmployeeController.php';
require_once './handles/AddressController.php';
require_once './handles/DetailOrderHistoryController.php';
?>

<main class="main-content">
    <header>
        <h1>Lịch Sử Mua Hàng</h1>
    </header>

    <!-- Danh sách đơn hàng -->
    <section class="order-list">
        <table>
            <thead>
                <tr>
                    <?php if (isset($_GET['orderhistory'])): ?>
                        <th>Mã hóa đơn</th>
                        <th>Nhân viên</th>
                        <th>Địa chỉ nhận</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    <?php endif; ?>
                    <?php if (isset($_GET['id'])): ?>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody id="orderTable">
                <?php 
                if (isset($_GET['orderhistory'])) {
                    foreach($orders as $order):
                        $EmployeeController = new EmployeeController();
                        $AddressController = new AddressController();
                        $name = $EmployeeController->getNameEmployeeByID($order['employee_id']);
                        $address = $AddressController->getAddressByID($order['address_id']);
                ?>
                    <tr>
                        <td><?= $order['order_id'] ?></td>
                        <td><?= $name ?></td>
                        <td><?= $address ?></td>
                        <td><?= $order['orderDate'] ?></td>
                        <td><?= $order['total'] ?></td>
                        <td><?= $order['status'] ?></td>
                        <td>
                            <button onclick="showOrderDetail(this)" value="<?= $order['order_id'] ?>">📄 Chi tiết</button>
                        </td>
                    </tr>
                <?php endforeach; 
                } ?>
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
               <?php
                   $DetailOrderHistoryController = new DetailOrderHistoryController();
                   $detailorders = $DetailOrderHistoryController->getAllDetailOrderHistoryByOrderId($id);
                   $ProductController = new ProductController();
                   foreach($detailorders as $detailorder):
               ?>
               <?php
               $name_product = $ProductController->getNameProductById($detailorder['product_id']);
               ?>
                <tr>
                    <td><?= $name_product ?></td>
                    <td><?= $detailorder['quantity'] ?></td>
                    <td><?= $detailorder['price'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button id="close-btn" onclick="hideOrderDetail()">Đóng</button>
    </div>
</div>

</main>

<style>
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
</style>

<script>
    function showOrderDetail(button) {
        const orderId = button.value;
        fetch('get_order_details.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',//dưới dạng html
            },
            body: 'order_id=' + encodeURIComponent(orderId)
        })
        .then(response => response.text())
        .then(data => {
        // Đổ dữ liệu vào bảng chi tiết
        document.getElementById("detail-table").getElementsByTagName("tbody")[0].innerHTML = data;
        // Hiển thị popup
        document.getElementById("order-detail-popup").classList.add("show");
    })
    .catch(error => {
        console.error('Lỗi khi lấy chi tiết đơn hàng:', error);
    });
        }
        function hideOrderDetail() {
    const popup = document.getElementById("order-detail-popup");
    popup.classList.remove("show");
}
</script>
