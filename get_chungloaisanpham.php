<?php
require_once('database/connect.php');
require_once('./handles/ChungLoaiController.php');
if (isset($_GET['maChungloai'])) {
    $maChungloai = $_GET['maChungloai'];
    $ChungLoaiController = new ChungLoaiController();
    $chungloais = $ChungLoaiController->getChungLoaiByChungLoai($maChungloai);

    foreach ($chungloais as $chungloai) {
        $ten = htmlspecialchars($chungloai['tenchungloai']);
        echo "<div>";
        echo "$ten";
        echo "</div>";
    }
} else {
    echo "Không có chủng loại được chọn.";
}
?>
