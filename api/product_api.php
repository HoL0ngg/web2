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
        case 'deleteProduct':
            $product_id = (int)$_POST['product_id'] ?? '';
            $productController->deleteProduct($product_id);
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