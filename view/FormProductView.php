<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>

</head>

<body>
    <div class="container-add-product">
        <div class="header-add-product">THÊM SẢN PHẨM</div>
        <div class="form-wrapper-add-product">
            <div class="image-upload">
                <div class="preview" id="imagePreview">
                    <span><img src="../imgs/addImg.png" alt="addImg"></span>
                </div>
                <label for="imageInput" class="upload-btn-label"><i class="fa-solid fa-cloud-arrow-up"></i> Chọn hình ảnh</label>
                <input type="file" id="imageInput" name="image" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="form-inputs">
                <form method="POST" action="index.php?action=saveProduct" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="ten">Tên sản phẩm</label>
                        <input type="text" id="ten" name="ten">
                    </div>
                    <div class="form-group">
                        <label for="soluong">Số lượng</label>
                        <input type="number" id="soluong" name="soluong">
                    </div>
                    <div class="form-group">
                        <label for="gia">Giá</label>
                        <input type="text" id="gia" name="gia">
                    </div>
                    <div class="form-group">
                        <label for="theloai">Thể loại</label>
                        <select id="theloai" name="theloai">
                            <option value="">-- Chọn thể loại --</option>
                            <?php foreach ($theloai as $cat): ?>
                                <option value="<?= $cat['matheloai']; ?>"><?= htmlspecialchars($cat['tentheloai']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="thuonghieu">Thương hiệu</label>
                        <select id="thuonghieu" name="thuonghieu">
                            <option value="">-- Chọn thương hiệu --</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?= $brand['brand_id']; ?>"><?= htmlspecialchars($brand['brand_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mota">Mô tả</label>
                        <textarea id="mota" name="mota"></textarea>
                    </div>
                    <div class="buttons-add-product">
                        <button type="submit">Thêm sản phẩm</button>
                        <button class="cancel-add-product"><a href="admin.php?page=product">Hủy</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
<script>
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = "<span>📷</span>";
        }
    }
</script>

</html>