<?php
require_once './Model/DetailOrderModel.php';
require_once './handles/ProductController.php';

class DetailOrderController{
    private $model;
    public function __construct()
    {
        $this->model = new DetailOrderModel();
    }

    public function getAllDetailOrderByOrderId($id){
        return $this->model->getAllDetailOrderByOrderId($id);
    }
}
?>