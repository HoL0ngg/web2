<?php
require_once 'handles/OrderController.php';
require_once 'Model/TKModel.php';
require_once 'handles/ProductController.php';
$orderController = new OrderController();
$tkmodel = new TKModel();
$productController = new ProductController();
$totalOrder = $orderController->getOrderCount();
$totalSumOrder = $orderController->getTotalCount();
$totalCustomer = $tkmodel->getTotalCustomer();
$product = $productController->getMostBuyProduct();
$product = $productController->getNameProductById($product);
?>

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
                <div><?= number_format($totalSumOrder, 0, ',', '.') ?> VNĐ</div>
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
                <div><?= $totalOrder ?> đơn hàng</div>
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
                <div><?= $totalCustomer ?> Khách hàng</div>
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
                <div><?= $product ?></div>
            </div>
        </div>
    </div>

    <div class="header">Top 5 khách hàng có hóa đơn cao nhất</div>
    <div class="filter">
        <select id="select-filter">
            <option value="30">30 ngày qua</option>
            <option value="7">7 ngày qua</option>
            <option value="custom">Tùy chỉnh</option>
        </select>
        <input type="date" placeholder="Từ ngày" id="startDate">
        <input type="date" placeholder="Đến ngày" id="endDate">
        <!-- <a href="#" class="export-btn">Xuất Excel</a> -->
    </div>
    <table>
    </table>

</div>
<script src="js/thongke.js"></script>
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
        /* cursor: pointer; */
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