    <?php
    require_once __DIR__ . '/../handles/FormProductController.php';
    $action = $_POST['action'];
    $productController = new FormProductController();
    switch ($action) {
        case 'addProduct':
            $productController->addProduct();
            break;
        case 'updateProduct':
            $product_id = (int)$_POST['product_id'] ?? '';
            $productController->editProduct($product_id);
        case 'checkProduct':
            $product_id = (int)$_POST['product_id'] ?? '';
            $check = $productController->checkProductIsSold($product_id);
            return $check;
        case 'deleteProduct':
            // header('Content-Type: application/json');
            // $response = ["success" => false, "message" => ""];
            $product_id = (int)$_POST['product_id'] ?? '';
            $result = $productController->deleteProduct($product_id);
            // switch ($result) {
            //     case 'delete_failed':
            //         $response["message"] = "Không thể xóa sản phẩm.";
            //         break;
            //     case 'product_sold':
            //         // $response["message"] = "Sản phẩm đã được bán, không thể xóa.";
            //         break;
            //     case 'exception':
            //         $response["message"] = "Có lỗi xảy ra trong quá trình xóa.";
            //         break;
            //     case 'success':
            //         $response["success"] = true;
            //         $response["message"] = "Xóa sản phẩm thành công!";
            //         break;
            //     default:
            //         $response["message"] = "Không xác định.";
            // }
            // echo json_encode($response);
            break;
        case 'hideProduct':
            $product_id = (int)$_POST['product_id'] ?? '';
            $productController->hideProduct($product_id);
            break;
        default:
            # code...
            break;
    }
    ?>