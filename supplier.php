<?php
require_once "handles/SupplierController.php";
$supplier_data = getSuppliersAndProducts();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Nhà cung cấp</title>
    <!-- Gọi file CSS -->
    <link rel="stylesheet" href="css/admin_category.css">
</head>
<body>
    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Quản Lý Nhà Cung Cấp</h1>
            <button class="add-chungloai-btn">➕ Thêm nhà cung cấp</button>
    
        </header>
        <!-- Popup chỉnh sửa chủng loại -->
        <div id="popup-edit-supplier" class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Chỉnh sửa nhà cung cấp</h2>
                    <span id="close-popup-edit-supplier" class="close-btn">✖</span>
                </div>
                <div class="popup-body">
                    <div class="left_info">
                        <input type="hidden" id="edit_supplier_id">
                        <div class="input-row">
                            <label for="edit_supplier_name">Tên nhà cung cấp:</label>
                            <input type="text" id="edit_supplier_name">
                            <label for="edit_supplier_address">Địa chỉ:</label>
                            <input type="text" id="edit_supplier_address">
                        </div>
                    </div>
                    <div class="right_table">
                        <h3>Danh sách sản phẩm</h3>
                        <button id="add-product-btn_supplier">➕ Thêm</button>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã SP</th>
                                    <th>Tên SP</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="product-list_supplier">
                                <!-- Dữ liệu sản phẩm sẽ được thêm vào đây bằng AJAX -->
                            </tbody>
                        </table>

                    </div>
                    <div class="popup-footer">
                        <button id="edit-supplier-btn_popup">Sửa</button>
                        <button id="delete-supplier-btn_popup">Xóa</button>
                        <!-- <button id="btn-xoa-supplier">Xóa</button> -->
                    </div>
                </div>
            </div>
        </div>
    
        <section class="chungloai-list">
            <table>
                <thead>
                    <tr>
                        <th>Mã NCC</th>
                        <th>Tên NCC</th>
                        <th>Địa chỉ NCC</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Hành động</th> <!-- Cột riêng -->
                    </tr>
                </thead>
    
                <tbody>
                    <?php
                        $prev_chungloai = "";
                        $rowspan = 0;
                        $temp_rows = [];

                        foreach ($supplier_data as $index => $row) {
                            $curr_supplier = $row["supplier_id"];
                            $temp_rows[$curr_supplier][] = $row; // Updated to use $curr_supplier
                        }

                        // Lặp theo nhà cung cấp
                        foreach ($temp_rows as $supplier_id => $rows) {
                            // Đánh dấu cho button chỉ ở dòng đầu tiên khi có sản phẩm
                            $first = true;

                            // Kiểm tra nếu không có sản phẩm nào
                            $has_sanpham = !empty($rows[0]['product_id']);

                            if (!$has_sanpham) {
                                echo "<tr>";
                                echo "<td>{$rows[0]['supplier_id']}</td>";
                                echo "<td>{$rows[0]['supplier_name']}</td>";
                                echo "<td>{$rows[0]['address']}</td>";
                                echo "<td colspan='2'>Không có sản phẩm</td>";

                                echo "<td>";
                                echo "<a href='admin.php?page=category&act=edit_chungloai&id={$rows[0]['supplier_id']}' 
                                        data-supplier_id='{$rows[0]['supplier_id']}' 
                                        data-supplier_name='" . htmlspecialchars($rows[0]['supplier_name'], ENT_QUOTES, 'UTF-8') . "'
                                        data-address='" . htmlspecialchars($rows[0]['address'], ENT_QUOTES, 'UTF-8') . "'>
                                        <button class='edit-supplier-btn'>✏️ Sửa</button></a>";
                                echo "</td>";
                                echo "</tr>";
                                continue;
                            }

                            // Nếu có sản phẩm
                            $rowspan = count($rows);
                            foreach ($rows as $r) {
                                echo "<tr>";
                                if ($first) {
                                    echo "<td rowspan='{$rowspan}'>{$r['supplier_id']}</td>";
                                    echo "<td rowspan='{$rowspan}'>{$r['supplier_name']}</td>";
                                    echo "<td rowspan='{$rowspan}'>{$r['address']}</td>";
                                }

                                echo "<td>{$r['product_id']}</td>";
                                echo "<td>{$r['product_name']}</td>";

                                if ($first) {
                                    echo "<td rowspan='{$rowspan}'>
                                            <a href='admin.php?page=category&act=add_type&cl_id={$r['supplier_id']}' 
                                            data-supplier_id='{$r['supplier_id']}'
                                            data-supplier_name='{$r['supplier_name']}' 
                                            data-supplier_address='{$r['address']}'>
                                            <button class='edit-supplier-btn'>✏️ Sửa</button></a>
                                        </td>";
                                    $first = false;
                                }

                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
    
            </table>
        </section>
    
    
    
    </main>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    

        // Mở popup chỉnh sửa nhà cung cấp
        $(document).on("click", ".edit-supplier-btn", function (e) {
            e.preventDefault();
            
            const $link = $(this).closest("a");
            const supplier_id = $link.data("supplier_id");
            const supplier_name = $link.data("supplier_name");
            const supplier_address = $link.data("supplier_address");

            $("#edit_supplier_id").val(supplier_id);
            $("#edit_supplier_name").val(supplier_name);
            $("#edit_supplier_address").val(supplier_address);
            $("#popup-edit-supplier").addClass("active");
            
            console.log("Giá trị input #edit_supplier_id:", $("#edit_supplier_id").val());
        });

        // Đóng popup chỉnh sửa nhà cung cấp
        $("#close-popup-edit-supplier").on("click", function () {
            $("#popup-edit-supplier").removeClass("active");
        });

        // Gửi AJAX sửa nhà cung cấp
        $("#edit-supplier-btn_popup").on("click", function () {
            const machungloai = $("#edit_machungloai").val();
            const tenchungloai = $("#edit_tenchungloai").val().trim();

            if (tenchungloai === "") {
                alert("Vui lòng nhập tên chủng loại");
                return;
            }

            $.ajax({
                url: "handles/CategoryController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "edit_chungloai",
                    machungloai: machungloai,
                    tenchungloai: tenchungloai
                },
                success: function (response) {
                    if (response.success) {
                        location.reload(); // Reload để cập nhật bảng
                    } else {
                        alert("Sửa thất bại: " + response.error);
                    }
                },
                error: function () {
                    alert("Lỗi khi gửi yêu cầu sửa chủng loại");
                }
            });
        });

        // Gửi AJAX xóa chủng loại từ popup
        $("#delete-supplier-btn_popup").on("click", function () {
            const machungloai = $("#edit_machungloai").val();

            if (confirm("Bạn có chắc muốn xóa chủng loại này không?")) {
                $.ajax({
                    url: "handles/CategoryController.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: "delete_chungloai",
                        machungloai: machungloai
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload(); // Reload để cập nhật bảng
                        } else {
                            alert("Xóa thất bại: " + response.error);
                        }
                    },
                    error: function () {
                        alert("Lỗi khi gửi yêu cầu xóa chủng loại");
                    }
                });
            }
        });


    </script>

</body>
</html>


