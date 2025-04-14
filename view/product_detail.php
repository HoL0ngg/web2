<!DOCTYPE html>
<html lang="vi">
<?php
// Dữ liệu mô phỏng (thực tế bạn sẽ lấy từ DB)
// $product_id = $_GET['id'] ?? 1;

$product = [
    'product_id' => 1,
    'product_name' => 'Sữa Rửa Mặt Trà Xanh Innisfree',
    'image_url' => '../imgs/sp2.jpg',
    'price' => 170000,
    'quantity' => 20,
    'mota' => '
        Tinh chất Clinical Niacinamide 20% Treatment chứa nồng độ 20% Niacinamide (vitamin B3) đậm đặc...
        <ul>
            <li>Giảm đáng kể tình trạng lỗ chân lông to</li>
            <li>Kiểm soát hoạt động của tuyến bã nhờn</li>
            <li>Giúp bề mặt da săn chắc, sáng khỏe</li>
            <li>Làm đều màu da & làm mờ dần các vết thâm sau mụn</li>
        </ul>
    '
];
?>

<head>
    <meta charset="UTF-8">
    <title><?php echo $product['product_name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* .container-product-detail {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            font-family: Arial, sans-serif;

        }

        .product-detail {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
        }

        .product-left {
            flex: 1;
            text-align: center;
        }

        .product-left img {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-right {
            flex: 1;
            position: relative;
        }

        .product-right h2 {
            font-size: 24px;
            margin-bottom: 17px;
        }

        .mota {
            margin: 10px 0;
            line-height: 1.6;
            border-bottom: 2px solid #ccc;
            padding: 10px;
            min-height: 190px;
        }

        .price {
            font-size: 18px;
            margin: 15px 0;
            color: #e91e63;
            padding-left: 7px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
            padding-left: 7px;
        }

        .quantity-control button {
            padding: 5px 10px;
            font-size: 1.2rem;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quantity-control button:hover {
            background-color: #e0e0e0;
            border-color: #999;
        }

        #quantity {
            width: 60px;
            padding: 8px;
            font-size: 1rem;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            margin: 0 5px;
            transition: border-color 0.2s ease;
        }

        #quantity:focus {
            border-color: #3bb4f2;
            box-shadow: 0 0 4px rgba(59, 180, 242, 0.5);
        }

        .stock {
            color: black;
            font-size: 1.2rem;
            margin: 10px;
        }

        .product-name {
            border-bottom: 2px solid #ccc;
            text-align: center;
        } */
    </style>

</head>


<body>
    <div id="container-product-detail">
        <div id="product-detail">
            <div class="btn-close">x</div>
            <div class="product-left">
                <img src="<?php echo $product['image_url']; ?>" alt="Ảnh sản phẩm">
            </div>
            <div class="product-right">
                <div class="product-name">
                    <h2><?php echo $product['product_name']; ?></h2>
                </div>
                <div class="mota"><?php echo $product['mota']; ?></div>

                <div class="price"><strong>Giá:</strong> <?php echo number_format($product['price'], 0, ',', '.'); ?> đ</div>
                <div class="quantity-control">
                    <button onclick="decrease()">−</button>
                    <input type="number" id="quantity" value="1" min="1" max="<?php echo $product['quantity']; ?>">
                    <button onclick="increase()">+</button>
                </div>
                <div class="stock">Số lượng còn lại: <?php echo $product['quantity']; ?></div>
                <div><button class="add-to-cart" onclick="addToCart()">Thêm vào giỏ</button></div>
            </div>
        </div>
    </div>


    <script>
        function increase() {
            const input = document.getElementById("quantity");
            if (parseInt(input.value) < <?php echo $product['quantity']; ?>) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function decrease() {
            const input = document.getElementById("quantity");
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
        let close = document.getElementById("product-detail");
        document.addEventListener("mousedown", function(event) {
            if (close && !close.contains(event.target)) {
                close.parentElement.style.display = 'none';
                console.log("hihihi");

            }
        });
        document.querySelector(".btn-close").addEventListener('click', function() {
            document.getElementById("container-product-detail").style.display = 'none';
        })
    </script>
</body>


</html>