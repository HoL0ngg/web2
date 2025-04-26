<?php
// require('handles/PhanQuyenController.php');
$funcId = 'sanpham';
$phanquyenController = new PhanQuyenController();
$canUpdate = $phanquyenController->hasPermission($funcId, 'update', $_SESSION['permissions']);
$canDelete = $phanquyenController->hasPermission($funcId, 'delete', $_SESSION['permissions']);
$canAdd = $phanquyenController->hasPermission($funcId, 'create', $_SESSION['permissions']);
?>
<div id="product-container">
    <div id="product-header">
        <div class="header-left">
            <h1>Quản lý sản phẩm</h1>
        </div>

        <div class="header-right">

            <div class="search-box">
                <select id="search-combobox">
                    <option value="all">Tất cả</option>
                    <option value="product_id">Mã sản phẩm</option>
                    <option value="product_name">Tên sản phẩm</option>
                    <option value="brand_name">Tên thương hiệu</option>
                    <option value="tentheloai">Thể loại</option>
                    <option value="quantity">Số lượng</option>
                </select>

                <input type="text" placeholder="Tìm kiếm sản phẩm..." id="search-input-product">
            </div>
            <?php if ($canAdd): ?>
                <div id="product-header-btn">
                    <a href="admin.php?page=product&action=add" class="btn">➕ Thêm sản phẩm</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div id="product-list">
        <table>
            <tr>
                <!-- <th>STT</th> -->
                <!-- <th id="sort-product-id" style="cursor: pointer;">
                    Mã sản phẩm <span id="sort-icon">⬍</span>
                </th> -->
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Tên thương hiệu</th>
                <th>Thể loại</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Trạng thái</th>
                <?php if ($canUpdate || $canDelete): ?>
                    <th>Thao tác</th>
                <?php endif; ?>
            </tr>
            <?php
            // require("database/connect.php");
            foreach ($products as $row) {
            ?>
                <tr class="<?php echo ($row['status'] == 0) ? 'hidden-product' : ''; ?>">
                    <td><?php echo $row['product_id'] ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['brand_name'] ?></td>
                    <td><?php echo $row['tentheloai']; ?></td>
                    <td><?php echo $row['quantity'] ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <!-- <td><img src="imgs/sp1.jpg" alt="product-image"></td> -->
                    <td><img src="<?php echo $row['image_url']; ?>" alt="product-image"></td>
                    <td><?php echo $row['status'] == 0 ? '<span class="status-no-complete">Ẩn sản phẩm</span>' : '<span class="status-complete">Hiển thị</span>' ?></td>
                    <?php if ($canUpdate || $canDelete): ?>
                        <td>
                            <?php if ($canUpdate): ?>
                                <div>
                                    <a href="admin.php?page=product&action=edit&id=<?php echo $row['product_id']; ?>" class="btn">✏️ Sửa</a>
                                </div>
                            <?php endif; ?>

                            <?php if ($canDelete): ?>
                                <div style="margin-top: 5px;">
                                    <button class="delete-btn-product btn" data-id="<?= $row['product_id'] ?>">❌ Xóa</button>
                                    <!-- <a href="admin.php?page=product&action=delete&id=<?php echo $row['product_id']; ?>" data-id="<?= $row['product_id'] ?>" class="delete-btn-product btn">❌ Xóa</a> -->
                                </div>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>
<style>
    /* PRODUCT.PHP */
    #product-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    #product-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-left {
        flex: 1;
        min-width: 200px;
        font-size: 24px;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    #product-header h2 {
        font-size: 24px;
        color: #2c3e50;
        font-weight: 600;
        margin: 0;
    }

    .search-box {
        display: flex;
        align-items: center;
        background: white;
        /* border-radius: 4px; */
        overflow: hidden;
        /* box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); */
    }

    #search-input-product {
        padding: 8px 12px;
        border: none;
        outline: none;
        min-width: 250px;
        font-size: 1rem;
        border: 2px solid #ccc;
        margin: 0 0 0 7px;
    }

    #search-combobox {
        padding: 8px 12px;
        border: 2px solid #ccc;
        min-width: 150px;
        font-size: 1rem;
    }

    .search-btn {
        background: #f8f9fa;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .search-btn:hover {
        background: #e9ecef;
    }

    #product-header-btn .btn {
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

    #product-header-btn .btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #product-list {
        overflow: auto;
        max-height: 580;
    }

    #product-list table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    #product-list th {
        background-color: #3498DB;
        color: white;
        font-weight: 500;
        padding: 12px 15px;
        text-align: center;
        border: 1px solid #BDC3C7;
    }

    #product-list td {
        padding: 12px 15px;
        border: 1px solid #BDC3C7;
        color: #333;
        text-align: center;
    }

    #product-list tr:last-child td {
        border-bottom: none;
    }

    #product-list tr:hover {
        background-color: #f5f5f5;
    }

    #product-list img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #eee;
    }

    /* Action buttons */
    #product-list .btn {
        display: inline-block;
        padding: 6px 12px;
        margin: 2px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s;
        color: black;
        border: 1px solid black;
        background-color: white;
    }


    #product-list .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .highlight {
        background-color: yellow;
        font-weight: bold;
    }

    /* 
    #sort-icon {
        font-size: 11px;
        margin-left: 2px;
    } */

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #product-header {
            flex-direction: column;
            align-items: flex-start;
        }

        #product-header-btn {
            margin-top: 10px;
        }
    }

    /* #product-list td:last-child div {
        margin-bottom: 6px;
    } */
</style>
<!-- <script>
    let ascending = true; // Mặc định: sắp xếp tăng dần

    document.getElementById('sort-product-id').addEventListener('click', function() {
        const table = document.querySelector('#product-list table');
        const rowsArray = Array.from(table.querySelectorAll('tr')).slice(1); // Bỏ dòng tiêu đề
        const sortIcon = document.getElementById('sort-icon');

        rowsArray.sort((a, b) => {
            const idA = a.children[0].textContent.trim();
            const idB = b.children[0].textContent.trim();
            // Nếu Mã sản phẩm là số:
            return ascending ? parseInt(idA) - parseInt(idB) : parseInt(idB) - parseInt(idA);
            // Nếu Mã sản phẩm là chuỗi (ví dụ SP001):
            // return ascending ? idA.localeCompare(idB) : idB.localeCompare(idA);
        });

        rowsArray.forEach(row => table.appendChild(row));

        // Đổi icon
        if (ascending) {
            sortIcon.textContent = '⬇️'; // Tăng dần
        } else {
            sortIcon.textContent = '⬆️'; // Giảm dần
        }

        ascending = !ascending; // Đảo chiều
    });
</script> -->