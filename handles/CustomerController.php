<?php
require_once './Model/CustomerModel.php';
class CustomerController
{
    private $model;
    public function __construct()
    {
        $this->model = new CustomerModel();
    }

    public function getAllKhachHang(){
        return $this->model->getAllKhachHang();
    }

    public function getNameCustomerByID($id){
        return $this->model->getNameCustomerByID($id);
    }
}
