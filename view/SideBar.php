    <?php
    $menuItems = [
        'danhmuc' => ['page' => 'category', 'icon' => 'fa-list'],
        'donhang' => ['page' => 'order', 'icon' => 'fa-box-open'],
        'nguoidung' => ['page' => 'user', 'icon' => 'fa-user'],
        'nhacungcap' => ['page' => 'supplier', 'icon' => 'fa-truck-field'],
        'nhaphang' => ['page' => 'import', 'icon' => 'fa-file-invoice'],
        'phanquyen' => ['page' => 'phanquyen&role_id=1', 'icon' => 'fa-users-gear'],
        'thongke' => ['page' => 'thongke', 'icon' => 'fa-chart-simple'],
        'sanpham' => ['page' => 'product', 'icon' => 'fa-cart-plus'],
        'sukien' => ['page' => 'importbill', 'icon' => 'fa-file-invoice-dollar'],
    ];

    ?>
    <div id="logo">
        <img src="imgs/logo3.svg" alt="logo">
    </div>

    <div id="hideSideBar"><i class="fa-solid fa-less-than"></i></div>

    <div id="menu">
        <ul>
            <li class="<?= $page === 'admin_home' ? 'active' : '' ?>">
                <a href="admin.php?page=admin_home">
                    <i class="fa-solid fa-house"></i>
                    <span class="text">Trang tổng quan</span>
                </a>
            </li>

            <?php foreach ($allowedFunctions as $func): ?>
                <?php
                $fid = $func['function_id'];
                if (!isset($menuItems[$fid])) continue;
                $item = $menuItems[$fid];
                ?>
                <li class="<?= $page === $item['page'] ? 'active' : '' ?>">
                    <a href="admin.php?page=<?= $item['page'] ?>">
                        <i class="fa-solid <?= $item['icon'] ?>"></i>
                        <span class="text"><?= $func['function_name'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div id="footer">
        <div id="admin-info">
            <p>Xin chào: <span><?= $_SESSION['user']['username'] ?? 'admin' ?></span></p>
        </div>
        <div id="admin-logout">
            <?php if ($_SESSION['user']['role_id'] == 1): ?>
                <a href="view/admin/logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="text">Đăng xuất</span>
                </a>
            <?php else: ?>
                <a href="handles/logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="text">Đăng xuất</span>
                </a>
            <?php endif; ?>
        </div>
    </div>