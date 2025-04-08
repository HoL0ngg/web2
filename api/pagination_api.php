    <?php
    require_once '../handles/ProductController.php';

    $page = isset($_GET['pagenum']) ? intval($_GET['pagenum']) : 1;

    $productController = new ProductController();
    $productController->getProductsPaginated($page);
    ?>