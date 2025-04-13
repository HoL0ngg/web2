<?php
if (isset($_GET['maChungloai']))
{
    echo "
                <div id='leftmenu_product'>
                    <div id='leftmenu_product_title'>
                        Danh Mục";
            include('get_chungloaisanpham.php');
            echo "</div>
                    <div id='leftmenu_product_thuonghieu'>
                        <div id='leftmenu_product_thuonghieu_title'>
                           Thương Hiệu
                        </div>
                        <div id='leftmenu_product_checkbox'>
                            <ul>";
                                include('get_brand.php');
                            echo"</ul>
                        </div>
                    </div>
                    <div id='leftmenu_product_gia'>
                        <div id='leftmenu_product_gia_title'>Giá</div>
                        <div id='leftmenu_product_range'>
                            <div id='price-values'>
                                <span id='min-price'>0đ</span><span id='max-price'>10000000đ</span>
                            </div>
                            <input type='range' id='price-range' min='0' max='10000000' step='10' value='10000000'>
                        </div>
                        <div id='leftmenu_product_button'>
                            <input type='button' value='Áp Dụng'>
                        </div>
                    </div>
                    <div id='leftmenu_product_danhmucsanpham'>
                        <div id='leftmenu_product_danhmucsanpham_tittle'>Danh Mục Sản Phẩm</div>
                        <div id='leftmenu_product_checkbox'>
                            <ul id='loaisanpham-list'>";
            include('get_loaisanpham.php');
            echo "</ul>
                        </div>
                        <div style='text-align:center; margin-top: 10px;'>
                        <button id='reset-filters' style='padding: 8px 12px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; float: right;  '>
                            Đặt lại
                        </button>
                        </div>
                    </div>
                </div>
                <div id='rightmenu_product'>
                    <div id='product-container'></div>
                    <div id='pagenum'></div>
                </div>
            ";
}
?>