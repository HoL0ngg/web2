<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <!-- <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Toast -->
    <div id="toast"></div>

    <div id="container">
        <div id="container-left">
            <div id="logo">
                <img src="imgs/logo3.svg" alt="logo">
            </div>

            <div id="hideSideBar"><i class="fa-solid fa-less-than"></i></div>
            <div id="menu">
                <ul>
                    <li class="active">
                        <a href="admin.php?page=admin_home">
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

                    <li>
                        <a href="admin.php?page=phanquyen">
                            <i class="fa-solid fa-users-gear"></i>
                            <span class="text">Phân quyền</span>
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
                    require_once('handles/ProductController.php');
                    $productController = new ProductController();
                    if (isset($_GET['action'])) {
                        $productController->addForm();
                    } else {
                        include('product.php');
                    }
                } elseif ($page == 'category') {
                    include('category.php');
                } elseif ($page == 'user') {
                    include("chucnangAccount.php"); // Đảm bảo file chứa class được gọi
                    if (isset($_GET['act'])) {
                        $act = $_GET['act'];
                        switch ($act) {
                            case 'add':
                                $addAcc = new AccountFunction();
                                $addAcc->accountForm("THÊM TÀI KHOẢN", "addUserForm");
                                break;
                            case 'update':
                                require_once("Model/TKModel.php");
                                $id = $_GET['uid'] ?? '';
                                $id = (int)$id;
                                $tkmodel = new TKModel();
                                $user = $tkmodel->getUserById($id);
                                $addAcc = new AccountFunction();
                                $addAcc->accountForm("SỬA TÀI KHOẢN", "updateUserForm", $user);
                                break;
                            default:
                                break;
                        }
                    } else {

                        include('user.php');
                    }
                } elseif ($page == 'order') {
                    include('order.php');
                } elseif ($page == 'thongke') {
                    include('thongke.php');
                } elseif ($page == 'phanquyen') {
                    include('thongke.php');
                } else {
                    include('admin/home.php');
                }
            } else {
                include('admin/home.php');
            }
            ?>
        </div>
    </div>
    <script src="js/admin.js"></script>
</body>

</html>