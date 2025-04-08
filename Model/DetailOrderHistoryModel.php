<?php
require_once("database/connect.php");

class DetailOrderHistoryModel{
    private $conn;
    
    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getAllDetailOrderHistoryByOrderId($id){
        $sql = "SELECT  * FROM chitietdonhang WHERE order_id = ?";
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

}

?>