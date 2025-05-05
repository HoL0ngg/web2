<script src="js/script.js"></script>
<div id="content-wrapper">
    <?php
    $action = '';

    if (isset($_GET['orderhistory'])) {
        if (isset($_SESSION['username'])) {
            $action = 'orderhistory';   
        } else {
            echo '<script>showToast("Bạn chưa đăng nhập");</script>';
        }
    } else if (isset($_GET['loveProduct'])) {
        $action = 'loveProduct';
    } else if (isset($_GET['gioithieu'])) {
        $action = 'gioithieu';
    } else {
        $action = 'default';
    }

    switch ($action) {
        case 'orderhistory':
            $user = new TKModel();
            $customer_id = $user->getIdByUsername($_SESSION['username']);
            $customer_id = $user->getCustomerIdByUserId($customer_id);
            require_once './handles/OrderController.php';
            $OrderHistoryController = new OrderController();
            $OrderHistoryController->getAllOrderHistoryByCustomerId($customer_id);
            break;
        case 'loveProduct':
            include 'view/LoveProductView.php';
            break;
        case 'gioithieu':
            include 'view/gioithieu.php';
            break;
        default:
            include('left_menu.php');
            break;
    }
    ?>
</div>
    