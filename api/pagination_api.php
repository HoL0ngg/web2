    <?php
    require_once '../handles/ProductController.php';

    $page = isset($_GET['pagenum']) ? intval($_GET['pagenum']) : 1;
    $keyword = isset($_GET["keyword"]) ? trim($_GET["keyword"]) : "";

    $productController = new ProductController();
    $productController->getProductsPaginated($page, 8, $keyword);

 

    ?>