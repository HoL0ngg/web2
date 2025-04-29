<div style="width: 100%; text-align: center; font-size: 2.6em; font-weight: 700;margin-top: 20px;">
    TOP SẢN PHẨM BÁN CHẠY NHẤT
</div>
<div class="swiper review-swiper">
    <div class="swiper-wrapper">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <div class="swiper-slide" data-id="<?= htmlspecialchars($product['product_id']) ?>">
                    <!-- <div class="product"> -->
                    <?php if ($product['quantity'] == 0): ?>
                        <div class="product-soldout">HẾT HÀNG</div>
                    <?php endif; ?>

                    <div class="product-img" onclick="getInfoProduct(<?= htmlspecialchars($product['product_id']) ?>)">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    </div>

                    <div class="productArray-info">
                        <p><?= htmlspecialchars($product['product_name']) ?></p>
                        <div class="product-price"><?= number_format($product['price']) ?> VNĐ</div>
                    </div>

                    <div class="product-button-container">
                        <!-- <div class="heart-icon" onClick="toggleLove(this, <?= htmlspecialchars($product['product_id']) ?>)">
                            <i class="fa-regular fa-heart"></i>
                        </div> -->
                        <button class="add-to-cart" onClick="addToCart(<?= htmlspecialchars($product['product_id']) ?>, 1)">Thêm vào giỏ</button>
                    </div>

                    <div class="product-detail" style="margin-top: 7px;">
                        <button class="product-detail-button" onClick="getInfoProduct(<?= htmlspecialchars($product['product_id']) ?>)">Chi tiết</button>
                    </div>
                    <!-- </div> -->
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Không có sản phẩm bán chạy nào.</p>
        <?php endif; ?>

    </div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
</div>
<script>
    const swiper = new Swiper('.review-swiper', {
        slidesPerView: 3,
        spaceBetween: 30,
        grabCursor: true,
        loop: true,
        autoplay: {
            delay: 3000, // 3 giây
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            640: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 4,
            }
        }
    });
</script>