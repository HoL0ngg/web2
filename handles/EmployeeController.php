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

    public function getEmployeeIdByUserID($id){
        return $this->model->getEmployeeIdByUserID($id);
    }
}
