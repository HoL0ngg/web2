<?php
require_once './Model/BrandModel.php';
class BrandController
{
    private $model;

    public function __construct()
    {
        $this->model = new BrandModel();
    }

    public function getBrandByMaChungLoai($machungloai){
        return $this->model->getBrandByMaChungLoai($machungloai);
    }

    public function getAllBrand(){
        return $this->model->getALL();
    }
}
