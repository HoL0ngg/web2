<?php
$funcId = 'nguoidung';
$phanquyenController = new PhanQuyenController();
$canUpdate = $phanquyenController->hasPermission($funcId, 'update', $_SESSION['permissions']);
$canDelete = $phanquyenController->hasPermission($funcId, 'delete', $_SESSION['permissions']);
$canAdd = $phanquyenController->hasPermission($funcId, 'create', $_SESSION['permissions']);
?>

<main class="main-content">
    <header>
        <h1>Quản Lý Người Dùng</h1>
        <div class="search-box">
            <select id="search-combobox-user">
                <option value="all">Tất cả</option>
                <option value="userId">ID</option>
                <option value="username">Tên đăng nhập</option>
                <option value="fullname">Họ tên</option>
                <option value="phone">Số điện thoại</option>
                <option value="email">Email</option>
            </select>

            <input type="text" placeholder="Tìm kiếm người dùng...." id="search-input-user">
        </div>
        <?php if ($canAdd) : ?>
            <a href="admin.php?page=user&act=add" class="add-user-btn">➕Thêm người dùng</a>
        <?php endif; ?>
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
                    <?php if ($canUpdate || $canDelete) : ?>
                        <th>Thao tác</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php if (!empty($users)) : ?> <!-- dau : de ket hop php voi html -->
                    <?php foreach ($users as $user) : ?>
                        <tr class="<?= ($user['status'] == 0) ? 'hidden-product' : ''; ?>">
                            <td><?= htmlspecialchars($user['user_id']) ?></td> <!-- dau = la php echo  -->
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['fullname']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['status'] == 0 ? '<span class="status-no-complete">Bị khóa</span>' : '<span class="status-complete">Hoạt động</span>' ?></td>
                            <td><?= htmlspecialchars($user['role_name']) ?></td>
                            <?php if ($canUpdate || $canDelete) : ?>
                                <td>
                                    <?php if ($canUpdate) : ?>
                                        <a href="admin.php?page=user&act=update&uid=<?= $user['user_id'] ?>">
                                            <button class="edit-btn">✏️ Sửa</button>
                                        </a>
                                    <?php endif; ?>
                                    <!-- <button class="delete-btn-user" data-id="<?= $user['user_id'] ?>">❌ Xóa</button> -->
                                </td>
                            <?php endif; ?>
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

    /* .add-user-btn {
        background: #27AE60;
        color: white;
        border: none;
        width: 148px;
        height: 30px;
        border-radius: 5px;
        cursor: pointer;
    } */

    .add-user-btn a {
        font-weight: 600;
        text-decoration: none;
        color: white;
        /* width: 100%;
         height: 30px; */
        /* border: 3px solid black; */
    }

    /* .add-user-btn:hover {
        background: #219150;
    } */
    .search-box {
        display: flex;
        align-items: center;
        background: #ECF0F1;
        overflow: hidden;
    }

    #search-input-user {
        padding: 8px 12px;
        border: none;
        outline: none;
        min-width: 250px;
        font-size: 1rem;
        border: 2px solid #ccc;
        margin: 0 0 0 7px;
    }

    #search-combobox-user {
        padding: 8px 12px;
        border: 2px solid #ccc;
        min-width: 150px;
        font-size: 1rem;
    }

    .add-user-btn {
        background-color: #3498db;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
    }

    .add-user-btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Bảng danh sách người dùng */
    .user-list {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        /* overflow  */
        overflow-y: auto;
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
    @media (max-width: 768px) {
        header {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-box {
            margin-top: 10px;
        }

        #search-input-user,
        #search-combobox-user {
            width: 100%;
            margin-bottom: 10px;
        }

        .add-user-btn {
            text-align: center;
        }
    }
</style>