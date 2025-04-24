    <?php
    require_once(__DIR__ . '/../database/connect.php');

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
        public function themChucNang($function_id, $function_name)
        {
            $sql = "INSERT INTO danhmucchucnang(function_id, function_name,trangthai) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $trangthai = 1;
            $stmt->bind_param("ssi", $function_id, $function_name, $trangthai);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function xoaChiTietNhomQuyen($role_id)
        {
            $sql = "DELETE FROM chitietnhomquyen WHERE role_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $role_id);
            $stmt->execute();
        }

        public function themChiTietNhomQuyen($rold_id, $function_id, $action)
        {
            $sql = "INSERT INTO chitietnhomquyen(role_id, function_id,action) VALUES(?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iss", $rold_id, $function_id, $action);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
            $stmt->close();
        }

        public function getAllowedFunctions($roleId)
        {
            $sql = "SELECT dm.function_id, dm.function_name, ct.action
                    FROM chitietnhomquyen ct
                    JOIN danhmucchucnang dm ON ct.function_id = dm.function_id
                    WHERE ct.role_id = ? AND ct.action = 'read'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $roleId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }
    ?>
