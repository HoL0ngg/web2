<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mỹ phẩm</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="cart.css">
</head>

<body>
    <?php include('header.php') ?>
    <div
        style="margin: 10px 0 0 100px; border-bottom: 5px solid black; display: inline-block; padding-bottom: 4px; font-size: 32px;">
        Giỏ hàng
    </div>
    <div id="cart" style="display: flex; gap: 12px;">
        <div id="cart-left" style="flex: 5;">
            <div id="empty-cart" style="margin: 100px auto; width: max-content; user-select: none;">
                <div style="width: max-content; margin: 10px auto;">
                    <i class="fa-solid fa-cart-shopping fa-5x"></i>
                </div>
                <p style="text-align: center;">
                    Giỏ hàng của bạn đang trống
                </p>
            </div>
            <div class="container">
                <table>
                    <tbody id="cart-container">
                        <!-- <tr>
                            <th></th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th></th>
                        </tr> -->
                        <!-- <tr class="cart-item">
                            <td style="display: none;">msp1</td>
                            <td><img src="Logo-DH-Sai-Gon-SGU-flat.webp" alt="" style="height: 55px;"></td>
                            <td>
                                Quạt máy senko
                            </td>
                            <td>
                                <p class="item-price">
                                    200.000 VNĐ
                                </p>
                            </td>
                            <td>
                                <div id="chinhsoluong">
                                    <button style="color: gray;" class="decrease">
                                        -
                                    </button>
                                    <p class="quantity">1</p>
                                    <button class="increase">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td>
                                <p class="item-total">
                                    200.000 VNĐ
                                </p>
                            </td>
                            <td>
                                <div class="xoa">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>
                            </td>
                        </tr>
                        <tr class="cart-item">
                            <td style="display: none;">msp2</td>
                            <td><img src="Logo-DH-Sai-Gon-SGU-flat.webp" alt="" style="height: 55px;"></td>
                            <td>
                                Quạt máy senko
                            </td>
                            <td>
                                <p class="item-price">
                                    200.000 VNĐ
                                </p>
                            </td>
                            <td>
                                <div id="chinhsoluong">
                                    <button style="color: gray;" class="decrease">
                                        -
                                    </button>
                                    <p class="quantity">1</p>
                                    <button class="increase">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td>
                                <p class="item-total">
                                    200.000 VNĐ
                                </p>
                            </td>
                            <td>
                                <div class="xoa">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>
                            </td>
                        </tr>
                        <tr class="cart-item">
                            <td style="display: none;">msp3</td>
                            <td><img src="Logo-DH-Sai-Gon-SGU-flat.webp" alt="" style="height: 55px;"></td>
                            <td>
                                Quạt máy senko
                            </td>
                            <td>
                                <p class="item-price">
                                    200.000 VNĐ
                                </p>
                            </td>
                            <td>
                                <div id="chinhsoluong">
                                    <button style="color: gray;" class="decrease">
                                        -
                                    </button>
                                    <p class="quantity">1</p>
                                    <button class="increase">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td>
                                <p class="item-total">
                                    200.000 VNĐ
                                </p>
                            </td>
                            <td>
                                <div class="xoa">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>
                            </td>
                        </tr>
                        <tr class="cart-item">
                            <td style="display: none;">msp4</td>
                            <td><img src="Logo-DH-Sai-Gon-SGU-flat.webp" alt="" style="height: 55px;"></td>
                            <td>
                                Quạt máy senko
                            </td>
                            <td>
                                <p class="item-price">
                                    200.000 VNĐ
                                </p>
                            </td>
                            <td>
                                <div id="chinhsoluong">
                                    <button style="color: gray;" class="decrease">
                                        -
                                    </button>
                                    <p class="quantity">1</p>
                                    <button class="increase">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td>
                                <p class="item-total">
                                    200.000 VNĐ
                                </p>
                            </td>
                            <td>
                                <div class="xoa">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="cart-right" style="flex: 3;">
            <div class="container">
                <div
                    style="border-bottom: 1px black solid; text-align: center; padding: 14px; font-size: 18px; font-weight: 600;">
                    HÓA ĐƠN
                </div>
                <div id="payment-info">
                    <div id="info">
                        <p>Họ và tên: Hồ Hoàng Long</p>
                        <p>Địa chỉ: hihihihi</p>
                        <p>SĐT: hihihi</p>
                    </div>
                    <div style="display: flex; justify-content: space-between; width: 90%; margin: 0 auto;">
                        <div>
                            <p>
                                TỔNG CỘNG:
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <p id="total-price" style="font-size: 1.2rem;">0 VNĐ</p>
                            <p style="font-size: 13px; font-weight: 100; color: grey;">(Đã bao gồm VAT nếu có)</p>
                        </div>
                    </div>
                    <div style="width: 90%; margin: 12 auto;">
                        <button
                            style="background-color: #0d5146; width: 100%; padding: 6px; font-weight: 700; color: white; cursor: pointer;"
                            id="ThanhToanbtn" onclick="ThanhToan()">THANH
                            TOÁN</button>
                    </div>
                    <div id="payment">
                        <i class=" fa-brands fa-cc-visa fa-xl payment-icon" onclick="MoPopUpThanhtoan(this)"></i>
                        <i class="fa-brands fa-cc-mastercard fa-xl payment-icon" onclick="MoPopUpThanhtoan(this)"></i>
                        <i class="fa-regular fa-credit-card fa-xl payment-icon" onclick="MoPopUpThanhtoan(this)"></i>
                        <i class="fa-solid fa-money-bill-1-wave payment-icon fa-xl"
                            onclick="MoPopUpThanhtoan(this)"></i>
                    </div>
                </div>
                <!-- <div id="not_payment-info">
                    <div style="width: max-content; margin: 10px auto">
                        <i class=" fa-regular fa-address-card fa-4x"></i>
                    </div>
                    <p style="text-align: center;">Bạn phải nhập thông tin cá nhân trước khi mua hàng</p>
                    <div style="width: 80%; margin: 40px auto;">
                        <div style="width: max-content; margin: 0 auto; background-color: #0d5146; padding: 20px; color: white; border-radius: 10px; cursor: pointer;"
                            onclick="openPersonalInfoTable()">
                            Nhập thông tin</div>
                    </div>
                </div>
                <div id="not_login">
                    <div style="width: max-content; margin: 10px auto">
                        <i class=" fa-regular fa-address-card fa-4x"></i>
                    </div>
                    <p style="text-align: center;">Bạn phải đăng nhập trước khi mua hàng</p>
                    <div style="width: 80%; margin: 40px auto;">
                        <div style="width: max-content; margin: 0 auto; background-color: #0d5146; padding: 20px; color: white; border-radius: 10px; cursor: pointer;"
                            onclick="showLogin()">
                            Đăng nhập</div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</body>