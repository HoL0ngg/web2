<?php
require_once __DIR__ . '/../Model/CategoryModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header("Content-Type: application/json");

    $action = $_POST['action'];
    $model = new CategoryModel();

    switch ($action) {
        case 'add_chungloai':
            $ten = $_POST['tenchungloai'];
            $hinhanh = isset($_POST['hinhanh']) ? $_POST['hinhanh'] : null;
        
            // Kiểm tra định dạng đường dẫn ảnh (nếu cần)
            if ($hinhanh && !preg_match('/^imgs\/[a-zA-Z0-9_-]+\.(jpg|jpeg|png|gif|webp)$/', $hinhanh)) {
                http_response_code(400);
                echo json_encode(["error" => "Đường dẫn ảnh không hợp lệ"]);
                exit;
            }
        
            $new_id = $model->insertChungLoai($ten, $hinhanh);
        
            if (!$new_id) {
                http_response_code(500);
                echo json_encode(["error" => "Lỗi khi thêm chủng loại"]);
                exit;
            }
        
            echo json_encode(["success" => true]);
            exit;

        case 'delete_chungloai':
            $machungloai = $_POST['machungloai'];
            $result = $model->deleteChungLoai($machungloai);
            if (!$result) {
                http_response_code(500);
                echo json_encode(["error" => "Lỗi khi xóa chủng loại"]);
                exit;
            }
            echo json_encode(['success' => $result]);
            exit;

        case 'edit_chungloai':
            $machungloai = $_POST['machungloai'];
            $tenchungloai = $_POST['tenchungloai'];
            $result = $model->updateChungLoai($machungloai, $tenchungloai);
            if (!$result) {
                http_response_code(500);
                echo json_encode(["error" => "Lỗi khi sửa chủng loại"]);
                exit;
            }
            echo json_encode(["success" => true]);
            exit;

        case 'update_chungloai':
            $machungloai = $_POST['machungloai'];
            $tenchungloai = $_POST['tenchungloai'];
            $theloai = isset($_POST['theloai']) ? json_decode($_POST['theloai'], true) : [];
            $hinhanh = isset($_POST['hinhanh']) ? $_POST['hinhanh'] : null;

            // Kiểm tra định dạng đường dẫn ảnh (nếu cần)
            if ($hinhanh && !preg_match('/^imgs\/[a-zA-Z0-9_-]+\.(jpg|jpeg|png|gif|webp)$/', $hinhanh)) {
                http_response_code(400);
                echo json_encode(["error" => "Đường dẫn ảnh không hợp lệ"]);
                exit;
            }

            if (!is_array($theloai)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Danh sách thể loại không hợp lệ']);
                exit;
            }

            $result = $model->updateChungLoaiWithTheLoai($machungloai, $tenchungloai, $theloai, $hinhanh);
            if (!$result) {
                http_response_code(500);
                echo json_encode(["error" => "Lỗi khi cập nhật chủng loại, vui lòng thử lại"]);
                exit;
            }
            echo json_encode(["success" => true]);
            exit;
        case 'add_theloai':
            $ten = $_POST['tentheloai'];
            $maCL = $_POST['machungloai'];
            $new_id = $model->insertTheLoai($ten, $maCL);
            if (!$new_id) {
                http_response_code(500);
                echo json_encode(["error" => "Lỗi khi thêm thể loại"]);
                exit;
            }
            echo json_encode(["success" => true, "matheloai" => $new_id]);
            exit;

        case 'edit_theloai':
            $matheloai = $_POST['matheloai'];
            $tentheloai = $_POST['tentheloai'];
            $result = $model->updateTheLoai($matheloai, $tentheloai);
            if (!$result) {
                http_response_code(500);
                echo json_encode(["error" => "Lỗi khi sửa thể loại"]);
                exit;
            }
            echo json_encode(["success" => true]);
            exit;

        case 'delete_theloai':
            $matheloai = $_POST['matheloai'];
            $result = $model->deleteTheLoai($matheloai);
            if (!$result) {
                http_response_code(500);
                echo json_encode(["error" => "Lỗi khi xóa thể loại, có thể thể loại này đang được sử dụng"]);
                exit;
            }
            echo json_encode(["success" => true]);
            exit;

        case 'get_theloai_by_chungloai':
            $machungloai = $_POST['machungloai'];
            $theloai = $model->getTheLoaiByChungLoai($machungloai);
            echo json_encode(['success' => true, 'data' => $theloai]);
            exit;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Hành động không hợp lệ']);
            exit;
    }
}

function getCategoryData() {
    $model = new CategoryModel();
    return $model->getChungLoaiWithTheLoaiAndProductCount();
}
?>