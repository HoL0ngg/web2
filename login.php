<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div id="login-wrapper">
        <div id="login-container">
            <form name="frmLogin" action="" method="post">
                <div class="form-title">
                    <h2>ĐĂNG NHẬP</h2>
                    <div class="btn-close" onclick="close(this)">x</div>
                </div>

                <div class="input-field">
                    <input type="text" id="username" name="username" required>
                    <label for="username"><i class="fa-solid fa-user"></i></span>Tên đăng nhập</label>
                </div>

                <div class="input-field">
                    <input type="password" id="password" name="password" required>
                    <label for="password"><i class="fa-solid fa-key"></i></span>Mật khẩu</label>
                    <span class="eye-icon" onclick="togglePasswordStatus(this)"><i class="fa-regular fa-eye"></i></span>
                </div>

                <div class="input-btn-wrapper">
                    <input type="submit" value="Đăng nhập" class="btn">
                </div>

                <div style="text-align: center;">
                    <span>Bạn đã có tài khoản chưa?</span>
                    <a href="registration.php">Đăng ký</a>
                </div>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>