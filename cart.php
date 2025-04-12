<?php
session_start();
require_once 'Model/ProductModel.php';
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'addtocart') {
    $id = intval($_POST['id']);
    $quantity = intval($_POST['quantity']);

    // Kiểm tra xem sản phẩm đã có trong giỏ chưa
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $id,
            'quantity' => $quantity
        ];
    }

    echo "success";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'remove') {
    $idToRemove = $_POST['id'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] == $idToRemove) {
                unset($_SESSION['cart'][$index]);
                // Re-index mảng để tránh lỗi sau này
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
    }

    echo 'success';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                echo 'success';
                $item['quantity'] = $quantity;
                break;
            }
        }
        unset($item);
    }
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