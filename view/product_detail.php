<!DOCTYPE html>
<html lang="vi">
<?php
$product_id = $_GET['productId'] ?? 1;
require_once('../handles/ProductController.php');
$productController = new ProductController();
$product = $productController->getProductById($product_id);
$img_url = $productController->getImgUrlById($product_id);
?>
<div id="container-product-detail">

    <div id="product-detail">
        <div class="btn-close">x</div>
        <div class="product-left">
            <img src="<?= $img_url ?>" alt="Ảnh sản phẩm">
        </div>
        <div class="product-right">

            <div class="product-name">
                <h2><?php echo $product['product_name']; ?></h2>
            </div>
            <div class="mota"><?php echo $product['mota']; ?></div>

            <div class="price"><strong>Giá:</strong> <span id="product-price" data-unit-price=<?= $product['price'] ?>> <?php echo number_format($product['price'], 0, ',', '.'); ?> đ</span></div>

            <div class="quantity-control">
                <button>−</button>
                <input type="number" id="quantity" value="1" min="1" max="<?php echo $product['quantity']; ?>">
                <button>+</button>
            </div>

            <div class="stock">Số lượng còn lại: <?php echo $product['quantity']; ?></div>
            <?php if ($product['quantity'] > 0): ?>
                <div><button class="add-to-cart">Thêm vào giỏ</button></div>
            <?php elseif ($product['quantity'] == 0): ?>
                <div class="soldout">HẾT HÀNG</div>
            <?php endif; ?>

        </div>
    </div>
</div>
<script>
    const unitPrice = <?php echo $product['price']; ?>;
</script>