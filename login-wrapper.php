<div id="login-wrapper">
    <div id="login-container">
        <form name="frmLogin" method="post" onsubmit="return checkLogin()">
            <div class="form-title">
                <h2>ĐĂNG NHẬP</h2>
                <div class="btn-close">x</div>
            </div>

            <div class="input-field">
                <input type="text" id="username" name="username" required>
                <label for="username"><i class="fa-solid fa-user"></i></span>Tên đăng nhập</label>
            </div>
            <div class="error" id="usernameErr"></div>

            <div class="input-field">
                <input type="password" id="password" name="password" required>
                <label for="password"><i class="fa-solid fa-key"></i></span>Mật khẩu</label>
                <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
            </div>
            <div class="error" id="passwordErr"></div>

            <div class="input-btn-wrapper">
                <input type="submit" value="Đăng nhập" class="btn" name="btnLogin">
            </div>

            <div style="text-align: center;margin: 17px">
                <span>Bạn đã có tài khoản chưa?</span>
                <span style="font-weight: 700;color: #0063EC;cursor: pointer;" onclick="openRegisterForm()">Đăng ký</span>
            </div>
        </form>
    </div>
</div>