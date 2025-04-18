    <?php
    require_once './handles/handleLove.php';
    require_once './Model/TKModel.php';
    require_once './handles/ProductController.php';

    $handleLove = new handleLove();
    $user = new TKModel();

    $customer_id = $user->getIdByUsername($_SESSION['username']);
    $lovedProducts = $handleLove->getLoveProducts($customer_id);
    ?>

    <div id='product-container'></div>
    <div id='pagenum'></div>

    <script src="js/loveProduct.js"></script>