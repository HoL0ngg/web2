<?php
require_once './Model/EmployeeModel.php';
class EmployeeController
{
    private $model;
    public function __construct()
    {
        $this->model = new EmployeeModel();
    }

    public function getNameEmployeeByID($id)
    {
        return $this->model->getNameEmployeeByID($id);
    }

    public function getNameEmployeeByUserID($id){
        return $this->model->getNameEmployeeByUserID($id);
    }
}
