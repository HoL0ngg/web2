<div id="product-container">
    <div id="product-header">
        <h2>Quản lý sản phẩm</h2>
        <div id="product-header-btn">
            <a href="admin.php?page=product&action=add" class="btn">Thêm sản phẩm</a>
        </div>
    </div>
    <div id="product-list">
        <table>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Danh mục</th>
                <th>Thao tác</th>
            </tr>
            <?php
            require("connect.php");
            $sql = "SELECT * FROM sanpham";
            $result = mysqli_query($conn, $sql);
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['tensp']; ?></td>
                    <td><?php echo $row['gia']; ?></td>
                    <td><img src="../img/<?php echo $row['hinhanh']; ?>" alt="product-image"></td>
                    <td><?php echo $row['theloai']; ?></td>
                    <td>
                        <div>
                            <a href="admin.php?page=product&action=edit&id=<?php echo $row['id']; ?>" class="btn">Sửa</a>
                        </div>
                        <div>
                            <a href="admin.php?page=product&action=delete&id=<?php echo $row['id']; ?>" class="btn">Xóa</a>
                        </div>
                    </td>
                </tr>
            <?php
                $i++;
            }
            ?>
        </table>
    </div>
</div>