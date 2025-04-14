<?php
require_once __DIR__ . '/../Model/ProductModel.php';
// require_once './Model/ProductModel.php';
class ProductController
{
    private $model;

    public function __construct()
    {
        $db = new database();
        $this->model = new ProductModel();
    }

    public function getNameProductById($id)
    {
        return $this->model->getNameProductById($id);
    }

    public function getProductsPaginated($page = 1, $limit = 8, $keyword = "", $selected_checkboxes_brand = [], $selected_checkboxes_loaisanpham = [], $price = 0, $maChungLoai)
    {

        $products = $this->model->getProductsByPageNum($page, $limit, $keyword, $selected_checkboxes_brand, $selected_checkboxes_loaisanpham, $price, $maChungLoai);


        $totalProducts = $this->model->getQuantityProducts($keyword, $selected_checkboxes_brand, $selected_checkboxes_loaisanpham, $price, $maChungLoai);
        $pagenum = ceil($totalProducts / $limit);

        $response = ["products" => $products, "totalPage" => $pagenum];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getProductById($id)
    {
        return $this->model->getProductById($id);
    }
    public function getImgUrlById($id)
    {
        return $this->model->getMainImageByProductId($id);
    }
}
