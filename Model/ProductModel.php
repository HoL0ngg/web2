<?php
// require_once __DIR__ . '/../database/connect.php';
require_once('database/connect.php');
class ProductModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getNameProductById($id)
    {
        $sql = "SELECT product_name FROM sanpham WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $name_product = $result->fetch_assoc();
        $stmt->close();
        return $name_product['product_name'];
    }
    public function getProductsByPageNum($page = 1, $limit = 8)
    {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT sp.*, ha.image_url
                FROM SanPham sp
                JOIN SanPhamHinhAnh ha ON sp.product_id = ha.product_id
                WHERE ha.is_main = TRUE
                LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    public function getQuantityProducts()
    {
        $sql = "SELECT COUNT(*) AS soluong FROM SanPham";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['soluong'];
    }
}
