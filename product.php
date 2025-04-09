<?php
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        include 'views/product/add.php'; // Giao diện thêm sản phẩm
        break;

    case 'edit':
        include 'views/product/edit.php'; // Giao diện chỉnh sửa sản phẩm
        break;

    case 'delete':
        include 'views/product/delete.php'; // Xử lý xóa sản phẩm
        break;

    default:
        echo ''; // Giao diện danh sách sản phẩm
        break;
}

?>

<div id="product-container">
    <div id="product-header">
        <div class="header-left">
            <h2>Quản lý sản phẩm</h2>
        </div>

        <div class="header-right">

            <div class="search-box">
                <input type="text" placeholder="Tìm kiếm sản phẩm..." id="search-input">
                <button type="submit" class="search-btn">🔍</button>
            </div>

            <div id="product-header-btn">
                <a href="admin.php?page=product&action=add" class="btn">+ Thêm sản phẩm</a>
            </div>
        </div>
    </div>
    <div id="product-list">
        <table>
            <tr>
                <th>STT</th>
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Tên thương hiệu</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <!-- <th>Danh mục</th> -->
                <th>Thao tác</th>
            </tr>
            <?php
            require("database/connect.php");
            $db = new database();
            $conn = $db->getConnection();
            $sql = "SELECT * FROM sanpham";
            $result = $conn->query($sql);
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['product_id'] ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['brand_id'] ?></td>
                    <td><?php echo '10' ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><img src="imgs/sp1.jpg" alt="product-image"></td>
                    <!-- <td><img src="../imgs/<?php echo $row['hinhanh']; ?>" alt="product-image"></td> -->
                    <!-- <td><?php echo $row['matheloai']; ?></td> -->
                    <td>
                        <div>
                            <a href="admin.php?page=product&action=edit&id=<?php echo $row['product_id']; ?>" class="btn">✏️ Sửa</a>
                        </div>
                        <div>
                            <a href="admin.php?page=product&action=delete&id=<?php echo $row['product_id']; ?>" class="btn">❌ Xóa</a>
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
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    #search-input {
        padding: 8px 12px;
        border: none;
        outline: none;
        min-width: 250px;
        font-size: 14px;
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
        white-space: nowrap
    }

    #product-header-btn .btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #product-list {
        overflow-x: auto;
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
    }


    #product-list .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

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
</style>