<?php
session_start();
// Kiểm tra nếu form được gửi đi
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lấy dữ liệu từ form
    $gioitinh = $_POST['gioitinh'] ?? '';
    $hoten = $_POST['hoten'] ?? '';
    $sdt = $_POST['sdt'] ?? '';
    $email = $_POST['email'] ?? '';
    $thanhpho = $_POST['thanhpho'] ?? '';
    $quan = $_POST['quan'] ?? '';
    $phuong = $_POST['phuong'] ?? '';
    $diachi = $_POST['diachi'] ?? '';
    $note = $_POST['note'] ?? '';
    $pttt = $_POST['payment-method'] ?? '';
    $cart = $_SESSION['cart'];

    // Lưu vào session
    $_SESSION['order_info'] = [
        'gioitinh' => $gioitinh,
        'hoten' => $hoten,
        'sdt' => $sdt,
        'email' => $email,
        'thanhpho' => $thanhpho,
        'quan' => $quan,
        'phuong' => $phuong,
        'diachi' => $diachi,
        'note' => $note,
        'pttt' => $pttt,
        'cart' => $cart,
        'order_time' => date("Y-m-d H:i:s")
    ];
    // Chuyển hướng sang trang hóa đơn
    header("Location: cart.php?action=hoadon");
    exit();
}
