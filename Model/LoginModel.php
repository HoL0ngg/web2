    <?php
    require_once(__DIR__ . '/../database/connect.php');

    class LoginModel
    {
        private $conn;

        public function __construct()
        {
            $db = new database();
            $this->conn = $db->getConnection();
        }

        public function getUserByUsername($username)
        {
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            $stmt->close(); // không bắt buộc nhưng nên có
            return $user;
        }
    }
    ?>