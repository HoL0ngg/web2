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
            $checkUsername = $this->isUsernameExists($username);
            if ($checkUsername) {
                return 'username_exists';
            }

            $checkPhone = $this->isPhoneExists($phone);
            if ($checkPhone) {
                return 'phone_exists';
            }

            $checkEmail = $this->isEmailExists($email);
            if ($checkEmail) {
                return 'email_exists';
            }
            switch ($role) {
                case 1: // Admin
                case 2: // Nhân viên
                    $sqlInsert = "INSERT INTO nhanvien(user_id, name, phone, email) VALUES(?, ?, ?, ?)";
                    break;

                default: // Khách hàng                    
                    $sqlInsert = "INSERT INTO khachhang(user_id, customer_name, phone, email) VALUES(?, ?, ?, ?)";
                    break;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmtUser = $this->conn->prepare("INSERT INTO users (username, password, status, role_id) VALUES (?, ?, ?, ?)");
            $stmtUser->bind_param("ssii", $username, $hashedPassword, $status, $role);
            if (!$stmtUser->execute()) {
                return 'insert_failed';
            }
            $user_id = $this->conn->insert_id;
            $stmtUser->close();

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
            // Bắt đầu transaction
            $this->conn->begin_transaction();

            // 1. Kiểm tra username
            $stmtCheckUsername = $this->conn->prepare("SELECT user_id FROM users WHERE username = ? AND user_id != ?");
            $stmtCheckUsername->bind_param("si", $username, $id);
            $stmtCheckUsername->execute();
            if ($stmtCheckUsername->get_result()->num_rows > 0) {
                $stmtCheckUsername->close();
                return 'username_exists';
            }
            $stmtCheckUsername->close();

            // 2. Tùy theo role
            switch ($role) {
                case 1:
                case 2:
                    $sqlUpdate = "UPDATE nhanvien SET name = ?, phone = ?, email = ? WHERE user_id = ?";
                    break;
                default:
                    $sqlUpdate = "UPDATE khachhang SET customer_name = ?, phone = ?, email = ? WHERE user_id = ?";
                    break;
            }

            // 3. Kiểm tra phone
            $tables = ['khachhang', 'nhanvien'];
            foreach ($tables as $table) {
                $sqlCheckPhone = "SELECT 1 FROM $table WHERE phone = ? AND user_id != ? LIMIT 1";
                $stmtCheckPhone = $this->conn->prepare($sqlCheckPhone);
                $stmtCheckPhone->bind_param("si", $phone, $id);
                $stmtCheckPhone->execute();
                if ($stmtCheckPhone->get_result()->num_rows > 0) {
                    $stmtCheckPhone->close();
                    return 'phone_exists';
                }
                $stmtCheckPhone->close();
            }

            // 4. Kiểm tra email
            foreach ($tables as $table) {
                $sqlCheckEmail = "SELECT 1 FROM $table WHERE email = ? AND user_id != ? LIMIT 1";
                $stmtCheckEmail = $this->conn->prepare($sqlCheckEmail);
                $stmtCheckEmail->bind_param("si", $email, $id);
                $stmtCheckEmail->execute();
                if ($stmtCheckEmail->get_result()->num_rows > 0) {
                    $stmtCheckEmail->close();
                    return 'email_exists';
                }
                $stmtCheckEmail->close();
            }

            // 5. Cập nhật users
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmtUpdateUser = $this->conn->prepare("UPDATE users SET username = ?, password = ?, status = ?, role_id = ? WHERE user_id = ?");
                $stmtUpdateUser->bind_param("ssiii", $username, $hashedPassword, $status, $role, $id);
            } else {
                $stmtUpdateUser = $this->conn->prepare("UPDATE users SET username = ?, status = ?, role_id = ? WHERE user_id = ?");
                $stmtUpdateUser->bind_param("siii", $username, $status, $role, $id);
            }
            $stmtUpdateUser->execute();
            $stmtUpdateUser->close();

            // 6. Cập nhật nhân viên hoặc khách hàng
            $stmtUpdateDetail = $this->conn->prepare($sqlUpdate);
            $stmtUpdateDetail->bind_param("sssi", $fullname, $phone, $email, $id);
            $stmtUpdateDetail->execute();
            $stmtUpdateDetail->close();

            // Nếu tới đây thì commit
            $this->conn->commit();

            return 'success';
        } catch (Exception $e) {
            $this->conn->rollback();
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
            LEFT JOIN nhanvien nv ON nv.user_id = u.user_id
            LEFT JOIN khachhang kh ON kh.user_id = u.user_id
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
            -- Ưu tiên lấy số điện thoại từ bảng nhanvien (nếu tồn tại), nếu không có thì lấy từ bảng khachhang

            COALESCE(nv.email, kh.email) AS email,  
            -- Tương tự, ưu tiên lấy email từ bảng nhanvien, nếu không có thì lấy từ bảng khachhang
            COALESCE(nv.name, kh.customer_name) AS fullname,
            r.role_name  
            -- Lấy tên vai trò từ bảng roles dựa trên role_id

            FROM users u
            -- Bảng chính là bảng users

            LEFT JOIN nhanvien nv ON nv.user_id = u.user_id  
            -- Nối bảng nhanvien với users thông qua user_id (nếu người dùng là nhân viên thì sẽ có dữ liệu)

            LEFT JOIN khachhang kh ON kh.user_id = u.user_id  
            -- Nối bảng khachhang với users thông qua user_id (nếu người dùng là khách hàng thì sẽ có dữ liệu)

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
        $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = ?");
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
    public function isEmailExists($email)
    {
        $tables = ['khachhang', 'nhanvien'];
        foreach ($tables as $table) {
            $stmt = $this->conn->prepare("SELECT 1 FROM $table WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
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
    public function insertKhachHang($user_id, $phone, $fullname, $email)
    {
        $sql = "INSERT INTO khachhang(user_id,phone,customer_name,email) VALUES(?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $user_id, $phone, $fullname, $email);
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

    public function getOrderById($id)
    {
        $sql = "SELECT khachhang.customer_name, khachhang.phone, khachhang.customer_id, donhang.total, donhang.order_id, donhang.OrderDate
                FROM donhang 
                JoIN khachhang 
                ON donhang.customer_id = khachhang.customer_id 
                WHERE donhang.customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();
        return $orders;
    }
}
