<?php
header('Content-Type: application/json');

require_once './handles/ChungLoaiController.php';

$ChungLoaiController = new ChungLoaiController();
$data = $ChungLoaiController->getAllChungLoai();

// Trả kết quả JSON
echo json_encode($data);
?>