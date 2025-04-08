<?php
require_once("database/connect.php");
class TKModel
{
    private $db;
    public function __construct()
    {
        $this->db = new database();
    }

    public function them($username, $phone, $email, $password, $status, $role)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($username) && !empty($email) && !empty($password)) {
                // Hash the password for security
                $conn = $this->db->getConnection();
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                if ($conn->connect_error) {
                    die('Connection failed: ' . $conn->connect_error);
                }
                try {
                    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                    $checkStmt->bind_param("s", $email);
                    $checkStmt->execute();
                    if ($checkStmt->get_result()->num_rows > 0) {
                        $checkStmt->close();
                        return false; // Email đã tồn tại cho user khác
                    }
                    $checkStmt->close();
                    $stmt = $conn->prepare("INSERT INTO users (username, phone, email, password, status, role) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssii", $username, $phone, $email, $hashedPassword, $status, $role);


                    $result = $stmt->execute();
                    $stmt->close();

                    return $result;
                } catch (Exception $e) {
                    // Ghi log lỗi nếu cần
                    error_log("Error adding user: " . $e->getMessage());
                    return false;
                }
            }
        }
    }

    public function sua($id, $username, $phone, $email, $password, $status, $role)
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return false;
        }

        if (empty($username) || empty($email)) {
            return false;
        }

        $conn = $this->db->getConnection();
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        try {
            // Kiểm tra email trùng (trừ user hiện tại)
            $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $checkStmt->bind_param("si", $email, $id);
            $checkStmt->execute();
            if (mysqli_num_rows($checkStmt->get_result()) > 0) {
                $checkStmt->close();
                return false; // Email đã tồn tại cho user khác
            }
            $checkStmt->close();

            // Xử lý mật khẩu
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET username = ?, phone = ?, email = ?, password = ?, status = ?, role = ? WHERE id = ?");
                $stmt->bind_param("ssssiii", $username, $phone, $email, $hashedPassword, $status, $role, $id);
            } else {
                // Nếu không nhập mật khẩu mới thì giữ nguyên mật khẩu cũ
                $stmt = $conn->prepare("UPDATE users SET username = ?, phone = ?, email = ?, status = ?, role = ? WHERE id = ?");
                $stmt->bind_param("sssiii", $username, $phone, $email, $status, $role, $id);
            }

            $result = $stmt->execute();
            $stmt->close();

            return $result;
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }
    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $conn = $this->db->getConnection();
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) { // trả về true /false
            die('Execute failed: ' . $stmt->error);
        }

        $result = $stmt->get_result(); //kết quả
        $user = $result->fetch_assoc(); //fetch dữ liệu dưới dạng associative array
        return $user;
    }

    public function xoa($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $conn = $this->db->getConnection();

        if ($conn->connect_error) {
            return false; // Lỗi kết nối
        }

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return false; // Lỗi khi chuẩn bị truy vấn
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            return false; // Lỗi khi thực thi truy vấn
        }

        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        $this->db->closeConnection();

        return $affectedRows > 0; // Trả về true nếu có bản ghi bị xóa, ngược lại false
    }
}
