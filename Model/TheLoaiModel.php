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
            $sql = "SELECT matheloai,tentheloai FROM theloai";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $brand = $result->fetch_assoc();
            $stmt->close();
            return $brand;
        }
    }
    ?>