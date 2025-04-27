<?php
session_start();
require_once('./handles/OrderController.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['status'])){
    $employee_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : null;
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];
    $OrderController = new OrderController();
    $OrderController->changeStatusById($orderId, $newStatus, $employee_id);
}
?>