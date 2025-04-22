<?php
require_once("database/connect.php");

class AdressModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getAddressByID($id)
    {
        $sql = "SELECT * FROM diachi WHERE address_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $diachi = $result->fetch_assoc();
        $diachichitiet = $diachi['SoNha'] . ", " . $diachi['Phuong'] . ", " . $diachi['Quan'] . ", " . $diachi['ThanhPho'];
        $stmt->close();
        return $diachi ? $diachichitiet : 'Không rõ';
    }
}
