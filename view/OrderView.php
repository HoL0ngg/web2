<h2 style="margin-top: 20px">Danh sách đơn hàng của khách hàng <?php echo $orders[0]['customer_name']; ?></h2>
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
                <td><a href=''>Chi tiết</a></td>
              </tr>";
        }
        echo "</table>";
    } else {
        echo "Không có đơn hàng nào.";
    }
    ?>
</div>