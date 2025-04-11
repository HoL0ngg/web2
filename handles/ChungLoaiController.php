<?php
require_once './Model/ChungLoaiModel.php';
class ChungLoaiController
{
    private $model;

    public function __construct()
    {
        $this->model = new ChungLoaiModel();
    }

    public function getChungLoaiByChungLoai($machungloai){
        return $this->model->getChungLoaiByChungLoai($machungloai);
    }
    public function getAllChungLoai(){
        return $this->model->getAllChungLoai();
    }
}
