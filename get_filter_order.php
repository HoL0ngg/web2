<?php
require_once './handles/OrderController.php';
require_once './handles/EmployeeController.php';
require_once './handles/AddressController.php';
require_once './handles/DetailOrderController.php';
require_once './handles/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = isset($_POST['from']) ? $_POST['from'] : "";
    $to = isset($_POST['to']) ? $_POST['to'] : "";
    $customerId = isset($_POST['customerId']) ? intval($_POST['customerId']) : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : "";

    $OrderController = new OrderController();
    $CustomerController = new CustomerController();
    $AddressController = new AddressController();

    $orders = $OrderController->getOrdersWithFilters($from, $to, $customerId, $status);

    if (!empty($orders)) {
        foreach ($orders as $order) {
            $name = $CustomerController->getNameCustomerByID($order['customer_id']);
            $address = $AddressController->getAddressByID($order['address_id']);
            $phone = $CustomerController->getPhoneCustomerByID($order['customer_id']);

            // Định nghĩa màu nền và kiểu dáng cho từng trạng thái
            $statusStyles = [
                'processing' => 'background-color: rgba(218, 174, 0, 0.7); color: #fff;', // Vàng mờ
                'shipping' => 'background-color: rgba(41, 128, 185, 0.7); color: #fff;', // Xanh nước biển mờ
                'delivered' => 'background-color: rgba(39, 174, 96, 0.7); color: #fff;', // Xanh lá mờ
                'cancelled' => 'background-color: rgba(192, 57, 43, 0.7); color: #fff;' // Đỏ mờ
            ];
            // Lấy kiểu dáng tương ứng với trạng thái, mặc định là nền xám nếu trạng thái không hợp lệ
            $style = isset($statusStyles[$order['status']]) ? $statusStyles[$order['status']] : 'background-color: rgba(0, 0, 0, 0.2); color: #fff;';

            // Tạo nút Xác nhận nếu trạng thái là processing hoặc shipping
            $confirmBtn = '';
            if ($order['status'] === 'processing' || $order['status'] === 'shipping') {
                $confirmBtn = '<button class="confirm-btn">✅ Xác nhận</button>';
            }

            echo '<tr>
                    <td>' . $order['order_id'] . '</td>
                    <td>' . $name . '</td>
                    <td>' . $phone . '</td>
                    <td>' . $address . '</td> 
                    <td>' . $order['orderDate'] . '</td>
                    <td>' . $order['total'] . '</td>
                    <td class="status-cell" data-order-id="' . $order['order_id'] . '">
                        <div class="status" style="display: inline-block; padding: 4px 8px; font-size: 14px; border-radius: 6px; ' . $style . '">' . $order['status'] . '</div>
                        ' . $confirmBtn . '
                    </td>
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