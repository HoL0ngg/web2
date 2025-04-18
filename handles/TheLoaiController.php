<?php
require_once './Model/TheLoaiModel.php';
class TheLoaiController
{
    private $model;

    public function __construct()
    {
        $this->model = new TheLoaiModel();
    }

    public function getTheLoaiByChungLoai($machungloai){
        return $this->model->getTheLoaiByChungLoai($machungloai);
    }

    public function getALLtheloai(){
        return $this->model->getALL();
    }
}
