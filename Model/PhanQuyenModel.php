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

        public function getChiTietNhomQuyen($role_id)
        {
            $sql = "SELECT function_id, action FROM chitietnhomquyen WHERE role_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $role_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }
    ?>
