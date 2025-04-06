<div style="width: 42%; margin: 32px auto 0px; padding: 24px 48px; background-color:rgba(52, 152, 219, 0.5); border-radius: 10px">
    <div class="progress-container">
        <div class="progress-step active" data-step="Giỏ hàng"><i class="fa-solid fa-cart-shopping"></i></div>
        <span class="progress-line active"></span>
        <div class="progress-step active" data-step="Thông tin cá nhân"><i class="fa-solid fa-address-card"></i></div>
        <span class="progress-line"></span>
        <div class="progress-step" data-step="Hóa đơn"><i class="fa-solid fa-receipt"></i></div>
        <span class="progress-line"></span>
        <div class="progress-step" data-step="Hoàn tất"><i class="fa-solid fa-circle-check"></i></div>
    </div>
</div>

<div id="customer-info-container">
    <h3>Thông tin khách hàng</h2>
        <form action="">
            <div class="gioitinh-container">
                <div class="gioitinh-item">
                    <input type="radio" name="gioitinh" id="nam" value="nam" checked><label for="nam">Anh</label>
                </div>
                <div class="gioitinh-item">
                    <input type="radio" name="gioitinh" id="nu" value="nu"><label for="nu">Chị</label>
                </div>
            </div>
            <div class="info-container">
                <div><input type="text" name="" id="" placeholder="Họ và tên"></div>
                <div><input type="text" name="" id="" placeholder="Số điện thoại"></div>
                <div><input type="text" name="" id="" placeholder="Địa chỉ Email"></div>
            </div>
            <h3>Địa chỉ giao hàng</h3>
            <div class="diachi-container">
                <div class="diachi-item">
                    <select name="thanhpho" id="thanhpho" onchange="loadQuan()">
                        <option value="">Chọn tỉnh/thành phố</option>
                    </select>
                </div>
                <div class="diachi-item">
                    <select name="quan" id="quan" onchange="loadPhuong()">
                        <option value="">Chọn quận/huyện</option>
                    </select>
                </div>
                <div class="diachi-item">
                    <select name="phuong" id="phuong">
                        <option value="">Chọn xã/phường</option>
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
                    <input type="radio" name="payment-method" id="bank-transfer" value="bank-transfer"><img src="https://file.hstatic.net/200000636033/file/icon_atm_eb07d9eabaef47e088d7f214e3562b97.svg" alt="bank-transfer"><label for="bank-transfer">Chuyển khoản ngân hàng</label>
                </div>
                <div class="payment-method-item">
                    <input type="radio" name="payment-method" id="mono" value="mono"><img src="https://file.hstatic.net/200000636033/file/momo_50d207f0cbd34562b936001ab362bd8e.png" alt="mono"><label for="mono">Thanh toán qua ví Mono</label>
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
                    <p id="total-cost">100.000đ</p>
                </div>
            </div>
            <div id="confirm-btn">THANH TOÁN NGAY</div>
        </form>
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
        margin: 16px 0px;
        gap: 12px;
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