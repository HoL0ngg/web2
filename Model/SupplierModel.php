<?php

require_once __DIR__ . '/../database/connect.php';
// require_once("./database/connect.php");


class SupplierModel {
    private $conn;

    public function __construct() {
        $db = new database();
        $this->conn = $db->getConnection();
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
    }
    
    public function getSuppliersAndProducts() {
        $sql = "
            SELECT 
                ncc.supplier_id,
                ncc.supplier_name,
                ncc.address,
                sp.product_id,
                sp.product_name
            FROM nhacungcapsanpham AS nccsp
            JOIN nhacungcap AS ncc ON nccsp.supplier_id = ncc.supplier_id
            JOIN sanpham AS sp ON nccsp.product_id = sp.product_id
        ";
        $result = $this->conn->query($sql);
    
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    
}
?>
