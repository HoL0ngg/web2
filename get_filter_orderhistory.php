<?php
session_start();
require_once './handles/OrderController.php';
require_once './handles/EmployeeController.php';
require_once './handles/AddressController.php';
require_once './handles/DetailOrderController.php';
require_once './Model/TKModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = isset($_POST['from']) ? $_POST['from'] : "";
    $to = isset($_POST['to']) ? $_POST['to'] : "";
    $user = new TKModel();
    $customerId = $user->getIdByUsername($_SESSION['username']);
    $customerId = $user->getCustomerIdByUserId($customerId);
    $status = isset($_POST['status']) ? $_POST['status'] : "";
    $OrderController = new OrderController();
    $EmployeeController = new EmployeeController();
    $AddressController = new AddressController();

    $orders = $OrderController->getOrderHistoriesWithFilters($from, $to, $customerId, $status);

    if (!empty($orders)) {
        foreach ($orders as $order) {
            $name = $EmployeeController->getNameEmployeeByID($order['employee_id']);
            $address = $AddressController->getAddressByID($order['address_id']);
            echo '<tr>
                    <td>' . $order['order_id'] . '</td>
                    <td>' . $name . '</td>
                    <td>' . $address . '</td> 
                    <td>' . $order['orderDate'] . '</td>
                    <td>' . $order['total'] . '</td>
                    <td class="status-cell" data-order-id="' . $order['order_id'] . '">' . $order['status'] . '</td>
                    <td>
                        <button class="detail-btn" value="' . $order['order_id'] . '"  onclick="showOrderDetail(this)">📄 Chi tiết</button>
                    </td>
                    <td>
                        <button class="cancel-btn" value="' . $order['order_id'] . '">❌ Hủy đơn</button>
                    </td>
                  </tr>';
        }
    } else {
        echo '<tr><td colspan="8">Không có đơn hàng nào phù hợp.</td></tr>';
    }
} else {
    echo '<tr><td colspan="8">Yêu cầu không hợp lệ</td></tr>';
}
?>
