<?php
require_once './Model/AddressModel.php';
class AddressController
{
    private $model;
    public function __construct()
    {
        $this->model = new AdressModel();
    }

    public function getAddressByID($id)
    {
        return $this->model->getAddressByID($id);
    }
}
