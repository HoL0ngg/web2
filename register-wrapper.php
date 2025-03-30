<div id="register-wrapper">
    <div id="register-container">
        <form name="frmRegister">
            <div class="form-title">
                <h2>ĐĂNG KÝ</h2>
                <div class="btn-close">x</div>
            </div>
            <div class="input-field-wrapper">
                <div class="input-field">
                    <input type="text" id="reg-phone" name="reg-phone" required>
                    <label for="reg-phone"><span><i class="fa-solid fa-phone"></i></span>Số điện thoại</label>
                </div>
                <div class="error phone"></div>

                <div class="input-field">
                    <input type="text" id="reg-address" name="reg-address" required>
                    <label for="reg-address"><span><i class="fa-solid fa-location-dot"></i></span>Địa chỉ</label>
                </div>
                <div class="error address"></div>

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
            </div>

            <div class="input-btn-wrapper">
                <input type="submit" class="btn" value="Đăng ký ngay" name="btnRegister">
            </div>
        </form>
    </div>
</div>