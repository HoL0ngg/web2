    <?php
    require_once __DIR__ . '/../handles/FormProductController.php';
    $action = $_POST['action'];
    $productController = new FormProductController();
    switch ($action) {
        case 'addProduct':
            $productController->addProduct();
            break;

        default:
            # code...
            break;
    }
    ?>