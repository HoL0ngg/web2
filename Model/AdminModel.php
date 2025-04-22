<?php
require_once(__DIR__ . '/../database/connect.php');
class AdminModel
{
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function checkLogin($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? AND role_id = 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
    public function changePass()
    {
        $plainPassword = 'admin123';
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $username = 'admin'; // hoặc username bạn muốn cập nhật
        $stmt->bind_param("ss", $hashedPassword, $username);

        $stmt->execute();
        $stmt->close();
    }
}
