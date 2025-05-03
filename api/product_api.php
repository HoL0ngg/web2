    <?php
    session_start();
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
            break;
        case 'checkProduct':
            $product_id = (int)$_POST['product_id'] ?? '';
            $check = $productController->checkProductIsSold($product_id);
            break;
        case 'checkProductIsImported':
            $product_id = (int)$_POST['product_id'] ?? '';
            $check = $productController->checkProductIsImported($product_id);
            break;
        case 'deleteProduct':
            $product_id = (int)$_POST['product_id'] ?? '';
            $productController->deleteProduct($product_id);
            break;
        case 'hideProduct':
            $product_id = (int)$_POST['product_id'] ?? '';
            $productController->hideProduct($product_id);
            break;
        case 'searchProduct':
            $keyword = $_POST['keyword'] ?? '';
            $type = $_POST['type'] ?? 'all';
            $productController->search($keyword, $type);
            break;
        default:
            # code...
            break;
    }
    ?>