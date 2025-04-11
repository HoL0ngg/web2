database:
-- Bảng ChungLoai
CREATE TABLE ChungLoai (
    machungloai INT PRIMARY KEY,
    tenchungloai VARCHAR(50)
);
-- Bảng TheLoai
CREATE TABLE TheLoai (
    matheloai INT PRIMARY KEY,
    tentheloai VARCHAR(50),
    machungloai INT,
    FOREIGN KEY (machungloai) REFERENCES ChungLoai(machungloai)
);

Tôi có entry point category.php:
<!-- Gọi file CSS -->
<link rel="stylesheet" href="css/admin_category.css">

<!-- Main Content -->
<main class="main-content">
    <header>
        <h1>Quản Lý Chủng Loại</h1>
        <a href="admin.php?page=category&act=del">
            <button class="delete-chungloai-btn">❌ Xóa chủng loại</button>
        </a>
        <a href="admin.php?page=category&act=add">
            <button class="add-chungloai-btn">➕ Thêm chủng loại</button>
        </a>

    </header>

    <section class="chungloai-list">
        <table>
            <thead>
                <tr>
                    <th>Mã chủng loại</th>
                    <th>Tên chủng loại</th>
                    <th>Mã thể loại</th>
                    <th>Tên thể loại</th>
                    <th>Số lượng hàng</th>
                    <th>Hành động</th> <!-- Cột riêng -->
                    <th>Thêm thể loại</th> <!-- Cột riêng -->
                </tr>
            </thead>
            <tbody>
                <!-- Chủng loại "Da mặt" -->
                <tr>
                    <td rowspan="3">CL001</td>
                    <td rowspan="3">Da mặt</td>
                    <td>TL001</td>
                    <td>Sữa rửa mặt</td>
                    <td>30</td>
                    <td>
                        <a href="admin.php?page=category&act=edit_type&id=TL001"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                        <a href="admin.php?page=category&act=delete_type&id=TL001"><button class="delete-theloai-btn">❌ Xóa</button></a>
                    </td>
                    <td rowspan="3">
                        <a href="admin.php?page=category&act=add_type&cl_id=CL001">
                            <button class="add-theloai-btn">➕ Thêm thể loại</button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>TL002</td>
                    <td>Tẩy tế bào chết</td>
                    <td>15</td>
                    <td>
                        <a href="admin.php?page=category&act=edit_type&id=TL002"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                        <a href="admin.php?page=category&act=delete_type&id=TL002"><button class="delete-theloai-btn">❌ Xóa</button></a>
                    </td>
                </tr>
                <tr>
                    <td>TL003</td>
                    <td>Mặt nạ</td>
                    <td>20</td>
                    <td>
                        <a href="admin.php?page=category&act=edit_type&id=TL003"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                        <a href="admin.php?page=category&act=delete_type&id=TL003"><button class="delete-theloai-btn">❌ Xóa</button></a>
                    </td>
                </tr>

                <!-- Chủng loại "Chăm sóc tóc" -->
                <tr>
                    <td rowspan="2">CL002</td>
                    <td rowspan="2">Chăm sóc tóc</td>
                    <td>TL004</td>
                    <td>Dầu gội</td>
                    <td>50</td>
                    <td>
                        <a href="admin.php?page=category&act=edit_type&id=TL004"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                        <a href="admin.php?page=category&act=delete_type&id=TL004"><button class="delete-theloai-btn">❌ Xóa</button></a>
                    </td>
                    <td rowspan="2">
                        <a href="admin.php?page=category&act=add_type&cl_id=CL002">
                            <button class="add-theloai-btn">➕ Thêm thể loại</button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>TL005</td>
                    <td>Dầu xả</td>
                    <td>40</td>
                    <td>
                        <a href="admin.php?page=category&act=edit_type&id=TL005"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                        <a href="admin.php?page=category&act=delete_type&id=TL005"><button class="delete-theloai-btn">❌ Xóa</button></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
</main>


Hãy giúp tôi viết theo mô hình 3 lớp trên chức năng:
1. Thêm chủng loại (khi ấn vào button 'Thêm chủng loại'): hiện lên một popup ở dưới button, trong trang hiện tại, trong đó có text field: Tên chủng loại và button Thêm. 
Khi thêm, các chủng loại được cập nhật trong bảng mà không phải load lại trang. 

2. Xóa chủng loại (khi nhấn vào button 'Xóa chủng loại'): người dùng chọn hàngkiểm tra xem trong database có bao nhiêu thể loại thuộc chủng loại này. Nếu >0 thì thông báo: 'Còn tồn tại thể loại trong chủng loại này.', nếu =0 thì xác nhận xóa và xóa.
