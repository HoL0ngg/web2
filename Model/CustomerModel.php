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
            $sql = "SELECT * FROM  khachhang";
            $stmt= $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $khachhangs = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $khachhangs;
        }

        public function getNameCustomerByID($id)
        {
            $sql = "SELECT customer_name FROM  khachhang WHERE customer_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $name = $result->fetch_assoc();
            $stmt->close();
            return $name ? $name['customer_name'] : 'Không rõ';
        }
        public function getPhoneCustomerByID($id){
            $sql = "SELECT phone FROM  khachhang WHERE customer_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $phone = $result->fetch_assoc();
            $stmt->close();
            return $phone ? $phone['phone'] : 'Không rõ';
        }

        public function getCustomerIdByID($id){
            $sql = "SELECT customer_id FROM  khachhang WHERE user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $id = $result->fetch_assoc();
            $stmt->close();
            return $id ? $id['customer_id'] : 'Không rõ';
        }
}
