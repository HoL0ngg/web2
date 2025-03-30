<div id="changepassword-wrapper">
    <div id="changepassword-container">
        <form method="post" name="frmChangePass" onsubmit="return checkChangePassword()">
            <div class="form-title">
                <h2>ĐỔI MẬT KHẨU</h2>
                <div class="btn-close">x</div>
            </div>

            <div class="input-field-wrapper">
                <div class="input-field">
                    <input type="password" name="currentpass" id="currentpass" required>
                    <label for="currentpass"><span><i class="fa-solid fa-lock"></i>Nhập mật khẩu hiện tại</label>
                    <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                </div>
                <div class="error" id="currentpassErr"></div>

                <div class="input-field">
                    <input type="password" name="newpass" id="newpass" required>
                    <label for="newpass"><span><i class="fa-solid fa-lock"></i>Nhập mật khẩu mới</label>
                    <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                </div>
                <div class="error" id="newpassErr"></div>

                <div class="input-field">
                    <input type="password" name="renewpass" id="renewpass" required>
                    <label for="renewpass"><span><i class="fa-solid fa-lock"></i>Nhập lại mật khẩu mới</label>
                    <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                </div>
                <div class="error" id="renewpassErr"></div>

                <div class="input-btn-wrapper">
                    <input type="submit" class="btn" value="Đổi mật khẩu" name="btnChangePassword">
                </div>
            </div>
        </form>
    </div>
</div>