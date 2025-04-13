<div id="content-wrapper">
    <?php
    $action = '';

    if (isset($_GET['maChungloai'])) {
        $action = 'maChungloai';
    } elseif (isset($_GET['orderhistory'])) {
        $action = 'orderhistory';
    } else {
        $action = 'default';
    }

    switch ($action) {
        case 'maChungloai':
            include('left_menu.php');
            break;

        case 'orderhistory':
            require_once './handles/OrderController.php';
            $OrderHistoryController = new OrderController();
            $OrderHistoryController->getAllOrderHistoryByCustomerId(2);
            break;

        default:
            echo '
                <div id="rightmenu_product">
                    <div id="product-container"></div>
                    <div id="pagenum"></div>
                </div>
            ';
            break;
    }
    ?>
</div>