<?php
class AccountFunction
{
    public function accountForm($title, $id)
    {
        echo '<div class="container-addaccount">
            <h2>' . $title . '</h2>
            <form method="post" id="' . $id . '">
                <label for="username">Tên tài khoản:</label>
                <input type="text" id="username" name="username">

                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email">

                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password">

                <label for="status">Trạng Thái:</label>
                <select id="status" name="status">
                    <option value="1">Hoạt động</option>
                    <option value="0">Không hoạt động</option>
                </select>

                <label for="role">Quyền:</label>
                <select id="role" name="role">
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                </select>

                <button type="submit" class="btn-submit" name="' . ($title == "THÊM TÀI KHOẢN" ? "them" : "sua") . '"' .
            'onclick="' . ($id == "addUserForm" ? "addUsers()" : "") . '">' . $title . '</button>
            </form>
        </div>';
    }
}
