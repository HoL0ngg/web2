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

    public function changeStatusByEmployeeId($orderId, $newStatus, $employee_id)
    {
        return $this->model->changeStatusByEmployeeId($orderId, $newStatus, $employee_id);
    }

    public function changeStatusByCustomerId($orderId, $newStatus, $customer_id){
        return $this->model->changeStatusByCustomerId($orderId, $newStatus, $customer_id);
    }

    public function addOrder($customer_recipient_name, $phone, $email, $customer_id, $order_date, $total_price, $status, $address_id, $note, $pttt)
    {
        return $this->model->addOrder($customer_recipient_name, $phone, $email, $customer_id, $order_date, $total_price, $status, $address_id, $note, $pttt);
    }

    public function addDetailOrder($order_id, $product_id, $quantity, $price)
    {
        return $this->model->addDetailOrder($order_id, $product_id, $quantity, $price);
    }

    public function getAutoIncrementId()
    {
        return $this->model->getAutoIncrementId();
    }

    public function getOrdersByDateRange($from, $to)
    {
        return $this->model->getOrdersByDateRange($from, $to);
    }

    public function getOrdersWithFilters($from = "", $to = "", $keyword = "", $status = "", $thanhpho = "", $quan = "", $phuong = "")
    {
        return $this->model->getOrdersWithFilters($from, $to, $keyword, $status, $thanhpho, $quan, $phuong);
    }

    public function getOrderHistoriesWithFilters($from = "", $to = "", $customer_id = "", $status = ""){
        return $this->model->getOrderHistoriesWithFilters($from, $to,$customer_id,$status);
}
    
    public function getOrderCount()
    {
        return $this->model->getOrderCount();
    }

    public function getTotalCount()
    {
        return $this->model->getTotalCount();
    }
}
