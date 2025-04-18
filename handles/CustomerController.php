<?php
require_once './Model/CustomerModel.php';
class CustomerController
{
    private $model;
    public function __construct()
    {
        $this->model = new CustomerModel();
    }

    public function getCustomerByID($id)
    {
        return $this->model->getCustomerByID($id);
    }
}
