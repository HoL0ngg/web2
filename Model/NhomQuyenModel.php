    <?php
    require_once('database/connect.php');

    class NhomQuyenModel
    {
        private $conn;

        public function __construct()
        {
            $db = new database();
            $this->conn = $db->getConnection();
        }

        public function getNhomQuyen()
        {
            $sql = "SELECT * FROM NhomQuyen";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $role_names = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $role_names;
        }
    }
    ?>