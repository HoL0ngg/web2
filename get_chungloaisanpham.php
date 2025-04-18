<?php
require_once('database/connect.php');
require_once('./handles/ChungLoaiController.php');
require_once('get_loaisanpham.php');
    $ChungLoaiController = new ChungLoaiController();
    $chungloais = $ChungLoaiController->getAllChungLoai();

    $get_loaisanpham = new get_loaisanpham();

    foreach ($chungloais as $chungloai) {
        $ten = htmlspecialchars($chungloai['tenchungloai']);
    $maCL = $chungloai['machungloai'];
    $hinhAnh = htmlspecialchars($chungloai['hinhanh']);

    echo "<li class='chungloaisanpham'>";
    echo "<a href='index.php?maChungloai=$maCL'>";
    echo "<img src='$hinhAnh' alt='$ten' />"; 
    echo "<span class='chungloai-title'>$ten</span>";
    echo "</a>";

    // Hiển thị danh sách thể loại
    $get_loaisanpham->get_loaisanpham($maCL);

    echo "</li>";
    }
?>
