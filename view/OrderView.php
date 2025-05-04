<?php $selectedSort = $_GET['sort'] ?? 'tang'; ?>
<h2 style="margin-top: 20px">Danh sách đơn hàng của khách hàng <?php echo $orders[0]['customer_name']; ?></h2>
<div class="back-btn"><i class="fa-solid fa-2x fa-arrow-left"></i></div>
<label for="sort" style="display: inline;">Sắp xếp theo </label>
<select name="sort" id="sort" style="padding: 8px; border: 1px solid #E0E0E0; border-radius: 8px; margin-left: 8px;">
    <option value="tang" <?php if ($selectedSort === 'tang') echo 'selected'; ?>>Tăng dần</option>
    <option value="giam" <?php if ($selectedSort === 'giam') echo 'selected'; ?>>Giảm dần</option>
</select>
<div class="table-container">
    <?php
    if (!empty($orders)) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr>
            <th>Mã đơn hàng</th>
            <th>Ngày đặt hàng</th>
            <th>Tổng cộng</th>
            <th>Hành động</th>
          </tr>";
        foreach ($orders as $order) {
            echo "<tr>
                <td>{$order['order_id']}</td>
                <td>{$order['OrderDate']}</td>
                <td>" . number_format($order['total'], 0, ',', '.') . " VNĐ</td>
                <td><button class=\"detail-btn\" value=\"{$order['order_id']}\" onclick=\"showOrderDetail(this)\">📄 Chi tiết</button></td>
              </tr>";
        }
        echo "</table>";
    } else {
        echo "Không có đơn hàng nào.";
    }
    ?>
</div>
<div id="order-detail-popup">
    <div id="order-detail-content">
        <h2>Chi tiết đơn hàng</h2>
        <table id="detail-table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <button id="close-btn" onclick="hideOrderDetail()">Đóng</button>
    </div>
</div>

<script>
    document.querySelector('.back-btn').addEventListener("click", (e) => {
        window.location.href = 'admin.php?page=thongke';
        console.log('hihihi');

    })

    document.getElementById('sort').addEventListener('change', function() {
        const sortValue = this.value;
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id'); // lấy customer_id từ URL

        // Reload trang với sort mới
        window.location.href = `admin.php?page=thongke&id=${id}&sort=${sortValue}`;
    });
</script>

<style>
    .detail-btn {
        border: none;
        /* width: 72px;
        height: 30px; */
        cursor: pointer;
        border-radius: 5px;
        border: 1px solid #BDC3C7;
        margin: 2px;
        background: white;
        padding: 8px;
    }

    .detail-btn:hover {
        background-color: #69b7ff;
        color: white;
    }
</style>