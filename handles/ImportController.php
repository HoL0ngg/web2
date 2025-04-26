<?php
require_once __DIR__ . '/../Model/ImportModel.php';

// Chỉ xử lý các yêu cầu AJAX khi có POST và action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Set type of return: JSON
    header('Content-Type: application/json');

    $action = $_POST['action'];

    switch ($action) {
        case 'add_phieunhap':
            file_put_contents(__DIR__ . "/debug_add_phieunhap_data.log", "Fetched suppliers: " . print_r($data, true) . "\n", FILE_APPEND);

            $supplier_id = isset($_POST['supplier_id']) ? trim($_POST['supplier_id']) : '';
            $employee_id = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';

            if (empty($supplier_id)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Tên nhà cung cấp không được để trống']);
                exit;
            }if (empty($employee_id)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Tên nhân viên không được để trống']);
                exit;
            }

            $model = new ImportModel();
            $result = $model->addPhieuNhap($supplier_id, $employee_id);
            echo json_encode($result);
            exit;
        case 'update_phieunhap':
            $receipt_id = isset($_POST['receipt_id']) ? trim($_POST['receipt_id']) : '';
            $status = isset($_POST['status']) ? trim($_POST['status']) : '';
            $products = isset($_POST['products']) ? json_decode($_POST['products'], true) : [];
        
            if (empty($receipt_id)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Mã phiếu nhập không được để trống']);
                exit;
            }
            if (!in_array($status, ['processing', 'confirmed', 'cancelled'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Trạng thái không hợp lệ']);
                exit;
            }
            if (!is_array($products)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Danh sách sản phẩm không hợp lệ']);
                exit;
            }
        
            $model = new ImportModel();
            $result = $model->updatePhieuNhap($receipt_id, $status, $products);
            echo json_encode($result);
            exit;

        case 'get_chitietphieunhap_data_popup':
            $receipt_id = isset($_POST['receipt_id']) ? trim($_POST['receipt_id']) : '';
            if (empty($receipt_id)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Mã phiếu nhập không được để trống']);
                exit;
            }
            $model = new ImportModel();
            $result = $model->getChiTietPhieuNhapDataPopup($receipt_id); // Chỉ truyền receipt_id
            echo json_encode($result);
            exit;

        case 'get_available_products':
            $supplier_id = isset($_POST['supplier_id']) ? trim($_POST['supplier_id']) : '';
            $current_products = isset($_POST['current_products']) ? json_decode($_POST['current_products'], true) : [];
        
            if (empty($supplier_id)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Mã nhà cung cấp không được để trống']);
                exit;
            }
        
            $model = new ImportModel();
            $result = $model->getAvailableProducts($supplier_id, $current_products);
            echo json_encode($result);
            exit;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
            exit;
    }
}

function getImportData() {
    $model = new ImportModel();
    $data = $model->getImportData();
    return $data;
}
function getSuppliers() {
    $model = new ImportModel();
    $suppliers = $model->getSuppliers();
    return $suppliers;
}
function getEmployees() {
    $model = new ImportModel();
    $employees = $model->getEmployees();
    return $employees;
}
?>