<?php
require_once 'Model/DiaChiModel.php';
class DiaChiController
{
    private $diaChiModel;

    public function __construct()
    {
        $this->diaChiModel = new DiaChiModel();
    }

    public function getAllDiaChiByCustomerId($customerId)
    {
        return $this->diaChiModel->getAllDiaChiByCustomerId($customerId);
    }

    public function addDiaChi($diachi, $phuong, $quan, $thanhpho)
    {
        return $this->diaChiModel->addDiaChi($diachi, $phuong, $quan, $thanhpho);
    }

    public function getAutoIncrementId()
    {
        return $this->diaChiModel->getAutoIncrementId();
    }

    public function addDiaChiToCustomer($customer_id, $address_id)
    {
        return $this->diaChiModel->AddDiaChiToKhachHang($customer_id, $address_id);
    }

    public function getDiaChiById($address_id)
    {
        return $this->diaChiModel->getDiaChiById($address_id);
    }
}
