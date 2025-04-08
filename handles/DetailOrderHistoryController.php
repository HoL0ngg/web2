<?php
require_once './Model/DetailOrderHistoryModel.php';
require_once './handles/ProductController.php';

class DetailOrderHistoryController{
    private $model;
    public function __construct()
    {
        $this->model = new DetailOrderHistoryModel();
    }

    public function getAllDetailOrderHistoryByOrderId($id){
        return $this->model->getAllDetailOrderHistoryByOrderId($id);
    }
}
?>