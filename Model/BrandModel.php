    <?php
    require_once("database/connect.php");
    class BrandModel
    {
        private $conn;

        public function __construct()
        {
            $db = new database();
            $this->conn = $db->getConnection();
        }

        public function getAll()
        {
            $sql = "SELECT brand_id, brand_name FROM Brand";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $brands = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $brands;
        }

        public function getBrandByMaChungLoai($machungloai){
            $sql = "SELECT DISTINCT b.brand_id, b.brand_name
                    FROM TheLoai t
                    JOIN SanPham s ON t.matheloai = s.matheloai
                    JOIN Brand b ON s.brand_id = b.brand_id
                    WHERE t.machungloai = ?;
                    ";
            $stmt= $this->conn->prepare($sql);
            $stmt->bind_param("i", $machungloai);
            $stmt->execute();
            $result = $stmt->get_result();
            $theloais = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $theloais;
        }
    }
    ?>