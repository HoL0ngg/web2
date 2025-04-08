<div id="content-wrapper">
    <?php
    $action = '';

    if (isset($_GET['maChungloai'])) {
        $action = 'maChungloai';
    } elseif (isset($_GET['orderhistory'])) {
        $action = 'orderhistory';
    } else {
        $action = 'default';
    }

    switch ($action) {
        case 'maChungloai':
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
                            <ul>
                                <li><input type='checkbox'><span>DOVE</span></li>
                                <li><input type='checkbox'><span>SENKA</span></li>
                                <li><input type='checkbox'><span>CETAPHIL</span></li>
                                <li><input type='checkbox'><span>BIORÉ</span></li>
                            </ul>
                        </div>
                    </div>
                    <div id='leftmenu_product_gia'>
                        <div id='leftmenu_product_gia_title'>Giá</div>
                        <div id='leftmenu_product_range'>
                            <div id='price-values'>
                                <span id='min-price'>0đ</span><span id='max-price'>1000000000đ</span>
                            </div>
                            <input type='range' id='price-range' min='0' max='1000000' step='10' value='0'>
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
                    </div>  
                </div>

                <div id='rightmenu_product'>
                    <div id='product-container'></div>
                    <div id='pagenum'></div>
                </div>
            ";
            break;

        case 'orderhistory':
            require_once './handles/OrderHistoryController.php';
            $OrderHistoryController = new OrderHistoryController();
            $OrderHistoryController->getAllOrderHistoryByCustomerId(1);
            break;

        default:
            echo '
                <div id="rightmenu_product">
                    <div id="product-container"></div>
                    <div id="pagenum"></div>
                </div>
            ';
            break;
    }
    ?>
</div>