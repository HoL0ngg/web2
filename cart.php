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
        <div class="product-item">
            <div class="product-img">
                <img src="/img/img1.jpg" alt="">
            </div>
            <div class="product-info">
                <div class="product-title">Son j đó</div>
                <div class="product-delete">
                    <div>
                        <span><i class="fa-solid fa-trash"></i></span>
                        <span>Xóa</span>
                    </div>
                </div>
            </div>
            <div class="product-hihi">
                <div class="product-total">
                    100.000đ
                </div>
                <div class="product-quantity">
                    <div class="quantity-container">
                        <button>-</button>
                        <p>1</p>
                        <button>+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>