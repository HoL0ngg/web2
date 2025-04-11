<?php
require_once('database/connect.php');
require_once('./handles/BrandController.php');
if (isset($_GET['maChungloai'])) {
    $maChungloai = $_GET['maChungloai'];

    $BrandController = new BrandController();
    $brandnames = $BrandController->getBrandByMaChungLoai($maChungloai);

    foreach ($brandnames as $brandname) {
        $id = $brandname['brand_id'];
        $ten = htmlspecialchars($brandname['brand_name']);
        echo "<li>";
        echo "<input type='checkbox' id='brandname_$id' class='brandname' value='$id'>";
        echo "<span>$ten</span>";
        echo "</li>";
    }
}
?> 

