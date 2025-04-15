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

    public function getProductsByPageNum($page = 1, $limit = 8, $keyword = "", $selected_checkboxes_brand = [], $selected_checkboxes_loaisanpham = [], $maTheLoai = 0, $minprice = 0, $maxprice = 9000000, $maChungLoai = 0)
    {
        $offset = ($page - 1) * $limit;
        $keyword = "%$keyword%";

        $sql = "SELECT sp.*, ha.image_url
                FROM SanPham sp
                JOIN SanPhamHinhAnh ha ON sp.product_id = ha.product_id
                JOIN theloai tl ON sp.matheloai = tl.matheloai
                WHERE ha.is_main = TRUE AND sp.product_name LIKE ? AND sp.status = 1";

        $params = [];
        $types = "s"; // keyword là string
        $params[] = $keyword;

        if (!empty($selected_checkboxes_brand)) {
            $chuoichamhoibrand = implode(",", array_fill(0, count($selected_checkboxes_brand), "?"));
            $sql .= " AND sp.brand_id IN ($chuoichamhoibrand)";
            foreach ($selected_checkboxes_brand as $brand_id) {
                $types .= "i";
                $params[] = $brand_id;
            }
        }

        if (!empty($selected_checkboxes_loaisanpham)) {
            $chuoichamhoiloaisanpham = implode(",", array_fill(0, count($selected_checkboxes_loaisanpham), "?"));
            $sql .= " AND sp.matheloai IN ($chuoichamhoiloaisanpham)";
            foreach ($selected_checkboxes_loaisanpham as $maloaisanpham) {
                $types .= "i";
                $params[] = $maloaisanpham;
            }
        }

        if ($maxprice > $minprice) {
            $sql .= " AND sp.price BETWEEN ? AND ?";
            $types .= "ii";
            $params[] = $minprice;
            $params[] = $maxprice;
        }

        if ($maChungLoai != 0) {
            $sql .= " AND tl.machungloai = ?";
            $types .= "i";
            $params[] = $maChungLoai;
        }

        if ($maTheLoai != 0) {
            $sql .= " AND sp.maTheLoai = ?";
            $types .= "i";
            $params[] = $maTheLoai;
        }

        $sql .= " LIMIT ? OFFSET ?";
        $types .= "ii";
        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->conn->prepare($sql);


        // Tạo mảng bind đúng chuẩn tham chiếu
        $bind_names[] = $types;
        foreach ($params as $key => $value) {
            $bind_name = 'bind' . $key;
            $$bind_name = $value;
            $bind_names[] = &$$bind_name;
        }

        call_user_func_array([$stmt, 'bind_param'], $bind_names);

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


    public function getQuantityProducts($keyword = "", $selected_checkboxes_brand = [], $selected_checkboxes_loaisanpham = [], $maTheLoai = 0, $minprice = 0, $maxprice = 9000000,  $maChungLoai = 0)
    {
        $keyword = "%$keyword%";
        // $sql = "SELECT COUNT(*) AS soluong FROM SanPham WHERE product_name LIKE ?";
        $sql = "SELECT COUNT(*) AS soluong
        FROM SanPham sp
        JOIN theloai tl ON sp.matheloai = tl.matheloai
        WHERE sp.product_name LIKE ? AND sp.status = 1";



        $params = [];
        $types = "s";
        $params[] = $keyword;

        if (!empty($selected_checkboxes_brand)) {
            $chuoichamhoibrand = implode(",", array_fill(0, count($selected_checkboxes_brand), "?"));
            $sql .= " AND sp.brand_id IN ($chuoichamhoibrand)";
            foreach ($selected_checkboxes_brand as $id) {
                $types .= "i";
                $params[] = $id;
            }
        }

        if (!empty($selected_checkboxes_loaisanpham)) {
            $chuoichamhoiloaisanpham = implode(",", array_fill(0, count($selected_checkboxes_loaisanpham), "?"));
            $sql .= " AND sp.matheloai IN ($chuoichamhoiloaisanpham)";
            foreach ($selected_checkboxes_loaisanpham as $maloaisanpham) {
                $types .= "i";
                $params[] = $maloaisanpham;
            }
        }

        if ($maxprice > $minprice) {
            $sql .= " AND sp.price BETWEEN ? AND ?";
            $types .= "ii";
            $params[] = $minprice;
            $params[] = $maxprice;
        }

        if ($maChungLoai != 0) {
            $sql .= " AND tl.machungloai = ?";
            $types .= "i";
            $params[] = $maChungLoai;
        }

        if ($maTheLoai != 0) {
            $sql .= " AND sp.maTheLoai = ?";
            $types .= "i";
            $params[] = $maTheLoai;
        }


        $stmt = $this->conn->prepare($sql);

        // Tạo mảng bind đúng chuẩn tham chiếu
        $bind_names[] = $types;
        foreach ($params as $key => $value) {
            $bind_name = 'bind' . $key;
            $$bind_name = $value;
            $bind_names[] = &$$bind_name;
        }



        call_user_func_array([$stmt, 'bind_param'], $bind_names);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['soluong'];
    }
}
