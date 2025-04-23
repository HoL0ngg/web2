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
        <div id="popup-edit-chungloai" class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Chỉnh sửa chủng loại</h2>
                    <span id="close-popup-edit-chungloai" class="close-btn">✖</span>
                </div>
                <div class="popup-body">
                    <input type="hidden" id="edit_machungloai">
                    <div class="input-row">
                        <label for="edit_tenchungloai">Tên chủng loại:</label>
                        <input type="text" id="edit_tenchungloai">
                    </div>
                    <div class="popup-footer">
                        <button id="edit-chungloai-btn_popup">Sửa</button>
                        <button id="btn-xoa-chungloai">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Popup thêm chủng loại (giữa màn hình) -->
        <div id="popup-add-chungloai" class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Thêm chủng loại</h2>
                    <span id="close-popup" class="close-btn">✖</span>
                </div>
                <div class="popup-body">
                    <div class="input-row">
                        <label for="tenchungloai">Tên chủng loại:</label>
                        <input type="text" id="tenchungloai" placeholder="Nhập tên chủng loại">
                    </div>
                    <button id="btn-them-chungloai">Thêm</button>
                </div>

            </div>
        </div>
        <!-- Popup thêm thể loại -->
        <div id="popup-add-theloai" class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Thêm thể loại</h2>
                    <span id="close-popup-theloai" class="close-btn">✖</span>
                </div>
                <div class="popup-body">
                    <input type="hidden" id="cl_id_theloai">

                    <div class="input-row">
                        <label for="ten-chungloai-hienthi">Tên chủng loại:</label>
                        <span id="ten-chungloai-hienthi" style="font-weight: bold;"></span>
                    </div>

                    <div class="input-row">
                        <label for="tentheloai">Tên thể loại:</label>
                        <input type="text" id="tentheloai" placeholder="Nhập tên thể loại">
                    </div>

                    <button id="btn-them-theloai">Thêm</button>
                </div>
            </div>
        </div>
        <!-- Popup chỉnh sửa thể loại -->
        <div id="popup-edit-theloai" class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Chỉnh sửa thể loại</h2>
                    <span id="close-popup-edit-theloai" class="close-btn">✖</span>
                </div>
                <div class="popup-body">
                    <input type="hidden" id="edit_matheloai">
                    <input type="hidden" id="edit_machungloai">
                    
                    <div class="input-row">
                        <!-- ERROR -->
                        <label for="edit_tenchungloai_theloai">Tên chủng loại:</label>
                        <input type="text" id="edit_tenchungloai_theloai" style="font-weight: bold;"></input>
                    </div>
                    <div class="input-row">
                        <label for="edit_tentheloai">Tên thể loại:</label>
                        <input type="text" id="edit_tentheloai" placeholder="Nhập tên thể loại">
                    </div>
                    <div class="popup-footer">
                        <button id="btn-sua-theloai">Sửa</button>
                        <button id="btn-xoa-theloai" style="display: none;">Xóa</button>
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
                        <th>Địa chỉ</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Hành động</th> <!-- Cột riêng -->
                        <th>Thêm sản phẩm</th> <!-- Cột riêng -->
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
                            $first = true;

                            // Kiểm tra nếu không có thể loại nào
                            $has_sanpham = !empty($rows[0]['product_id']);

                            if (!$has_sanpham) {
                                echo "<tr>";
                                echo "<td>{$rows[0]['supplier_id']}</td>";
                                echo "<td>{$rows[0]['supplier_name']}</td>";
                                echo "<td>{$rows[0]['address']}</td>";
                                echo "<td colspan='2'>Không có sản phẩm</td>";

                                echo "<td>";
                                echo "<a href='admin.php?page=category&act=edit_chungloai&id={$rows[0]['machungloai']}' 
                                        data-supplier_id='{$rows[0]['supplier_id']}' 
                                        data-supplier_name='" . htmlspecialchars($rows[0]['supplier_name'], ENT_QUOTES, 'UTF-8') . "'
                                        data-address='" . htmlspecialchars($rows[0]['address'], ENT_QUOTES, 'UTF-8') . "'>
                                        <button class='edit-chungloai-btn'>✏️ Sửa</button></a>";
                                echo "</td>";


                                echo "<td>";
                                echo "<a href='admin.php?page=category&act=add_type&cl_id={$rows[0]['machungloai']}' 
                                        data-supplier_id='{$rows[0]['supplier_id']}' 
                                        data-supplier_name='" . htmlspecialchars($rows[0]['supplier_name'], ENT_QUOTES, 'UTF-8') . "' 
                                        data-address='" . htmlspecialchars($rows[0]['address'], ENT_QUOTES, 'UTF-8') . "'>
                                        <button class='add-theloai-btn'>➕ Thêm sản phẩm</button></a>";
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

                                // Cột Hành động cho thể loại
                                echo "<td>";
                                // Luôn có nút Sửa
                                echo "<a href='admin.php?page=category&act=edit_type&id={$r['matheloai']}' 
                                        data-supplier_id='{$r['supplier_id']}' 
                                        data-supplier_name='{$r['supplier_name']}' 
                                        data-product_id='{$r['product_id']}' 
                                        data-product_name='{$r['product_name']}' >
                                        <button class='edit-theloai-btn'>✏️ Sửa</button></a>";

                                echo "</td>";

                                // Cột Thêm sản phẩm (chỉ ở dòng đầu tiên)
                                if ($first) {
                                    echo "<td rowspan='{$rowspan}'>
                                            <a href='admin.php?page=category&act=add_type&cl_id={$r['machungloai']}' 
                                            data-supplier_id='{$r['supplier_id']}' 
                                            data-supplier_name='{$r['supplier_name']}'>
                                            <button class='add-theloai-btn'>➕ Thêm sản phẩm</button></a>
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
        $(document).ready(function () {
            // Hiện popup
            $(".add-chungloai-btn").on("click", function (e) {
                e.preventDefault();
                $("#popup-add-chungloai").addClass("active");
            });

            // Đóng popup
            $("#close-popup").on("click", function () {
                $("#popup-add-chungloai").removeClass("active");
            });

            // Thêm chủng loại
            $("#btn-them-chungloai").on("click", function () {
                const tenchungloai = $("#tenchungloai").val().trim();
                if (tenchungloai === "") {
                    alert("Vui lòng nhập tên chủng loại");
                    return;
                }

                $.ajax({
                    url: "handles/CategoryController.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: "add_chungloai",
                        tenchungloai: tenchungloai
                    },

                    success: function (newRowHTML) {
                        $("#popup-add-chungloai").removeClass("active");
                        $("#tenchungloai").val(""); // reset
                        $("tbody").append(newRowHTML); // cập nhật bảng
                    },
                    error: function () {
                        alert("Lỗi thêm chủng loại");
                    }
                });
            });
        });
        
        // // Xóa chủng loại
        // $(document).on("click", ".delete-chungloai-btn", function (e) {
        //     e.preventDefault();
        //     const row = $(this).closest("tr"); // hàng hiện tại
        //     const maCL = $(this).closest("a").attr("href").split("id=")[1];

        //     if (confirm("Bạn có chắc muốn xóa chủng loại này không?")) {
        //         $.ajax({
        //             url: "handles/CategoryController.php",
        //             method: "POST",
        //             dataType: "json",
        //             data: {
        //                 action: "delete_chungloai",
        //                 machungloai: maCL
        //             },
        //             success: function (res) {
        //                 if (res.success) {
        //                     // Xoá tất cả hàng có rowspan (nếu có thể loại)
        //                     $(`td[rowspan][rowspan!='1']:contains('${maCL}')`).each(function () {
        //                         const rowspan = parseInt($(this).attr("rowspan"));
        //                         const rowIndex = $(this).closest("tr").index();
        //                         for (let i = 0; i < rowspan; i++) {
        //                             $("tbody tr").eq(rowIndex).remove();
        //                         }
        //                     });

        //                     // Nếu là hàng đơn (không rowspan)
        //                     row.remove();
        //                 } else {
        //                     alert("Xóa thất bại");
        //                 }
        //             },
        //             error: function () {
        //                 alert("Lỗi khi gửi yêu cầu xoá chủng loại");
        //             }
        //         });
        //     }
        // });
        // Mở popup thêm thể loại
        $(document).on("click", ".add-theloai-btn", function (e) {
            e.preventDefault();
            
            const $link = $(this).closest("a");
            const cl_id = $link.data("machungloai");
            const tenCL = $link.data("tenchungloai");

            $("#cl_id_theloai").val(cl_id);
            $("#ten-chungloai-hienthi").text("\t" + tenCL);
            $("#popup-add-theloai").addClass("active");
        });


        // Đóng popup
        $("#close-popup-theloai").on("click", function () {
            $("#popup-add-theloai").removeClass("active");
        });

        // Gửi AJAX thêm thể loại
        $("#btn-them-theloai").on("click", function () {
            const tentheloai = $("#tentheloai").val().trim();
            const cl_id = $("#cl_id_theloai").val();

            if (tentheloai === "") {
                alert("Vui lòng nhập tên thể loại");
                return;
            }

            $.ajax({
                url: "handles/CategoryController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "add_theloai",
                    tentheloai: tentheloai,
                    machungloai: cl_id
                },
                success: function (response) {
                    location.reload(); // Reload để cập nhật lại bảng
                },
                error: function () {
                    alert("Lỗi thêm thể loại");
                }
            });
        });

        // Mở popup chỉnh sửa thể loại
        $(document).on("click", ".edit-theloai-btn", function (e) {
            e.preventDefault();
            
            const $link = $(this).closest("a");
            const matheloai = $link.data("matheloai");
            const machungloai = $link.data("machungloai");
            const tenchungloai = $link.data("tenchungloai");
            const tentheloai = $link.data("tentheloai");
            const so_sanpham = $link.data("so-sanpham");
            
            // Testing
            console.log("matheloai:", matheloai);
            console.log("machungloai:", machungloai);
            console.log("tenchungloai:", tenchungloai);
            console.log("tentheloai:", tentheloai);
            console.log("so_sanpham:", so_sanpham);

            $("#edit_matheloai").val(matheloai);
            $("#edit_tenchungloai_theloai").val(tenchungloai);
            $("#edit_tentheloai").val(tentheloai);
            $("#edit_machungloai").val(machungloai);
            
            console.log("Giá trị input #edit_tenchungloai_theloai:", $("#edit_tenchungloai_theloai").val());

            // Hiển thị hoặc ẩn nút Xóa dựa trên số lượng sản phẩm
            if (parseInt(so_sanpham) === 0) {
                $("#btn-xoa-theloai").show();
            } else {
                $("#btn-xoa-theloai").hide();
            }

            $("#popup-edit-theloai").addClass("active");
        });

        // Đóng popup chỉnh sửa
        $("#close-popup-edit-theloai").on("click", function () {
            $("#popup-edit-theloai").removeClass("active");
        });

        // Gửi AJAX sửa thể loại
        $("#btn-sua-theloai").on("click", function () {
            const matheloai = $("#edit_matheloai").val();
            const tentheloai = $("#edit_tentheloai").val().trim();

            if (tentheloai === "") {
                alert("Vui lòng nhập tên thể loại");
                return;
            }

            $.ajax({
                url: "handles/CategoryController.php",
                method: "POST",
                dataType: "json",
                data: {
                    action: "edit_theloai",
                    matheloai: matheloai,
                    tentheloai: tentheloai,
                    machungloai: $("#edit_machungloai").val(),
                    tenchungloai: $("#edit_tenchungloai_theloai").val().trim()
                },
                success: function (response) {
                    if (response.success) {
                        location.reload(); // Reload để cập nhật bảng
                    } else {
                        alert("Sửa thất bại: " + response.error);
                    }
                },
                error: function () {
                    alert("Lỗi khi gửi yêu cầu sửa thể loại");
                }
            });
        });

        // Gửi AJAX xóa thể loại từ popup
        $("#btn-xoa-theloai").on("click", function () {
            const matheloai = $("#edit_matheloai").val();

            if (confirm("Bạn có chắc muốn xóa thể loại này không?")) {
                $.ajax({
                    url: "handles/CategoryController.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: "delete_theloai",
                        matheloai: matheloai
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload(); // Reload để cập nhật bảng
                        } else {
                            alert("Xóa thất bại: " + response.error);
                        }
                    },
                    error: function () {
                        alert("Lỗi khi gửi yêu cầu xóa thể loại");
                    }
                });
            }
        });

        // Mở popup chỉnh sửa chủng loại
        $(document).on("click", ".edit-chungloai-btn", function (e) {
            e.preventDefault();
            
            const $link = $(this).closest("a");
            const machungloai = $link.data("machungloai");
            const tenchungloai = $link.data("tenchungloai");

            $("#edit_machungloai").val(machungloai);
            $("#edit_tenchungloai").val(tenchungloai);
            $("#popup-edit-chungloai").addClass("active");
            
            console.log("Giá trị input #edit_tenchungloai:", $("#edit_tenchungloai").val());

        });

        // Đóng popup chỉnh sửa chủng loại
        $("#close-popup-edit-chungloai").on("click", function () {
            $("#popup-edit-chungloai").removeClass("active");
        });

        // Gửi AJAX sửa chủng loại
        $("#edit-chungloai-btn_popup").on("click", function () {
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
        $("#btn-xoa-chungloai").on("click", function () {
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


