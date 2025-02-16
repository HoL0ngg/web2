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
    <div id="header">
        <div id="top-header">
            <div id="left-header">
                <div style="flex: 1;">
                    <img src="" alt="">
                    Logo
                </div>
                <div id="timkiem-header">
                    <div id="filter" onclick="display_filter()">
                        <i class="fa-solid fa-filter" style="color: white;"></i>
                    </div>
                    <input type="text" name="timkiem" id="timkiem" placeholder="Tìm kiếm sản phẩm">
                    <div id="find">
                        <i class="fa-solid fa-magnifying-glass" style="color: white;"></i>
                    </div>
                    <div id="filter-menu">
                        <div style="float: right; cursor: pointer;" onclick="display_filter()"><i class="fa-solid fa-xmark"></i></div>
                        <div id="filter-price">
                            <h3>Price</h3>
                            <input type="text" placeholder="min price">
                            <input type="text" placeholder="max price">
                        </div>
                        <div id="filter-category">
                            <h3>Category</h3>
                            <div><label for="">Skincare</label><input type="checkbox" name="" id=""></div>
                            <div><label for="">Makeup</label><input type="checkbox" name="" id=""></div>
                            <div><label for="">Haircare</label><input type="checkbox" name="" id=""></div>
                            <div><label for="">Bodycare</label><input type="checkbox" name="" id=""></div>
                        </div>
                        <div id="filter-brand">
                            <h3>Brand</h3>
                            <div><label for="">L'Oreal</label><input type="checkbox" name="" id=""></div>
                            <div><label for="">Dove</label><input type="checkbox" name="" id=""></div>
                            <div><label for="">la roche-posay</label><input type="checkbox" name="" id=""></div>
                        </div>
                        <div id="filter-reset" style="display: flex; justify-content: center;">
                            <button> RESET </button>
                        </div>
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
                <div style="border: 3px solid #5cb3f1;border-radius: 20px;">
                    <div id="taikhoan-container">
                        <i class="fa-solid fa-user" style="color: #6794c1;"></i>
                        <div style="color: #5cb3f1;">Tài khoản</div>
                    </div>
                </div>
                <div>
                    <div style="position: relative;">
                        <i class="fa-regular fa-heart fa-xl"></i>
                        <div
                            style="position: absolute; top: -16px; right: -8px; background-color: #c8edf7; border-radius: 100%; width: 16px; height: 16px; text-align: center;">
                            0</div>
                    </div>
                </div>
                <div>
                    <div id="cart-container">
                        <div style="position: relative;">
                            <i class="fa-solid fa-bag-shopping fa-xl" style="color: white;"></i>
                            <div
                                style="position: absolute; top: -16px; right: -8px; background-color: #c8edf7; border-radius: 100%; width: 16px; height: 16px; text-align: center;">
                                0</div>
                        </div>
                        <div style="color: white;">Giỏ hàng</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="bot-header">
            <div>
                <div id="left-bot-header">
                    <div>Trang chủ</div>
                    <div>Giới thiệu</div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div>Sản phẩm</div>
                        <div class="icon-up"><i class="fa-solid fa-sort-up"></i></div>
                    </div>
                    <div>Tin tức</div>
                    <div>Liên hệ</div>
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

    <div id="banner">
        <img src="img/img1.jpg" alt="img1">
        <img src="img/img2.png" alt="img2">
    </div>

    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="img/img1.jpg"></div>
            <div class="swiper-slide"><img src="img/img2.png"></div>
            <div class="swiper-slide"><img src="img/img1.jpg"></div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 30000000
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

    <div id="information">
        <h2>Nhận thông tin khuyến mãi mới nhất</h2>
        <p>Để lại email của bạn để nhận những thông tin khuyến mãi mới nhất từ chúng tôi</p>
        <div id="input-information">
            <input type="email" name="email-info" id="email-info" placeholder="Email của bạn">
            <button onclick="checkEmailkhuyenmai()" id="emailkhuyenmai">
                <i class="fa-solid fa-arrow-right" style="color: white;"></i>
            </button>
        </div>
    </div>
    <div id="footer">
        <div id="footer-container">
            <div class="footer-item">
                <img src="Logo-DH-Sai-Gon-SGU-flat.webp" alt="">
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


    <div id="content"></div>
    <!-- Login -->
    <!--  action="handles/handleLogin.php" -->
    <div id="login-wrapper">
        <div id="login-container">
            <form name="frmLogin" method="post" onsubmit="return checkLogin()">
                <div class="form-title">
                    <h2>ĐĂNG NHẬP</h2>
                    <div class="btn-close">x</div>
                </div>

                <div class="input-field">
                    <input type="text" id="username" name="username" required>
                    <label for="username"><i class="fa-solid fa-user"></i></span>Tên đăng nhập</label>
                </div>
                <div class="error" id="usernameErr"></div>

                <div class="input-field">
                    <input type="password" id="password" name="password" required>
                    <label for="password"><i class="fa-solid fa-key"></i></span>Mật khẩu</label>
                    <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                </div>
                <div class="error" id="passwordErr"></div>

                <div class="input-btn-wrapper">
                    <input type="submit" value="Đăng nhập" class="btn" name="btnLogin">
                </div>

                <div style="text-align: center;margin: 17px">
                    <span>Bạn đã có tài khoản chưa?</span>
                    <span style="font-weight: 700;color: #0063EC;cursor: pointer;" onclick="openRegisterForm()">Đăng ký</span>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast">To Ast</div>

    <!-- Register -->
    <!-- method="post" action="handles/handleRegister.php" onsubmit="return checkRegister()" -->
    <div id="register-wrapper">
        <div id="register-container">
            <form name="frmRegister">
                <div class="form-title">
                    <h2>ĐĂNG KÝ</h2>
                    <div class="btn-close">x</div>
                </div>
                <div class="input-field-wrapper">
                    <div class="input-field">
                        <input type="text" id="reg-phone" name="reg-phone" required>
                        <label for="reg-phone"><span><i class="fa-solid fa-phone"></i></span>Số điện thoại</label>
                    </div>
                    <div class="error phone"></div>

                    <div class="input-field">
                        <input type="text" id="reg-username" name="reg-username" required>
                        <label for="reg-username"><span><i class="fa-solid fa-user"></i></span>Tên đăng nhập</label>
                    </div>
                    <div class="error username"></div>

                    <div class="input-field">
                        <input type="password" id="reg-password" name="reg-password" required>
                        <label for="reg-password"><span><i class="fa-solid fa-key"></i></span>Mật khẩu </label>
                        <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="error password"></div>

                    <div class="input-field">
                        <input type="password" id="reg-repassword" name="reg-repassword" required>
                        <label for="reg-repassword"><span><i class="fa-solid fa-key"></i></span>Nhập lại mật khẩu </label>
                        <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="error repassword"></div>
                </div>

                <div class="input-btn-wrapper">
                    <input type="submit" class="btn" value="Đăng ký ngay" name="btnRegister">
                </div>
            </form>
        </div>
    </div>
    <!-- Logout -->
    <div id="logout">
        <span>Đổi mật khẩu</span><br>
        <span><a href="handles/logout.php" style="text-decoration: none; color: black">Đăng xuất</a></span>
    </div>
    <script src="js/script.js"></script>
</body>

</html>