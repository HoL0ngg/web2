    <?php
    require_once('database/connect.php');

    class TheLoaiModel
    {
        private $conn;

        public function __construct()
        {
            $db = new database();
            $this->conn = $db->getConnection();
        }

        public function getAll()
        {
            $sql = "SELECT matheloai, tentheloai FROM TheLoai";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $theloai = $result->fetch_all(MYSQLI_ASSOC); // ✔ Lấy toàn bộ
            $stmt->close();
            return $theloai;
        }

        public function getTheLoaiByChungLoai($machungloai){
            $sql = "SELECT matheloai , tentheloai FROM TheLoai WHERE machungloai = ?";
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