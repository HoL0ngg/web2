<?php
require_once'./Model/OrderModel.php';

class OrderController{
    private $model;
    public function __construct()
    {
        $this->model = new OrderModel();
    }

    public function getAllOrderHistoryByCustomerId($id){
        $orders = $this->model->getAllOrderHistoryByCustomerId($id);
        include'./view/OrderHistoryView.php';
    }

    public function getAllOrder(){
        $orders = $this->model->getAllOrder();
        include'./order.php';
    }

    public function changeStatusById($orderId, $newStatus){
        return $this->model->changeStatusById($orderId,$newStatus);
    }

    public function getOrdersByDateRange($from, $to){
        return $this->model->getOrdersByDateRange($from,$to);
    }

    public function getOrdersWithFilters($from = null, $to = null, $customerId = null, $status = null){
        return $this->model->getOrdersWithFilters($from, $to, $customerId, $status);
    }
}

?>