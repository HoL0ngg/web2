    <?php
    require_once __DIR__ . '/../handles/ProductController.php';

    $page = isset($_GET['pagenum']) ? intval($_GET['pagenum']) : 1;
    $keyword = isset($_GET["keyword"]) ? trim($_GET["keyword"]) : "";
    $minprice = isset($_GET['minprice']) ? intval($_GET['minprice']) : 0;
    $maxprice = isset($_GET['maxprice']) ? intval($_GET['maxprice']) : 9000000;
    $maChungLoai = isset($_GET['maChungLoai']) ? $_GET['maChungLoai'] : 0;
    $matheloai = isset($_GET['maTheLoai']) ? $_GET['maTheLoai'] : 0;
    $isLove = isset($_GET['isLove']) && $_GET['isLove'] === 'true';

    // var_dump($isLove);
    $selected_checkboxes_brandJson = isset($_GET['selected_checkboxes_brand']) ? $_GET['selected_checkboxes_brand'] : '[]';
    $selected_checkboxes_brand = json_decode($selected_checkboxes_brandJson, true);
    $selected_checkboxes_loaisanphamJson = isset($_GET['selected_checkboxes_loaisanpham']) ? $_GET['selected_checkboxes_loaisanpham'] : '[]';
    $selected_checkboxes_loaisanpham = json_decode($selected_checkboxes_loaisanphamJson, true);
    $productController = new ProductController();
    $productController->getProductsPaginated($page, 8, $keyword, $selected_checkboxes_brand, $selected_checkboxes_loaisanpham, $matheloai, $minprice, $maxprice, $maChungLoai, $isLove);
    ?>
