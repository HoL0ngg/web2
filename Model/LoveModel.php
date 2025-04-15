<?php
require_once('database/connect.php');
class LoveModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function addLove($customer_id, $product_id)
    {
        $sql = "INSERT INTO yeuthich (user_id, product_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $customer_id, $product_id);
        return $stmt->execute();
    }

    public function removeLove($customer_id, $product_id)
    {
        $sql = "DELETE FROM yeuthich WHERE user_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $customer_id, $product_id);
        return $stmt->execute();
    }

    public function getLoveProducts($customer_id)
    {
        $sql = "SELECT * FROM yeuthich WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
