<?php
require_once("database/connect.php");
class CartModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getAllProductInCart($customerId)
    {
        $sql = "SELECT * FROM giohang WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }

    public function addProductToCart($productId, $quantity, $customerId)
    {
        $sql = "INSERT INTO giohang (product_id, quantity, customer_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $productId, $quantity, $customerId);
        return $stmt->execute();
    }

    public function removeCart($customerId)
    {
        $sql = "DELETE FROM giohang WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        return $stmt->execute();
    }
}
