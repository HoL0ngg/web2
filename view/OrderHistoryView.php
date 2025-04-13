<?php
require_once './handles/EmployeeController.php';
require_once './handles/AddressController.php';
require_once './handles/DetailOrderController.php';
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

</style>
