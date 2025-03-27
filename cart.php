<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mỹ phẩm</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="cart.css">
</head>

<body>
    <?php include("header.php") ?>
    <div style="width: max-content; margin: 32px auto 0px; padding: 24px 48px; background-color:rgb(168, 213, 243); border-radius: 10px">
        <div class="progress-container">
            <div class="progress-step active" data-step="Giỏ hàng"><i class="fa-solid fa-cart-shopping"></i></div>
            <span class="progress-line active"></span>
            <div class="progress-step active" data-step="Thông tin cá nhân"><i class="fa-solid fa-address-card"></i></div>
            <span class="progress-line"></span>
            <div class="progress-step" data-step="Hóa đơn"><i class="fa-solid fa-receipt"></i></div>
            <span class="progress-line"></span>
            <div class="progress-step" data-step="Hoàn tất"><i class="fa-solid fa-circle-check"></i></div>
        </div>
    </div>
    <div id="cart-info">
        <div class="cart-item">
            <div class="cart-image">
                <img src="/img/img1.jpg" alt="Son">
            </div>
            <div class="cart-info">
                <p class="cart-title"><strong>[NEW][Màu 1-39] Son Tint Lì, Căng Bóng Romand The Juicy Lasting Tint</strong></p>
                <p class="cart-color">07 JUJUBE</p>
                <i class="fa-solid fa-trash"></i>
                <span class="cart-remove">Xóa</span>
            </div>
            <div class="cart-price">
                <div class="new-price">152.150đ</div>
                <div class="old-price">334.000đ</div>
                <div class="cart-quantity">
                    <button class="minus">-</button>
                    <p>1</p>
                    <button class="plus">+</button>
                </div>
            </div>
        </div>

    </div>

    <?php include("login-wrapper.php") ?>
    <?php include("register-wrapper.php") ?>
    <?php include("changepassword-wrapper.php") ?>
    <script src="/js/cart.js"></script>
    <script src="/js/script.js"></script>
</body>