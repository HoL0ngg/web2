<?php
require_once __DIR__ . '/../database/connect.php';
class TKModel
{
    private $conn;
    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function them($username, $fullname, $phone, $email, $password, $status, $role)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($username) && !empty($email) && !empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sqlInsert = "";

                try {
                    // 1. Kiểm tra username đã tồn tại chưa
                    $checkUsername = $this->conn->prepare("SELECT user_id FROM users WHERE username = ?");
                    $checkUsername->bind_param("s", $username);
                    $checkUsername->execute();
                    if ($checkUsername->get_result()->num_rows > 0) {
                        $checkUsername->close();
                        return 'username_exists';
                    }
                    $checkUsername->close();

                    // 2. Tùy theo role để xác định bảng kiểm tra email và phone
                    switch ($role) {
                        case 1:
                        case 2:
                            $sqlCheckEmail = "SELECT employee_id FROM nhanvien WHERE email = ?";
                            $sqlCheckPhone = "SELECT employee_id FROM nhanvien WHERE phone = ?";
                            $sqlInsert = "INSERT INTO nhanvien(user_id, name, phone, email) VALUES(?, ?, ?, ?)";
                            break;

                        default:
                            $sqlCheckEmail = "SELECT customer_id FROM khachhang WHERE email = ?";
                            $sqlCheckPhone = "SELECT customer_id FROM khachhang WHERE phone = ?";
                            $sqlInsert = "INSERT INTO khachhang(user_id, customer_name, phone, email) VALUES(?, ?, ?, ?)";
                            break;
                    }

                    // 3. Kiểm tra số điện thoại trùng
                    $checkPhone = $this->conn->prepare($sqlCheckPhone);
                    $checkPhone->bind_param("s", $phone);
                    $checkPhone->execute();
                    if ($checkPhone->get_result()->num_rows > 0) {
                        $checkPhone->close();
                        return 'phone_exists';
                    }
                    $checkPhone->close();

                    // 4. Kiểm tra email trùng
                    $checkEmail = $this->conn->prepare($sqlCheckEmail);
                    $checkEmail->bind_param("s", $email);
                    $checkEmail->execute();
                    if ($checkEmail->get_result()->num_rows > 0) {
                        $checkEmail->close();
                        return 'email_exists';
                    }
                    $checkEmail->close();


                    // 5. Insert vào bảng users
                    $stmt = $this->conn->prepare("INSERT INTO users (username, password, status, role_id) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssii", $username, $hashedPassword, $status, $role);
                    if (!$stmt->execute()) {
                        return 'insert_failed';
                    }
                    $stmt->close();

                    // 6. Insert vào bảng nhân viên hoặc khách hàng
                    $user_id = $this->conn->insert_id;
                    $stmtInsert = $this->conn->prepare($sqlInsert);
                    $stmtInsert->bind_param("isss", $user_id, $fullname, $phone, $email);
                    $stmtInsert->execute();
                    $stmtInsert->close();

                    return 'success';
                } catch (Exception $e) {
                    error_log("Error adding user: " . $e->getMessage());
                    return 'exception';
                }
            }
        }
        return 'invalid_request';
    }


    public function sua($id, $username, $phone, $email, $password, $status, $role)
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return false;
        }

        if (empty($username) || empty($email)) {
            return false;
        }

        try {
            // Kiểm tra email trùng (trừ user hiện tại)
            $checkStmt = $this->conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
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
                $stmt = $this->conn->prepare("UPDATE users SET username = ?, phone = ?, email = ?, password = ?, status = ?, role_id = ? WHERE id = ?");
                $stmt->bind_param("ssssiii", $username, $phone, $email, $hashedPassword, $status, $role, $id);
            } else {
                // Nếu không nhập mật khẩu mới thì giữ nguyên mật khẩu cũ
                $stmt = $this->conn->prepare("UPDATE users SET username = ?, phone = ?, email = ?, status = ?, role_id = ? WHERE id = ?");
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
        $query = "SELECT 
            u.*,
            COALESCE(nv.phone, kh.phone) AS phone,
            COALESCE(nv.email, kh.email) AS email,
            COALESCE(nv.name, kh.customer_name) AS fullname
            FROM users u
            LEFT JOIN NhanVien nv ON nv.user_id = u.user_id
            LEFT JOIN KhachHang kh ON kh.user_id = u.user_id
            WHERE u.user_id = ?";
        $stmt = $this->conn->prepare($query);
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
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false; // Lỗi khi chuẩn bị truy vấn
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            return false; // Lỗi khi thực thi truy vấn
        }

        $affectedRows = $stmt->affected_rows;
        $stmt->close();

        return $affectedRows > 0; // Trả về true nếu có bản ghi bị xóa, ngược lại false
    }

    public function getAllUsers()
    {
        $sql = "SELECT 
            u.*,  -- Lấy tất cả các cột từ bảng users (user_id, username, password, role_id, status, ...)
            
            COALESCE(nv.phone, kh.phone) AS phone,  
            -- Ưu tiên lấy số điện thoại từ bảng NhanVien (nếu tồn tại), nếu không có thì lấy từ bảng KhachHang

            COALESCE(nv.email, kh.email) AS email,  
            -- Tương tự, ưu tiên lấy email từ bảng NhanVien, nếu không có thì lấy từ bảng KhachHang
            COALESCE(nv.name, kh.customer_name) AS fullname,
            r.role_name  
            -- Lấy tên vai trò từ bảng roles dựa trên role_id

            FROM users u
            -- Bảng chính là bảng users

            LEFT JOIN NhanVien nv ON nv.user_id = u.user_id  
            -- Nối bảng NhanVien với users thông qua user_id (nếu người dùng là nhân viên thì sẽ có dữ liệu)

            LEFT JOIN KhachHang kh ON kh.user_id = u.user_id  
            -- Nối bảng KhachHang với users thông qua user_id (nếu người dùng là khách hàng thì sẽ có dữ liệu)

            LEFT JOIN nhomquyen r ON u.role_id = r.role_id  
            -- Nối bảng roles với users để lấy tên vai trò của người dùng dựa vào role_id

            ORDER BY u.user_id DESC
            -- Sắp xếp kết quả theo user_id giảm dần (người dùng mới nhất nằm trên cùng)
            ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $users;
    }
}
