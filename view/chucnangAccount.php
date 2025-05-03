<?php
class AccountFunction
{
    public function accountForm($title, $id, $roles = [], $userData = null)
    {
        $username = $userData['username'] ?? '';
        $fullname = $userData['fullname'] ?? ''; // Thêm biến fullname
        $phone = $userData['phone'] ?? '';
        $email = $userData['email'] ?? '';
        $password = $userData['password'] ?? '';
        $status = $userData['status'] ?? '1';
        $roleId = $userData['role_id'] ?? '1';

        echo '<div class="container-addaccount">
            <h2>' . $title . '</h2>
            <form method="post" id="' . $id . '" onsubmit="return checkAddUser()">';

        // ID ẩn nếu sửa
        if ($userData) {
            echo '<input type="hidden" name="id" value="' . htmlspecialchars($userData['user_id'] ?? '') . '">';
        }

        echo '
                <label for="username">Tên tài khoản:</label>
                <input type="text" id="username" name="username" value="' . htmlspecialchars($username) . '">

                <label for="fullname">Họ tên:</label>
                <input type="text" id="fullname" name="fullname" value="' . htmlspecialchars($fullname) . '">

                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" value="' . htmlspecialchars($phone) . '">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="' . htmlspecialchars($email) . '">

                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" placeholder="' . ($userData ? 'Để trống nếu không đổi' : '') . '">

                <label for="status">Trạng Thái:</label>
                <select id="status" name="status">
                    <option value="1" ' . ($status == '1' ? 'selected' : '') . '>Hoạt động</option>
                    <option value="0" ' . ($status == '0' ? 'selected' : '') . '>Khóa tài khoản</option>
                </select>

                <label for="role">Quyền:</label>
                <select id="role" name="role">';

        // Lặp qua danh sách quyền và tạo option
        foreach ($roles as $role) {
            $selected = $role['role_id'] == $roleId ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($role['role_id']) . '" ' . $selected . '>' . htmlspecialchars($role['role_name']) . '</option>';
        }

        echo '</select>
                <button type="submit" class="btn-submit" name="' . ($title == "THÊM TÀI KHOẢN" ? "them" : "sua") . '">' . $title . '</button>
            </form>
        </div>';
    }
}
