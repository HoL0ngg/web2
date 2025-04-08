<?php
require_once './handles/DetailOrderHistoryController.php';
require_once './handles/ProductController.php';

// Kiểm tra nếu có dữ liệu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Lấy chi tiết đơn hàng từ CSDL
    $DetailOrderHistoryController = new DetailOrderHistoryController();
    $ProductController = new ProductController();

    $detailorders = $DetailOrderHistoryController->getAllDetailOrderHistoryByOrderId($orderId);

    // Xuất HTML bảng
    foreach ($detailorders as $detailorder) {
        $productName = $ProductController->getNameProductById($detailorder['product_id']);
        $quantity = $detailorder['quantity'];
        $price = $detailorder['price'];

        echo "<tr>
                <td>$productName</td>
                <td>$quantity</td>
                <td>$price</td>
              </tr>";
    }
} else {
    echo '<tr><td colspan="3">Không tìm thấy đơn hàng</td></tr>';
}
