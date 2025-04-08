<?php
require_once("database/connect.php");

class OrderHistoryModel{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getAllOrderHistory(){
        $sql = "SELECT  * FROM donhang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while($row = $result->fetch_assoc()){
            $orders[] = $row;
        }
        $stmt->close();

        return $orders;
    }

    public function getAllOrderHistoryByCustomerId($id){
        $sql = "SELECT  * FROM donhang WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while($row = $result->fetch_assoc()){
            $orders[] = $row;
        }
        $stmt->close();

        return $orders;
    }

    public function getOrderHistoryByStatus($status)
    {
        $sql = "SELECT  * FROM donhang WHERE status = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s",$status);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        return $order;
    }



    
}
?>