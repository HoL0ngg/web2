<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div id="container">
        <div id="container-left">
            <div id="logo">
                <img src="img/logo.png" alt="logo">
            </div>
            <div id="menu">
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="admin.php?page=product">Sản phẩm</a></li>
                    <li><a href="admin.php?page=category">Danh mục</a></li>
                    <li><a href="admin.php?page=user">Người dùng</a></li>
                    <li><a href="admin.php?page=order">Đơn hàng</a></li>
                    <li><a href="admin.php?page=staticstic">Thống kê</a></li>
                </ul>
            </div>
            <div id="footer">
                <div id="admin-info">
                    <p>Xin chào: <span>admin</span></p>
                </div>
                <div id="admin-logout">
                    <a href="logout.php">Đăng xuất</a>
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
                } elseif ($page == 'staticstic') {
                    include('staticstic.php');
                }
            } else {
                include('product.php');
            }
            ?>
        </div>
</body>

</html>