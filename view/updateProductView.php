<div class="container-add-product">
    <div class="header-add-product">SỬA SẢN PHẨM</div>
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
            <form method="POST" action="index.php?action=updateProduct&id=<?= $product['product_id'] ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="ten">Tên sản phẩm</label>
                    <input type="text" id="ten" name="ten" value="<?= htmlspecialchars($product['product_name']) ?>">
                </div>

                <div class="form-group">
                    <label for="soluong">Số lượng</label>
                    <input type="number" id="soluong" name="soluong" value="<?= $product['quantity'] ?>">
                </div>

                <div class="form-group">
                    <label for="gia">Giá</label>
                    <input type="text" id="gia" name="gia" value="<?= $product['price'] ?>">
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
                        <input type="radio" id="hien" name="trangthai" value="1" <?= $product['status'] == 1 ? 'checked' : '' ?>>
                        <label for="hien">Hiện</label>

                        <input type="radio" id="an" name="trangthai" value="0" <?= $product['status'] == 0 ? 'checked' : '' ?>>
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
            </form>
        </div>
    </div>
</div>