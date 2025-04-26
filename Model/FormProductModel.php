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
                FROM sanpham sp
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
    public function sua($img, $product_id, $product_name, $quantity, $price, $theloai, $thuonghieu, $status, $mota)
    {
        try {
            $stmtCheckProName = "SELECT product_name FROM sanpham WHERE product_name = ? && product_id != ?";
            $stmtCheckProName = $this->conn->prepare($stmtCheckProName);
            $stmtCheckProName->bind_param("si", $product_name, $product_id);
            $stmtCheckProName->execute();
            if ($stmtCheckProName->get_result()->num_rows > 0) {
                $stmtCheckProName->close();
                return 'name_exists';
            }

            $sqlUpdate = "UPDATE sanpham SET product_name = ?,quantity = ?,price = ?,mota = ?,brand_id = ?, matheloai = ?,status  = ? WHERE product_id = ?";
            $stmt = $this->conn->prepare($sqlUpdate);
            $stmt->bind_param("siisiiii", $product_name, $quantity, $price, $mota, $thuonghieu, $theloai, $status, $product_id);
            if (!$stmt->execute()) {
                return 'update_failed';
            }
            $stmt->close();

            if ($img !== null) {
                $stmtUpdateImg = "UPDATE sanphamhinhanh SET image_url = ? WHERE product_id = ? AND is_main = ?";
                $stmtUpdateImg = $this->conn->prepare($stmtUpdateImg);
                $is_main = 1;
                $stmtUpdateImg->bind_param("sii", $img, $product_id, $is_main);
                if (!$stmtUpdateImg->execute()) {
                    return 'updateImg_failed';
                }
                $stmtUpdateImg->close();
            }
            return 'success';
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return 'exception';
        }
    }
    public function checkProductIsSold($product_id)
    {
        $sql = "SELECT 1 
                FROM chitietdonhang ct 
                JOIN donhang dh ON  ct.order_id = dh.order_id
                WHERE product_id = ? AND status != 'cancelled' 
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return true; // Sản phẩm đã được bán
        } else {
            return false; // Sản phẩm chưa được bán
        }
    }

    public function xoa($product_id)
    {
        try {
            $sql = "DELETE FROM sanpham WHERE product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            if (!$stmt->execute()) {
                return 'delete_failed';
            }
            $stmt->close();
            return 'success';
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return 'exception';
        }
    }
    public function hideProduct($product_id)
    {
        try {
            $sql = "UPDATE sanpham SET status = 0 WHERE product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $stmt->close();
            return 'success';
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return 'exception';
        }
    }
    public function getAllProducts()
    {
        $sql = "SELECT sp.*, ha.image_url, tl.tentheloai, brand.brand_name
                FROM sanpham sp
                JOIN sanphamhinhanh ha ON sp.product_id = ha.product_id
                JOIN theloai tl ON sp.matheloai = tl.matheloai
                JOIN brand ON sp.brand_id = brand.brand_id
                WHERE ha.is_main = TRUE
                ORDER BY product_id DESC";
        $result = $this->conn->query($sql);
        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
        return $products;
    }
}
