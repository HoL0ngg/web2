<?php
require_once './Model/FormProductModel.php';
require_once './Model/TheLoaiModel.php';
require_once './Model/BrandModel.php';
class FormProductController
{
    private $model;

    public function __construct()
    {
        // $db = new database();
        $this->model = new FormProductModel();
    }

    public function addForm()
    {
        $theloaiModel = new TheLoaiModel();
        $brandModel = new BrandModel();

        $theloai = $theloaiModel->getAll();
        $brands = $brandModel->getAll();
        include('view/addProductView.php');
    }

    public function updateForm($id)
    {
        $id = (int)$id;
        $product = $this->model->getProductById($id);

        $theloaiModel = new TheLoaiModel();
        $brandModel = new BrandModel();

        $theloai = $theloaiModel->getAll();
        $brands = $brandModel->getAll();
        include('view/updateProductView.php');
    }
}
