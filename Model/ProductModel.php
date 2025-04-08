<?php
require_once("database/connect.php");

class ProductModel{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getNameProductById($id)
    {
        $sql = "SELECT product_name FROM sanpham WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $name_product = $result->fetch_assoc();
        $stmt->close();
        return $name_product['product_name'];
    }
}
?>