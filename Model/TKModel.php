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
                case 1: // Admin
                case 2: // Nhân viên
                    $sqlCheckEmail = "SELECT employee_id FROM nhanvien WHERE email = ?";
                    $sqlCheckPhone = "SELECT employee_id FROM nhanvien WHERE phone = ?";
                    $sqlInsert = "INSERT INTO nhanvien(user_id, name, phone, email) VALUES(?, ?, ?, ?)";
                    break;

                default: // Khách hàng
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

            // 5. Hash mật khẩu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // 6. Insert vào bảng users
            $stmtUser = $this->conn->prepare("INSERT INTO users (username, password, status, role_id) VALUES (?, ?, ?, ?)");
            $stmtUser->bind_param("ssii", $username, $hashedPassword, $status, $role);
            if (!$stmtUser->execute()) {
                return 'insert_failed';
            }
            $user_id = $this->conn->insert_id;
            $stmtUser->close();

            // 7. Insert vào bảng nhân viên hoặc khách hàng
            $stmtDetail = $this->conn->prepare($sqlInsert);
            $stmtDetail->bind_param("isss", $user_id, $fullname, $phone, $email);
            $stmtDetail->execute();
            $stmtDetail->close();

            return 'success';
        } catch (Exception $e) {
            error_log("Lỗi thêm user: " . $e->getMessage());
            return 'exception';
        }
    }


    public function sua($id, $username, $fullname, $phone, $email, $password, $status, $role)
    {
        try {
            // 1. Kiểm tra username đã tồn tại chưa
            $checkUsername = $this->conn->prepare("SELECT user_id FROM users WHERE username = ? AND user_id != ?");
            $checkUsername->bind_param("si", $username, $id);
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
                    $sqlCheckEmail = "SELECT user_id FROM nhanvien WHERE email = ? AND user_id != ?";
                    $sqlCheckPhone = "SELECT user_id FROM nhanvien WHERE phone = ? AND user_id != ?";
                    $sqlUpdate = "UPDATE nhanvien SET name = ?, phone = ?, email = ? WHERE user_id = ?";
                    break;
                default:
                    $sqlCheckEmail = "SELECT user_id FROM khachhang WHERE email = ? AND user_id != ?";
                    $sqlCheckPhone = "SELECT user_id FROM khachhang WHERE phone = ? AND user_id != ?";
                    $sqlUpdate = "UPDATE khachhang SET customer_name = ?, phone = ?, email = ? WHERE user_id = ?";
                    break;
            }

            // 3. Kiểm tra số điện thoại trùng
            $checkPhone = $this->conn->prepare($sqlCheckPhone);
            $checkPhone->bind_param("si", $phone, $id);
            $checkPhone->execute();
            if ($checkPhone->get_result()->num_rows > 0) {
                $checkPhone->close();
                return 'phone_exists';
            }
            $checkPhone->close();

            // 4. Kiểm tra email trùng
            $checkEmail = $this->conn->prepare($sqlCheckEmail);
            $checkEmail->bind_param("si", $email, $id);
            $checkEmail->execute();
            if ($checkEmail->get_result()->num_rows > 0) {
                $checkEmail->close();
                return 'email_exists';
            }
            $checkEmail->close();

            // 5. Cập nhật bảng users
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->conn->prepare("UPDATE users SET username = ?, password = ?, status = ?, role_id = ? WHERE user_id = ?");
                $stmt->bind_param("ssiii", $username, $hashedPassword, $status, $role, $id);
            } else {
                $stmt = $this->conn->prepare("UPDATE users SET username = ?, status = ?, role_id = ? WHERE user_id = ?");
                $stmt->bind_param("siii", $username, $status, $role, $id);
            }
            $stmt->execute();
            $stmt->close();

            // 6. Cập nhật bảng nhân viên hoặc khách hàng
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("sssi", $fullname, $phone, $email, $id);
            $stmtUpdate->execute();
            $stmtUpdate->close();

            return 'success';
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return 'exception';
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

    public function getIdByUsername($username)
    {
        $sql = "SELECT user_id FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['user_id'];
        } else {
            return null; // Không tìm thấy user_id
        }
    }

    public function getCustomerIdByUserId($user_id)
    {
        $sql = "SELECT customer_id FROM khachhang WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['customer_id'];
        } else {
            return null; // Không tìm thấy customer_id
        }
    }
    public function isUsernameExists($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function isPhoneExists($phone)
    {
        $tables = ['khachhang', 'nhanvien'];
        foreach ($tables as $table) {
            $stmt = $this->conn->prepare("SELECT 1 FROM $table WHERE phone = ? LIMIT 1");
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $stmt->close();
                return true;
            }
            $stmt->close();
        }
        return false;
    }
    public function insertUser($username, $password, $role_id = 3)
    {
        $sql = "INSERT INTO users(username, password, role_id) VALUES(?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $password, $role_id);
        $stmt->execute();
        $user_id = $this->conn->insert_id;
        $stmt->close();
        return $user_id;
    }
    public function insertKhachHang($user_id, $phone)
    {
        $sql = "INSERT INTO khachhang(user_id,phone) VALUES(?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $phone);
        $stmt->execute();
        $customer_id = $this->conn->insert_id;
        $stmt->close();
        return $customer_id;
    }

    public function insertDiaChi($thanhpho, $quan, $phuong, $sonha)
    {
        $stmt = $this->conn->prepare("INSERT INTO diachi (ThanhPho, Quan, Phuong, SoNha) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $thanhpho, $quan, $phuong, $sonha);
        $stmt->execute();
        $insertId = $stmt->insert_id;
        $stmt->close();
        return $insertId; // trả về address_id
    }

    public function insertKhachHangDiaChi($customer_id, $address_id, $isDefault = false)
    {
        $sql = "INSERT INTO khachhang_diachi(customer_id, address_id,is_default) VALUES(?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $customer_id, $address_id, $isDefault);
        $stmt->execute();
        $stmt->close();
    }

    public function getTop5KhachHang()
    {
        $sql = "SELECT kh.customer_id, kh.customer_name, kh.phone, SUM(dh.total) AS order_sum
                FROM khachhang kh
                JOIN donhang dh ON kh.customer_id = dh.customer_id
                GROUP BY kh.customer_id, kh.customer_name, kh.phone
                ORDER BY order_sum DESC
                LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $topCustomers = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $topCustomers;
    }
}
