<?php
    require_once('database/connect.php');

    class CustomerModel
    {
        private $conn;

        public function __construct()
        {
            $db = new database();
            $this->conn = $db->getConnection();
        }
        
        public function getAllKhachHang(){
            $sql = "SELECT * FROM KhachHang";
            $stmt= $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $khachhangs = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $khachhangs;
        }

        public function getNameCustomerByID($id)
        {
            $sql = "SELECT customer_name FROM KhachHang WHERE customer_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $name = $result->fetch_assoc();
            $stmt->close();
            return $name ? $name['customer_name'] : 'Không rõ';
        }
}
