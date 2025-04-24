<?php

// session_start();
// if (!isset($_SESSION['user']) && !isset($_SESSION['user']['role_id'])) {
//     header('Location: index.php');
//     exit;
// }
// if ($_SESSION['user']['role_id'] == 3) {
//     header('Location: index.php');
//     exit;
// }
// $role_id = $_SESSION['user']['role_id'];

require_once('handles/PhanQuyenController.php');
$phanQuyenController = new PhanQuyenController();
$allowedFunctions = $phanQuyenController->getAllowedFunctions($role_id);
$_SESSION['permissions'] = $phanQuyenController->getChiTietNhomQuyen($role_id);
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

    <div id="container">
        <div id="container-left">
            <?php include('view/SideBar.php'); ?>
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
                } elseif ($page == 'supplier') {
                    include('supplier.php');
                } elseif ($page == 'import') {
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