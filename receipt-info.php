<?php
$order = $_SESSION['order_info'];
?>

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
        <p><strong>Tên khách hàng: </strong><?php echo $order['hoten'] ?></p>
        <p><strong>Địa chỉ giao hàng: </strong><?php echo $order['diachi'] . ' ' . $order['phuong'] . ' ' . $order['quan'] . ' ' . $order['thanhpho'] ?></p>
        <p><strong>Số điện thoại: </strong><?php echo $order['sdt'] ?></p>
        <p><strong>Email: </strong> <?php echo $order['email'] ?></p>
        <p><strong>Ngày đặt hàng: </strong> <?php echo $order['order_time'] ?></p>
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
                <?php
                $productmodel = new ProductModel();
                $total = 0;
                foreach ($_SESSION['cart'] as $item):
                    $id = $item['id'];
                    $quantity = $item['quantity'];
                    $row = $productmodel->getProductById($id);
                    $img_url = $productmodel->getMainImageByProductId($id);
                    if (!$row) {
                        // xu li gi do
                    } else {
                        $subtotal = $row['price'] * $quantity;
                        $total += $subtotal;
                    }
                ?>
                    <tr>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo number_format($subtotal, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="receipt-total">
        <!-- <h2>Tổng tiền: <?php echo number_format($total_amount, 0, ',', '.'); ?> VNĐ</h2> -->
        <h2>Tổng tiền: <?php echo number_format($total, 0, ',', '.') ?> VNĐ</h2>
    </div>
    <div class="btn-HoanThanh">HOÀN THÀNH</div>
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

    .btn-HoanThanh {
        padding: 10px 20px;
        background-color: #3498db;
        color: white;
        text-align: center;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 32px;
        cursor: pointer;
    }
</style>