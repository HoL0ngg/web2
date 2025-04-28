<?php
session_start();
require_once('./handles/OrderController.php');
require_once('./handles/EmployeeController.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['status'])){
    $user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : null;
    $EmployeeController= new EmployeeController();
    $employee_id = $EmployeeController -> getEmployeeIdByUserID($user_id);  
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];
    $OrderController = new OrderController();
    if($employee_id !== null) {
        $OrderController->changeStatusById($orderId, $newStatus, $employee_id);
        echo "success";
    } else {
        echo "error: employee not found";
    }

}
?>