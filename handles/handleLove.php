<?php
require_once('./Model/LoveModel.php');
class handleLove
{
    private $model;
    public function __construct()
    {
        $this->model = new LoveModel();
    }

    public function addLove($customer_id, $product_id)
    {
        return $this->model->addLove($customer_id, $product_id);
    }

    public function removeLove($customer_id, $product_id)
    {
        return $this->model->removeLove($customer_id, $product_id);
    }

    public function getLoveProducts($customer_id)
    {
        return $this->model->getLoveProducts($customer_id);
    }

    public function checkProductInWishlist($userId, $productId)
    {
        return $this->model->checkProductInWishlist($userId, $productId);
    }

    public function getLoveCount($customerId)
    {
        return $this->model->getLoveCount($customerId);
    }
}
