<?php
require_once('database/connect.php');
require_once('./handles/TheLoaiController.php');
class get_loaisanpham{
    public function get_loaisanpham($maChungloai){
        $TheLoaiController = new TheLoaiController();
        $theloais = $TheLoaiController->getTheLoaiByChungLoai($maChungloai);
        echo"<ul  class='sub-loai'>";
    foreach ($theloais as $theloai) {
        $id = $theloai['matheloai'];
        $ten = htmlspecialchars($theloai['tentheloai']);
        echo "<li class='loaisanpham' data-matheloai='$id' data-machungloai='$maChungloai'>";
        echo "$ten";
        echo "</li>";
    }
        echo"</ul>";
    }

    public function get_loaisanphamfilter()
    {
        $TheLoaiController = new TheLoaiController();
        $theloais = $TheLoaiController->getALLtheloai();
    
        foreach ($theloais as $theloai) {
            $id = $theloai['matheloai'];
            $ten = htmlspecialchars($theloai['tentheloai']);
            echo "<li>";
            echo "<input type='checkbox' id='theloai_$id' class='loaisanphamcb' value='$id'>";
            echo "<span>$ten</span>";
            echo "</li>";
        }
    }
}
?>