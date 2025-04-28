<div id="register-wrapper">
    <div id="register-container">
        <form name="frmRegister">

            <div class="input-field-wrapper">
                <div id="left-input-field">

                    <div class="form-title-left">
                        <h2>THÔNG TIN CÁ NHÂN</h2>
                    </div>

                    <div class="input-field">
                        <input type="text" id="reg-fullname" name="reg-fullname" required>
                        <label for="reg-fullname"><span><i class="fa-solid fa-user"></i></span>Họ tên</label>
                    </div>
                    <div class="error fullname"></div>

                    <div class="input-field">
                        <input type="text" id="reg-phone" name="reg-phone" required>
                        <label for="reg-phone"><span><i class="fa-solid fa-phone"></i></span>Số điện thoại</label>
                    </div>
                    <div class="error phone"></div>

                    <div class="diachi-container">
                        <div class="diachi-item">
                            <select name="thanhpho" id="thanhpho">
                                <option value="">Chọn tỉnh/thành phố</option>
                            </select>
                        </div>

                        <div class="diachi-item">
                            <select name="quan" id="quan">
                                <option value="">Chọn quận/huyện</option>
                            </select>
                        </div>

                        <div class="diachi-item">
                            <select name="phuong" id="phuong">
                                <option value="">Chọn phường/xã</option>
                            </select>
                        </div>

                        <div class="diachi-item">
                            <input type="text" name="diachi" id="diachi" placeholder="Nhập số nhà, tên đường">
                        </div>

                    </div>


                </div>

                <div class="btn-close">x</div>

                <div id="right-input-field">

                    <div class="form-title-right">
                        <h2>ĐĂNG KÝ</h2>
                    </div>

                    <div class="input-field">
                        <input type="email" id="reg-email" name="reg-email" required>
                        <label for="reg-email"><span><i class="fa-solid fa-envelope"></i></span>Email</label>
                    </div>
                    <div class="error email"></div>

                    <div class="input-field">
                        <input type="text" id="reg-username" name="reg-username" required>
                        <label for="reg-username"><span><i class="fa-solid fa-user"></i></span>Tên đăng nhập</label>
                    </div>
                    <div class="error username"></div>

                    <div class="input-field">
                        <input type="password" id="reg-password" name="reg-password" required>
                        <label for="reg-password"><span><i class="fa-solid fa-key"></i></span>Mật khẩu </label>
                        <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="error password"></div>

                    <div class="input-field">
                        <input type="password" id="reg-repassword" name="reg-repassword" required>
                        <label for="reg-repassword"><span><i class="fa-solid fa-key"></i></span>Nhập lại mật khẩu </label>
                        <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="error repassword"></div>
                    <div class="input-btn-wrapper">
                        <input type="submit" class="btn" value="Đăng ký ngay" name="btnRegister">
                    </div>
                </div>

            </div>



        </form>
    </div>
</div>
<script src="../web2/js/customer-info.js"></script>
<style>
    .diachi-container {
        display: flex;
        flex-wrap: wrap;
        /* background-color: #ECECEC; */
        border-radius: 6px;
        padding: 4px;
    }

    .diachi-container .diachi-item {
        padding: 10px 7px;
        width: 50%;
    }

    .diachi-container .diachi-item select,
    .diachi-container .diachi-item input[type="text"] {
        width: 100%;
        padding: 14px;
        /* border: none; */
        border-radius: 4px;
        /* outline: none; */
    }
</style>