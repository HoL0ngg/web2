<div style="width: 42%; margin: 32px auto 0px; padding: 24px 48px; background-color:rgba(52, 152, 219, 0.5); border-radius: 10px">
    <div class="progress-container">
        <div class="progress-step active" data-step="Giỏ hàng"><i class="fa-solid fa-cart-shopping"></i></div>
        <span class="progress-line"></span>
        <div class="progress-step" data-step="Thông tin cá nhân"><i class="fa-solid fa-address-card"></i></div>
        <span class="progress-line"></span>
        <div class="progress-step" data-step="Hóa đơn"><i class="fa-solid fa-receipt"></i></div>
        <span class="progress-line"></span>
        <div class="progress-step" data-step="Hoàn tất"><i class="fa-solid fa-circle-check"></i></div>
    </div>
</div>

<div id="cart-info">
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
        <div class="cart-item">
            <div class="cart-image">
                <img src=<?php echo $img_url; ?> alt="Hinh anh">
            </div>
            <div class="cart-info">
                <p class="cart-title"><strong><?php echo $row['product_name'] ?></strong></p>
                <div>
                    <i class="fa-solid fa-trash"></i>
                    <span class="cart-remove" data-id="<?php echo $row['product_id'] ?>">Xóa</span>
                </div>
            </div>
            <div class="cart-price">
                <div class="new-price"><?php echo number_format($row['price'], 0, ',', '.') ?>đ</div>
                <!-- <div class="old-price">334.000đ</div> -->
                <div class="cart-quantity-container">
                    <button class="minus">-</button>
                    <p class="cart-quantity">1</p>
                    <button class="plus">+</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div id="cart-total">
        <div>Tổng tiền: </div>
        <div class="total-price"><?php echo number_format($total, 0, ',', '.') ?>VNĐ</div>
    </div>
    <?php $_SESSION['total'] = $total; ?>
    <div id="cart-thanhtoan">
        ĐẶT HÀNG NGAY
    </div>

</div>
<script src="/js/cart.js"></script>