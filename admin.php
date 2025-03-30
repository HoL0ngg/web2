<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div id="container">
        <div id="container-left">
            <div id="logo">
                <img src="img/logo3.svg" alt="logo">
            </div>

            <div id="hideSideBar"><i class="fa-solid fa-less-than"></i></div>
            <div id="menu">
                <ul>
                    <li class="active">
                        <a href="admin.php">
                            <i class="fa-solid fa-house"></i>
                            <span class="text">Trang tổng quan</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin.php?page=product">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span class="text">Sản phẩm</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin.php?page=category">
                            <i class="fa-solid fa-list"></i>
                            <span class="text">Danh mục</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin.php?page=user">
                            <i class="fa-solid fa-user"></i>
                            <span class="text">Người dùng</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin.php?page=order">
                            <i class="fa-solid fa-box-open"></i>
                            <span class="text">Đơn hàng</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin.php?page=thongke">
                            <i class="fa-solid fa-chart-simple"></i>
                            <span class="text">Thống kê</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div id="footer">

                <div id="admin-info">
                    <p>Xin chào: <span>admin</span></p>
                </div>

                <div id="admin-logout">
                    <a href="index.php">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="text">Đăng xuất</span>
                    </a>
                </div>

            </div>
        </div>
        <div id="container-right">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if ($page == 'product') {
                    include('product.php');
                } elseif ($page == 'category') {
                    include('category.php');
                } elseif ($page == 'user') {
                    include('user.php');
                } elseif ($page == 'order') {
                    include('order.php');
                } elseif ($page == 'thongke') {
                    include('thongke.php');
                }
            } else {
                include('product.php');
            }
            ?>
        </div>
    </div>
    <script src="js/admin.js"></script>
</body>

</html>