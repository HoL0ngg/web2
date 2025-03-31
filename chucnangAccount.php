<?php
class AccountFunction
{
    public function accountForm($title)
    {
        echo '<div class="container">
            <h2>' . $title . '</h2>
            <form>
                <label for="username">Tên Tài Khoản:</label>
                <input type="text" id="username" name="username">

                <label for="phone">Số Điện Thoại:</label>
                <input type="text" id="phone" name="phone">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email">

                <label for="password">Mật Khẩu:</label>
                <input type="password" id="password" name="password">

                <label for="status">Trạng Thái:</label>
                <select id="status" name="status">
                    <option value="inactive">Không hoạt động</option>
                    <option value="active">Hoạt động</option>
                </select>

                <label for="role">Quyền:</label>
                <select id="role" name="role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>

                <button type="submit" class="btn-submit">Thêm Tài Khoản</button>
            </form>
        </div>';
    }
}
