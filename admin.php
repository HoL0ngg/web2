<?php
// session_start();
// if (!isset($_SESSION['admin'])) {
    // header('Location: index.php');
    // exit;
// }

// Nếu đã đăng nhập:
// $admin = $_SESSION['admin'];
?>

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
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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
                        <a href="admin.php?page=supplier">
                            <i class="fa-solid fa-truck-field"></i>
                            <span class="text">Nhà cung cấp</span>
                        </a>
                    </li>

                    <li>
                        <a href="admin.php?page=import">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span class="text">Nhập hàng</span>
                        </a>
                    </li>

                    <li>
                        <a href="admin.php?page=thongke">
                            <i class="fa-solid fa-chart-simple"></i>
                            <span class="text">Thống kê</span>
                        </a>
                    </li>

                    <li>
                        <a href="admin.php?page=phanquyen&role_id=1">
                            <i class="fa-solid fa-users-gear"></i>
                            <span class="text">Phân quyền</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div id="footer">

                <div id="admin-info">
                    <p>Xin chào: <span><?= $_SESSION['admin'] ?></span></p>
                </div>

                <div id="admin-logout">
                    <a href="view/admin/logout.php">
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
                    require_once('handles/FormProductController.php');
                    $formProductController = new FormProductController();
                    if (isset($_GET['action'])) {
                        $act = $_GET['action'];
                        switch ($act) {
                            case 'add':
                                $formProductController->addForm();
                                break;
                            case 'edit':
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                    $formProductController->updateForm($id);
                                }
                                break;
                            default:
                                # code...
                                break;
                        }
                    } else {
                        $formProductController->getAllProducts();
                    }
                } elseif ($page == 'category') {
                    include('category.php');
                } elseif ($page == 'user') {
                    require_once("handles/TKController.php");
                    $tkController = new TKController(); // Đảm bảo file chứa class được gọi
                    if (isset($_GET['act'])) {
                        $act = $_GET['act'];
                        switch ($act) {
                            case 'add':
                                $tkController->addForm();
                                break;
                            case 'update':
                                $id = $_GET['uid'] ?? '';
                                $id = (int)$id;
                                $tkController->updateForm($id);
                                break;
                            default:
                                $tkController->userList();
                                break;
                        }
                    } else {
                        $tkController->userList();
                    }
                } elseif ($page == 'order') {
                    require_once './handles/OrderController.php';
                    $OrderHistoryController = new OrderController();
                    $OrderHistoryController->getAllOrder();
                } elseif ($page == 'supplier'){
                    include('supplier.php');
                } elseif ($page == 'import'){
                    include('import.php');
                } elseif ($page == 'thongke') {
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        require_once 'handles/TKController.php';
                        $tkController = new TKController();
                        $orders = $tkController->getOrderById($id);
                        require_once 'view/OrderView.php';
                    } else {
                        include('thongke.php');
                    }
                } elseif ($page == 'phanquyen') {
                    require_once('handles/PhanQuyenController.php');
                    $phanquyenController = new PhanQuyenController();
                    $phanquyenController->roleList();
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