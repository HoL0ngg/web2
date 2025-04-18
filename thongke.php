<div>
    <!-- tutu chinh tiep -->
    <div class="thongke-container">
        <i class="fa-solid fa-circle-left back-button fa-2x hide" onclick="Back()"></i>
        <canvas id="myChart" class="hide"></canvas>
        <div class="thongke-item">
            <div class="thongke-icon">
                <div>
                    <i class="fa-solid fa-money-bill-wave fa-2x" style="color: white"></i>
                </div>
            </div>
            <div class="thongke-title">
                <p>Tổng doanh thu</p>
                <div>10.000.000 VNĐ</div>
            </div>
        </div>
        <div class="thongke-item">
            <div class="thongke-icon">
                <div>
                    <i class="fa-solid fa-receipt fa-2x" style="color: white;"></i>
                </div>
            </div>
            <div class="thongke-title">
                <p>Tổng đơn hàng</p>
                <div>69 Đơn hàng</div>
            </div>
        </div>
        <div class="thongke-item">
            <div class="thongke-icon">
                <div>
                    <i class="fa-solid fa-face-smile fa-2x" style="color: white;"></i>
                </div>
            </div>
            <div class="thongke-title">
                <p>Tổng khách hàng</p>
                <div>100 Khách hàng</div>
            </div>
        </div>
        <div class="thongke-item">
            <div class="thongke-icon">
                <div>
                    <i class="fa-solid fa-cart-shopping fa-2x" style="color: white;"></i>
                </div>
            </div>
            <div class="thongke-title">
                <p>Sản phẩm bán chạy</p>
                <div>Son bla bla</div>
            </div>
        </div>
    </div>

    <div class="header">Top 5 khách hàng có hóa đơn cao nhất</div>
    <div class="filter">
        <select>
            <option>30 ngày qua</option>
            <option>7 ngày qua</option>
            <option>Tùy chỉnh</option>
        </select>
        <input type="date" placeholder="Từ ngày">
        <input type="date" placeholder="Đến ngày">
        <a href="#" class="export-btn">Xuất Excel</a>
    </div>
    <table>
        <?php
        require_once 'Model/TKModel.php';
        $tkModel = new TKModel();

        $top5 = $tkModel->getTop5KhachHang();
        if ($top5) {
            echo '<tr>';
            echo '<th>STT</th>';
            echo '<th>Tên khách hàng</th>';
            echo '<th>Số điện thoại</th>';
            // echo '<th>Địa chỉ</th>';
            echo '<th>Tổng tiền</th>';
            echo '<th>Hành động</th>';
            echo '</tr>';

            foreach ($top5 as $index => $khachHang) {
                echo '<tr>';
                echo '<td>' . ($index + 1) . '</td>';
                echo '<td>' . htmlspecialchars($khachHang['customer_name']) . '</td>';
                echo '<td>' . htmlspecialchars($khachHang['phone']) . '</td>';
                // echo '<td>' . htmlspecialchars($khachHang['dia_chi']) . '</td>';
                echo '<td>' . number_format($khachHang['order_sum'], 0, ',', '.') . ' VNĐ</td>';
                echo '<td><a href="admin.php?page=thongke&id=' . $khachHang['customer_id'] . '">Xem chi tiết</a></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5">Không có dữ liệu.</td></tr>';
        }
        ?>
    </table>

</div>
<script src="/js/thongke.js"></script>
<style>
    .header {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .thongke-container {
        width: 100%;
        height: 400px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        position: relative;
    }

    .thongke-item {
        background-color: white;
        height: 140px;
        width: calc(100% / 2 - 140px);
        margin: 24px 70px;
        display: flex;
        align-items: center;
        border-radius: 6px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .thongke-item.hide {
        display: none;
    }

    .thongke-icon {
        flex: 1;
        text-align: center;
        margin: 16px;
    }

    .thongke-icon div {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #007BFF;
        border-radius: 50%;
        /* padding: 18px; */
        width: 70px;
        height: 70px;
    }

    .thongke-title {
        flex: 4;
    }

    .thongke-title p {
        font-weight: 700;
        font-size: 1.2em;
        margin-bottom: 4px;
    }

    .back-button {
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
    }

    .back-button.hide,
    #myChart.hide {
        display: none !important;
    }


    .filter {
        margin-bottom: 20px;
    }

    .filter select,
    .filter input {
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #E0E0E0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #E0E0E0;
    }

    tr:nth-child(even) {
        background-color: #FAFAFA;
    }

    tr:hover {
        background-color: #F0F5FF;
    }

    .export-btn {
        float: right;
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        border-radius: 8px;
        text-decoration: none;
    }
</style>