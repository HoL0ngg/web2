<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mỹ phẩm</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="cart.css">
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
            case "receipt":
                include("payment-info.php");
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