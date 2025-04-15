<?php
require_once 'Model/CartModel.php';
class CartController
{
    private $model;

    public function __construct()
    {
        $this->model = new CartModel();
    }

    public function getAllProductInCart($customerId)
    {
        return $this->model->getAllProductInCart($customerId);
    }

    public function addProductToCart($productId, $quantity, $customerId)
    {
        return $this->model->addProductToCart($productId, $quantity, $customerId);
    }
    public function removeCart($customerId)
    {
        return $this->model->removeCart($customerId);
    }
}
