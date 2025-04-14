<?php
require_once("database/connect.php");
class DiaChiModel
{
    private $conn;

    public function __construct()
    {

        $db = new database();

        $this->conn = $db->getConnection();
    }

    public function getAllDiaChiByCustomerId($customerId)
    {

        $sql = "SELECT address_id FROM khachhang_diachi WHERE customer_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $customerId);

        $stmt->execute();

        $result = $stmt->get_result();
        $addressIds = [];
        while ($row = $result->fetch_assoc()) {
            $addressIds[] = $row['address_id'];
        }
        $stmt->close();
        $addresses = [];
        foreach ($addressIds as $addressId) {
            $sql = "SELECT * FROM diachi WHERE address_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $addressId);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $addresses[] = $row;
            }
            $stmt->close();
        }
        return $addresses;
    }

    public function getAutoIncrementId()
    {
        $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'webbanhang' AND TABLE_NAME = 'diachi'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['AUTO_INCREMENT'];
    }

    public function addDiaChi($diachi, $phuong, $quan, $thanhpho)
    {
        $sql = "INSERT INTO diachi ( sonha, phuong, quan, thanhpho) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $diachi, $phuong, $quan, $thanhpho);
        if ($stmt->execute()) {
            return $this->conn->insert_id; // Trả về ID của địa chỉ vừa thêm
        } else {
            return false;
        }
    }

    public function AddDiaChiToKhachHang($customer_id, $address_id)
    {
        $sql = "INSERT INTO khachhang_diachi (customer_id, address_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $customer_id, $address_id);
        return $stmt->execute();
    }

    public function getDiaChiById($id)
    {
        $sql = "SELECT * FROM diachi WHERE address_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
