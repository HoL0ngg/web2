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

    public function removeProductInCart($productId, $customerId)
    {
        return $this->model->removeProductInCart($productId, $customerId);
    }

    public function updateProductInCart($productId, $quantity, $customerId)
    {
        return $this->model->updateProductInCart($productId, $quantity, $customerId);
    }

    public function updateCartSessionToDatabase($customerId, $cart)
    {
        if (empty($cart)) {
            return;
        } else {
            foreach ($cart as $item) {
                $productId = $item['id'];
                $quantity = $item['quantity'];
                if ($this->model->checkProductInCart($productId, $customerId)->num_rows > 0) {
                    $this->updateProductInCart($productId, $quantity, $customerId);
                } else {
                    $this->addProductToCart($productId, $quantity, $customerId);
                }
            }
        }
    }
}
