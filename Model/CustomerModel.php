<?php
require_once("database/connect.php");

class CustomerModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getCustomerByID($id)
    {
        $sql = "SELECT * FROM KhachHang WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cus = $result->fetch_assoc();
        $stmt->close();
        // echo "$cus";
        return $cus;
    }
}
?>
