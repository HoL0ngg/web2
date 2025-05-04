<?php
require_once 'Model/TKModel.php';
$tkModel = new TKModel();

$filter = isset($_POST['filter']) ? $_POST['filter'] : '30';

if ($filter === 'custom') {
    // Có thể xử lý khoảng ngày tùy chỉnh ở đây
}

$startDate = $_POST['start'] ?? null;
$endDate = $_POST['end'] ?? null;
$tkModel = new TKModel();
$top5 = $tkModel->getTop5KhachHang($startDate, $endDate);

if ($top5) {
    echo '<tr><th>STT</th><th>Tên khách hàng</th><th>Số điện thoại</th><th>Tổng tiền</th><th>Hành động</th></tr>';
    foreach ($top5 as $index => $khachHang) {
        echo '<tr>';
        echo '<td>' . ($index + 1) . '</td>';
        echo '<td>' . htmlspecialchars($khachHang['customer_name']) . '</td>';
        echo '<td>' . htmlspecialchars($khachHang['phone']) . '</td>';
        echo '<td>' . number_format($khachHang['order_sum'], 0, ',', '.') . ' VNĐ</td>';
        echo '<td><a href="admin.php?page=thongke&id=' . $khachHang['customer_id'] . '">Xem chi tiết</a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">Không có dữ liệu.</td></tr>';
}
