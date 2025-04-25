<?php
require_once 'Model/TKModel.php';
require_once 'handles/CartController.php';
$tkModel = new TKModel();
$cartController = new CartController();
$customer_id = $tkModel->getIdByUsername($_SESSION['username']);
$customer = $tkModel->getUserById($customer_id);
$customer_id = $tkModel->getCustomerIdByUserId($customer_id);
$cart = $cartController->getAllProductInCart($customer_id);
if (empty($cart)) {
    echo '<script>alert("Bạn đã thanh toán rồi!"); window.location.href = "index.php";</script>';
    exit;
}
?>

<div style="width: 38%; margin: 32px auto 0px; padding: 24px 48px; background-color:rgba(52, 152, 219, 0.5); border-radius: 10px">
    <div class="progress-container">
        <div class="progress-step active" data-step="Giỏ hàng"><i class="fa-solid fa-cart-shopping"></i></div>
        <span class="progress-line active"></span>
        <div class="progress-step active" data-step="Thông tin cá nhân"><i class="fa-solid fa-address-card"></i></div>
        <span class="progress-line"></span>
        <div class="progress-step" data-step="Hóa đơn"><i class="fa-solid fa-receipt"></i></div>
        <!-- <span class="progress-line"></span>
        <div class="progress-step" data-step="Hoàn tất"><i class="fa-solid fa-circle-check"></i></div> -->
    </div>
</div>

<div id="customer-info-container">
    <h3>Thông tin khách hàng</h2>
        <form action="xacnhanthongtin.php" method="POST" id="checkoutForm">
            <div class="gioitinh-container">
                <div class="gioitinh-item">
                    <input type="radio" name="gioitinh" id="nam" value="nam" checked><label for="nam">Anh</label>
                </div>
                <div class="gioitinh-item">
                    <input type="radio" name="gioitinh" id="nu" value="nu"><label for="nu">Chị</label>
                </div>
            </div>
            <div class="info-container">
                <div class="input-group"><input type="text" name="hoten" id="txtHoten" placeholder="" value="<?= $customer['fullname'] ?>"><label for="txtHoten">Họ và tên</label></div>
                <div class="input-group"><input type="text" name="sdt" id="txtSDT" placeholder="" value="<?= $customer['phone'] ?>"><label for="txtSDT">Số điện thoại</label></div>
                <div class="input-group"><input type="text" name="email" id="txtEmail" placeholder="" value="<?= $customer['email'] ?>"><label for="txtEmail">Email</label></div>
            </div>
            <h3>Địa chỉ giao hàng</h3>
            <div class="diachi-user-container">
                <select name="diachi_user" id="diachi_user">
                    <option value="0">Chọn địa chỉ đã lưu</option>
                    <?php
                    require_once 'Model/DiaChiModel.php';
                    $diachiModel = new DiaChiModel();
                    $addresses = $diachiModel->getAllDiaChiByCustomerId($customer_id);
                    // var_dump($addresses);
                    foreach ($addresses as $address) {
                        echo '<option value="' . $address['address_id'] . '" data-sonha="' . $address['SoNha'] . '" data-thanhpho="' . $address['ThanhPho'] . '" data-quan="' . $address['Quan'] . '" data-phuong="' . $address['Phuong'] . '">' . $address['SoNha'] . ', ' . $address['Phuong'] . ', ' . $address['Quan'] . ', ' . $address['ThanhPho'] . '</option>';
                    }
                    echo '<option value="-1">Nhập địa chỉ mới</option>';
                    ?>
                </select>
            </div>
            <div class="diachi-container">
                <div class="diachi-item">
                    <select name="thanhpho" id="thanhpho" disabled>
                        <option value="">Chọn tỉnh/thành phố</option>
                    </select>
                </div>
                <div class="diachi-item">
                    <select name="quan" id="quan" disabled>
                        <option value="">Chọn quận/huyện</option>
                    </select>
                </div>
                <div class="diachi-item">
                    <select name="phuong" id="phuong" disabled>
                        <option value="">Chọn phường/xã</option>
                    </select>
                </div>
                <div class="diachi-item">
                    <input type="text" name="diachi" id="diachi" placeholder="Nhập số nhà, tên đường">
                </div>
            </div>
            <div class="note">
                <p>Ghi chú: (không bắt buộc)</p>
                <input type="text" name="note" id="note" placeholder="Nhập ghi chú cho đơn hàng của bạn">
            </div>
            <div class="payment-method-container">
                <h3>Chọn phương thức thanh toán</h3>
                <div class="payment-method-item">
                    <input type="radio" name="payment-method" id="cod" value="cod" checked><img src="https://file.hstatic.net/200000636033/file/pay_2d752907ae604f08ad89868b2a5554da.png" alt="cod"><label for="cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
                <div class="payment-method-item">
                    <input type="radio" name="payment-method" id="visa" value="visa"><img src="https://file.hstatic.net/200000636033/file/icon_atm_eb07d9eabaef47e088d7f214e3562b97.svg" alt="visa"><label for="visa">Thanh toán bằng VISA</label>
                </div>
                <div class="payment-method-item">
                    <input type="radio" name="payment-method" id="momo" value="momo"><img src="https://file.hstatic.net/200000636033/file/momo_50d207f0cbd34562b936001ab362bd8e.png" alt="momo"><label for="momo">Thanh toán qua ví Mono</label>
                </div>
                <div class="payment-method-item">
                    <input type="radio" name="payment-method" id="vnpay" value="vnpay"><img src="https://file.hstatic.net/1000006063/file/img-vivnpay.jpg" alt="vnpay"><label for="vnpay">Thanh toán qua ví VNPay</label>
                </div>
            </div>
            <div class="total-container">
                <div class="ship-cost-container">
                    <p>Phí vận chuyển:</p>
                    <p class="ship-cost">MIỄN PHÍ</p>
                </div>
                <div class="total">
                    <p>Tổng tiền:</p>
                    <p id="total-cost"><?php echo number_format($_SESSION['total'], 0, ',', '.') ?> VNĐ</p>
                </div>
            </div>
            <div id="confirm-btn">THANH TOÁN NGAY</div>
        </form>
        <div id="qr-section-container">
            <div id="qr-section">
                <div class="qr-exitbtn"><i class="fa-solid fa-xmark"></i></div>
                <p class="qr-title">Quét mã QR để thanh toán</p>
                <img id="qr-image" src="" alt="QR Code"><br>
                <button type="button" id="confirm-payment">Tôi đã thanh toán</button>
            </div>
        </div>
        <div id="visa-section-container">
            <div id="visa-section">
                <div class="visa-exitbtn"><i class="fa-solid fa-xmark"></i></div>
                <p class="visa-title">Nhập thông tin thẻ VISA</p>
                <div class="input-container">
                    <div class="input-group" style="flex: 3">
                        <input type="text" name="card-number" id="card-number" maxlength="19" placeholder="" value="" oninput="validateCardNumber(this)">
                        <label for="card-number">Số thẻ</label>
                    </div>
                    <div class="input-group" style="flex: 1">
                        <input type="text" name="cvv" id="cvv" maxlength="3" placeholder="" value="" oninput="validateNumber(this)">
                        <label for="cvv">Mã CVV</label>
                    </div>
                </div>
                <div class="input-container">
                    <div class="input-group">
                        <input type="text" name="expiry-date" id="expiry-date" maxlength="5" placeholder="" value="" oninput="validateExpiryDate(this)">
                        <label for="expiry-date">Hạn thẻ (MM/YY)</label>
                    </div>
                    <div class="input-group">
                        <input type="text" name="ZIP" id="ZIP" placeholder="" value="" maxlength="5" oninput="validateNumber(this)">
                        <label for="ZIP">Mã ZIP</label>
                    </div>
                </div>
                <div style="width: 80%; margin: 0 auto;" id="visa-confirm">
                    <button type="submit">HOÀN THÀNH</button>
                </div>
            </div>
        </div>
</div>

<script src="/js/customer-info.js"></script>
<style>
    #customer-info-container {
        width: 40%;
        margin: 32px auto;
    }

    #customer-info-container h3 {
        margin-bottom: 16px;
    }

    #customer-info-container .gioitinh-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    #customer-info-container .gioitinh-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-container {
        display: flex;
        flex-wrap: wrap;
        margin: 12px 0px;
        gap: 12px;
    }

    .info-container div.error {
        border: 1px solid red;
        margin: 0;
        margin-top: 20px;
    }

    .input-container div.error {
        border: 1px solid red;
        margin: 0;
        margin-top: 20px;
        padding-left: 0;
    }

    .info-container div {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px;
    }

    .info-container div input[type="text"] {
        width: 100%;
        padding: 8px;
        border: none;
        border-radius: 8px;
        outline: none;
    }

    .info-container div:nth-child(1) {
        width: calc(50% - 12px);
    }

    .info-container div:nth-child(2) {
        width: 50%;
    }

    .info-container div:nth-child(3) {
        width: 100%;
    }

    .input-group {
        position: relative;
        margin-top: 20px;
    }

    /* .input-group input {
        width: 100%;
        padding: 12px 8px 8px 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
    } */

    .input-group label {
        position: absolute;
        left: 8px;
        top: 12px;
        background: white;
        color: #aaa;
        font-size: 16px;
        transition: 0.2s ease;
        pointer-events: none;
        padding: 0 4px;
    }

    .input-group.valid {
        border: 1px solid #3498DB;
    }

    /* Khi input focus hoặc có nội dung thì label nổi lên trên */
    .input-group input:focus+label,
    .input-group input:not(:placeholder-shown)+label {
        top: -8px;
        font-size: 12px;
        /* color: #3f51b5; */
    }

    .diachi-user-container {
        margin: 16px 0px;
    }

    #qr-section-container {
        display: none;
        position: fixed;
        text-align: center;
        margin: auto;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }

    #qr-section {
        width: 30%;
        height: 50%;
        margin: 12.5% auto;
        background-color: #fff;
        position: relative;
        border-radius: 8px;
    }

    .qr-exitbtn {
        position: absolute;
        top: 8px;
        right: 8px;
        font-size: 24px;
        color: #333;
        cursor: pointer;
        /* margin: 0; */
        z-index: 10000;
    }

    #qr-section img {
        width: 70%;
        height: 70%;
        object-fit: cover;
    }

    .qr-title {
        margin: 16px 0px;
        font-size: 1.2em;
        color: #333;
    }

    #qr-section button {
        background-color: #3498DB;
        color: #fff;
        padding: 16px 32px;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        border: none;
        font-size: 1.2em;
        margin-top: 8px;
    }

    #qr-section button:hover {
        background-color: #2980B9;
    }

    #visa-section-container {
        display: none;
        position: fixed;
        margin: auto;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }

    #visa-section {
        width: 30%;
        /* height: 35%; */
        /* margin: 11.25% auto; */
        margin: 10% auto;
        background-color: #fff;
        position: relative;
        border-radius: 8px;
    }

    .visa-title {
        padding: 8px 0px;
        font-size: 1.2em;
        color: #333;
        text-align: center;
    }

    .visa-exitbtn {
        position: absolute;
        top: 8px;
        right: 8px;
        font-size: 24px;
        color: #333;
        cursor: pointer;
        z-index: 10000;
    }

    #visa-section input[type="text"] {
        width: 100%;
        padding: 8px;
        border: none;
        border-radius: 8px;
        outline: none;
    }

    /* #visa-section input[type="text"]:focus {
        border: 1px solid #3498DB;
    } */

    #visa-section button {
        background-color: #3498DB;
        width: 100%;
        color: #fff;
        padding: 16px 32px;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        border: none;
        font-size: 1.2em;
        margin: 12px 0px;
    }

    .input-container {
        display: flex;
        margin: 0 auto;
        width: 80%;
    }

    .input-container div {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px;
    }

    .input-container div:nth-child(2) {
        margin-left: 12px;
    }

    .diachi-user-container select {
        width: 100%;
        padding: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
        background-color: #fff;
    }

    .diachi-user-container select.error {
        border: 1px solid red;
        margin: 0;
        color: black;
        font-size: 1em;
    }

    .diachi-user-container select option {
        padding: 8px;
    }

    .diachi-container {
        display: flex;
        flex-wrap: wrap;
        background-color: #ECECEC;
        border-radius: 6px;
        padding: 4px;
    }

    .diachi-container .diachi-item {
        padding: 16px 12px;
        width: 50%;
    }

    .diachi-container .diachi-item select,
    .diachi-container .diachi-item input[type="text"] {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 4px;
        outline: none;
    }

    .diachi-item select.error {
        margin: 0;
        color: black;
        border: 1px solid red;
        /* font-size: 1em; */
    }

    .diachi-item input.error {
        border: 1px solid red !important;
        margin: 0;
        color: black;
        /* font-size: 1em; */
    }

    .note {
        margin: 16px 0px;
    }

    .note p {
        margin-bottom: 8px;
        margin-left: 8px;
        color: #666;
    }

    .note input[type="text"] {
        width: 100%;
        padding: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
        background-color: #fff;
    }

    .note input[type="text"]::placeholder {
        color: #ccc;
    }

    .note input[type="text"]:focus::placeholder {
        color: transparent;
    }

    .payment-method-container {
        margin: 16px 0px;
    }

    .payment-method-container h3 {
        margin-bottom: 16px;
        margin-left: 8px;
    }

    .payment-method-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .payment-method-item input[type="radio"] {
        margin-right: 8px;
    }

    .payment-method-item label {
        font-size: 16px;
        color: #333;
    }

    .payment-method-item img {
        width: 24px;
        height: 24px;
        margin-right: 8px;
    }

    .total-container {
        border-top: 2px solid #ccc;
        padding: 16px 0px;
        margin: 16px 0px;
    }

    .total-container .ship-cost-container {
        display: flex;
        justify-content: space-between;
    }

    .total-container .ship-cost-container p {
        margin: 8px 0;
        font-weight: bold;
    }

    .total-container .ship-cost {
        color: #2ECC71;
    }

    .total-container .total {
        display: flex;
        justify-content: space-between;
        margin-top: 16px;
    }

    .total-container .total p {
        margin: 0;
        font-weight: bold;
        font-size: 1.3em;
    }

    .total-container .total #total-cost {
        color: #E74C3C;
    }

    #confirm-btn {
        background-color: #3498DB;
        color: #fff;
        padding: 16px 32px;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        font-size: 1.2em;
        margin-top: 16px;
    }

    #confirm-btn:hover {
        background-color: #2980B9;
    }
</style>