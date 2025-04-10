<?php
// require_once __DIR__ . '/../database/connect.php';
require_once('database/connect.php');
class FormProductModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getProductById($id)
    {
        $id = (int)$id;
        $sql = "SELECT * FROM SanPham WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
        return $product;
    }
}
