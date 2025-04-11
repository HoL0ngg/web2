<?php
require_once('database/connect.php');
require_once('./handles/TheLoaiController.php');
if (isset($_GET['maChungloai'])) {
    $maChungloai = $_GET['maChungloai'];
    $TheLoaiController = new TheLoaiController();
    $theloais = $TheLoaiController->getTheLoaiByChungLoai($maChungloai);

    foreach ($theloais as $theloai) {
        $id = $theloai['matheloai'];
        $ten = htmlspecialchars($theloai['tentheloai']);
        echo "<li>";
        echo "<input type='checkbox' id='theloai_$id' class='loaisanpham' value='$id'>";
        echo "<span>$ten</span>";
        echo "</li>";
    }
} else {
    echo "Không có chủng loại được chọn.";
}
?>