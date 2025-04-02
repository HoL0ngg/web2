<?php
class AccountFunction
{
    public function accountForm($title, $id, $userData = null)
    {
        // Giá trị mặc định nếu không có $userData
        $username = $userData['username'] ?? '';
        $phone = $userData['phone'] ?? '';
        $email = $userData['email'] ?? '';
        $password = $userData['password'] ?? ''; // Lưu ý: Mật khẩu thường không hiển thị dạng plain text
        $status = $userData['status'] ?? '1';
        $role = $userData['role'] ?? '1';

        echo '<div class="container-addaccount">
            <h2>' . $title . '</h2>
            <form action="handles/handleUser.php" method="post" id="' . $id . '">
                <!-- Thêm trường ẩn để gửi ID người dùng khi sửa -->
                ' . ($userData ? '<input type="hidden" name="id" value="' . ($userData['id'] ?? '') . '">' : '') . '

                <label for="username">Tên tài khoản:</label>
                <input type="text" id="username" name="username" value="' . htmlspecialchars($username) . '">

                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" value="' . htmlspecialchars($phone) . '">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="' . htmlspecialchars($email) . '">

                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" placeholder="' . ($userData ? 'Để trống nếu không đổi' : '') . '">

                <label for="status">Trạng Thái:</label>
                <select id="status" name="status">
                    <option value="1" ' . ($status == '1' ? 'selected' : '') . '>Hoạt động</option>
                    <option value="0" ' . ($status == '0' ? 'selected' : '') . '>Không hoạt động</option>
                </select>

                <label for="role">Quyền:</label>
                <select id="role" name="role">
                    <option value="1" ' . ($role == '1' ? 'selected' : '') . '>Admin</option>
                    <option value="2" ' . ($role == '2' ? 'selected' : '') . '>User</option>
                </select>

                <button type="submit" class="btn-submit" name="' . ($title == "THÊM TÀI KHOẢN" ? "them" : "sua") . '">' . $title . '</button>
            </form>
        </div>';
    }
}
// htmlspecialchars Cross-site scripting tranh ma doc