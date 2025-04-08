<?php
// require_once __DIR__ . '/../Model/ProductModel.php';
require_once './Model/ProductModel.php';

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

    public function getProductsPaginated($page = 1, $limit = 8)
    {
        $products = $this->model->getProductsByPageNum($page, $limit);
        $totalProducts = $this->model->getQuantityProducts();
        $pagenum = ceil($totalProducts / $limit);

        $response = ["products" => $products, "totalPage" => $pagenum];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
