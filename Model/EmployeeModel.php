<?php
require_once("database/connect.php");

class EmployeeModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getNameEmployeeByID($id)
    {
        $sql = "SELECT name FROM nhanvien WHERE employee_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $name = $result->fetch_assoc();
        $stmt->close();
        return $name ? $name['name'] : 'Không rõ';
    }

    public function getEmployeeIdByUserID($id)
    {
        $sql = "SELECT employee_id FROM nhanvien WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $id = $result->fetch_assoc();
        $stmt->close();
        return $id ? $id['employee_id'] : 'Không tìm thấy id';
    }
}
