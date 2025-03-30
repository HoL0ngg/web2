<?php
session_start();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mỹ phẩm</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

</head>

<body>
    <?php include("header.php") ?>

    <!-- <div id="banner">
        <img src="img/img1.jpg" alt="img1">
        <img src="img/img2.png" alt="img2">
    </div> -->

    <!-- <div class="marquee-container">
        <div class="marquee-content">
            Đây là nội dung chạy chữ. Bạn có thể thay đổi nội dung này.
        </div>
    </div> -->
    <div class="swiper banner-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="img/img1.jpg" alt="img1"></div>
            <div class="swiper-slide"><img src="img/img2.png" alt="img2"></div>
            <div class="swiper-slide"><img src="img/img1.jpg" alt="img3"></div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
    <div id="content-wrapper">
        <?php include("content.php") ?>
    </div>
    <div style="width: 100%; text-align: center; font-size: 2.6em; font-weight: 700">
        Đánh giá người sử dụng
    </div>
    <div class="swiper review-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://fit.sgu.edu.vn/site/wp-content/uploads/2019/01/thanhsang.jpg" alt="Người 1" />
                <h3>Nguyễn Thanh Sang</h3>
                <p>Sản phẩm rất tốt, dịch vụ tuyệt vời!</p>
            </div>
            <div class="swiper-slide">
                <img src="https://fit.sgu.edu.vn/site/wp-content/uploads/2019/01/thanhsang.jpg" alt="Người 2" />
                <h3>Nguyễn Thanh Sang</h3>
                <p>Giao hàng nhanh, đáng tiền.</p>
            </div>
            <div class="swiper-slide">
                <img src="https://fit.sgu.edu.vn/site/wp-content/uploads/2019/01/thanhsang.jpg" alt="Người 3" />
                <h3>Nguyễn Thanh Sang</h3>
                <p>Chất lượng vượt mong đợi.</p>
            </div>
            <div class="swiper-slide">
                <img src="https://fit.sgu.edu.vn/site/wp-content/uploads/2019/01/thanhsang.jpg" alt="Người 3" />
                <h3>Nguyễn Thanh Sang</h3>
                <p>Chất lượng vượt mong đợi.</p>
            </div>
            <div class="swiper-slide">
                <img src="https://fit.sgu.edu.vn/site/wp-content/uploads/2019/01/thanhsang.jpg" alt="Người 3" />
                <h3>Nguyễn Thanh Sang</h3>
                <p>Chất lượng vượt mong đợi.</p>
            </div>
            <div class="swiper-slide">
                <img src="https://fit.sgu.edu.vn/site/wp-content/uploads/2019/01/thanhsang.jpg" alt="Người 3" />
                <h3>Nguyễn Thanh Sang</h3>
                <p>Chất lượng vượt mong đợi.</p>
            </div>
            <div class="swiper-slide">
                <img src="https://fit.sgu.edu.vn/site/wp-content/uploads/2019/01/thanhsang.jpg" alt="Người 3" />
                <h3>Nguyễn Thanh Sang</h3>
                <p>Chất lượng vượt mong đợi.</p>
            </div>
        </div>
    </div>
    <script>
        const swiper_title = new Swiper(".banner-swiper", {
            grabCursor: true,
            keyboard: {
                enabled: true, // Kích hoạt phím mũi tên
                onlyInViewport: true, // Chỉ hoạt động khi slider trong tầm nhìn
            },
            loop: true,
            autoplay: {
                delay: 3000
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            }
        });
    </script>
    <script>
        const swiper = new Swiper('.review-swiper', {
            slidesPerView: 3, // Hiển thị 4 slide cùng lúc
            spaceBetween: 30, // Khoảng cách giữa các slide
            grabCursor: true, // Hiển thị con trỏ kéo
            loop: true, // Lặp lại danh sách
            autoplay: {
                delay: 3000, // Tự động chuyển slide sau 3 giây
            },
            breakpoints: {
                // Responsive
                320: {
                    slidesPerView: 1, // 1 slide trên màn hình nhỏ
                },
                640: {
                    slidesPerView: 2, // 2 slide trên màn hình vừa
                },
                1024: {
                    slidesPerView: 4, // 4 slide trên màn hình lớn
                },
            },
        });
    </script>
    <div id="footer">
        <div id="footer-container">
            <div class="footer-item">
                <img src="" alt="">
            </div>
            <div class="footer-item">
                <h4>Thông tin hữu ích</h4>
                <a href="">Kiểm tra size quạt</a>
                <br>
                <a href="">Hướng dẫn bảo hành</a>
                <br>
                <a href="">Quy định đổi quạt</a>
            </div>
            <div class="footer-item">
                <h4>Giới thiệu</h4>
                <a href="">Quan niệm về quạt</a>
                <br>
                <a href="">Danh sách cửa hàng</a>
                <br>
                <a href="">Dành cho đại lý</a>
            </div>
            <div class="footer-item">
                <h4>Thông tin liên hệ</h4>
                <p>Địa chỉ: 273 An Dương Vương, P3, Quận 5, TP.HCM</p>
                <p>Số điện thoại: 0912345JQK</p>
            </div>
        </div>
    </div>

    <!-- Login -->
    <!--  action="handles/handleLogin.php" -->
    <?php include("login-wrapper.php") ?>

    <!-- Toast -->
    <div id="toast">To Ast</div>

    <!-- Register -->
    <!-- method="post" action="handles/handleRegister.php" onsubmit="return checkRegister()" -->
    <?php include("register-wrapper.php") ?>

    <!-- Change Password -->
    <?php include("changepassword-wrapper.php") ?>

    <script src="js/script.js"></script>

</body>

</html>