    <?php
    require_once("database/connect.php");

    class PhanQuyenModel
    {
        private $conn;

        public function __construct()
        {
            $db = new database();
            $this->conn = $db->getConnection();
        }

        public function getDanhMucChucNang()
        {
            $sql = "SELECT * FROM danhmucchucnang";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }
    ?>
