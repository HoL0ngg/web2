<?php
// Include đúng đường dẫn
require_once __DIR__ . '/../Model/SupplierModel.php';


function getSuppliersAndProducts() {
    $model = new SupplierModel();
    return $model->getSuppliersAndProducts();
}
