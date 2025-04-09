<?php
require_once __DIR__ . '/../database/connect.php';
// require_once('database/connect.php');
class ProductModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getProductById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row; // Trả về mảng chứa toàn bộ thông tin sản phẩm
        }
        $stmt->close();

        return null;
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
    public function getProductsByPageNum($page = 1, $limit = 8, $keyword = "")
    {
        $offset = ($page - 1) * $limit;
        $keyword = "%$keyword%";

        $sql = "SELECT sp.*, ha.image_url
                FROM SanPham sp
                JOIN SanPhamHinhAnh ha ON sp.product_id = ha.product_id
                WHERE ha.is_main = TRUE AND sp.product_name LIKE ?
                LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $keyword, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    public function getMainImageByProductId($productId)
    {
        $stmt = $this->conn->prepare("SELECT image_url FROM SanphamHinhanh WHERE product_id = ? AND is_main = 1");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['image_url'];
        } else {
            return 'imgs/default.jpg'; // fallback nếu không có hình chính
        }
    }

    public function getQuantityProducts($keyword = "")
    {
        $keyword = "%$keyword%";
        $sql = "SELECT COUNT(*) AS soluong FROM SanPham WHERE product_name LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['soluong'];
    }
}
