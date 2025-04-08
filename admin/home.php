<!DOCTYPE html>
<html lang="en" lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="admin_style/style.css">
    <title>Admin homepage</title>

</head>

<body>

    <div id="wrap">
        <section id="content">
            <!-- MAIN -->
            <main>
                <!-- DASHBOARD PAGE -->
                <div class="main-item" id="main__dashboard">
                    <nav>
                        <div id="site-name">Admin Dashboard</div>

                    </nav>
                    <div class="products-orders">
                        <div class="products">
                            <ul class="box-product">
                                <li class="general">
                                    <img class="product__icon icon " src="./imgs/nuochoa.webp" alt="Product">
                                    <span class="product__text text">
                                        <h1>Sản phẩm</h1>
                                    </span>
                                </li>
                                <li class="canhan">
                                    <img class="product__icon icon" src="./imgs/chamsoccanhan.webp" alt="Image">
                                    <span class="product__text text">
                                        <h2>20</h2>
                                        <p>Cá nhân</p>
                                    </span>
                                </li>
                                <li class="cothe">
                                    <img class="product__icon icon" src="./imgs/chamsoccothe.webp" alt="Image">
                                    <span class="product__text text">
                                        <h2>30</h2>
                                        <p>Cơ thể</p>
                                    </span>
                                </li>
                                <li class="damat">
                                    <img class="product__icon icon" src="./imgs/chamsocdamat.webp" alt="Image">
                                    <span class="product__text text">
                                        <h2>45</h2>
                                        <p>Da mặt</p>
                                    </span>
                                </li>
                                <li class="tocdadau">
                                    <img class="product__icon icon" src="./imgs/chamsoctocdadau.webp" alt="Image">
                                    <span class="product__text text">
                                        <h2>15</h2>
                                        <p>Tóc - Da đầu</p>
                                    </span>
                                </li>
                                <li class="nuochoa">
                                    <img class="product__icon icon" src="./imgs/nuochoa.webp" alt="Image">
                                    <span class="product__text text">
                                        <h2>15</h2>
                                        <p>Nước hoa</p>
                                    </span>
                                </li>
                                <li class="trangdiem">
                                    <img class="product__icon icon" src="./imgs/trangdiem.webp" alt="Image">
                                    <span class="product__text text">
                                        <h2>15</h2>
                                        <p>Trang điểm</p>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="order">
                            <ul class="box-order">
                                <li class="general">
                                    <img class="order__icon icon" src="./imgs/order_bill.png" alt="Order">
                                    <span class="order__text text">
                                        <h1>Đơn hàng</h1>
                                    </span>
                                </li>
                                <li class="cart">
                                    <img class="order__icon icon " src="./imgs/order_shopping-cart.png" alt="Cart">
                                    <span class="order__text text">
                                        <h2>20</h2>
                                        <p>Giỏ hàng</p>
                                    </span>
                                </li>
                                <li class="delivery">
                                    <img class="order__icon icon" src="./imgs/order_delivery-truck.png" alt="Delivery">
                                    <span class="order__text text">
                                        <h2>20</h2>
                                        <p>Đang giao</p>
                                    </span>
                                </li>
                                <li class="success">
                                    <img class="order__icon icon" src="./imgs/order_recieved.png" alt="Success">
                                    <span class="order__text text">
                                        <h2>30</h2>
                                        <p>Hoàn thành</p>
                                    </span>
                                </li>
                                <li class="failed">
                                    <img class="order__icon icon" src="./imgs/order_failed.png" alt="Failed">
                                    <span class="order__text text">
                                        <h2>45</h2>
                                        <p>Hủy đơn</p>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="customers">
                        <li class="customer__chart--name">
                            <img class="customer__icon icon" src="./imgs/customer.png" alt="Customer">
                            <span class="customer__text text">
                            </span>
                        </li>
                        <div class="customer__chart">
                            <div class="item item--click" style="--counter: 20">200</div>
                            <div class="item item--purchase" style="--counter: 12">120</div>
                            <div class="item item--click" style="--counter: 35">350</div>
                            <div class="item item--purchase" style="--counter: 27">270</div>
                            <div class="item item--click" style="--counter: 26">260</div>
                            <div class="item item--purchase" style="--counter: 17">170</div>
                            <div class="item item--click" style="--counter: 32">325</div>
                            <div class="item item--purchase" style="--counter: 30">320</div>
                            <div class="item item--click" style="--counter: 29">290</div>
                            <div class="item item--purchase" style="--counter: 25">250</div>

                        </div>

                        <div class="customer__note">
                            <li>
                                <img class="note_icon--click icon" src="./imgs/customer_click.png" alt="Click">
                                <span class="note__text text">
                                    Click vào website
                                </span>
                            </li>
                            <li>
                                <img class="note_icon--purchase icon" src="./imgs/customer_order.png" alt="Order">
                                <span class="note__text text">
                                    Mua hàng
                                </span>
                            </li>
                        </div>

                    </div>
                </div>
            </main>
        </section>
    </div>
</body>

</html>