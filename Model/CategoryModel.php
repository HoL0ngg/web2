<?php
require_once __DIR__ . '/../database/connect.php';

class CategoryModel {
    private $conn;

    public function __construct() {
        $db = new database();
        $this->conn = $db->getConnection();
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
    }

    public function insertChungLoai($tenchungloai, $hinhanh = null) {
        $stmt = $this->conn->prepare("INSERT INTO chungloai (tenchungloai, hinhanh) VALUES (?, ?)");
        $stmt->bind_param("ss", $tenchungloai, $hinhanh);
        if ($stmt->execute()) {
            $new_id = $stmt->insert_id;
            $stmt->close();
            return $new_id;
        }
        $stmt->close();
        return null;
    }

    public function deleteChungLoai($machungloai) {
        $stmt = $this->conn->prepare("DELETE FROM chungloai WHERE machungloai = ?");
        $stmt->bind_param("s", $machungloai);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateChungLoai($machungloai, $tenchungloai) {
        $stmt = $this->conn->prepare("UPDATE chungloai SET tenchungloai = ? WHERE machungloai = ?");
        $stmt->bind_param("ss", $tenchungloai, $machungloai);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateChungLoaiWithTheLoai($machungloai, $tenchungloai, $theloai, $hinhanh = null) {
        $this->conn->begin_transaction();
        try {
            // Update tên chủng loại và hình ảnh (nếu có)
            if ($hinhanh) {
                $stmt = $this->conn->prepare("UPDATE chungloai SET tenchungloai = ?, hinhanh = ? WHERE machungloai = ?");
                $stmt->bind_param("sss", $tenchungloai, $hinhanh, $machungloai);
            } else {
                $stmt = $this->conn->prepare("UPDATE chungloai SET tenchungloai = ? WHERE machungloai = ?");
                $stmt->bind_param("ss", $tenchungloai, $machungloai);
            }
            $stmt->execute();
            $stmt->close();
    
            // Nếu danh sách thể loại không rỗng, xóa các thể loại không có trong danh sách
            if (!empty($theloai)) {
                $placeholders = implode(',', array_fill(0, count($theloai), '?'));
                $stmt = $this->conn->prepare("DELETE FROM theloai WHERE machungloai = ? AND matheloai NOT IN ($placeholders)");
                $types = "s" . str_repeat('i', count($theloai));
                $params = array_merge([$machungloai], $theloai);
                $stmt->bind_param($types, ...$params);
                $stmt->execute();
                $stmt->close();
    
                // Cập nhật machungloai cho các thể loại trong danh sách
                foreach ($theloai as $matheloai) {
                    $stmt = $this->conn->prepare("UPDATE theloai SET machungloai = ? WHERE matheloai = ?");
                    $stmt->bind_param("si", $machungloai, $matheloai);
                    $stmt->execute();
                    $stmt->close();
                }
            } else {
                // Nếu danh sách thể loại rỗng, xóa tất cả thể loại liên kết với chủng loại
                $stmt = $this->conn->prepare("DELETE FROM theloai WHERE machungloai = ?");
                $stmt->bind_param("s", $machungloai);
                $stmt->execute();
                $stmt->close();
            }
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Lỗi khi cập nhật chủng loại: " . $e->getMessage());
            return false;
        }
    }

    public function insertTheLoai($tentheloai, $machungloai) {
        $stmt = $this->conn->prepare("INSERT INTO theloai (tentheloai, machungloai) VALUES (?, ?)");
        $stmt->bind_param("si", $tentheloai, $machungloai);
        if ($stmt->execute()) {
            $new_id = $stmt->insert_id;
            $stmt->close();
            return $new_id;
        }
        $stmt->close();
        return null;
    }

    public function updateTheLoai($matheloai, $tentheloai) {
        $stmt = $this->conn->prepare("UPDATE theloai SET tentheloai = ? WHERE matheloai = ?");
        $stmt->bind_param("ss", $tentheloai, $matheloai);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteTheLoai($matheloai) {
        // Check if theloai has associated products
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as count 
            FROM sanpham 
            WHERE matheloai = ? AND status = 1
        ");
        $stmt->bind_param("s", $matheloai);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row['count'] > 0) {
            return false; // Cannot delete due to associated products
        }

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
                cl.hinhanh,
                tl.matheloai,
                tl.tentheloai,
                COUNT(sp.product_id) AS so_sanpham
            FROM chungloai cl
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

    public function getTheLoaiByChungLoai($machungloai) {
        $stmt = $this->conn->prepare("
            SELECT 
                tl.matheloai, 
                tl.tentheloai,
                COUNT(sp.product_id) AS so_sanpham
            FROM theloai tl
            LEFT JOIN sanpham sp ON tl.matheloai = sp.matheloai AND sp.status = 1
            WHERE tl.machungloai = ?
            GROUP BY tl.matheloai, tl.tentheloai
        ");
        $stmt->bind_param("s", $machungloai);
        $stmt->execute();
        $result = $stmt->get_result();
        $theloai = [];
        while ($row = $result->fetch_assoc()) {
            $theloai[] = $row;
        }
        $stmt->close();
        return $theloai;
    }
}
?>