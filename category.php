<?php
require_once "handles/CategoryController.php";
$category_data = getCategoryData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Gọi file CSS -->
    <link rel="stylesheet" href="css/admin_category.css">
</head>
<body>
    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Quản Lý Chủng Loại</h1>
            <button class="add-chungloai-btn">➕ Thêm chủng loại</button>
            <!-- <a href="admin.php?page=category&act=add">
            </a> -->
    
        </header>
    
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
    
    
        <section class="chungloai-list">
            <table>
                <thead>
                    <tr>
                        <th>Mã chủng loại</th>
                        <th>Tên chủng loại</th>
                        <th>Mã thể loại</th>
                        <th>Tên thể loại</th>
                        <th>SL hàng</th>
                        <th>Hành động</th> <!-- Cột riêng -->
                        <th>Thêm thể loại</th> <!-- Cột riêng -->
                    </tr>
                </thead>
    
                <tbody>
                    <?php
                    $prev_chungloai = "";
                    $rowspan = 0;
                    $temp_rows = [];

                    foreach ($category_data as $index => $row) {
                        $curr_chungloai = $row["machungloai"];
                        $temp_rows[$curr_chungloai][] = $row;
                    }

                    // Lặp theo chủng loại
                    foreach ($temp_rows as $machungloai => $rows) {
                        $first = true;

                        // Kiểm tra nếu không có thể loại nào
                        $has_theloai = !empty($rows[0]['matheloai']);

                        if (!$has_theloai) {
                            echo "<tr>";
                            echo "<td>{$rows[0]['machungloai']}</td>";
                            echo "<td>{$rows[0]['tenchungloai']}</td>";
                            echo "<td colspan='3'>Không có thể loại</td>";

                            // Xóa chủng loại nếu không có thể loại con
                            echo "<td>";
                            echo "<a href='admin.php?page=category&act=del&id={$rows[0]['machungloai']}'><button class='delete-chungloai-btn'>❌ Xóa</button></a>";
                            echo "</td>";

                            echo "<td>";
                            echo "<a href='admin.php?page=category&act=add_type&cl_id={$rows[0]['machungloai']}'><button class='add-theloai-btn'>➕ Thêm thể loại</button></a>";
                            echo "</td>";
                            echo "</tr>";
                            continue;
                        }

                        // Nếu có thể loại
                        $rowspan = count($rows);
                        foreach ($rows as $r) {
                            echo "<tr>";
                            if ($first) {
                                echo "<td rowspan='{$rowspan}'>{$r['machungloai']}</td>";
                                echo "<td rowspan='{$rowspan}'>{$r['tenchungloai']}</td>";
                            }

                            echo "<td>{$r['matheloai']}</td>";
                            echo "<td>{$r['tentheloai']}</td>";
                            echo "<td>{$r['so_sanpham']}</td>";

                            // Cột Hành động cho thể loại
                            echo "<td>";
                            // Luôn có nút Sửa
                            echo "<a href='admin.php?page=category&act=edit_type&id={$r['matheloai']}'><button class='edit-theloai-btn'>✏️ Sửa</button></a>";

                            // Chỉ hiện nút Xóa nếu số lượng sản phẩm = 0
                            if ((int)$r['so_sanpham'] == 0) {
                                echo "<a href='admin.php?page=category&act=delete_type&id={$r['matheloai']}'><button class='delete-theloai-btn'>❌ Xóa</button></a>";
                            }

                            echo "</td>";

                            // Cột Thêm thể loại (chỉ ở dòng đầu tiên)
                            if ($first) {
                                echo "<td rowspan='{$rowspan}'>
                                        <a href='admin.php?page=category&act=add_type&cl_id={$r['machungloai']}'><button class='add-theloai-btn'>➕ Thêm thể loại</button></a>
                                    </td>";
                                $first = false;
                            }

                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>

    
    
                <!-- <tbody> -->
                    <!-- Chủng loại "Da mặt" -->
                    <!-- <tr>
                        <td rowspan="3">CL001</td>
                        <td rowspan="3">Da mặt</td>
                        <td>TL001</td>
                        <td>Sữa rửa mặt</td>
                        <td>30</td>
                        <td>
                            <a href="admin.php?page=category&act=edit_type&id=TL001"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                            <a href="admin.php?page=category&act=delete_type&id=TL001"><button class="delete-theloai-btn">❌ Xóa</button></a>
                        </td>
                        <td rowspan="3">
                            <a href="admin.php?page=category&act=add_type&cl_id=CL001">
                                <button class="add-theloai-btn">➕ Thêm thể loại</button>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>TL002</td>
                        <td>Tẩy tế bào chết</td>
                        <td>15</td>
                        <td>
                            <a href="admin.php?page=category&act=edit_type&id=TL002"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                            <a href="admin.php?page=category&act=delete_type&id=TL002"><button class="delete-theloai-btn">❌ Xóa</button></a>
                        </td>
                    </tr>
                    <tr>
                        <td>TL003</td>
                        <td>Mặt nạ</td>
                        <td>20</td>
                        <td>
                            <a href="admin.php?page=category&act=edit_type&id=TL003"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                            <a href="admin.php?page=category&act=delete_type&id=TL003"><button class="delete-theloai-btn">❌ Xóa</button></a>
                        </td>
                    </tr> -->
    
                    <!-- Chủng loại "Chăm sóc tóc" -->
                    <!-- <tr>
                        <td rowspan="2">CL002</td>
                        <td rowspan="2">Chăm sóc tóc</td>
                        <td>TL004</td>
                        <td>Dầu gội</td>
                        <td>50</td>
                        <td>
                            <a href="admin.php?page=category&act=edit_type&id=TL004"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                            <a href="admin.php?page=category&act=delete_type&id=TL004"><button class="delete-theloai-btn">❌ Xóa</button></a>
                        </td>
                        <td rowspan="2">
                            <a href="admin.php?page=category&act=add_type&cl_id=CL002">
                                <button class="add-theloai-btn">➕ Thêm thể loại</button>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>TL005</td>
                        <td>Dầu xả</td>
                        <td>40</td>
                        <td>
                            <a href="admin.php?page=category&act=edit_type&id=TL005"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                            <a href="admin.php?page=category&act=delete_type&id=TL005"><button class="delete-theloai-btn">❌ Xóa</button></a>
                        </td>
                    </tr>
    
                    <tr>
                        <td rowspan="1">CL002</td>
                        <td rowspan="1">Chăm sóc tóc</td>
                        <td>TL004</td>
                        <td>Dầu gội</td>
                        <td>50</td>
                        <td>
                            <a href="admin.php?page=category&act=edit_type&id=TL004"><button class="edit-theloai-btn">✏️ Sửa</button></a>
                            <a href="admin.php?page=category&act=delete_type&id=TL004"><button class="delete-theloai-btn">❌ Xóa</button></a>
                        </td>
                        <td rowspan="1">
                            <a href="admin.php?page=category&act=add_type&cl_id=CL002">
                                <button class="add-theloai-btn">➕ Thêm thể loại</button>
                            </a>
                        </td>
                    </tr> -->
                <!-- </tbody> -->
    
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
        
        // Xóa chủng loại
        $(document).on("click", ".delete-chungloai-btn", function (e) {
            e.preventDefault();
            const row = $(this).closest("tr"); // hàng hiện tại
            const maCL = $(this).closest("a").attr("href").split("id=")[1];

            if (confirm("Bạn có chắc muốn xóa chủng loại này không?")) {
                $.ajax({
                    url: "handles/CategoryController.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: "delete_chungloai",
                        machungloai: maCL
                    },
                    success: function (res) {
                        if (res.success) {
                            // Xoá tất cả hàng có rowspan (nếu có thể loại)
                            $(`td[rowspan][rowspan!='1']:contains('${maCL}')`).each(function () {
                                const rowspan = parseInt($(this).attr("rowspan"));
                                const rowIndex = $(this).closest("tr").index();
                                for (let i = 0; i < rowspan; i++) {
                                    $("tbody tr").eq(rowIndex).remove();
                                }
                            });

                            // Nếu là hàng đơn (không rowspan)
                            row.remove();
                        } else {
                            alert("Xóa thất bại");
                        }
                    },
                    error: function () {
                        alert("Lỗi khi gửi yêu cầu xoá chủng loại");
                    }
                });
            }
        });

    </script>
</body>
</html>


