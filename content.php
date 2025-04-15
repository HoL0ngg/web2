<div id="content-wrapper">
    <?php
    $action = '';

    if (isset($_GET['orderhistory'])) {
        $action = 'orderhistory';
    } else {
        $action = 'default';
    }

    switch ($action) {
        case 'orderhistory':
            require_once './handles/OrderController.php';
            $OrderHistoryController = new OrderController();
            $OrderHistoryController->getAllOrderHistoryByCustomerId(2);
            break;

        default:
            include('left_menu.php');
            break;
    }
    ?>
</div>