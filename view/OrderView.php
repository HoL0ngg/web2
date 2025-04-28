<h2 style="margin-top: 20px">Danh sách đơn hàng của khách hàng <?php echo $orders[0]['customer_name']; ?></h2>
<div class="back-btn"><i class="fa-solid fa-2x fa-arrow-left"></i></div>
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
                <td>{$order['total']}</td>
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