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
            $sql = "SELECT brand_id,brand_name FROM brand";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $brand = $result->fetch_assoc();
            $stmt->close();
            return $brand;
        }
    }
    ?>