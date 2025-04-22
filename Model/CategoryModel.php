<?php

require_once __DIR__ . '/../database/connect.php';
// require_once("./database/connect.php");


class CategoryModel {
    private $conn;

    public function __construct() {
        $db = new database();
        $this->conn = $db->getConnection();
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
    }

    function insertChungLoai($tenchungloai) {
        $stmt = $this->conn->prepare("INSERT INTO  chungloai (tenchungloai) VALUES (?)");
        $stmt->bind_param("s", $tenchungloai);
    
        if ($stmt->execute()) {
            $new_id = $stmt->insert_id; // Lấy ID vừa thêm
            $stmt->close();
            return $new_id;
        } else {
            $stmt->close();
            return null; // hoặc throw Exception
        }
    }
    public function deleteChungLoai($machungloai) {
        $stmt = $this->conn->prepare("DELETE FROM  chungloai WHERE machungloai = ?");
        $stmt->bind_param("s", $machungloai);
        return $stmt->execute();
    }
    public function updateChungLoai($machungloai, $tenchungloai) {
        $stmt = $this->conn->prepare("UPDATE  chungloai SET tenchungloai = ? WHERE machungloai = ?");
        $stmt->bind_param("ss", $tenchungloai, $machungloai);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    function insertTheLoai($tentheloai, $machungloai) {
        $stmt = $this->conn->prepare("INSERT INTO theloai (tentheloai, machungloai) VALUES (?, ?)");
        $stmt->bind_param("si", $tentheloai, $machungloai);
        return $stmt->execute();
    }
    
    public function updateTheLoai($matheloai, $tentheloai) {
        $stmt = $this->conn->prepare("UPDATE theloai SET tentheloai = ? WHERE matheloai = ?");
        $stmt->bind_param("ss", $tentheloai, $matheloai);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    public function deleteTheLoai($matheloai) {
        $stmt = $this->conn->prepare("DELETE FROM theloai WHERE matheloai = ?");
        $stmt->bind_param("s", $matheloai);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    
    public function getChungLoaiWithTheLoaiAndProductCount() {
        $sql = "
            SELECT 
                cl.machungloai,
                cl.tenchungloai,
                tl.matheloai,
                tl.tentheloai,
                COUNT(sp.product_id) AS so_sanpham
            FROM  chungloai cl
            LEFT JOIN theloai tl ON cl.machungloai = tl.machungloai
            LEFT JOIN sanpham sp ON tl.matheloai = sp.matheloai AND sp.status = 1
            GROUP BY cl.machungloai, cl.tenchungloai, tl.matheloai, tl.tentheloai
            ORDER BY cl.machungloai, tl.matheloai
        ";
        $result = $this->conn->query($sql);
    
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    
}
?>
