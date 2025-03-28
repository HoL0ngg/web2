<div>
    <!-- <canvas id="myChart"></canvas> -->
    <!-- tutu chinh tiep -->
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
        <tr>
            <th>STT</th>
            <th>Tên khách hàng</th>
            <th>Tổng hóa đơn</th>
            <th>Số lượng đơn</th>
            <th>Hành động</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Nguyễn Văn A</td>
            <td>25,000,000 VND</td>
            <td>15</td>
            <td><a href="#">Xem chi tiết</a></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Nguyễn Văn B</td>
            <td>24,000,000 VND</td>
            <td>15</td>
            <td><a href="#">Xem chi tiết</a></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Nguyễn Văn C</td>
            <td>20,000,000 VND</td>
            <td>15</td>
            <td><a href="#">Xem chi tiết</a></td>
        </tr>
        <!-- Thêm 2 dòng dữ liệu mẫu khác -->
    </table>

</div>
<script src="/js/thongke.js"></script>
<style>
    .header {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
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