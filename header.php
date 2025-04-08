<div id="header">
    <div id="top-header">
        <div id="left-header">
            <div style="flex: 1;height: 100%;margin-right: 10px;">
                <img src="img/logo3.svg" alt="" style="width: 100%;height: 100%;">
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
                <div><a href="index.php">Trang chủ</a></div>
                <div>Giới thiệu</div>
                <div id="sp" style="display: flex; align-items: center; gap: 8px;">
                    <div>Sản phẩm</div>
                    <div class="icon-up"><i class="fa-solid fa-sort-up"></i></div>
                    <div id="product-menu">
                        <div id="product-menu-nav">
                            <ul>

                                <li>
                                    <a href="index.php?maChungloai=1">
                                        <img src="img/trangdiem.webp" alt="">
                                        <span>Trang Điểm</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?maChungloai=2">
                                        <img src="img/chamsocdamat.webp" alt="">
                                        <span>Chăm Sóc Da Mặt</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?maChungloai=3">
                                        <img src="img/chamsoccothe.webp" alt="">
                                        <span>Chăm Sóc Cơ Thể</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?maChungloai=4">
                                        <img src="img/chamsoctocdadau.webp" alt="">
                                        <span>Chăm Sóc Tóc & Chăm Sóc Da Đầu</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?maChungloai=5">
                                        <img src="img/chamsoccanhan.webp" alt="">
                                        <span>Chăm Sóc Cá Nhân</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?maChungloai=6">
                                        <img src="img/nuochoa.webp" alt="">
                                        <span>Nước Hoa</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div>Tin tức</div>
                <div>Liên hệ</div>
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
    function loadSubCategories(maChungloai) {
        // Gọi API để lấy các thể loại theo maChungloai
        fetch(`api.php?maChungloai=${maChungloai}`)
            .then(response => response.json())
            .then(data => {
                // Hiển thị kết quả lên trang
                const loaisanphamList = document.getElementById('loaisanpham-list');
                loaisanphamList.innerHTML = ''; // Xóa danh sách cũ

                if (data.length > 0) {
                    data.forEach(loaisanpham => {
                        // Tạo thẻ <li> mới
                        const li = document.createElement('li');

                        // Tạo thẻ <input> checkbox
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.id = `loaisanpham-${loaisanpham.maLoaisanpham}`;
                        checkbox.name = `loaisanpham-${loaisanpham.maLoaisanpham}`;
                        checkbox.value = loaisanpham.maLoaisanpham;

                        // Tạo thẻ <span> chứa tên thể loại
                        const span = document.createElement('span');
                        span.textContent = loaisanpham.ten;

                        // Gắn checkbox và span vào thẻ <li>
                        li.appendChild(checkbox);
                        li.appendChild(span);

                        // Thêm thẻ <li> vào danh sách
                        loaisanphamList.appendChild(li);
                    });
                } else {
                    loaisanphamList.innerHTML = '<li>Không có thể loại nào</li>';
                }
            })
            .catch(error => {
                console.error('Có lỗi khi gọi API:', error);
            });
    }
</script>