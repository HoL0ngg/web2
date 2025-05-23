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
        $sql = "Select * from giohang where product_id = ? and customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $productId, $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $sql = "UPDATE giohang SET quantity = quantity + ? WHERE product_id = ? AND customer_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $quantity, $productId, $customerId);
        } else {
            $sql = "INSERT INTO giohang (product_id, quantity, customer_id) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $productId, $quantity, $customerId);
        }
        $stmt->execute();
        // $stmt->close();
        return $stmt->affected_rows > 0;
    }

    public function removeCart($customerId)
    {
        $sql = "DELETE FROM giohang WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        return $stmt->execute();
    }

    public function checkProductInCart($productId, $customerId)
    {
        $sql = "SELECT * FROM giohang WHERE product_id = ? AND customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $productId, $customerId);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function removeProductInCart($productId, $customerId)
    {
        $sql = "DELETE FROM giohang WHERE product_id = ? AND customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $productId, $customerId);
        return $stmt->execute();
    }

    public function updateProductInCart($productId, $quantity, $customerId)
    {
        $sql = "UPDATE giohang SET quantity = ? WHERE product_id = ? AND customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $productId, $customerId);
        return $stmt->execute();
    }

    public function deleteCart($customerId)
    {
        $sql = "DELETE FROM giohang WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        return $stmt->execute();
    }

    public function getCartCount($customerId)
    {
        $sql = "SELECT COUNT(*) as count FROM giohang WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['count'];
    }
}
