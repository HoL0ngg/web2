<?php
session_start();
require_once('./handles/OrderController.php');
require_once('./handles/EmployeeController.php');
require_once('./handles/CustomerController.php');
require_once('./handles/ProductController.php');
require_once('./handles/DetailOrderController.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['status'])){
    $user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : null;
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];
    if($_SESSION['user']['role_id']==3){
        $CustomerController= new CustomerController();
        $customer_id = $CustomerController->getCustomerIdByID($user_id);
        $OrderController = new OrderController();
    if($customer_id !== null) {
        $OrderController->changeStatusByCustomerId($orderId, $newStatus, $customer_id);
        echo "success";
    } else {
        echo "error: employee not found";
    }
    }
    else{
        $EmployeeController= new EmployeeController();
        $employee_id = $EmployeeController -> getEmployeeIdByUserID($user_id);  
        $OrderController = new OrderController();
        if($employee_id !== null) {
            $OrderController->changeStatusByEmployeeId($orderId, $newStatus, $employee_id);
            echo "success";
        } else {
            echo "error: employee not found";
        }
    }
   
    
    if($newStatus=="cancelled"){
        $DetailOrderController = new DetailOrderController();
          $ProductController = new ProductController();
          $detailorders = $DetailOrderController->getAllDetailOrderByOrderId($orderId);
          foreach ($detailorders as $detailorder){
            $ProductController->addQuantity($detailorder['product_id'],$detailorder['quantity']);
          }
    }
    

}
?>