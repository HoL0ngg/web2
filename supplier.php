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
    <link rel="stylesheet" href="css/admin_supplier.css">
</head>
<body>
    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Quản Lý Nhà Cung Cấp</h1>
            <button class="add-supplier-btn_style" id="add-supplier-btn">➕ Thêm nhà cung cấp</button>
        </header>

        <!-- Popup thêm nhà cung cấp -->
        <div id="popup-add-supplier" class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Thêm nhà cung cấp</h2>
                    <span id="close-popup-add-supplier" class="close-btn">✖</span>
                </div>
                <div class="popup-body">
                    <div class="left_info">
                        <div class="input-row">
                            <label for="add_supplier_name">Tên nhà cung cấp:</label>
                            <input type="text" id="add_supplier_name">
                        </div>
                        <div class="input-row">
                            <label for="add_supplier_address">Địa chỉ:</label>
                            <input type="text" id="add_supplier_address">
                        </div>
                    </div>
                </div>
                <div class="popup-footer">
                    <button id="add-supplier-btn_popup">Thêm</button>
                </div>
            </div>
        </div>

        <!-- Popup chỉnh sửa nhà cung cấp -->
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
                        </div>
                        <div class="input-row">
                            <label for="edit_supplier_address">Địa chỉ:</label>
                            <input type="text" id="edit_supplier_address">
                        </div>
                    </div>
                    <div class="right_table">
                        <div class="right_table--header">
                            <h3>Danh sách sản phẩm</h3>
                            <button id="add-product-btn_supplier">➕ Thêm</button>
                        </div>
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
                </div>
                <div class="popup-footer">
                    <button id="edit-supplier-btn_popup">Sửa</button>
                    <button id="delete-supplier-btn_popup" style="display: none;">Xóa</button>
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
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $temp_rows = [];

                        // Nhóm dữ liệu theo supplier_id
                        foreach ($supplier_data as $row) {
                            $curr_supplier = $row["supplier_id"];
                            $temp_rows[$curr_supplier][] = $row;
                        }

                        // Lặp qua từng nhà cung cấp
                        foreach ($temp_rows as $supplier_id => $rows) {
                            $first = true;
                            $has_sanpham = !empty($rows[0]['product_id']);

                            if (!$has_sanpham) {
                                // Nếu không có sản phẩm
                                echo "<tr>";
                                echo "<td>{$rows[0]['supplier_id']}</td>";
                                echo "<td>{$rows[0]['supplier_name']}</td>";
                                echo "<td>" . (empty($rows[0]['address']) ? '' : $rows[0]['address']) . "</td>";
                                echo "<td colspan='2'>Không có sản phẩm</td>";
                                echo "<td>";
                                echo "<a href='admin.php?page=category&act=edit_chungloai&id={$rows[0]['supplier_id']}' 
                                        data-supplier_id='{$rows[0]['supplier_id']}' 
                                        data-supplier_name='" . htmlspecialchars($rows[0]['supplier_name'], ENT_QUOTES, 'UTF-8') . "'
                                        data-address='" . htmlspecialchars($rows[0]['address'] ?? '', ENT_QUOTES, 'UTF-8') . "'>
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
                                    echo "<td rowspan='{$rowspan}'>" . (empty($r['address']) ? '' : $r['address']) . "</td>";
                                }

                                echo "<td>{$r['product_id']}</td>";
                                echo "<td>{$r['product_name']}</td>";

                                if ($first) {
                                    echo "<td rowspan='{$rowspan}'>
                                            <a href='admin.php?page=category&act=add_type&cl_id={$r['supplier_id']}' 
                                            data-supplier_id='{$r['supplier_id']}'
                                            data-supplier_name='{$r['supplier_name']}' 
                                            data-supplier_address='" . htmlspecialchars($r['address'] ?? '', ENT_QUOTES, 'UTF-8') . "'>
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
        // Mở popup thêm nhà cung cấp
        $("#add-supplier-btn").on("click", function () {
            $("#add_supplier_name").val("");
            $("#add_supplier_address").val("");
            $("#popup-add-supplier").addClass("active");
        });

        // Đóng popup thêm nhà cung cấp
        $("#close-popup-add-supplier").on("click", function () {
            $("#popup-add-supplier").removeClass("active");
        });

        // Gửi AJAX thêm nhà cung cấp
        $("#add-supplier-btn_popup").on("click", function () {
            const supplier_name = $("#add_supplier_name").val().trim();
            const supplier_address = $("#add_supplier_address").val().trim();

            if (supplier_name === "") {
                showToast("Vui lòng nhập tên nhà cung cấp");
                return;
            }

            $.ajax({
                url: "handles/SupplierController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "add_supplier",
                    supplier_name: supplier_name,
                    supplier_address: supplier_address
                },
                success: function (response) {
                    if (response.success) {
                        showToast("Thêm nhà cung cấp thành công!", true);
                        // Wait for 1 second before reloading
                        setTimeout(function () {
                            location.reload(); // Reload để cập nhật bảng
                        }, 1000);
                    } else {
                        showToast("Thêm thất bại: " + response.error);
                        
                    }
                },
                error: function () {
                    showToast("Lỗi khi gửi yêu cầu thêm nhà cung cấp");
                    
                }
            });
        });

        // Mở popup chỉnh sửa nhà cung cấp và lấy dữ liệu sản phẩm qua AJAX
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
            
            // Gửi AJAX để lấy danh sách sản phẩm của nhà cung cấp
            $.ajax({
                url: "handles/SupplierController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "get_products_by_supplier",
                    supplier_id: supplier_id
                },
                success: function (response) {
                    if (response.success) {
                        const products = response.data;
                        $("#product-list_supplier").empty(); // Xóa bảng hiện tại
                        if (products.length > 0) {
                            products.forEach(product => {
                                $("#product-list_supplier").append(`
                                    <tr data-product-id="${product.product_id}">
                                        <td>${product.product_id}</td>
                                        <td>${product.product_name}</td>
                                        <td><button class="delete-product-btn" data-product-id="${product.product_id}">❌</button></td>
                                    </tr>
                                `);
                            });
                        }
                        toggleDeleteButton(); // Cập nhật trạng thái nút Xóa
                    } else {
                        showToast("Lỗi khi lấy danh sách sản phẩm: " + response.error);
                        
                    }
                },
                error: function () {
                    showToast("Lỗi khi gửi yêu cầu lấy danh sách sản phẩm");
                }
            });
        });

        // Đóng popup chỉnh sửa nhà cung cấp
        $("#close-popup-edit-supplier").on("click", function () {
            $("#popup-edit-supplier").removeClass("active");
            $("#product-list_supplier").empty(); // Xóa bảng khi đóng popup
        });

        // Gửi AJAX sửa nhà cung cấp và danh sách sản phẩm
        $("#edit-supplier-btn_popup").on("click", function () {
            const supplier_id = $("#edit_supplier_id").val();
            const supplier_name = $("#edit_supplier_name").val().trim();
            const supplier_address = $("#edit_supplier_address").val().trim();

            if (supplier_name === "") {
                showToast("Vui lòng nhập tên nhà cung cấp");
                return;
            }

            // Lấy danh sách sản phẩm hiện tại trong bảng
            const products = [];
            $("#product-list_supplier tr").each(function () {
                const product_id = $(this).data("product-id");
                if (product_id) {
                    products.push(parseInt(product_id)); // Đảm bảo product_id là số
                }
            });

            $.ajax({
                url: "handles/SupplierController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "update_supplier",
                    supplier_id: supplier_id,
                    supplier_name: supplier_name,
                    supplier_address: supplier_address,
                    products: JSON.stringify(products) // Gửi dưới dạng chuỗi JSON
                },
                success: function (response) {
                    if (response.success) {
                        showToast("Sửa nhà cung cấp thành công!", true);
                        // Wait for 1 second before reloading
                        setTimeout(function () {
                            location.reload(); // Reload để cập nhật bảng
                        }, 1000);
                    } else {
                        showToast("Sửa thất bại: " + response.error);
                    }
                },
                error: function () {
                    showToast("Lỗi khi gửi yêu cầu sửa nhà cung cấp");
                }
            });
        });

        // Thêm dòng mới với combobox sản phẩm
        $("#add-product-btn_supplier").on("click", function () {
            const supplier_id = $("#edit_supplier_id").val();

            // Lấy danh sách sản phẩm hiện tại trong bảng để loại trừ
            const current_products = [];
            $("#product-list_supplier tr").each(function () {
                const product_id = $(this).data("product-id");
                if (product_id) {
                    current_products.push(parseInt(product_id));
                }
            });

            // Gửi AJAX để lấy danh sách sản phẩm chưa có trong bảng
            $.ajax({
                url: "handles/SupplierController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "get_available_products",
                    supplier_id: supplier_id,
                    current_products: JSON.stringify(current_products) // Gửi danh sách sản phẩm hiện tại để loại trừ
                },
                success: function (response) {
                    if (response.success) {
                        const available_products = response.data;
                        if (available_products.length === 0) {
                            showToast("Không còn sản phẩm nào để thêm!");
                            return;
                        }

                        // Tạo combobox với danh sách sản phẩm
                        let options = '<option value="">Chọn sản phẩm</option>';
                        available_products.forEach(product => {
                            options += `<option value="${product.product_id}" data-name="${product.product_name}">${product.product_name}</option>`;
                        });

                        // Thêm dòng mới với combobox
                        $("#product-list_supplier").prepend(`
                            <tr class="new-product-row">
                                <td></td>
                                <td>
                                    <select class="product-select">${options}</select>
                                </td>
                                <td><button class="delete-product-btn">X</button></td>
                            </tr>
                        `);
                        toggleDeleteButton();
                    } else {
                        showToast("Lỗi khi lấy danh sách sản phẩm: " + response.error);
                    }
                },
                error: function () {
                    showToast("Lỗi khi gửi yêu cầu lấy danh sách sản phẩm");
                }
            });
        });

        // Xử lý khi chọn sản phẩm từ combobox
        $(document).on("change", ".product-select", function () {
            const $row = $(this).closest("tr");
            const selectedOption = $(this).find("option:selected");
            const product_id = $(this).val();
            const product_name = selectedOption.data("name");

            if (product_id) {
                // Cập nhật dòng với thông tin sản phẩm đã chọn
                $row.attr("data-product-id", product_id);
                $row.find("td:first").text(product_id); // Cập nhật cột Mã SP
                $row.find("td:eq(1)").text(product_name); // Cập nhật cột Tên SP
            }
        });

        // Xóa sản phẩm khỏi bảng
        $(document).on("click", ".delete-product-btn", function () {
            $(this).closest("tr").remove();
            toggleDeleteButton();
        });

        // Gửi AJAX xóa nhà cung cấp từ popup
        $("#delete-supplier-btn_popup").on("click", function () {
            const supplier_id = $("#edit_supplier_id").val();

            Swal.fire({
                title: "Thông báo",
                text: "Bạn có chắc muốn xóa nhà cung cấp này không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Có",
                cancelButtonText: "Không"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "handles/SupplierController.php",
                        method: "POST",
                        dataType: "json",
                        data: {
                            action: "delete_supplier",
                            supplier_id: supplier_id
                        },
                        success: function (response) {
                            if (response.success) {
                                showToast("Xóa nhà cung cấp thành công!",true);
                                // Wait for 1 second before reloading
                                setTimeout(function () {
                                    location.reload(); // Reload để cập nhật bảng
                                }, 1000);
                            } else {
                                showToast("Xóa thất bại: " + response.error);
                            }
                        },
                        error: function () {
                            showToast("Lỗi khi gửi yêu cầu xóa nhà cung cấp");
                        }
                    });
                }
            })
        });

        // Hàm kiểm tra và ẩn/hiện nút Xóa
        function toggleDeleteButton() {
            const productList = $("#product-list_supplier").children().length;
            if (productList === 0) {
                $("#delete-supplier-btn_popup").show();
            } else {
                $("#delete-supplier-btn_popup").hide();
            }
        }
    </script>

</body>
</html>


