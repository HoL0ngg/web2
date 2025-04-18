<?php
// file_put_contents(__DIR__ . "/test_debug.log", "CategoryController loaded\n", FILE_APPEND);

// Include đúng đường dẫn
require_once __DIR__ . '/../Model/CategoryModel.php';

// echo "oke";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add_chungloai') {
    // Set type of return : JSON
    header("Content-Type: application/json"); 

    $model = new CategoryModel();
    $ten = $_POST['tenchungloai'];

    $new_id = $model->insertChungLoai($ten); // Trả về mã chủng loại mới

    if (!$new_id) { 
        error_log("Thêm thất bại: " . $this->conn->error); // log chi tiết lỗi
        http_response_code(500);
        echo json_encode(["error" => "Lỗi khi thêm chủng loại"]);
        exit;
    }

    $html = "
        <tr>
            <td>{$new_id}</td>
            <td>{$ten}</td>
            <td colspan='3'>Không có thể loại</td>
            <td>
                <a href='admin.php?page=category&act=edit_chungloai&id={$new_id}' 
                data-machungloai='{$new_id}' 
                data-tenchungloai='" . htmlspecialchars($ten, ENT_QUOTES, 'UTF-8') . "'>
                <button class='edit-chungloai-btn'>✏️ Sửa</button>
                </a>
            </td>
            <td>
                <a href='admin.php?page=category&act=add_type&cl_id={$new_id}' 
                data-machungloai='{$new_id}' 
                data-tenchungloai='" . htmlspecialchars($ten, ENT_QUOTES, 'UTF-8') . "'>
                <button class='add-theloai-btn'>➕ Thêm thể loại</button>
                </a>
            </td>
        </tr>
    ";

    echo json_encode($html);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete_chungloai') {
    header("Content-Type: application/json");

    $model = new CategoryModel();
    $machungloai = $_POST['machungloai'];

    $result = $model->deleteChungLoai($machungloai); // Trả về true/false
    if (!$result) { 
        error_log("Xóa thất bại: " . $this->conn->error); // log chi tiết lỗi
        http_response_code(500);
        echo json_encode(["error" => "Lỗi khi xóa chủng loại"]);
        exit;
    }
    echo json_encode(['success' => $result]);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit_chungloai') {
    header("Content-Type: application/json");

    $model = new CategoryModel();
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
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add_theloai') {
    header("Content-Type: application/json");

    $model = new CategoryModel();
    $ten = $_POST['tentheloai'];
    $maCL = $_POST['machungloai'];

    $result = $model->insertTheLoai($ten, $maCL);

    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => "Lỗi khi thêm thể loại"]);
        exit;
    }

    echo json_encode(["success" => true]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit_theloai') {
    header("Content-Type: application/json");

    $model = new CategoryModel();
    $matheloai = $_POST['matheloai'];
    $tentheloai = $_POST['tentheloai'];
    $machungloai = $_POST['machungloai'];
    $tenchungloai = $_POST['tenchungloai'];

    // Sửa thể loại
    $result1 = $model->updateTheLoai($matheloai, $tentheloai);
    // Sửa chủng loại
    $result2 = $model->updateChungLoai($machungloai, $tenchungloai);

    if (!$result1 || !$result2) {
        http_response_code(500);
        echo json_encode(["error" => "Lỗi khi sửa thể loại hoặc chủng loại"]);
        exit;
    }

    echo json_encode(["success" => true]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete_theloai') {
    header("Content-Type: application/json");

    $model = new CategoryModel();
    $matheloai = $_POST['matheloai'];

    $result = $model->deleteTheLoai($matheloai);

    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => "Lỗi khi xóa thể loại"]);
        exit;
    }

    echo json_encode(["success" => true]);
    exit;
}


function getCategoryData() {
    $model = new CategoryModel();
    return $model->getChungLoaiWithTheLoaiAndProductCount();
}
