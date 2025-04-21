<?php
    require_once('database/connect.php');

    class ChungLoaiModel
    {
        private $conn;

        public function __construct()
        {
            $db = new database();
            $this->conn = $db->getConnection();
        }
        
        public function getAllChungLoai(){
            $sql = "SELECT * FROM ChungLoai";
            $stmt= $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $chungloais = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $chungloais;
        }

        public function getChungLoaiByChungLoai($machungloai){
            $sql = "SELECT machungloai , tenchungloai FROM ChungLoai WHERE machungloai = ?";
            $stmt= $this->conn->prepare($sql);
            $stmt->bind_param("i", $machungloai);
            $stmt->execute();
            $result = $stmt->get_result();
            $chungloais = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $chungloais;
        }
    }
    ?>