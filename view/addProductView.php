<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>

</head>

<body>
    <div class="container-add-product">
        <div class="header-add-product">THÊM SẢN PHẨM</div>
        <div class="form-wrapper">
            <div class="image-upload">
                <div class="preview">
                    <span>📷</span>
                </div>
                <button>
                    ⬆ Chọn hình ảnh
                </button>
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
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['ten_the_loai']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="thuonghieu">Thương hiệu</label>
                        <select id="thuonghieu" name="thuonghieu">
                            <option value="">-- Chọn thương hiệu --</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?= $brand['id'] ?>"><?= htmlspecialchars($brand['ten_thuong_hieu']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mota">Mô tả</label>
                        <textarea id="mota" name="mota"></textarea>
                    </div>
                    <div class="buttons">
                        <button type="submit">Thêm sản phẩm</button>
                        <button type="reset" class="cancel">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>