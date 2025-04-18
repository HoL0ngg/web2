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
        default:
            # code...
            break;
    }
    ?>