<?php
require_once 'handles/handleLove.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['customer_id'] ?? null; // Assuming customer_id is stored in session
    if (!$customer_id) {
        echo json_encode(['status' => 'error', 'message' => 'Khách hàng chưa đăng nhập']);
        exit;
    }
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];

    $handleLove = new handleLove();

    if ($action === 'add') {
        if ($handleLove->addLove($customer_id, $product_id)) {
            echo json_encode(['status' => 'success', 'message' => 'Yêu thích sản phẩm thành công.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Thêm yêu thích thất bại.']);
        }
    } elseif ($action === 'remove') {
        if ($handleLove->removeLove($customer_id, $product_id)) {
            echo json_encode(['status' => 'success', 'message' => 'Đã xóa sản phẩm khỏi yêu thích.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Xóa yêu thích thất bại.']);
        }
    }
}
