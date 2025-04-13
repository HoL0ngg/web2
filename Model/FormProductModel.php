<?php
require_once __DIR__ . '/../database/connect.php';
// require_once('database/connect.php');
class FormProductModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getProductById($id)
    {
        $sql = "SELECT sp.*, ha.image_url
                FROM SanPham sp
                JOIN sanphamhinhanh ha ON sp.product_id = ha.product_id  
                WHERE sp.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
        return $product;
    }

    public function them($img, $product_name, $quantity, $price, $theloai, $thuonghieu, $status, $mota)
    {
        try {
            $stmtCheckProName = "SELECT product_name FROM sanpham WHERE product_name = ?";
            $stmtCheckProName = $this->conn->prepare($stmtCheckProName);
            $stmtCheckProName->bind_param("s", $product_name);
            $stmtCheckProName->execute();
            if ($stmtCheckProName->get_result()->num_rows > 0) {
                $stmtCheckProName->close();
                return 'name_exists';
            }

            $sqlInsert = "INSERT INTO sanpham(product_name,quantity,price,mota,brand_id, matheloai,status) VALUES(?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sqlInsert);
            $stmt->bind_param("siisiii", $product_name, $quantity, $price, $mota, $thuonghieu, $theloai, $status);
            if (!$stmt->execute()) {
                return 'insert_failed';
            }
            $product_id = $this->conn->insert_id;
            $stmt->close();

            $stmtInsertImg = "INSERT INTO sanphamhinhanh(image_url,is_main,product_id) VALUES(?,?,?)";
            $stmtInsertImg = $this->conn->prepare($stmtInsertImg);
            $is_main = 1;
            $stmtInsertImg->bind_param("sii", $img, $is_main, $product_id);
            if (!$stmtInsertImg->execute()) {
                return 'insertImg_failed';
            }

            $stmtInsertImg->close();
            return 'success';
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return 'exception';
        }
    }
    public function sua($data) {}
}
