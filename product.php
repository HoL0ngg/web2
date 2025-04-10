
<!-- Style -->
<link rel="stylesheet" href="css/admin_product.css">


<!-- Main Content -->
<main class="main-content">
    <header>
        <h1>Quản Lý Sản Phẩm</h1>
        <button class="add-product-btn"><a href="admin.php?page=product&act=add">➕Thêm sản phẩm</a></button>
    </header>

    <!-- Danh sách sản phẩm -->
    <section class="product-list">
        <table>
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Tên SP</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thể Loại</th>
                    <th>Thương Hiệu</th>
                    <th>Hiển thị</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="productTable">
                <tr>
                    <td>SP001</td>
                    <td>Áo Thun Nam</td>
                    <td>50</td>
                    <td>200,000₫</td>
                    <td>Thời trang</td>
                    <td>ABC</td>
                    <td class="visibility-cell">🟢</td>

                    <td>
                        <a href="admin.php?page=product&act=update"><button class="edit-btn">✏️ Sửa</button></a>
                        <button class="delete-btn-product">❌ Xóa</button>
                    </td>
                </tr>
                <tr>
                    <td>SP002</td>
                    <td>Giày Sneaker</td>
                    <td>30</td>
                    <td>850,000₫</td>
                    <td>Giày dép</td>
                    <td>XYZ</td>
                    <td class="visibility-cell">🔴</td>
                    <td>
                        <a href="admin.php?page=product&act=update"><button class="edit-btn">✏️ Sửa</button></a>
                        <button class="delete-btn-product">❌ Xóa</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>


    <script src="js/product_visibility.js"></script>

</main>
