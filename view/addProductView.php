<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>

</head>

<body>
    <div class="container-add-product">
        <div class="header-add-product">THÊM SẢN PHẨM</div>
        <form id="productAddForm" enctype="multipart/form-data">
            <div class="form-wrapper-add-product">
                <div class="image-upload">
                    <div class="preview" id="imagePreview">
                        <span><img src="../imgs/addImg.png" alt="addImg"></span>
                    </div>
                    <label for="imageInput" class="upload-btn-label"><i class="fa-solid fa-cloud-arrow-up"></i> Chọn hình ảnh</label>
                    <input type="file" id="imageInput" name="image" accept="image/*" onchange="previewImage(event)">
                </div>

                <div class="form-inputs">

                    <div class="form-group">
                        <label for="productname">Tên sản phẩm</label>
                        <input type="text" id="productname" name="productname">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Số lượng</label>
                        <input type="number" id="quantity" name="quantity">
                    </div>

                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input type="text" id="price" name="price">
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

                    <div class="form-group radio-product-status">
                        <label>Trạng thái</label>
                        <div id="container-product-status">
                            <input type="radio" id="hien" name="status" value="1" checked>
                            <label for="hien">Hiện</label>

                            <input type="radio" id="an" name="status" value="0">
                            <label for="an">Ẩn</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mota">Mô tả</label>
                        <textarea id="mota" name="mota"></textarea>
                    </div>
                    <div class="buttons-add-product">
                        <button type="submit">Thêm sản phẩm</button>
                        <button class="cancel-add-product"><a href="admin.php?page=product">Hủy</a></button>
                    </div>
                </div>
        </form>
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
            preview.innerHTML = `<span><img src="../imgs/addImg.png" alt="addImg"></span>`;
        }
    }
</script>

</html>