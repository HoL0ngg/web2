<?php
session_start();
require_once 'Model/ProductModel.php';
require_once 'Model/TKModel.php';
require_once 'handles/CartController.php';
require_once 'handles/ProductController.php';
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'addtocart') {
    if (!isset($_SESSION['username'])) {
        // Chưa đăng nhập -> xử lý bằng session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        } else {
            $id = intval($_POST['id']);
            $quantity = intval($_POST['quantity']);

            // Kiểm tra xem sản phẩm đã có trong giỏ chưa
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['product_id'] === $id) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }
            unset($item);

            if (!$found) {
                $_SESSION['cart'][] = [
                    'product_id' => $id,
                    'quantity' => $quantity
                ];
            }
            echo json_encode(['status' => 'success', 'message' => 'Đã thêm sản phẩm vào giỏ hàng']);
        }
        exit;
    } else {
        // Đã đăng nhập -> xử lý bằng database

        $user = new TKModel();
        $cartController = new CartController();
        $customer_id = $user->getIdByUsername($_SESSION['username']);
        $customer_id = $user->getCustomerIdByUserId($customer_id);
        $productId = $_POST['id'];
        $quantity = $_POST['quantity'];
        $cartController->addProductToCart($productId, $quantity, $customer_id);
        echo json_encode(['status' => 'success', 'message' => 'Đã thêm sản phẩm vào giỏ hàng']);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'remove') {
    if (!isset($_SESSION['username'])) {
        // Chưa đăng nhập -> xử lý bằng session
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $item) {
                if ($item['product_id'] == $_POST['id']) {
                    unset($_SESSION['cart'][$index]);
                    // Re-index mảng để tránh lỗi sau này
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                    break;
                }
            }
        }
        echo json_encode(['status' => 'success', 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
        exit;
    } else {
        // Đã đăng nhập -> xử lý bằng database

        $user = new TKModel();
        $cartController = new CartController();
        $customer_id = $user->getIdByUsername($_SESSION['username']);
        $customer_id = $user->getCustomerIdByUserId($customer_id);
        $productId = $_POST['id'];
        $cartController->removeProductInCart($productId, $customer_id);
        echo json_encode(['status' => 'success', 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    if (isset($_SESSION['username'])) {
        // Đã đăng nhập -> xử lý bằng database

        $user = new TKModel();
        $cartController = new CartController();
        $customer_id = $user->getIdByUsername($_SESSION['username']);
        $productId = $_POST['id'];
        $quantity = $_POST['quantity'];
        $cartController->updateProductInCart($productId, $quantity, $customer_id);
    } else {
        // Chưa đăng nhập -> xử lý bằng session
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['product_id'] == $_POST['id']) {
                    $item['quantity'] = $_POST['quantity'];
                    break;
                }
            }
            unset($item);
        }
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'getCartCount') {
    $cartCount = 0;
    if (isset($_SESSION['username'])) {
        require_once 'Model/TKModel.php';
        $user = new TKModel();
        $customer_id = $user->getIdByUsername($_SESSION['username']);
        $customer_id = $user->getCustomerIdByUserId($customer_id);
        $cartController = new CartController();
        $cartProducts = $cartController->getAllProductInCart($customer_id);
        $cartCount = is_array($cartProducts) ? count($cartProducts) : 0;
    } else {
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $cartCount += $item['quantity'];
            }
        } else {
            $cartCount = 0;
        }
    }
    echo json_encode(['count' => $cartCount]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'UpdateCartSessionToDatabase') {

    $user = new TKModel();
    $cartController = new CartController();
    $customer_id = $user->getIdByUsername($_SESSION['username']);
    $customer_id = $user->getCustomerIdByUserId($customer_id);
    $cart = $_SESSION['cart'] ?? [];
    $cartController->updateCartSessionToDatabase($customer_id, $cart);
    unset($_SESSION['cart']);
    echo json_encode(['status' => 'success', 'message' => 'Đã cập nhật giỏ hàng vào cơ sở dữ liệu']);
    exit;
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mỹ phẩm</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include("header.php") ?>

    <?php
    if (isset($_GET["action"])) {
        $page = $_GET["action"];
        switch ($page) {
            case "cart":
                include("cart-info.php");
                break;
            case "thanhtoan":
                include("customer-info.php");
                break;
            case "hoadon":
                include("receipt-info.php");
                break;
            default:
                include("cart-info.php");
                break;
        }
    }
    ?>
    <?php include("footer.php") ?>
    <?php include("login-wrapper.php") ?>
    <?php include("register-wrapper.php") ?>
    <?php include("changepassword-wrapper.php") ?>
    <script src="/js/script.js"></script>
</body>