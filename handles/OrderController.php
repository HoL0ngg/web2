<?php
require_once './Model/OrderModel.php';

class OrderController
{
    private $model;
    public function __construct()
    {
        $this->model = new OrderModel();
    }

    public function getAllOrderHistoryByCustomerId($id)
    {
        $orders = $this->model->getAllOrderHistoryByCustomerId($id);
        include './view/OrderHistoryView.php';
    }

    public function getAllOrder()
    {
        $orders = $this->model->getAllOrder();
        include './order.php';
    }

    public function changeStatusById($orderId, $newStatus)
    {
        return $this->model->changeStatusById($orderId, $newStatus);
    }

    public function addOrder($customer_id, $order_date, $total_price, $status, $address_id, $note, $pttt)
    {
        return $this->model->addOrder($customer_id, $order_date, $total_price, $status, $address_id, $note, $pttt);
    }

    public function addDetailOrder($order_id, $product_id, $quantity, $price)
    {
        return $this->model->addDetailOrder($order_id, $product_id, $quantity, $price);
    }

    public function getAutoIncrementId()
    {
        return $this->model->getAutoIncrementId();
    }

    public function getOrdersByDateRange($from, $to){
        return $this->model->getOrdersByDateRange($from,$to);
    }

    public function getOrdersWithFilters($from = "", $to = "", $customerId = 0, $status = ""){
        return $this->model->getOrdersWithFilters($from, $to, $customerId, $status);
    }
}
