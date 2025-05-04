<?php
require_once "handles/CategoryController.php";
$category_data = getCategoryData();

$funcId = 'danhmuc';
$phanquyenController = new PhanQuyenController();
$canUpdate = $phanquyenController->hasPermission($funcId, 'update', $_SESSION['permissions']);
$canDelete = $phanquyenController->hasPermission($funcId, 'delete', $_SESSION['permissions']);
$canAdd = $phanquyenController->hasPermission($funcId, 'create', $_SESSION['permissions']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Chủng Loại</title>
    <link rel="stylesheet" href="css/admin_category.css">
</head>
<body>
    <main class="main-content">
        <header>
            <h1>Quản Lý Chủng Loại</h1>
            <?php if ($canAdd) : ?>
                <button class="add-chungloai-btn">➕ Thêm chủng loại</button>
            <?php endif; ?>
        </header>

        <!-- Popup thêm chủng loại -->
        <div id="popup-add-chungloai" class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Thêm chủng loại</h2>
                    <span id="close-popup" class="close-btn">✖</span>
                </div>
                <div class="popup-body">
                    <div class="left-section">
                        <div class="input-row">
                            <img id="preview-hinhanh" src="imgs/default.webp" alt="Ảnh xem trước" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                            <input type="file" id="hinhanh-file" accept="image/*" style="display: none;">
                            <button type="button" id="choose-hinhanh">Chọn ảnh</button>
                        </div>
                    </div>
                    <div class="right-section">
                        <div class="input-row">
                            <label for="tenchungloai">Tên chủng loại:</label>
                            <input type="text" id="tenchungloai" placeholder="Nhập tên chủng loại">
                        </div>
                        <div class="input-row">
                            <label for="hinhanh">Ảnh chủng loại:</label>
                            <input type="text" id="hinhanh" placeholder="Nhập đường dẫn ảnh (ví dụ: imgs/img1.jpg)" value="imgs/default.webp">
                        </div>
                    </div>
                </div>
                <div class="popup-footer">
                    <button id="btn-them-chungloai">Thêm</button>
                </div>
            </div>
        </div>

        <!-- Popup chỉnh sửa chủng loại -->
        <div id="popup-edit-chungloai" class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Chỉnh sửa chủng loại</h2>
                    <span id="close-popup-edit-chungloai" class="close-btn">✖</span>
                </div>
                <div class="popup-body">
                    <div class="left_info">
                        <input type="hidden" id="edit_machungloai"> <!-- Thêm input ẩn -->
                        <div class="input-row">
                            <label for="display_machungloai">Mã chủng loại:</label>
                            <input type="text" id="display_machungloai" readonly>
                        </div>
                        <div class="input-row">
                            <label for="edit_tenchungloai">Tên chủng loại:</label>
                            <input type="text" id="edit_tenchungloai">
                        </div>
                        <div class="input-row">
                            <label for="edit_hinhanh">Ảnh chủng loại:</label>
                            <input type="text" id="edit_hinhanh" placeholder="Nhập đường dẫn ảnh (ví dụ: imgs/img1.jpg)" value="imgs/default.webp">
                            <input type="file" id="edit_hinhanh-file" accept="image/*" style="display: none;">
                            <img id="edit_preview-hinhanh" src="imgs/default.webp" alt="Ảnh chủng loại" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                        <div class="input-row">
                            <button type="button" id="edit_choose-hinhanh">Chọn ảnh</button>    
                        </div>
                    </div>
                    <div class="right_table">
                        <div class="right_table--header">
                            <h3>Danh sách thể loại</h3>
                            <button id="add-theloai-btn_popup">➕ Thêm</button>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã thể loại</th>
                                    <th>Tên thể loại</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="theloai-list">
                                <!-- Dữ liệu thể loại sẽ được thêm vào đây bằng AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="popup-footer">
                    <button id="edit-chungloai-btn_popup">Sửa</button>
                    <?php if ($canDelete) : ?>
                        <button id="btn-xoa-chungloai" style="display: none;">Xóa</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <section class="chungloai-list">
            <table>
                <thead>
                    <tr>
                        <th>Mã chủng loại</th>
                        <th>Ảnh</th>
                        <th>Tên chủng loại</th>
                        <th>Mã thể loại</th>
                        <th>Tên thể loại</th>
                        <th>SL hàng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $temp_rows = [];
                        foreach ($category_data as $row) {
                            $curr_chungloai = $row["machungloai"];
                            $temp_rows[$curr_chungloai][] = $row;
                        }

                        foreach ($temp_rows as $machungloai => $rows) {
                            $first = true;
                            $has_theloai = !empty($rows[0]['matheloai']);

                            if (!$has_theloai) {
                                echo "<tr>";
                                echo "<td>{$rows[0]['machungloai']}</td>";
                                echo "<td><img src='" . ($rows[0]['hinhanh'] ? $rows[0]['hinhanh'] : 'imgs/default.webp') . "' alt='Ảnh chủng loại' style='width: 50px; height: 50px; object-fit: cover;'></td>"; // Thêm ảnh với default nếu không có
                                echo "<td>{$rows[0]['tenchungloai']}</td>";
                                echo "<td colspan='3'>Không có thể loại</td>";
                                echo "<td>";
                                if ($canUpdate) {
                                    echo "<a href='admin.php?page=category&act=edit_chungloai&id={$rows[0]['machungloai']}' 
                                        data-machungloai='{$rows[0]['machungloai']}' 
                                        data-tenchungloai='" . htmlspecialchars($rows[0]['tenchungloai'], ENT_QUOTES, 'UTF-8') . "'
                                        data-hinhanh='{$rows[0]['hinhanh']}'>
                                        <button class='edit-chungloai-btn'>✏️ Sửa</button></a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                                continue;
                            }

                            $rowspan = count($rows);
                            foreach ($rows as $r) {
                                echo "<tr>";
                                if ($first) {
                                    echo "<td rowspan='{$rowspan}'>{$r['machungloai']}</td>";
                                    echo "<td rowspan='{$rowspan}'><img src='" . ($r['hinhanh'] ? $r['hinhanh'] : 'imgs/default.webp') . "' alt='Ảnh chủng loại' style='width: 50px; height: 50px; object-fit: cover;'></td>"; // Thêm ảnh với default nếu không có
                                    echo "<td rowspan='{$rowspan}'>{$r['tenchungloai']}</td>";
                                }
                                echo "<td>{$r['matheloai']}</td>";
                                echo "<td>{$r['tentheloai']}</td>";
                                echo "<td>{$r['so_sanpham']}</td>";
                                if ($first) {
                                    echo "<td rowspan='{$rowspan}'>";
                                    if ($canUpdate) {
                                        echo "<a href='admin.php?page=category&act=edit_chungloai&id={$r['machungloai']}' 
                                                data-machungloai='{$r['machungloai']}' 
                                                data-tenchungloai='" . htmlspecialchars($r['tenchungloai'], ENT_QUOTES, 'UTF-8') . "'
                                                data-hinhanh='{$r['hinhanh']}'>
                                                <button class='edit-chungloai-btn'>✏️ Sửa</button></a>";
                                    }
                                    echo "</td>";
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
            // Mở input file khi nhấn nút Chọn ảnh
            $("#choose-hinhanh").on("click", function () {
                $("#hinhanh-file").click();
            });

            // Xem trước ảnh và cập nhật đường dẫn khi chọn file
            $("#hinhanh-file").on("change", function (e) {
                const file = e.target.files[0];
                if (file) {
                    const fileName = "imgs/" + file.name;
                    $("#hinhanh").val(fileName);
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $("#preview-hinhanh").attr("src", e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $("#hinhanh").val("imgs/default.webp");
                    $("#preview-hinhanh").attr("src", "imgs/default.webp");
                }
            });
            // Mở input file khi nhấn nút Chọn ảnh trong popup Chỉnh sửa
            $("#edit_choose-hinhanh").on("click", function () {
                $("#edit_hinhanh-file").click();
            });

            // Xem trước ảnh và cập nhật đường dẫn khi chọn file trong popup Chỉnh sửa
            $("#edit_hinhanh-file").on("change", function (e) {
                const file = e.target.files[0];
                if (file) {
                    const fileName = "imgs/" + file.name;
                    $("#edit_hinhanh").val(fileName);
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $("#edit_preview-hinhanh").attr("src", e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $("#edit_hinhanh").val("imgs/default.webp");
                    $("#edit_preview-hinhanh").attr("src", "imgs/default.webp");
                }
            });

            // Mở popup thêm chủng loại
            $(".add-chungloai-btn").on("click", function (e) {
                e.preventDefault();
                $("#tenchungloai").val("");
                $("#popup-add-chungloai").addClass("active");
            });

            // Đóng popup thêm chủng loại
            $("#close-popup").on("click", function () {
                $("#popup-add-chungloai").removeClass("active");
            });

            // Thêm chủng loại
            $("#btn-them-chungloai").on("click", function () {
                const tenchungloai = $("#tenchungloai").val().trim();
                const hinhanh = $("#hinhanh").val().trim();

                if (tenchungloai === "") {
                    showToast("Vui lòng nhập tên chủng loại", false);
                    return;
                }

                $.ajax({
                    url: "handles/CategoryController.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: "add_chungloai",
                        tenchungloai: tenchungloai,
                        hinhanh: hinhanh || null
                    },
                    success: function (response) {
                        if (response.success) {
                            showToast("Thêm chủng loại thành công", true);
                            setTimeout(function () {
                                location.reload(); // Reload để cập nhật bảng
                            }, 1000);
                        } else {
                            showToast("Thêm thất bại: " + response.error, false);
                        }
                    },
                    error: function () {
                        showToast("Lỗi khi gửi yêu cầu thêm chủng loại", false);
                    }
                });
            });

            // Mở popup chỉnh sửa chủng loại và lấy danh sách thể loại
            $(document).on("click", ".edit-chungloai-btn", function (e) {
                e.preventDefault();
                const $link = $(this).closest("a");
                const machungloai = $link.data("machungloai");
                const tenchungloai = $link.data("tenchungloai");
                const hinhanh = $link.data("hinhanh") || "imgs/default.webp";

                $("#edit_machungloai").val(machungloai);
                $("#display_machungloai").val(machungloai);
                $("#edit_tenchungloai").val(tenchungloai);
                $("#edit_hinhanh").val(hinhanh);
                $("#edit_preview-hinhanh").attr("src", hinhanh);
                $("#popup-edit-chungloai").addClass("active");

                // Lấy danh sách thể loại
                $.ajax({
                    url: "handles/CategoryController.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: "get_theloai_by_chungloai",
                        machungloai: machungloai
                    },
                    success: function (response) {
                        if (response.success) {
                            const theloai_list = response.data;
                            $("#theloai-list").empty();
                            if (theloai_list.length > 0) {
                                theloai_list.forEach(theloai => {
                                    const canDelete = theloai.so_sanpham == 0 ? '' : 'style="display: none;"';
                                    $("#theloai-list").append(`
                                        <tr data-matheloai="${theloai.matheloai}" data-so-sanpham="${theloai.so_sanpham}">
                                            <td>${theloai.matheloai}</td>
                                            <td>${theloai.tentheloai}</td>
                                            <td><button class="delete-theloai-btn" data-matheloai="${theloai.matheloai}" ${canDelete}>❌</button></td>
                                        </tr>
                                    `);
                                });
                            }
                            toggleDeleteButton();
                        } else {
                            showToast("Lỗi khi lấy danh sách thể loại: " + response.error, false);
                        }
                    },
                    error: function () {
                        showToast("Lỗi khi gửi yêu cầu lấy danh sách thể loại", false);
                    }
                });
            });

            // Đóng popup chỉnh sửa chủng loại
            $("#close-popup-edit-chungloai").on("click", function () {
                $("#popup-edit-chungloai").removeClass("active");
                $("#theloai-list").empty();
            });

            // Thêm dòng mới với input để nhập tên thể loại
            $("#add-theloai-btn_popup").on("click", function () {
                const machungloai = $("#edit_machungloai").val();

                $("#theloai-list").prepend(`
                    <tr class="new-theloai-row" data-is-new="true">
                        <td>Tự động</td>
                        <td><input type="text" class="new-theloai-input" placeholder="Nhập tên thể loại"></td>
                        <td><button class="delete-theloai-btn">❌</button></td>
                    </tr>
                `);
                toggleDeleteButton();
            });

            // Xử lý khi nhập tên thể loại mới và lưu vào DB
            $(document).on("blur", ".new-theloai-input", function () {
                const $row = $(this).closest("tr");
                const tentheloai = $(this).val().trim();
                const machungloai = $("#edit_machungloai").val();

                if (tentheloai === "") {
                    showToast("Vui lòng nhập tên thể loại", false);
                    
                    $row.remove();
                    toggleDeleteButton();
                    return;
                }

                $.ajax({
                    url: "handles/CategoryController.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: "add_theloai",
                        tentheloai: tentheloai,
                        machungloai: machungloai
                    },
                    success: function (response) {
                        if (response.success && response.matheloai) {
                            $row.attr("data-matheloai", response.matheloai);
                            $row.attr("data-so-sanpham", 0);
                            $row.removeAttr("data-is-new");
                            $row.find("td:first").text(response.matheloai);
                            $row.find("td:eq(1)").text(tentheloai);
                            $row.find(".new-theloai-input").replaceWith(tentheloai);
                        } else {
                            showToast("Thêm thể loại thất bại: " + response.error, false);
                            $row.remove();
                        }
                    },
                    error: function () {
                        showToast("Lỗi khi gửi yêu cầu thêm thể loại", false);
                        
                        $row.remove();
                    }
                });
            });

            // Xóa thể loại khỏi bảng
            $(document).on("click", ".delete-theloai-btn", function () {
                const $row = $(this).closest("tr");
                const isNew = $row.attr("data-is-new") === "true";
                const matheloai = $row.data("matheloai");

                if (!isNew) {
                    Swal.fire({
                    title: "Thông báo",
                    text: "Bạn có chắc muốn xóa thể loại này không?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Có",
                    cancelButtonText: "Không"
                    }).then((result) => {
                        if (result.isConfirmed) {
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
                                        $row.remove();
                                        toggleDeleteButton();
                                    } else {
                                        // alert("Xóa thất bại: " + response.error);
                                        showToast("Xóa thất bại: " + response.error, false);
                                    }
                                },
                                error: function () {
                                    showToast("Lỗi khi gửi yêu cầu xóa thể loại", false);
                                }
                            });
                        }
                    })
                } else {
                    $row.remove();
                    toggleDeleteButton();
                }
            });

            // Gửi AJAX sửa chủng loại và danh sách thể loại
            $("#edit-chungloai-btn_popup").on("click", function () {
                const machungloai = $("#edit_machungloai").val();
                const tenchungloai = $("#edit_tenchungloai").val().trim();
                const hinhanh = $("#edit_hinhanh").val().trim();

                if (tenchungloai === "") {
                    showToast("Vui lòng nhập tên chủng loại", false);
                    return;
                }

                // Kiểm tra xem có hàng nào chưa được lưu (vẫn là input)
                if ($(".new-theloai-input").length > 0) {
                    showToast("Vui lòng hoàn tất việc thêm thể loại trước khi lưu!", false);
                    return;
                }

                const theloai_list = [];
                $("#theloai-list tr").each(function () {
                    const matheloai = $(this).data("matheloai");
                    if (matheloai) {
                        theloai_list.push(parseInt(matheloai));
                    }
                });

                $.ajax({
                    url: "handles/CategoryController.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: "update_chungloai",
                        machungloai: machungloai,
                        tenchungloai: tenchungloai,
                        theloai: JSON.stringify(theloai_list),
                        hinhanh: hinhanh || null
                    },
                    success: function (response) {
                        if (response.success) {
                            showToast("Sửa chủng loại thành công", true);
                            setTimeout(function () {
                                location.reload(); // Reload để cập nhật bảng
                            }, 1000);
                        } else {
                            showToast("Sửa thất bại: " + response.error, false);
                        }
                    },
                    error: function () {
                        showToast("Lỗi khi gửi yêu cầu sửa chủng loại", false);
                    }
                });
            });

            // Gửi AJAX xóa chủng loại
            $("#btn-xoa-chungloai").on("click", function () {
                const machungloai = $("#edit_machungloai").val();

                Swal.fire({
                title: "Thông báo",
                text: "Bạn có chắc muốn xóa chủng loại này không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Có",
                cancelButtonText: "Không"
                }).then((result) => {
                    if (result.isConfirmed) 
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
                                showToast("Xóa chủng loại thành công", true);
                                setTimeout(function () {
                                    location.reload(); // Reload để cập nhật bảng
                                }, 1000);
                            } else {
                                showToast("Xóa thất bại: " + response.error, false);
                            }
                        },
                        error: function () {
                            showToast("Lỗi khi gửi yêu cầu xóa chủng loại", false);
                        }
                    });
                })
            });

            // Hàm kiểm tra và ẩn/hiện nút Xóa chủng loại
            function toggleDeleteButton() {
                const theloaiCount = $("#theloai-list").children().length;
                if (theloaiCount === 0) {
                    $("#btn-xoa-chungloai").show();
                } else {
                    $("#btn-xoa-chungloai").hide();
                }
            }
        });
    </script>
</body>
</html>