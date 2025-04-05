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
                    <select name="thanhpho" id="thanhpho">
                        <option value="">Chọn tỉnh/thành phố</option>
                        <option value="Hà Nội">Hà Nội</option>
                        <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                        <option value="Đà Nẵng">Đà Nẵng</option>
                    </select>
                </div>
                <div class="diachi-item">
                    <select name="quan" id="quan">
                        <option value="">Chọn quận/huyện</option>
                        <option value="Ba Đình">Ba Đình</option>
                        <option value="Hoàn Kiếm">Hoàn Kiếm</option>
                        <option value="Đống Đa">Đống Đa</option>
                    </select>
                </div>
                <div class="diachi-item">
                    <select name="huyen" id="huyen">
                        <option value="">Chọn xã/phường</option>
                        <option value="Phường 1">Phường 1</option>
                        <option value="Phường 2">Phường 2</option>
                        <option value="Phường 3">Phường 3</option>
                    </select>
                </div>
                <div class="diachi-item">
                    <input type="text" name="diachi" id="diachi" placeholder="Nhập số nhà, tên đường">
                </div>
            </div>
        </form>
</div>

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
</style>