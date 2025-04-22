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
            $sql = "SELECT * FROM  nhomquyen";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $role_names = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $role_names;
        }

        public function themNhomQuyen($role_name)
        {
            $sql = "INSERT INTO nhomquyen(role_name) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $role_name);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
    ?>