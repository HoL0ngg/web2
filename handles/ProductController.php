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

    public function getProductsPaginated($page = 1, $limit = 8, $keyword = "", $selected_checkboxes_brand = [], $selected_checkboxes_loaisanpham = [], $matheloai = 0, $minprice, $maxprice, $maChungLoai = 0, $isLove = false)
    {

        $products = $this->model->getProductsByPageNum($page, $limit, $keyword, $selected_checkboxes_brand, $selected_checkboxes_loaisanpham, $matheloai, $minprice, $maxprice, $maChungLoai, $isLove);
        // var_dump($products);
        $totalProducts = $this->model->getQuantityProducts($keyword, $selected_checkboxes_brand, $selected_checkboxes_loaisanpham, $matheloai, $minprice, $maxprice, $maChungLoai, $isLove);
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

    public function removeQuantity($productId, $quantity)
    {
        return $this->model->removeQuantity($productId, $quantity);
    }

    public function getBestSellingProducts($limit)
    {
        // header('Content-Type: application/json');
        $products = $this->model->bestSellingProducts($limit);
        include('view/bestsellingproduct.php');
        // exit();
    }

    public function getMostBuyProduct()
    {
        return $this->model->getMostBuyProduct();
    }

    public function addQuantity($productId, $quantity){
        return $this->model->addQuantity($productId,$quantity);
    }
}
