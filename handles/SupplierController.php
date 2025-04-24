<?php
require_once __DIR__ . '/../Model/SupplierModel.php';

// Chỉ xử lý các yêu cầu AJAX khi có POST và action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Set type of return: JSON
    header('Content-Type: application/json');

    $action = $_POST['action'];

    switch ($action) {
        case 'add_supplier':
            $supplier_name = isset($_POST['supplier_name']) ? trim($_POST['supplier_name']) : '';
            $supplier_address = isset($_POST['supplier_address']) ? trim($_POST['supplier_address']) : '';

            if (empty($supplier_name)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Tên nhà cung cấp không được để trống']);
                exit;
            }

            $model = new SupplierModel();
            $result = $model->addSupplier($supplier_name, $supplier_address);
            echo json_encode($result);
            exit;

        case 'get_products_by_supplier':
            $supplier_id = isset($_POST['supplier_id']) ? intval($_POST['supplier_id']) : 0;
            if ($supplier_id <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid supplier ID']);
                exit;
            }
            $model = new SupplierModel();
            $products = $model->getProductsBySupplier($supplier_id);
            echo json_encode(['success' => true, 'data' => $products]);
            exit;

        case 'update_supplier':
            $supplier_id = isset($_POST['supplier_id']) ? intval($_POST['supplier_id']) : 0;
            $supplier_name = isset($_POST['supplier_name']) ? trim($_POST['supplier_name']) : '';
            $supplier_address = isset($_POST['supplier_address']) ? trim($_POST['supplier_address']) : '';
            $products = isset($_POST['products']) ? json_decode($_POST['products'], true) : [];

            if ($supplier_id <= 0 || empty($supplier_name)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid supplier data']);
                exit;
            }

            if (!is_array($products)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid products data']);
                exit;
            }

            $model = new SupplierModel();
            $result = $model->updateSupplier($supplier_id, $supplier_name, $supplier_address, $products);
            echo json_encode($result);
            exit;

        case 'get_available_products':
            $supplier_id = isset($_POST['supplier_id']) ? intval($_POST['supplier_id']) : 0;
            $current_products = isset($_POST['current_products']) ? json_decode($_POST['current_products'], true) : [];
            
            if ($supplier_id <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid supplier ID']);
                exit;
            }

            if (!is_array($current_products)) {
                $current_products = [];
            }

            $model = new SupplierModel();
            $products = $model->getAvailableProducts($supplier_id, $current_products);
            echo json_encode(['success' => true, 'data' => $products]);
            exit;

        case 'delete_supplier':
            $supplier_id = isset($_POST['supplier_id']) ? intval($_POST['supplier_id']) : 0;
            if ($supplier_id <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid supplier ID']);
                exit;
            }
            $model = new SupplierModel();
            $result = $model->deleteSupplier($supplier_id);
            echo json_encode($result);
            exit;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
            exit;
    }
}

function getSuppliersAndProducts() {
    $model = new SupplierModel();
    $data = $model->getSuppliersAndProducts();
    // Log the data to debug
    file_put_contents(__DIR__ . "/debug_supplier_data.log", "Fetched suppliers: " . print_r($data, true) . "\n", FILE_APPEND);
    return $data;
}
?>