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
                        <div style="float: right; cursor: pointer;" onclick="display_filter()"><i
                                class="fa-solid fa-xmark"></i></div>
                        <div id="filter-price">
                            <h3>Price</h3>
                            <input type="text" placeholder="min price">
                            <input type="text" placeholder="max price">
                        </div>
                        <div id="filter-category">
                            <h3>Category</h3>
                            <div><label for="skincare">Skincare</label><input type="checkbox" name="skincare" id="skincare"></div>
                            <div><label for="makeup">Makeup</label><input type="checkbox" name="makeup" id="makeup"></div>
                            <div><label for="haircare">Haircare</label><input type="checkbox" name="haircare" id="haircare"></div>
                            <div><label for="bodycare">Bodycare</label><input type="checkbox" name="bodycare" id="bodycare"></div>
                        </div>
                        <div id="filter-brand">
                            <h3>Brand</h3>
                            <div><label for="">L'Oreal</label><input type="checkbox" name="" id=""></div>
                            <div><label for="">Dove</label><input type="checkbox" name="" id=""></div>
                            <div><label for="">la roche-posay</label><input type="checkbox" name="" id=""></div>
                        </div>
                        <div id="filter-reset" style="display: flex; justify-content: center;">
                            <button onclick="clearInputField('#filter-menu ')"> Reset </button>
                            <!-- <button>Tìm kiếm</button> -->
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
                <div style="border: 3px solid #5cb3f1;border-radius: 20px;position: relative">
                    <div id="taikhoan-container">
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
            <div class="swiper-slide"><img src="img/img1.jpg"></div>
            <div class="swiper-slide"><img src="img/img2.png"></div>
            <div class="swiper-slide"><img src="img/img1.jpg"></div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
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

    <!-- Change Password -->
    <div id="changepassword-wrapper">
        <div id="changepassword-container">
            <form method="post" name="frmChangePass" onsubmit="return checkChangePassword()">
                <div class="form-title">
                    <h2>ĐỔI MẬT KHẨU</h2>
                    <div class="btn-close">x</div>
                </div>

                <div class="input-field-wrapper">
                    <div class="input-field">
                        <input type="password" name="currentpass" id="currentpass" required>
                        <label for="currentpass"><span><i class="fa-solid fa-lock"></i>Nhập mật khẩu hiện tại</label>
                        <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="error" id="currentpassErr"></div>

                    <div class="input-field">
                        <input type="password" name="newpass" id="newpass" required>
                        <label for="newpass"><span><i class="fa-solid fa-lock"></i>Nhập mật khẩu mới</label>
                        <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="error" id="newpassErr"></div>

                    <div class="input-field">
                        <input type="password" name="renewpass" id="renewpass" required>
                        <label for="renewpass"><span><i class="fa-solid fa-lock"></i>Nhập lại mật khẩu mới</label>
                        <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="error" id="renewpassErr"></div>

                    <div class="input-btn-wrapper">
                        <input type="submit" class="btn" value="Đổi mật khẩu" name="btnChangePassword">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>

</body>

</html>