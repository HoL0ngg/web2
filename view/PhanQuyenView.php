<!-- Main Content -->
<main class="main-content">
    <header>
        <h1>Quản lý phân quyền</h1>
    </header>

    <section class="permission-management">
        <form>
            <!-- Combobox chọn nhóm quyền -->
            <div class="permission-header">
                <label for="nhom_quyen">Nhóm quyền:</label>
                <select name="nhom_quyen" id="nhom_quyen" onchange="window.location.href='admin.php?page=phanquyen&role_id=' + this.value;">
                    <!-- <select name="nhom_quyen" id="nhom_quyen"> -->
                    <?php foreach ($nhomQuyen as $nhom): ?>
                        <option value="<?= $nhom['role_id'] ?>" <?= ($nhom['role_id'] == $_GET['role_id']) ? 'selected' : '' ?>>
                            <?= $nhom['role_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="permission-content">
                <div class="left-panel">
                    <div class="chuc-nang-item" style="background-color: #33bbee;font-weight: 600;">Danh mục chức năng</div>
                    <?php foreach ($chucNang as $chuc): ?>
                        <div class="chuc-nang-item"><?= $chuc['function_name'] ?></div>
                    <?php endforeach; ?>
                </div>

                <div class="right-panel">
                    <table class="permission-table">
                        <thead>
                            <tr>
                                <th>Tạo</th>
                                <th>Xem</th>
                                <th>Sửa</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($chucNang as $chuc): ?>
                                <?php
                                $actions = $quyenMap[$chuc['function_id']] ?? [];
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="permissions[<?= $chuc['function_id'] ?>][create]" <?= in_array('create', $actions) ? 'checked' : '' ?>></td>
                                    <td><input type="checkbox" name="permissions[<?= $chuc['function_id'] ?>][read]" <?= in_array('read', $actions) ? 'checked' : '' ?>></td>
                                    <td><input type="checkbox" name="permissions[<?= $chuc['function_id'] ?>][update]" <?= in_array('update', $actions) ? 'checked' : '' ?>></td>
                                    <td><input type="checkbox" name="permissions[<?= $chuc['function_id'] ?>][delete]" <?= in_array('delete', $actions) ? 'checked' : '' ?>></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="permission-submit">
                <button type="submit" class="apply-btn">Áp dụng</button>
            </div>
        </form>
    </section>
</main>

<style>
    /* Cấu trúc chính */
    .main-content {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .main-content header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .main-content h1 {
        margin: 0;
        color: #333;
    }

    /* Giao diện phân quyền */
    .permission-management {
        border: 1px solid #ddd;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
    }

    .permission-header {
        margin-bottom: 20px;
    }

    .permission-header label {
        font-weight: bold;
        margin-right: 10px;
    }

    .permission-content {
        display: flex;
        gap: 20px;
    }

    .left-panel {
        width: 30%;
        background-color: #f9f9f9;
        /* padding: 7px; */
        border-right: 1px solid #ccc;
    }

    .chuc-nang-item {
        padding: 8px 0;
        border-bottom: 2px solid #eee;
        text-align: center;
    }

    .right-panel {
        width: 70%;
        background-color: #eee;
        /* padding: 10px; */
        border-radius: 5px;
    }

    .permission-table {
        width: 100%;
        border-collapse: collapse;
    }

    .permission-table th {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
        background-color: #33bbee;
    }

    .permission-table td {
        border: 1px solid #ccc;
        padding: 11px;
        text-align: center;
        background-color: #fff;
    }

    .permission-submit {
        text-align: center;
        margin-top: 20px;
    }

    .apply-btn {
        background-color: #66ccff;
        border: none;
        padding: 10px 30px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .apply-btn:hover {
        background-color: #33bbee;
    }
</style>