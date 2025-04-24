<?php
session_start();
require_once 'handles/OrderController.php';
require_once 'handles/CartController.php';
require_once 'handles/DiaChiController.php';
require_once 'Model/ProductModel.php';
require_once 'Model/TKModel.php';
// Kiểm tra nếu form được gửi đi
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $orderController = new OrderController();
    $TkModel = new TKModel();
    $CartController = new CartController();

    // Lấy dữ liệu từ form
    $gioitinh = $_POST['gioitinh'] ?? '';
    $hoten = $_POST['hoten'] ?? '';
    $sdt = $_POST['sdt'] ?? '';
    $email = $_POST['email'] ?? '';
    $diachi_user = $_POST['diachi_user'];
    $finalAddressId = null; // Biến để lưu ID địa chỉ cuối cùng
    $thanhpho = $_POST['thanhpho'];
    $quan = $_POST['quan'];
    $phuong = $_POST['phuong'];
    $sonha = $_POST['diachi'];

    // Lấy ID khách hàng từ session
    $customer_id = $TkModel->getIdByUsername($_SESSION['username']);
    $customer_id = $TkModel->getCustomerIdByUserId($customer_id);

    if ($diachi_user == -1) {
        // 👉 Người dùng chọn "Nhập địa chỉ mới"
        $diachiModel = new DiaChiController();
        // Gọi hàm lưu địa chỉ mới vào DB
        $newAddressId = $diachiModel->addDiaChi($sonha, $phuong, $quan, $thanhpho);
        // Lưu địa chỉ vào bảng khachhang_diachi
        $diachiModel->addDiaChiToCustomer($customer_id, $newAddressId);

        $finalAddressId = $newAddressId;
    } else {
        // 👉 Người dùng chọn địa chỉ đã lưu
        $finalAddressId = $diachi_user;
    }
    $note = $_POST['note'] ?? '';
    $pttt = $_POST['payment-method'] ?? '';
    $cart = $CartController->getAllProductInCart($customer_id);

    $_SESSION['order_info'] = [
        'customer_id' => $customer_id,
        'gioitinh' => $gioitinh,
        'hoten' => $hoten,
        'sdt' => $sdt,
        'email' => $email,
        'note' => $note,
        'pttt' => $pttt,
        'cart' => $cart,
        'order_time' => date("Y-m-d H:i:s"),
        'address_id' => $finalAddressId,
    ];

    unset($_SESSION['cart']); // Xóa giỏ hàng sau khi đã xử lý

    // Tính tổng giá trị đơn hàng
    $total_price = 0;
    foreach ($cart as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        // Giả sử bạn có một hàm để lấy giá sản phẩm theo ID
        $productModel = new ProductModel();
        $product = $productModel->getProductById($product_id);
        if ($product) {
            $total_price += $product['price'] * $quantity;
        }
        // $orderController->addDetailOrder($order_id, $product_id, $quantity, $product['price']);
    }

    // Thêm đơn hàng vào cơ sở dữ liệu
    $order_id = $orderController->addOrder($hoten, $sdt, $email, $customer_id, date("Y-m-d H:i:s"), $total_price, 'processing', $finalAddressId, $note, $pttt);
    // Thêm chi tiết đơn hàng vào cơ sở dữ liệu
    foreach ($cart as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        // Giả sử bạn có một hàm để lấy giá sản phẩm theo ID
        $productModel = new ProductModel();
        $product = $productModel->getProductById($product_id);
        $orderController->addDetailOrder($order_id, $product_id, $quantity, $product['price']);
    }

    // Xóa sản phẩm sau khi đã thêm vào đơn hàng
    foreach ($cart as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $productModel = new ProductModel();
        // Cập nhật số lượng sản phẩm trong kho
        $productModel->removeQuantity($product_id, $quantity);
    }

    // Xóa giỏ hàng của người dùng
    $CartController->deleteCart($customer_id);
    unset($_SESSION['cart']);


    // Chuyển hướng sang trang hóa đơn
    header("Location: cart.php?action=hoadon");
    exit();
}
