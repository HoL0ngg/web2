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
                <div id="cart-container" style="user-select: none;">
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