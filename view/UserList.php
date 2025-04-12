<!-- Main Content -->
<main class="main-content">
    <header>
        <h1>Quản Lý Người Dùng</h1>
        <button class="add-user-btn"><a href="admin.php?page=user&act=add">➕Thêm người dùng</a></button>
    </header>

    <!-- Danh sách người dùng -->
    <section class="user-list">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Trạng thái</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php if (!empty($users)) : ?> <!-- dau : de ket hop php voi html -->
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= htmlspecialchars($user['user_id']) ?></td> <!-- dau = la php echo  -->
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['fullname']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['status'] == 0 ? '<span class="status-no-complete">Bị khóa</span>' : '<span class="status-complete">Hoạt động</span>' ?></td>
                            <td><?= htmlspecialchars($user['role_name']) ?></td>
                            <td>
                                <a href="admin.php?page=user&act=update&uid=<?= $user['user_id'] ?>">
                                    <button class="edit-btn">✏️ Sửa</button>
                                </a>
                                <button class="delete-btn-user" data-id="<?= $user['user_id'] ?>">❌ Xóa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">Không có dữ liệu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<style>
    /* Reset CSS */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    /* Main Content */
    .main-content {
        padding: 20px;
        background: #ECF0F1;
        min-height: 100vh;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .add-user-btn {
        background: #27AE60;
        color: white;
        border: none;
        width: 148px;
        height: 30px;
        border-radius: 5px;
        cursor: pointer;
    }

    .add-user-btn a {
        font-weight: 600;
        text-decoration: none;
        color: white;
        /* width: 100%;
         height: 30px; */
        /* border: 3px solid black; */
    }

    .add-user-btn:hover {
        background: #219150;
    }

    /* Bảng danh sách người dùng */
    .user-list {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #BDC3C7;
        padding: 10px;
        text-align: center;
    }

    td a {
        text-decoration: none;
        color: black;
        /* border: 2px solid red; */
        /* padding: 10px; */
    }

    th {
        background: #3498DB;
        color: white;
    }

    /* Nút chỉnh sửa & xóa */
    .edit-btn,
    .delete-btn-user {
        border: none;
        /* padding: 5px 10px; */
        width: 70px;
        height: 30px;
        cursor: pointer;
        /* margin: 0 5px; */
        border-radius: 5px;
        border: 1px solid #BDC3C7;
    }

    .edit-btn {
        background: white;
    }

    .delete-btn-user {
        background: white;
        color: black;
    }

    .edit-btn:hover {
        background: #D4AC0D;
    }

    .delete-btn-user:hover {
        background: #C0392B;
    }
</style>