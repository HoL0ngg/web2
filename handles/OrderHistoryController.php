<?php
require_once'./Model/OrderHistoryModel.php';

class OrderHistoryController{
    private $model;
    public function __construct()
    {
        $this->model = new OrderHistoryModel();
    }

    public function getAllOrderHistoryByCustomerId($id){
        $orders = $this->model->getAllOrderHistoryByCustomerId($id);
        include'./view/OrderHistoryView.php';
    }
}

?>