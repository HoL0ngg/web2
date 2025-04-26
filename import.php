<?php
require_once "handles/ImportController.php";
$import_data = getImportData();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Nhà cung cấp</title>
    <!-- Gọi file CSS -->
    <link rel="stylesheet" href="css/admin_import.css">
</head>
<body>
    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Quản lý nhập hàng</h1>
            <button class="add-import-btn_style" id="add-import-btn">➕ Thêm phiếu nhập</button>
        </header>

        <!-- Popup thêm phiếu nhập -->
        <div id="popup-add-import" class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Thêm phiếu nhập</h2>
                    <span id="close-popup-add-import" class="close-btn">✖</span>
                </div>
                <div class="popup-body">
                    <div class="left_info">
                        <div class="input-row">
                            <label for="add_supplier_name">Tên nhà cung cấp:</label>
                            <!-- A combobox to select nhacungcap -->
                            <select id="add_import_supplier_combobox">
                                <?php
                                    $suppliers = getSuppliers();
                                    foreach ($suppliers as $supplier) {
                                        echo "<option value='{$supplier['supplier_id']}'>{$supplier['supplier_name']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="input-row">
                            <label for="add_import_nhanvien">Nhân viên:</label>
                            <!-- A combobox to select nhanvien -->
                            <select id="add_import_nhanvien_combobox">
                                <?php
                                    $employees = getEmployees();
                                    foreach ($employees as $employee) {
                                        echo "<option value='{$employee['employee_id']}'>{$employee['name']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="popup-footer">
                    <button id="add-import-btn_popup">Thêm</button>
                </div>
            </div>
        </div>

        <!-- Popup Chi tiết phiếu nhập -->
        <div id="popup-edit-supplier" class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Chi tiết phiếu nhập </h2>
                    <span id="close-popup-edit-import" class="close-btn">✖</span>
                </div>
                <div class="popup-body">
                    <div class="popup-body_info">
                        <div class="info_left">
                            <div class="info_left-nhacungcap">
                                <label for="">Nhà cung cấp: </label>
                                <span id="nhacungcap-supplier_id"></span> - <span id="nhacungcap-supplier_name"></span>
                            </div>
                            <div class="info_left-nhacungcap"> 
                                <label for="">Địa chỉ:</label>
                                <span id="nhacungcap-supplier_address"></span>
                            </div>
                            <div class="info_left-nhanvien"> 
                                <label for="">Nhân viên:</label>
                                <span id="nhanvien-employee_id"></span> - <span id="nhanvien-employee_name"></span>
                            </div>
                        </div>
                        <div class="info_right">
                            <!-- Combobox status and calculate total -->
                            <div class="info_right-status">
                                    <label for="info_right-status-combobox">Trạng thái: </label>
                                    <select name="info_right-status-combobox" id="info_right-status-combobox">
                                        
                                    </select>
                            </div>
                            <div class="info_right-total">
                                <label for="info_right-total-calcTotal">Tổng tiền: </label>
                                <span id="info_right-status-calcTotal">0</span>

                            </div>
                        </div>
                    </div>
                    <div class="popup-body_table">
                        <div class="table--header">
                            <h3>Danh sách sản phẩm</h3>
                            <button id="add-product-btn_receipt">➕ Thêm</button>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã SP</th>      <!-- Readonly -->
                                    <th>Tên SP</th>
                                    <th>Giá nhập</th>
                                    <th>Phần trăm</th>
                                    <th>Giá bán</th>    <!-- Readonly -->
                                    <th>Số lượng</th>
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
                    <button id="edit-receipt-btn_popup">Sửa</button>
                    <button id="delete-supplier-btn_popup" style="display: none;">Xóa</button>
                </div>
            </div>
        </div>

        <section class="import-list">
            <table>
                <thead>
                    <tr>
                        <th>Mã phiếu nhập</th>
                        <th>Tên NCC</th>
                        <th>Tên NV</th>
                        <th>Ngày tạo</th>
                        <th>Ngày nhận/hủy</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $temp_rows = [];
                        foreach ($import_data as $row) {
                            $curr_receipt = $row["receipt_id"];
                            $temp_rows[$curr_receipt][] = $row;
                        }
                        foreach ($temp_rows as $receipt_id => $rows) {
                            $rowspan = count($rows);
                            foreach ($rows as $r) {
                                echo "<tr>";
                                    echo "<td>{$r['receipt_id']}</td>";
                                    echo "<td>{$r['supplier_name']}</td>";
                                    echo "<td>{$r['name']}</td>";
                                    echo "<td>{$r['create_time']}</td>";
                                    echo "<td>{$r['confirm_time']}</td>";
                                    echo "<td>{$r['total']}</td>";
                                    // Thêm lớp CSS cho trạng thái
                                    echo "<td><span class='status status-{$r['status']}'>";
                                    // Hiển thị văn bản trạng thái bằng tiếng Việt
                                    switch ($r['status']) {
                                        case 'processing':
                                            echo "Đang xử lý";
                                            break;
                                        case 'confirmed':
                                            echo "Đã xác nhận";
                                            break;
                                        case 'cancelled':
                                            echo "Đã hủy";
                                            break;
                                        default:
                                            echo $r['status'];
                                    }
                                    echo "</span></td>";
                                    echo "<td>";
                                        if ($r['status'] === 'processing') {
                                            echo "<a href='admin.php?page=import&act=edit&receipt_id={$r['receipt_id']}' 
                                                    data-receipt_id='{$r['receipt_id']}' 
                                                    data-supplier_id='{$r['supplier_id']}' >
                                                    <button class='edit-receipt-btn'>✏️ Sửa</button></a>";
                                        } else {
                                            echo "<a href='admin.php?page=import&act=detail&receipt_id={$r['receipt_id']}' 
                                                    data-receipt_id='{$r['receipt_id']}' 
                                                    data-supplier_id='{$r['supplier_id']}' >
                                                    <button class='detail-receipt-btn'>📄 Chi tiết</button></a>";
                                        }
                                    echo "</td>";
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
        // Mở popup thêm phiếu nhập
        $("#add-import-btn").on("click", function () {
            $("#popup-add-import").addClass("active");
        });

        // Đóng popup thêm phiếu nhập
        $("#close-popup-add-import").on("click", function () {
            $("#popup-add-import").removeClass("active");
        });

        // Gửi AJAX thêm phiếu nhập
        $("#add-import-btn_popup").on("click", function () {
            $.ajax({
                url: "handles/ImportController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "add_phieunhap",
                    supplier_id: $("#add_import_supplier_combobox").val(),    
                    employee_id: $("#add_import_nhanvien_combobox").val()
                },
                success: function (response) {
                    if (response.success) {
                        location.reload(); // Reload để cập nhật bảng
                    } else {
                        alert("Thêm thất bại: " + response.error);
                    }
                },
                error: function () {
                    alert("Lỗi khi gửi yêu cầu thêm phiếu nhập");
                }
            });
        });

        // Mở popup chi tiết phiếu nhập và lấy dữ liệu qua AJAX
        $(document).on("click", ".edit-receipt-btn, .detail-receipt-btn", function (e) {
            e.preventDefault();
            
            const $link = $(this).closest("a");
            const receipt_id = $link.data("receipt_id");
            const isDetailView = $(this).hasClass("detail-receipt-btn");

            console.log("Receipt_id: " + receipt_id + ", isDetailView: " + isDetailView);

            // Lưu receipt_id vào popup header
            $("#popup-edit-supplier .popup-header h2").data("receipt_id", receipt_id);
            $("#popup-edit-supplier").addClass("active");

            // Gửi AJAX để lấy thông tin phiếu nhập và danh sách sản phẩm
            $.ajax({
                url: "handles/ImportController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "get_chitietphieunhap_data_popup",
                    receipt_id: receipt_id
                },
                success: function (response) {
                    if (response.success) {
                        const { info, products } = response.data;

                        // Cập nhật tiêu đề popup
                        $("#popup-edit-supplier .popup-header h2").text(isDetailView ? "Chi tiết phiếu nhập" : "Chỉnh sửa phiếu nhập");

                        // Cập nhật thông tin nhà cung cấp và nhân viên
                        $("#nhacungcap-supplier_id").text(info.supplier_id);
                        $("#nhacungcap-supplier_name").text(info.supplier_name);
                        $("#nhacungcap-supplier_address").text(info.address);
                        $("#nhanvien-employee_id").text(info.employee_id);
                        $("#nhanvien-employee_name").text(info.employee_name);

                        // Cập nhật trạng thái
                        const statusOptions = [
                            { value: 'processing', text: 'Đang xử lý' },
                            { value: 'confirmed', text: 'Đã xác nhận' },
                            { value: 'cancelled', text: 'Đã hủy' }
                        ];
                        $("#info_right-status-combobox").empty().append(
                            statusOptions.map(opt => 
                                `<option value="${opt.value}" ${opt.value === info.status ? 'selected' : ''} 
                                ${isDetailView ? 'disabled' : ''}>${opt.text}</option>`
                            ).join('')
                        );
                        if (isDetailView) {
                            $("#info_right-status-combobox").prop("disabled", true);
                        }

                        // Cập nhật tổng tiền
                        $("#info_right-status-calcTotal").text(info.total || 0);

                        // Cập nhật danh sách sản phẩm
                        $("#product-list_supplier").empty();
                        if (products.length > 0) {
                            products.forEach(product => {
                                $("#product-list_supplier").append(`
                                    <tr data-product-id="${product.product_id}">
                                        <td>${product.product_id}</td>
                                        <td>${product.product_name}</td>
                                        <td><input type="number" class="price-input" value="${product.price}" min="0" ${isDetailView ? 'readonly' : ''}></td>
                                        <td><input type="number" class="percent-input" value="${product.percent}" min="0" max="100" ${isDetailView ? 'readonly' : ''}></td>
                                        <td class="sell-price">${Number(product.sell_price).toFixed(0)}</td>
                                        <td><input type="number" class="quantity-input" value="${product.quantity}" min="1" ${isDetailView ? 'readonly' : ''}></td>
                                        <td>${isDetailView ? '' : `<button class="delete-product-btn" data-product-id="${product.product_id}">❌</button>`}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            $("#product-list_supplier").append(`
                                    <tr>
                                        <td colspan="7">Không có sản phẩm nào.</td>
                                    </tr>
                                `);
                        }

                        // Ẩn/hiện nút Sửa và Thêm sản phẩm
                        if (isDetailView) {
                            $("#edit-receipt-btn_popup").hide();
                            $("#add-product-btn_receipt").hide();
                            $("#delete-supplier-btn_popup").hide();
                        } else {
                            $("#edit-receipt-btn_popup").show();
                            $("#add-product-btn_receipt").show();
                            toggleDeleteButton();
                        }
                    } else {
                        alert("Lỗi khi lấy chi tiết phiếu nhập: " + response.error);
                    }
                },
                error: function () {
                    alert("Lỗi khi gửi yêu cầu lấy chi tiết phiếu nhập");
                }
            });
        });


        // Format tiền
        $(document).on("input", ".price-input, .percent-input", function () {
            const $row = $(this).closest("tr");
            const price = parseFloat($row.find(".price-input").val()) || 0;
            const percent = parseFloat($row.find(".percent-input").val()) || 0;
            const sellPrice = (price * (1 + percent / 100)).toFixed(0); // Làm tròn 0 chữ số thập phân
            $row.find(".sell-price").text(sellPrice);
        });

        // Cập nhật tổng tiền khi thay đổi số lượng, giá nhập hoặc phần trăm
        $(document).on("input", ".price-input, .percent-input, .quantity-input", function () {
            let total = 0;
            $("#product-list_supplier tr").each(function () {
                const price = parseFloat($(this).find(".price-input").val()) || 0;
                const quantity = parseFloat($(this).find(".quantity-input").val()) || 0;
                total += price * quantity;
            });
            $("#info_right-status-calcTotal").text(total.toFixed(0)); // Làm tròn 0 chữ số thập phân
        });

        // Đóng popup chỉnh sửa nhà cung cấp
        $("#close-popup-edit-import").on("click", function () {
            $("#popup-edit-supplier").removeClass("active");
            $("#product-list_supplier").empty(); // Xóa bảng khi đóng popup
            $("#info_right-status-combobox").prop("disabled", false); // Đặt lại combobox trạng thái
            // location.reload();
        });

        $("#edit-receipt-btn_popup").on("click", function () {
            const receipt_id = $("#popup-edit-supplier .popup-header h2").data("receipt_id");
            const status = $("#info_right-status-combobox").val();

            console.log("Onclick Sửa trong popup chitietphieunhap, receipt_id: " + receipt_id);

            // Lấy danh sách sản phẩm
            const products = [];
            $("#product-list_supplier tr").each(function () {
                const product_id = $(this).data("product-id");
                if (product_id) {
                    products.push({
                        product_id: parseInt(product_id),
                        price: parseInt($(this).find(".price-input").val()) || 0,
                        percent: parseInt($(this).find(".percent-input").val()) || 0,
                        quantity: parseInt($(this).find(".quantity-input").val()) || 0
                    });
                }
            });

            $.ajax({
                url: "handles/ImportController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "update_phieunhap",
                    receipt_id: receipt_id,
                    status: status,
                    products: JSON.stringify(products)
                },
                success: function (response) {
                    if (response.success) {
                        location.reload(); // Reload để cập nhật bảng
                    } else {
                        alert("Cập nhật thất bại: " + response.error);
                    }
                },
                error: function () {
                    alert("Lỗi khi gửi yêu cầu cập nhật phiếu nhập");
                }
            });
        });




        // Thêm dòng mới với combobox sản phẩm
        $("#add-product-btn_receipt").on("click", function () {
            const supplier_id = $("#nhacungcap-supplier_id").text();

            // Lấy danh sách sản phẩm hiện tại trong bảng
            const current_products = [];
            $("#product-list_supplier tr").each(function () {
                const product_id = $(this).data("product-id");
                if (product_id) {
                    current_products.push(parseInt(product_id));
                }
            });

            // Gửi AJAX để lấy danh sách sản phẩm khả dụng
            $.ajax({
                url: "handles/ImportController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "get_available_products",
                    supplier_id: supplier_id,
                    current_products: JSON.stringify(current_products)
                },
                success: function (response) {
                    if (response.success) {
                        const available_products = response.data;
                        if (available_products.length === 0) {
                            alert("Không còn sản phẩm nào để thêm!");
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
                                <td><select class="product-select">${options}</select></td>
                                <td><input type="number" class="price-input" value="0" min="0"></td>
                                <td><input type="number" class="percent-input" value="0" min="0" max="100"></td>
                                <td class="sell-price">0.00</td>
                                <td><input type="number" class="quantity-input" value="1" min="1"></td>
                                <td><button class="delete-product-btn">❌</button></td>
                            </tr>
                        `);
                        toggleDeleteButton();
                    } else {
                        alert("Lỗi khi lấy danh sách sản phẩm: " + response.error);
                    }
                },
                error: function () {
                    alert("Lỗi khi gửi yêu cầu lấy danh sách sản phẩm");
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
                $row.attr("data-product-id", product_id);
                $row.find("td:first").text(product_id); // Cập nhật cột Mã SP
                $row.find("td:eq(1)").html(product_name); // Thay combobox bằng tên sản phẩm
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

            if (confirm("Bạn có chắc muốn xóa nhà cung cấp này không?")) {
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
                            location.reload(); // Reload để cập nhật bảng
                        } else {
                            alert("Xóa thất bại: " + response.error);
                        }
                    },
                    error: function () {
                        alert("Lỗi khi gửi yêu cầu xóa nhà cung cấp");
                    }
                });
            }
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


