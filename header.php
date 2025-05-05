<?php
$cartCount = 0;
$loveCount = 0;
require_once 'handles/CartController.php';
require_once 'Model/TKModel.php';
require_once 'handles/handleLove.php';
if (isset($_SESSION['username'])) {
    $tkmodel = new TKModel();
    $customer_id = $tkmodel->getIdByUsername($_SESSION['username']);
    $customer_id = $tkmodel->getCustomerIdByUserId($customer_id);
    $cartController = new CartController();
    $loveController = new handleLove();
    $cartCount = $cartController->getCartCount($customer_id);
    $loveCount = $loveController->getLoveCount($customer_id);
} else {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $cartCount += $item['quantity'];
        }
    } else {
        $cartCount = 0;
    }
    if (isset($_SESSION['wishlist'])) {
        $loveCount = count($_SESSION['wishlist']);
    } else {
        $loveCount = 0;
    }
}

?>
<div id="header">
    <div id="top-header">
        <div id="left-header">
            <div style="flex: 1;height: 100%;margin-right: 10px;">
                <img src="imgs/logo3.svg" alt="" style="width: 100%;height: 100%;">
            </div>
            <div id="timkiem-header">
                <input type="text" name="timkiem" id="timkiem" placeholder="Tìm kiếm sản phẩm">
                <div id="find">
                    <i class="fa-solid fa-magnifying-glass" style="color: white;"></i>
                </div>
            </div>
        </div>
        <div id="infomation-header">
            <div>
                <div>
                    <i class="fa-solid fa-phone-volume"></i>
                </div>
                <div>
                    <div style="color: #6794c1;">Hotline:</div>
                    <div style="color: #5cb3f1;">1900 1080</div>
                </div>
            </div>
            <div>
                <div>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <div style="color: #6794c1;">Email:</div>
                    <div style="color: #5cb3f1;">longcute@gmail.com</div>
                </div>
            </div>
        </div>
        <div id="right-header">
            <?php if (isset($_SESSION['user']['role_id']) && $_SESSION['user']['role_id'] != 3) : ?>
                <a href="admin.php" style="color: black"><i class="fa-solid fa-gear"></i></a>
            <?php endif; ?>
            <div style="border: 3px solid #5cb3f1;border-radius: 20px;position: relative">
                <div id="taikhoan-container" onclick="openLoginForm()">
                    <?php
                    if (isset($_SESSION["username"])) {
                        echo "Xin chào, " . $_SESSION["username"];
                    } else {
                        echo '<i class="fa-solid fa-user" style="color: #6794c1;"></i>
                                <div style="color: #5cb3f1;">Tài khoản</div>';
                    }
                    ?>
                </div>

                <!-- Logout -->
                <div id="logout">
                    <span id="btnChangePass">Đổi mật khẩu</span><br>
                    <span><a href="handles/logout.php" style="text-decoration: none; color: black">Đăng xuất</a></span>
                </div>
            </div>
            <div>
                <div id="love-container">
                    <div style="position: relative;">
                        <i class="fa-regular fa-heart fa-xl"></i>
                        <div id="love-count"
                            style="position: absolute; top: -16px; right: -12px; background-color: #c8edf7; border-radius: 100%; width: 20px; height: 20px; text-align: center;">
                            <?php echo ($loveCount < 10 ? $loveCount : '9+') ?></div>
                    </div>
                </div>
            </div>
            <div>
                <div id="cart-container">
                    <div style="position: relative;">
                        <i class="fa-solid fa-bag-shopping fa-xl" style="color: white;"></i>
                        <div id="cart-count"
                            style="position: absolute; top: -16px; right: -12px; background-color: #c8edf7; border-radius: 100%; width: 20px; height: 20px; text-align: center;">
                            <?php echo ($cartCount < 10 ? $cartCount : '9+') ?></div>
                    </div>
                    <div style="color: white;">Giỏ hàng</div>
                </div>
            </div>
        </div>
    </div>
    <div id="bot-header">
        <div>
            <div id="left-bot-header">
                <div id="menu">
                    <div>Menu</div>
                     <div id="menu-sub">
                            <div><a href="index.php?gioithieu">Giới Thiệu</a></div>
                            <div>Liên Hệ</div>
                            <div>Tin Tức</div>
                    </div>
                </div>
                <div><a href="index.php">Trang chủ</a></div>
                <div class="hihi"><a href="index.php?gioithieu">Giới Thiệu</a></div>
                <div id="sp" style="display: flex; align-items: center; gap: 8px;">
                    <div>Lọc Sản Phẩm</div>
                    <div class="icon-up"><i class="fa-solid fa-sort-up"></i></div>
                    <div id="product-menu">
                        <div id="product-menu-nav">
                            <div id="brand">
                                <h2>Hãng</h2>
                                <?php
                                include('get_brand.php');
                                ?>
                            </div>
                            <div id="theloai">
                                <h2>Thể loại</h2>
                                <?php
                                require_once('get_loaisanpham.php');
                                $get_loaisanpham = new get_loaisanpham();
                                $get_loaisanpham->get_loaisanphamfilter();
                                ?>
                            </div>
                            <div id="price">
                                <h2>Khoảng giá</h2>
                                <div id="input"><input type="text" id="minprice" placeholder="0" />
                                    <span>-</span>
                                    <input type="text" id="maxprice" placeholder="100.000.000" />
                                </div>
                                <div id="button"><button id='filters'>Áp dụng lọc</button>
                                    <button id='reset-filters'> Đặt lại</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hihi">Tin tức</div>
                <div class="hihi">Liên hệ</div>
                <div>
                    <a href="index.php?orderhistory">Lịch sử mua hàng</a>
                </div>
            </div>

            <div id="right-bot-header">
                <div>
                    <i class="fa-solid fa-bolt-lightning"></i>
                </div>
                <div>
                    Flash Sale
                </div>
            </div>
        </div>
    </div>
</div>
<div style="height: 139px;"></div>
<script>
const button = document.getElementById('sp');
const content = document.getElementById('product-menu');
const find = document.getElementById('timkiem-header');
const iconUp = document.querySelector('.icon-up');
const iconUpI = document.querySelector('.icon-up i');


button.addEventListener('click', (event) => {
    event.stopPropagation();
    content.classList.toggle('show');
    iconUp.classList.toggle('rotated');
    iconUpI.classList.toggle('rotated');
});

find.addEventListener('click', (event) => {
    event.stopPropagation();
});


// Ngăn chặn đóng khi click vào bên trong menu
content.addEventListener('click', (event) => {
    event.stopPropagation();
});

// Click ra ngoài thì đóng
document.addEventListener('click', (e) => {
    if (!button.contains(e.target) && !content.contains(e.target)) {
        content.classList.remove('show');
        iconUp.classList.remove('rotated');
        iconUpI.classList.remove('rotated');
    }
});



</script>