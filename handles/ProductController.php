<?php
require_once './Model/ProductModel.php';
class ProductController{
    private $model;

    public function __construct()
    {
        $db = new database();
        $this->model = new ProductModel();
    }

    public function getNameProductById($id){
        return $this->model->getNameProductById($id);
    }

}
?>