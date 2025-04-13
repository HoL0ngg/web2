<?php
require_once('./handles/OrderController.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['status'])){
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];
    $OrderController = new OrderController();
    $OrderController ->changeStatusById($orderId,$newStatus);
}
?>