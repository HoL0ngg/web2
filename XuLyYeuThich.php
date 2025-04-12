<?php
session_start();
require_once 'handles/handleLove.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['username'] ?? null; // Assuming customer_id is stored in session
    if (!$customer_id) {
        echo json_encode(['status' => 'error', 'message' => 'Khách hàng chưa đăng nhập']);
        exit;
    }
    $action = $_POST['action'];

    $handleLove = new handleLove();

    if ($action === 'add') {
        $product_id = $_POST['productId'];
        if ($handleLove->addLove($customer_id, $product_id)) {
            echo json_encode(['status' => 'success', 'message' => 'Yêu thích sản phẩm thành công.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Thêm yêu thích thất bại.']);
        }
    } elseif ($action === 'remove') {
        $product_id = $_POST['productId'];
        if ($handleLove->removeLove($customer_id, $product_id)) {
            echo json_encode(['status' => 'success', 'message' => 'Đã xóa sản phẩm khỏi yêu thích.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Xóa yêu thích thất bại.']);
        }
    } elseif ($action === 'getLoveProducts') {
        $lovedProducts = $handleLove->getLoveProducts($customer_id);
        if ($lovedProducts) {
            echo json_encode(['status' => 'success', 'data' => $lovedProducts]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm yêu thích.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ.']);
    }
}
