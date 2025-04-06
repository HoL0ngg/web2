<div style="width: 42%; margin: 32px auto 0px; padding: 24px 48px; background-color:rgba(52, 152, 219, 0.5); border-radius: 10px">
    <div class="progress-container">
        <div class="progress-step active" data-step="Giỏ hàng"><i class="fa-solid fa-cart-shopping"></i></div>
        <span class="progress-line active"></span>
        <div class="progress-step active" data-step="Thông tin cá nhân"><i class="fa-solid fa-address-card"></i></div>
        <span class="progress-line active"></span>
        <div class="progress-step active" data-step="Hóa đơn"><i class="fa-solid fa-receipt"></i></div>
        <span class="progress-line"></span>
        <div class="progress-step" data-step="Hoàn tất"><i class="fa-solid fa-circle-check"></i></div>
    </div>
</div>

<div class="receipt-container">
    <div class="receipt-header">
        <h1>HÓA ĐƠN THANH TOÁN</h1>
    </div>
    <div class="receipt-content">
        <p><strong>Tên khách hàng: </strong>Long cute</p>
        <p><strong>Địa chỉ giao hàng: </strong> hihihi</p>
        <p><strong>Số điện thoại: </strong>0987654321</p>
        <p><strong>Email: </strong> hihihi@gmail.com</p>
        <p><strong>Ngày đặt hàng: </strong> 30/4/2025</p>
    </div>
    <div class="receipt-items">
        <h2>Chi tiết đơn hàng</h2>
        <table>
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng cộng</th>
                </tr>
            </thead>
            <tbody>
                <!-- <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?php echo $item['product_name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo number_format($item['total'], 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?> -->
                <td>Son j đó</td>
                <td>2</td>
                <td>100.000 VNĐ</td>
                <td>200.000 VNĐ</td>
            </tbody>
        </table>
    </div>

    <div class="receipt-total">
        <!-- <h2>Tổng tiền: <?php echo number_format($total_amount, 0, ',', '.'); ?> VNĐ</h2> -->
        <h2>Tổng tiền: 400.000 VNĐ</h2>
    </div>
</div>


<style>
    .receipt-container {
        width: 40%;
        margin: 12px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .receipt-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .receipt-content {
        margin-bottom: 20px;
    }

    .receipt-items {
        margin-bottom: 20px;
    }

    .receipt-items table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 12px;
    }

    .receipt-items th,
    .receipt-items td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    .receipt-total {
        text-align: right;
        font-size: 1.2em;
    }
</style>