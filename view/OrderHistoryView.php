<?php
    require_once './handles/EmployeeController.php';
    require_once './handles/AddressController.php';
    require_once './handles/DetailOrderController.php';
    require_once './handles/CustomerController.php';
    ?>
<main class="main-content">
    <header>
        <h1>Lịch Sử Mua Hàng</h1>
    </header>
    <div class="filter-form">
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

        <button onclick="filterOrders()">Lọc</button>
        <button onclick="refreshOrders()">Làm mới</button>
    </div>

    <!-- Danh sách đơn hàng -->
    <section class="order-list">
        <table>
            <thead>
                <tr>                
                        <th>Mã hóa đơn</th>
                        <th>Nhân viên</th>
                        <th>Địa chỉ nhận</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                        <th>Hủy đơn</th>
                </tr>
            </thead>
            <tbody id="orderTable">
                <?php 
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
                        <td class="status-cell" data-order-id="<?= $order['order_id'] ?>"><?= $order['status'] ?></td>
                        <td>
                            <button onclick="showOrderDetail(this)" value="<?= $order['order_id'] ?>">📄 Chi tiết</button>
                        </td>
                        <td>
                            <button class="cancel-btn" value="<?= $order['order_id'] ?>">❌ Hủy đơn </button>
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
.filter-form {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 10px;
    margin-top: 15px;
}

.filter-form label {
    display: flex;
    /* align-items: center; */
    justify-content: space-around;
    font-weight: bold;
}
.filter-form button{
    /* margin-top: 15px; */
    height: 30px;
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
