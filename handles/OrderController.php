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
}

?>