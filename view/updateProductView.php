<div class="container-add-product">
    <div class="header-add-product">SỬA SẢN PHẨM</div>
    <form id="productUpdateForm" enctype="multipart/form-data">
        <div class="form-wrapper-add-product">
            <div class="image-upload">
                <div class="preview" id="imagePreview">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="product image">
                    <?php else: ?>
                        <img src="imgs/addImg.png" alt="addImg">
                    <?php endif; ?>
                </div>
                <label for="imageInput" class="upload-btn-label"><i class="fa-solid fa-cloud-arrow-up"></i> Chọn hình ảnh</label>
                <input type="file" id="imageInput" name="image" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="form-inputs">

                <div class="form-group">
                    <label for="productname">Tên sản phẩm</label>
                    <input type="text" id="productname" name="productname" value="<?= htmlspecialchars($product['product_name']) ?>">
                </div>

                <div class="form-group">
                    <label for="quantity">Số lượng</label>
                    <input type="number" id="quantity" name="quantity" value="<?= $product['quantity'] ?>">
                </div>

                <div class="form-group">
                    <label for="price">Giá</label>
                    <input type="text" id="price" name="price" value="<?= $product['price'] ?>">
                </div>

                <div class="form-group">
                    <label for="theloai">Thể loại</label>
                    <select id="theloai" name="theloai">
                        <option value="">-- Chọn thể loại --</option>
                        <?php foreach ($theloai as $cat): ?>
                            <option value="<?= $cat['matheloai']; ?>" <?= $cat['matheloai'] == $product['matheloai'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['tentheloai']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="thuonghieu">Thương hiệu</label>
                    <select id="thuonghieu" name="thuonghieu">
                        <option value="">-- Chọn thương hiệu --</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand['brand_id']; ?>" <?= $brand['brand_id'] == $product['brand_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($brand['brand_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group radio-product-status">
                    <label>Trạng thái</label>
                    <div id="container-product-status">
                        <input type="radio" id="hien" name="status" value="1" <?= $product['status'] == 1 ? 'checked' : '' ?>>
                        <label for="hien">Hiện</label>

                        <input type="radio" id="an" name="status" value="0" <?= $product['status'] == 0 ? 'checked' : '' ?>>
                        <label for="an">Ẩn</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mota">Mô tả</label>
                    <textarea id="mota" name="mota"><?= htmlspecialchars($product['mota']) ?></textarea>
                </div>

                <div class="buttons-add-product">
                    <button type="submit">Lưu thay đổi</button>
                    <button class="cancel-add-product"><a href="admin.php?page=product">Hủy</a></button>
                </div>
            </div>
        </div>
    </form>
</div>